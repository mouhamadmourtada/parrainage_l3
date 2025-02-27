<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de votre parrainage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 20px;
        }
        .details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .success-icon {
            text-align: center;
            color: #10B981;
            font-size: 48px;
            margin-bottom: 10px;
        }
        .footer {
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 20px;
            text-align: center;
        }
        .important-note {
            background-color: #FEF3C7;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #F59E0B;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Confirmation de votre parrainage</h1>
    </div>

    <div class="content">
        <div class="success-icon">✓</div>
        
        <p>Bonjour {{ $prenom }} {{ $nom }},</p>
        
        <p>Nous vous confirmons que votre parrainage a été enregistré avec succès.</p>
        
        <div class="details">
            <h3>Détails du parrainage</h3>
            <p><strong>Candidat parrainé :</strong> {{ $candidat_prenom }} {{ $candidat_nom }}</p>
            <p><strong>Date d'enregistrement :</strong> {{ $date }}</p>
        </div>

        <div class="important-note">
            <p><strong>Important :</strong> Conservez cet email comme preuve de votre parrainage.</p>
            <p>Votre choix est définitif et ne pourra pas être modifié pour l'élection en cours.</p>
        </div>

        <p>Nous vous remercions pour votre participation au processus électoral.</p>
    </div>

    <div class="footer">
        <p>Ce message est automatique, merci de ne pas y répondre.</p>
        <p>&copy; {{ date('Y') }} Gestion des Parrainages Électoraux - Tous droits réservés</p>
    </div>
</body>
</html>