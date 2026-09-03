<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Carvix</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f5f1;
        }

        .split-wrap {
            display: flex;
            min-height: 100vh;
        }

        .split-image {
            flex: 1.1;
            position: relative;
            background: #20291f;
        }

        .split-image img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .split-image .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(35,42,36,.1), rgba(35,42,36,.85));
        }

        .split-image .content {
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
        }

        .split-image .brand {
            color: #fff;
            font-weight: 800;
            font-size: 24px;
            text-decoration: none;
        }

        .split-image .tagline {
            color: #fff;
            font-size: 34px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            max-width: 420px;
        }

        .badges {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge {
            background: rgba(255,255,255,.15);
            color: #fff;
            font-size: 13px;
            padding: 8px 14px;
            border-radius: 30px;
        }

        .split-form {
            flex: 1;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            overflow-y: auto;
        }

        .form-inner {
            width: 100%;
            max-width: 380px;
        }

        .form-inner h1 {
            font-size: 28px;
            font-weight: 800;
            color: #20291f;
            margin: 0 0 6px;
        }

        .form-inner .subtitle {
            font-size: 14px;
            color: #5c6b57;
            margin-bottom: 28px;
        }

        .status-message {
            background: #d1e7dd;
            color: #0f5132;
            border: 1px solid #a3cfbb;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #20291f;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            border: 1px solid #d8ddd4;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            margin-bottom: 6px;
            background: #f9faf7;
        }

        input:focus {
            outline: none;
            border-color: #232a24;
            background: #fff;
        }

        .field-error {
            color: #c1121f;
            font-size: 12px;
            margin-bottom: 14px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 14px 0 22px;
        }

        .remember-row input {
            width: auto;
            margin: 0;
        }

        .remember-row label {
            margin: 0;
            font-weight: 400;
            color: #5c6b57;
        }

        .forgot-link {
            display: block;
            text-align: right;
            font-size: 13px;
            color: #5c6b57;
            text-decoration: underline;
            margin-bottom: 18px;
        }

        button {
            width: 100%;
            background: #232a24;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 14px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
        }

        button:hover {
            background: #333d33;
        }

        .footer-link {
            text-align: center;
            font-size: 13px;
            color: #5c6b57;
            margin-top: 18px;
        }

        .footer-link a {
            color: #20291f;
            font-weight: 600;
            text-decoration: none;
        }

        @media (max-width: 900px) {
            .split-wrap { flex-direction: column; }
            .split-image { min-height: 220px; }
        }
    </style>
</head>
<body>

<div class="split-wrap">

    <div class="split-image">
        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=80" alt="Voiture Carvix">
        <div class="overlay"></div>
        <div class="content">
            <a href="{{ route('home') }}" class="brand">carvix</a>
            <div>
                <div class="tagline">Content de vous revoir</div>
                <div class="badges">
                    <div class="badge">🛡️ Assurance incluse</div>
                    <div class="badge">⏱️ Réservation en 2 min</div>
                    <div class="badge">🚗 +200 véhicules</div>
                </div>
            </div>
        </div>
    </div>

    <div class="split-form">
        <div class="form-inner">
            <h1>Connexion</h1>
            <div class="subtitle">Accédez à votre espace Carvix</div>

            @if (session('status'))
                <div class="status-message">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="vous@email.com">
                @if($errors->get('email'))
                    <div class="field-error">{{ $errors->first('email') }}</div>
                @endif

                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                @if($errors->get('password'))
                    <div class="field-error">{{ $errors->first('password') }}</div>
                @endif

                <div class="remember-row">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Se souvenir de moi</label>
                </div>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                @endif

                <button type="submit">Se connecter</button>

                <div class="footer-link">
                    Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
                </div>
            </form>
        </div>
    </div>

</div>

</body>
</html>