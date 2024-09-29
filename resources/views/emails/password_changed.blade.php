<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe changé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #2B2B68; /* Dark blue */
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            padding: 10px;
            text-align: center;
            background-color: #f4f4f4;
        }
        .footer p {
            margin: 0;
            color: #777;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #ffffff;
            background-color: #FF5330; /* Bright orange */
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mot de passe changé</h1>
        </div>
        <div class="content">
            <h2>Bonjour {{ $client->name }},</h2>
            <p>Nous vous informons que votre mot de passe a été changé avec succès.</p>
            <p>Si vous n'avez pas demandé cette modification, veuillez contacter notre support.</p>
            <a href="mailto:support@360tn.com" class="button">Contacter le support</a>
        </div>
        <div class="footer">
            <p>Cordialement,<br>360 TN Support</p>
            <p>© 2024 360 TN. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
