<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h1 {
            color: #2B2B68; /* Color(0xFF2B2B68) */
            margin-bottom: 20px;
            font-size: 24px;
        }
        p {
            color: #666666;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        a.button {
            display: inline-block;
            background-color: #FF5330; /* Color(0xFFFF5330) */
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        a.button:hover {
            background-color: #e94e29; /* Darker shade for hover effect */
            transform: translateY(-2px);
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Bonjour {{ $client->name }},</h1>
        <p>Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
        <p>Cliquez sur le bouton ci-dessous pour réinitialiser votre mot de passe. Ce lien est valide pendant 60 minutes.</p>
        <p>
            <a href="{{ $url }}" class="button">Réinitialiser le mot de passe</a>
        </p>
        <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, veuillez ignorer cet email.</p>
        <p>Cordialement,<br>L'équipe de support</p>
        <div class="footer">
            <p>© 2024 360TN. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
