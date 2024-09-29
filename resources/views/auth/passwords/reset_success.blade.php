<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe changé</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: background-color 0.3s;
        }

        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            width: 350px;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            color: #2B2B68; /* Color(0xFF2B2B68) */
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
            color: #555;
        }

        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 30px;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #FF5330; /* Color(0xFFFF5330) */
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .button:hover {
            background-color: #e94e29; /* Darker shade for hover effect */
            transform: translateY(-3px);
        }

        .button:active {
            transform: translateY(1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Succès!</h1>
        <p>Votre mot de passe a été changé avec succès.</p>
        <p>Si vous n'avez pas demandé cette modification, veuillez contacter notre support.</p>
        <!-- <a href="/" class="button">Retour à l'accueil</a> -->
        <div class="footer">Cordialement,<br>360 TN Support</div>
    </div>
</body>
</html>
