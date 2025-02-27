DELIMITER //

-- Variable globale pour l'état de l'upload des électeurs
SET @EtatUploadElecteurs = FALSE;

-- Fonction pour vérifier si une chaîne est en UTF-8
CREATE FUNCTION EstUTF8(str TEXT) 
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE is_utf8 BOOLEAN;
    SET is_utf8 = str REGEXP '^([[:ascii:]]|[\u0080-\u00FF])*$';
    RETURN is_utf8;
END //

-- Fonction pour vérifier le format CIN (exemple: 1234567890123)
CREATE FUNCTION EstFormatCINValide(cin VARCHAR(13))
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    RETURN cin REGEXP '^[0-9]{13}$';
END //

-- Fonction pour vérifier le format du numéro d'électeur
CREATE FUNCTION EstFormatNumeroElecteurValide(numero VARCHAR(20))
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    RETURN numero REGEXP '^[A-Z0-9]{10,20}$';
END //

-- Fonction principale pour contrôler le fichier des électeurs
CREATE FUNCTION ControlerFichierElecteurs(
    p_fichier_contenu TEXT,
    p_checksum_saisi VARCHAR(64),
    p_upload_id BIGINT
) 
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE v_checksum_calcule VARCHAR(64);
    DECLARE v_est_utf8 BOOLEAN;
    DECLARE v_message_erreur TEXT;
    
    -- Calculer le SHA256 du contenu
    SET v_checksum_calcule = SHA2(p_fichier_contenu, 256);
    
    -- Vérifier si le contenu est en UTF-8
    SET v_est_utf8 = EstUTF8(p_fichier_contenu);
    
    -- Si le checksum ne correspond pas
    IF v_checksum_calcule != p_checksum_saisi THEN
        SET v_message_erreur = 'Le checksum ne correspond pas au fichier uploadé';
        
        -- Mettre à jour l'historique avec l'erreur
        UPDATE historique_uploads 
        SET est_succes = FALSE, 
            message_erreur = v_message_erreur 
        WHERE upload_id = p_upload_id;
        
        RETURN FALSE;
    END IF;
    
    -- Si le contenu n'est pas en UTF-8
    IF NOT v_est_utf8 THEN
        SET v_message_erreur = 'Le fichier n''est pas encodé en UTF-8';
        
        -- Mettre à jour l'historique avec l'erreur
        UPDATE historique_uploads 
        SET est_succes = FALSE, 
            message_erreur = v_message_erreur 
        WHERE upload_id = p_upload_id;
        
        RETURN FALSE;
    END IF;
    
    RETURN TRUE;
END //

