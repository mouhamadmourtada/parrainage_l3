DELIMITER //

-- Variable globale pour l'état de l'upload des électeurs
SET @EtatUploadElecteurs = FALSE;

-- Fonction pour vérifier si une chaîne est en UTF-8
DROP FUNCTION IF EXISTS EstUTF8 //
CREATE FUNCTION EstUTF8(str TEXT) 
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    -- Conversion de la chaîne avec CONVERT() en utilisant utf8mb4
    -- Si la conversion ne change pas la chaîne, elle est déjà en UTF-8 valide
    DECLARE original_length INT;
    DECLARE converted_length INT;
    
    -- Obtenir la longueur en octets de la chaîne originale
    SET original_length = LENGTH(str);
    
    -- Obtenir la longueur en octets après conversion explicite en UTF-8
    -- Si des séquences invalides sont présentes, elles seront remplacées ou ignorées
    SET converted_length = LENGTH(CONVERT(CONVERT(str USING utf8mb4) USING utf8mb4));
    
    -- Si les longueurs sont identiques, la chaîne était déjà en UTF-8 valide
    RETURN original_length = converted_length;
END//

-- Fonction pour vérifier le format CIN (exemple: 1234567890123)
DROP FUNCTION IF EXISTS EstFormatCINValide //
CREATE FUNCTION EstFormatCINValide(cin VARCHAR(13))
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    RETURN cin REGEXP '^[0-9]{13}$';
END //

-- Fonction pour vérifier le format du numéro d'électeur
DROP FUNCTION IF EXISTS EstFormatNumeroElecteurValide //
CREATE FUNCTION EstFormatNumeroElecteurValide(numero VARCHAR(20))
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    RETURN numero REGEXP '^[A-Z0-9]{10,20}$';
END //

-- Fonction principale pour contrôler le fichier des électeurs
DROP FUNCTION IF EXISTS ControlerFichierElecteurs //
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
    
    insert into logs (data) values (v_checksum_calcule);
    -- Vérifier si le contenu est en UTF-8
    SET v_est_utf8 = EstUTF8(p_fichier_contenu);
    
    -- Si le checksum ne correspond pas
    IF v_checksum_calcule != p_checksum_saisi THEN
        SET v_message_erreur = 'Le checksum ne correspond pas au fichier uploadé';
        
        insert into logs (data) values (v_message_erreur);

        -- Mettre à jour l'historique avec l'erreur
        UPDATE historique_uploads 
        SET est_succes = FALSE, 
            message_erreur = v_message_erreur 
        WHERE id = p_upload_id;
        
        RETURN FALSE;
    END IF;
    
    -- Si le contenu n'est pas en UTF-8
    IF NOT v_est_utf8 THEN
        SET v_message_erreur = 'Le fichier n''est pas encodé en UTF-8';
        
        insert into logs (data) values (v_message_erreur);

        -- Mettre à jour l'historique avec l'erreur
        UPDATE historique_uploads 
        SET est_succes = FALSE, 
            message_erreur = v_message_erreur 
        WHERE id = p_upload_id;
        
        RETURN FALSE;
    END IF;
    
    RETURN TRUE;
END //

