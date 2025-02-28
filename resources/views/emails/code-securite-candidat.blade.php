<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Code de sécurité pour votre candidature</title>
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
            background-color: #0066cc;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            background-color: #f5f5f5;
            border: 1px dashed #ccc;
            margin: 20px 0;
            letter-spacing: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Code de sécurité pour votre candidature</h1>
    </div>
    
    <div class="content">
        <p>Bonjour <strong>{{ $nom }}</strong>,</p>
        
        <p>Votre inscription en tant que candidat pour le parrainage électoral a été enregistrée avec succès.</p>
        
        <p>Voici votre code de sécurité qui vous permettra de vous authentifier sur la plateforme :</p>
        
        <div class="code">{{ $code }}</div>
        
        <p><strong>Important :</strong> Ce code est personnel et confidentiel. Ne le partagez avec personne.</p>
        
        <p>Pour accéder à votre espace candidat, utilisez votre adresse email et le code de sécurité ci-dessus.</p>
        
        <div style="text-align: center;">
            <a href="{{ route('welcome') }}" class="button">Accéder à la plateforme</a>
        </div>
        
        <p>Si vous n'êtes pas à l'origine de cette candidature, veuillez nous contacter immédiatement.</p>
        
        <p>Cordialement,<br>
        L'équipe de la Direction Générale des Élections</p>
    </div>
    
    <div class="footer">
        <p>Ce message est automatique, merci de ne pas y répondre.</p>
        <p>© {{ date('Y') }} Direction Générale des Élections - Tous droits réservés.</p>
    </div>
</body>
</html>