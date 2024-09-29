<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #FF5330, #2B2B68); /* Color gradient */
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .reset-password-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
            animation: fadeIn 1.5s ease;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2B2B68; /* Deep Blue-Violet */
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #666;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 50px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #FF5330; /* Orange-Red Focus */
            background-color: #fff;
            box-shadow: 0 0 8px rgba(255, 83, 48, 0.3);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 50px;
            background: linear-gradient(135deg, #FF5330, #2B2B68); /* Button Gradient */
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #2B2B68, #FF5330);
        }

        .footer-note {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }

        .footer-note p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="reset-password-container">
        <h1>Réinitialiser le mot de passe</h1>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" name="email" id="email" value="{{ $email }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <button type="submit" class="submit-btn">Réinitialiser le mot de passe</button>
        </form>

        <div class="footer-note">
            <p>© 2024 360TN. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