-- Fonction pour contrôler les données des électeurs
CREATE FUNCTION ControlerElecteurs(
    p_cin VARCHAR(13),
    p_numero_electeur VARCHAR(20),
    p_nom VARCHAR(100),
    p_prenom VARCHAR(100),
    p_date_naissance DATE,
    p_lieu_naissance VARCHAR(100),
    p_sexe CHAR(1),
    p_upload_id BIGINT
) 
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE v_message_erreur TEXT DEFAULT NULL;
    
    -- Vérifier le format CIN
    IF NOT EstFormatCINValide(p_cin) THEN
        SET v_message_erreur = 'Format CIN invalide';
    END IF;
    
    -- Vérifier le format numéro électeur
    IF NOT EstFormatNumeroElecteurValide(p_numero_electeur) THEN
        SET v_message_erreur = CONCAT(v_message_erreur, '; Format numéro électeur invalide');
    END IF;
    
    -- Vérifier l'unicité
    IF EXISTS (SELECT 1 FROM electeurs WHERE cin = p_cin OR numero_electeur = p_numero_electeur) THEN
        SET v_message_erreur = CONCAT(v_message_erreur, '; CIN ou numéro électeur déjà existant');
    END IF;
    
    -- Vérifier les champs obligatoires et leur format
    IF p_nom IS NULL OR p_nom = '' OR NOT EstUTF8(p_nom) THEN
        SET v_message_erreur = CONCAT(v_message_erreur, '; Nom invalide ou vide');
    END IF;
    
    IF p_prenom IS NULL OR p_prenom = '' OR NOT EstUTF8(p_prenom) THEN
        SET v_message_erreur = CONCAT(v_message_erreur, '; Prénom invalide ou vide');
    END IF;
    
    IF p_date_naissance IS NULL THEN
        SET v_message_erreur = CONCAT(v_message_erreur, '; Date de naissance invalide');
    END IF;
    
    IF p_lieu_naissance IS NULL OR p_lieu_naissance = '' OR NOT EstUTF8(p_lieu_naissance) THEN
        SET v_message_erreur = CONCAT(v_message_erreur, '; Lieu de naissance invalide ou vide');
    END IF;
    
    IF p_sexe NOT IN ('M', 'F') THEN
        SET v_message_erreur = CONCAT(v_message_erreur, '; Sexe invalide');
    END IF;
    
    -- Si des erreurs ont été trouvées, enregistrer dans la table des problèmes
    IF v_message_erreur IS NOT NULL THEN
        INSERT INTO electeurs_problemes (upload_id, cin, numero_electeur, nature_probleme)
        VALUES (p_upload_id, p_cin, p_numero_electeur, v_message_erreur);
        RETURN FALSE;
    END IF;
    
    RETURN TRUE;
END //

-- Procédure pour valider l'importation
CREATE PROCEDURE ValiderImportation(IN p_upload_id BIGINT)
BEGIN
    DECLARE v_count_problemes INT;
    
    -- Vérifier s'il y a des problèmes
    SELECT COUNT(*) INTO v_count_problemes 
    FROM electeurs_problemes 
    WHERE upload_id = p_upload_id;
    
    -- Si aucun problème n'est détecté
    IF v_count_problemes = 0 THEN
        -- Transférer les données de la table temporaire vers la table permanente
        INSERT INTO electeurs (
            cin, 
            numero_electeur, 
            nom, 
            prenom, 
            date_naissance, 
            lieu_naissance, 
            sexe, 
            bureau_vote
        )
        SELECT 
            cin, 
            numero_electeur, 
            nom, 
            prenom, 
            date_naissance, 
            lieu_naissance, 
            sexe, 
            bureau_vote
        FROM electeurs_temp;
        
        -- Vider la table temporaire
        TRUNCATE TABLE electeurs_temp;
        
        -- Mettre à jour le statut de l'upload
        UPDATE historique_uploads 
        SET est_succes = TRUE 
        WHERE upload_id = p_upload_id;
        
        -- Empêcher les nouveaux uploads
        SET @EtatUploadElecteurs = TRUE;
    END IF;
END //

-- Fonction pour vérifier si un électeur peut être parrain
CREATE FUNCTION PeutEtreParrain(
    p_numero_electeur VARCHAR(20),
    p_cin VARCHAR(13),
    p_nom VARCHAR(100),
    p_bureau_vote VARCHAR(100)
) 
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE v_count INT;
    
    SELECT COUNT(*) INTO v_count
    FROM electeurs e
    WHERE e.numero_electeur = p_numero_electeur
    AND e.cin = p_cin
    AND e.nom = p_nom
    AND e.bureau_vote = p_bureau_vote;
    
    RETURN v_count > 0;
END //

-- Fonction pour vérifier si un électeur peut être candidat
CREATE FUNCTION PeutEtreCandidat(
    p_numero_electeur VARCHAR(20)
) 
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    -- Vérifier si l'électeur existe et n'est pas déjà candidat
    RETURN EXISTS (
        SELECT 1 
        FROM electeurs e
        WHERE e.numero_electeur = p_numero_electeur
        AND NOT EXISTS (
            SELECT 1 
            FROM candidats c 
            WHERE c.numero_electeur = e.numero_electeur
        )
    );
END //

DELIMITER ;
