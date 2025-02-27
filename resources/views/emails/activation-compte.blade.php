<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation de compte parrain</title>
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
        .credentials {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .credentials p {
            margin: 5px 0;
        }
        .footer {
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 20px;
            text-align: center;
        }
        .auth-code {
            font-weight: bold;
            color: #1a56db;
            font-size: 18px;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Activation de votre compte parrain</h1>
    </div>

    <div class="content">
        <p>Bonjour {{ $prenom }} {{ $nom }},</p>
        
        <p>Nous avons le plaisir de vous confirmer l'activation de votre compte parrain sur notre plateforme de gestion des parrainages électoraux.</p>

        <p>Voici vos identifiants de connexion :</p>
        
        <div class="credentials">
            <!-- <p><strong>Identifiant :</strong> {{ $username }}</p> -->
            <p><strong>Code d'authentification :</strong> <span class="auth-code">{{ $code_authentification }}</span></p>
        </div>

        <p>Vous pouvez dès maintenant vous connecter à votre espace parrain pour suivre l'avancement de votre parrainage.</p>

        <p>Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe lors de votre première connexion.</p>
    </div>

    <div class="footer">
        <p>Ce message est automatique, merci de ne pas y répondre.</p>
        <p>&copy; {{ date('Y') }} Gestion des Parrainages Électoraux - Tous droits réservés</p>
    </div>
</body>
</html>