-- Fonction pour contrôler un électeur individuel
DROP FUNCTION IF EXISTS ControlerElecteurIndividuel //
CREATE FUNCTION ControlerElecteurIndividuel(
    p_cin VARCHAR(13),
    p_numero_electeur VARCHAR(20),
    p_nom VARCHAR(100),
    p_prenom VARCHAR(100),
    p_date_naissance DATE,
    p_lieu_naissance VARCHAR(100),
    p_sexe CHAR(1),
    p_bureau_vote VARCHAR(100)
) 
RETURNS TEXT
DETERMINISTIC
BEGIN
    DECLARE v_message_erreur TEXT DEFAULT NULL;
    
    -- Vérifier le format CIN
    IF NOT EstFormatCINValide(p_cin) THEN
        SET v_message_erreur = 'Format CIN invalide';
    END IF;
    
    -- Vérifier le format numéro électeur
    IF NOT EstFormatNumeroElecteurValide(p_numero_electeur) THEN
        SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Format numéro électeur invalide');
    END IF;
    
    -- Vérifier l'unicité
    IF EXISTS (SELECT 1 FROM electeurs WHERE cin = p_cin OR numero_electeur = p_numero_electeur) THEN
        SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'CIN ou numéro électeur déjà existant');
    END IF;
    
    -- Vérifier les champs obligatoires et leur format
    IF p_nom IS NULL OR p_nom = '' OR NOT EstUTF8(p_nom) THEN
        SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Nom invalide ou vide');
    END IF;
    
    IF p_prenom IS NULL OR p_prenom = '' OR NOT EstUTF8(p_prenom) THEN
        SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Prénom invalide ou vide');
    END IF;
    
    IF p_date_naissance IS NULL THEN
        SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Date de naissance invalide');
    END IF;
    
    IF p_lieu_naissance IS NULL OR p_lieu_naissance = '' OR NOT EstUTF8(p_lieu_naissance) THEN
        SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Lieu de naissance invalide ou vide');
    END IF;
    
    IF p_sexe NOT IN ('M', 'F') THEN
        SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Sexe invalide');
    END IF;
    
    IF p_bureau_vote IS NULL OR p_bureau_vote = '' THEN
        SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Bureau de vote invalide ou vide');
    END IF;
    
    RETURN v_message_erreur;
END //

