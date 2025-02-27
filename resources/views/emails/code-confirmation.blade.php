<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de confirmation pour votre parrainage</title>
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
        .code-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .code {
            font-weight: bold;
            color: #1a56db;
            font-size: 32px;
            letter-spacing: 5px;
        }
        .footer {
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 20px;
            text-align: center;
        }
        .candidat-info {
            background-color: #eef2ff;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Code de confirmation de parrainage</h1>
    </div>

    <div class="content">
        <p>Bonjour {{ $prenom }} {{ $nom }},</p>
        
        <p>Vous avez choisi de parrainer <strong>{{ $candidat_prenom }} {{ $candidat_nom }}</strong> lors de cette élection.</p>
        
        <div class="candidat-info">
            <p><strong>Candidat sélectionné :</strong> {{ $candidat_prenom }} {{ $candidat_nom }}</p>
        </div>

        <p>Pour confirmer votre choix, veuillez utiliser le code à usage unique ci-dessous :</p>
        
        <div class="code-box">
            <div class="code">{{ $code }}</div>
        </div>

        <p>Ce code est valable pour une durée limitée. Veuillez le saisir sur la page de confirmation pour valider définitivement votre parrainage.</p>

        <p>Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer cet email.</p>
    </div>

    <div class="footer">
        <p>Ce message est automatique, merci de ne pas y répondre.</p>
        <p>&copy; {{ date('Y') }} Gestion des Parrainages Électoraux - Tous droits réservés</p>
    </div>
</body>
</html>