-- Procédure pour contrôler l'ensemble des électeurs d'un fichier
DROP PROCEDURE IF EXISTS ControlerElecteurs //
CREATE PROCEDURE ControlerElecteurs(
    IN p_fichier_contenu TEXT,
    IN p_upload_id BIGINT
)
BEGIN
    DECLARE v_ligne TEXT;
    DECLARE v_position INT DEFAULT 1;
    DECLARE v_longueur INT;
    DECLARE v_fin_ligne INT;
    DECLARE v_ligne_num INT DEFAULT 0;
    DECLARE v_erreur_global BOOLEAN DEFAULT FALSE;
    DECLARE v_ligne_valide BOOLEAN DEFAULT TRUE;
    
    -- Variables pour les données d'électeurs
    DECLARE v_cin VARCHAR(13);
    DECLARE v_numero_electeur VARCHAR(20);
    DECLARE v_nom VARCHAR(100);
    DECLARE v_prenom VARCHAR(100);
    DECLARE v_date_naissance DATE;
    DECLARE v_lieu_naissance VARCHAR(100);
    DECLARE v_sexe CHAR(1);
    DECLARE v_bureau_vote VARCHAR(100);
    DECLARE v_message_erreur TEXT;
    
    -- Ensemble pour vérifier l'unicité pendant le traitement du fichier
    DECLARE v_cins_vus TEXT DEFAULT '';
    DECLARE v_numeros_vus TEXT DEFAULT '';
    
    -- Vider la table temporaire des électeurs
    TRUNCATE TABLE electeurs_temp;
    
    -- Initialiser le compteur de lignes et la position
    SET v_longueur = LENGTH(p_fichier_contenu);
    
    -- Traiter chaque ligne du fichier
    WHILE v_position <= v_longueur DO
        -- Trouver la fin de la ligne
        SET v_fin_ligne = LOCATE('\n', p_fichier_contenu, v_position);
        IF v_fin_ligne = 0 THEN
            SET v_fin_ligne = v_longueur + 1;
        END IF;
        
        -- Extraire la ligne
        SET v_ligne = SUBSTRING(p_fichier_contenu, v_position, v_fin_ligne - v_position);
        SET v_ligne = TRIM(BOTH '\r' FROM v_ligne);
        SET v_ligne_num = v_ligne_num + 1;
        
        -- Réinitialiser le flag de validité de la ligne
        SET v_ligne_valide = TRUE;
        
        -- Ignorer les lignes vides ou d'en-tête (première ligne)
        IF LENGTH(v_ligne) > 0 AND v_ligne_num > 1 THEN
            -- Analyser la ligne (supposons un fichier CSV avec des séparateurs ;)
            -- Format attendu: CIN;NUMERO_ELECTEUR;NOM;PRENOM;DATE_NAISSANCE;LIEU_NAISSANCE;SEXE;BUREAU_VOTE
            
            SET v_cin = SUBSTRING_INDEX(v_ligne, ';', 1);
            SET v_ligne = SUBSTRING(v_ligne, LENGTH(v_cin) + 2);
            
            SET v_numero_electeur = SUBSTRING_INDEX(v_ligne, ';', 1);
            SET v_ligne = SUBSTRING(v_ligne, LENGTH(v_numero_electeur) + 2);
            
            SET v_nom = SUBSTRING_INDEX(v_ligne, ';', 1);
            SET v_ligne = SUBSTRING(v_ligne, LENGTH(v_nom) + 2);
            
            SET v_prenom = SUBSTRING_INDEX(v_ligne, ';', 1);
            SET v_ligne = SUBSTRING(v_ligne, LENGTH(v_prenom) + 2);
            
            -- Convertir la date (format attendu YYYY-MM-DD)
            SET v_date_naissance = STR_TO_DATE(SUBSTRING_INDEX(v_ligne, ';', 1), '%Y-%m-%d');
            SET v_ligne = SUBSTRING(v_ligne, LENGTH(SUBSTRING_INDEX(v_ligne, ';', 1)) + 2);
            
            SET v_lieu_naissance = SUBSTRING_INDEX(v_ligne, ';', 1);
            SET v_ligne = SUBSTRING(v_ligne, LENGTH(v_lieu_naissance) + 2);
            
            SET v_sexe = SUBSTRING_INDEX(v_ligne, ';', 1);
            SET v_ligne = SUBSTRING(v_ligne, LENGTH(v_sexe) + 2);
            
            SET v_bureau_vote = v_ligne;
            
            -- 1. Vérification du format et de l'unicité des identifiants
            -- Vérifier le format CIN
            IF NOT EstFormatCINValide(v_cin) THEN
                INSERT INTO electeurs_problemes (upload_id, cin, numero_electeur, nature_probleme)
                VALUES (p_upload_id, v_cin, v_numero_electeur, 'Format CIN invalide');
                SET v_erreur_global = TRUE;
                SET v_ligne_valide = FALSE;
            END IF;
            
            -- Vérifier le format numéro électeur
            IF v_ligne_valide AND NOT EstFormatNumeroElecteurValide(v_numero_electeur) THEN
                INSERT INTO electeurs_problemes (upload_id, cin, numero_electeur, nature_probleme)
                VALUES (p_upload_id, v_cin, v_numero_electeur, 'Format numéro électeur invalide');
                SET v_erreur_global = TRUE;
                SET v_ligne_valide = FALSE;
            END IF;
            
            -- Vérifier l'unicité dans la base existante
            IF v_ligne_valide AND EXISTS (SELECT 1 FROM electeurs WHERE cin = v_cin OR numero_electeur = v_numero_electeur) THEN
                INSERT INTO electeurs_problemes (upload_id, cin, numero_electeur, nature_probleme)
                VALUES (p_upload_id, v_cin, v_numero_electeur, 'CIN ou numéro électeur déjà existant dans la base');
                SET v_erreur_global = TRUE;
                SET v_ligne_valide = FALSE;
            END IF;
            
            -- Vérifier l'unicité au sein du fichier
            IF v_ligne_valide AND FIND_IN_SET(v_cin, v_cins_vus) > 0 THEN
                INSERT INTO electeurs_problemes (upload_id, cin, numero_electeur, nature_probleme)
                VALUES (p_upload_id, v_cin, v_numero_electeur, 'CIN en doublon dans le fichier');
                SET v_erreur_global = TRUE;
                SET v_ligne_valide = FALSE;
            ELSEIF v_ligne_valide THEN
                SET v_cins_vus = CONCAT_WS(',', v_cins_vus, v_cin);
            END IF;
            
            IF v_ligne_valide AND FIND_IN_SET(v_numero_electeur, v_numeros_vus) > 0 THEN
                INSERT INTO electeurs_problemes (upload_id, cin, numero_electeur, nature_probleme)
                VALUES (p_upload_id, v_cin, v_numero_electeur, 'Numéro d''électeur en doublon dans le fichier');
                SET v_erreur_global = TRUE;
                SET v_ligne_valide = FALSE;
            ELSEIF v_ligne_valide THEN
                SET v_numeros_vus = CONCAT_WS(',', v_numeros_vus, v_numero_electeur);
            END IF;
            
            -- 2. Vérification des autres informations si la ligne est toujours valide
            IF v_ligne_valide THEN
                SET v_message_erreur = NULL;
                
                -- Vérifier les champs obligatoires et leur format
                IF v_nom IS NULL OR v_nom = '' OR NOT EstUTF8(v_nom) THEN
                    SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Nom invalide ou vide');
                END IF;
                
                IF v_prenom IS NULL OR v_prenom = '' OR NOT EstUTF8(v_prenom) THEN
                    SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Prénom invalide ou vide');
                END IF;
                
                IF v_date_naissance IS NULL THEN
                    SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Date de naissance invalide');
                END IF;
                
                IF v_lieu_naissance IS NULL OR v_lieu_naissance = '' OR NOT EstUTF8(v_lieu_naissance) THEN
                    SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Lieu de naissance invalide ou vide');
                END IF;
                
                IF v_sexe NOT IN ('M', 'F') THEN
                    SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Sexe invalide');
                END IF;
                
                IF v_bureau_vote IS NULL OR v_bureau_vote = '' THEN
                    SET v_message_erreur = CONCAT(IFNULL(v_message_erreur, ''), IF(v_message_erreur IS NULL, '', '; '), 'Bureau de vote invalide ou vide');
                END IF;
                
                -- Enregistrer les erreurs pour cet électeur
                IF v_message_erreur IS NOT NULL THEN
                    INSERT INTO electeurs_problemes (upload_id, cin, numero_electeur, nature_probleme)
                    VALUES (p_upload_id, v_cin, v_numero_electeur, v_message_erreur);
                    SET v_erreur_global = TRUE;
                ELSE
                    -- Si tout est valide, insérer dans la table temporaire
                    INSERT INTO electeurs_temp (
                        cin, 
                        numero_electeur, 
                        nom, 
                        prenom, 
                        date_naissance, 
                        lieu_naissance, 
                        sexe, 
                        bureau_vote
                    ) VALUES (
                        v_cin, 
                        v_numero_electeur, 
                        v_nom, 
                        v_prenom, 
                        v_date_naissance, 
                        v_lieu_naissance, 
                        v_sexe, 
                        v_bureau_vote
                    );
                END IF;
            END IF;
        END IF;
        
        -- Avancer à la ligne suivante
        SET v_position = v_fin_ligne + 1;
    END WHILE;
    
    -- Mettre à jour le statut de l'upload dans l'historique
    IF v_erreur_global THEN
        UPDATE historique_uploads 
        SET est_succes = FALSE,
            message_erreur = 'Des erreurs ont été détectées dans le fichier des électeurs'
        WHERE id = p_upload_id;
    ELSE
        UPDATE historique_uploads 
        SET message_erreur = NULL
        WHERE id = p_upload_id;
    END IF;
END //

-- Procédure pour valider l'importation
DROP PROCEDURE IF EXISTS ValiderImportation //
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
        WHERE id = p_upload_id;
        
        -- Empêcher les nouveaux uploads
        SET @EtatUploadElecteurs = TRUE;
    END IF;
END //

-- Fonction pour vérifier si un électeur peut être parrain
DROP FUNCTION IF EXISTS PeutEtreParrain //
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
DROP FUNCTION IF EXISTS PeutEtreCandidat //
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
