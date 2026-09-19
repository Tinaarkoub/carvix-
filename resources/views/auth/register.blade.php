<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Carvix</title>
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

        label {
            font-size: 13px;
            font-weight: 600;
            color: #20291f;
            display: block;
            margin-bottom: 6px;
        }

        .required-star {
            color: #c1121f;
            margin-left: 3px;
        }

        input, select {
            width: 100%;
            border: 1px solid #d8ddd4;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            margin-bottom: 6px;
            background: #f9faf7;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #232a24;
            background: #fff;
        }

        .field-error {
            color: #c1121f;
            font-size: 12px;
            margin-bottom: 14px;
        }

        .password-wrap {
            position: relative;
        }

        .password-wrap input {
            padding-right: 44px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            width: auto;
            padding: 0;
            margin: 0;
            cursor: pointer;
            font-size: 13px;
            color: #5c6b57;
            font-weight: 600;
        }

        .toggle-password:hover {
            background: none;
            color: #20291f;
        }

        button[type="submit"] {
            width: 100%;
            background: #232a24;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 14px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            margin-top: 8px;
        }

        button[type="submit"]:hover {
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
                <div class="tagline">Rejoignez des milliers de conducteurs</div>
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
            <h1>Créer un compte</h1>
            <div class="subtitle">Louez votre prochaine voiture dès aujourd'hui</div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <label for="name">Nom<span class="required-star">*</span></label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Votre nom">
                @if($errors->get('name'))
                    <div class="field-error">{{ $errors->first('name') }}</div>
                @endif

                <label for="email">Email<span class="required-star">*</span></label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="vous@email.com">
                @if($errors->get('email'))
                    <div class="field-error">{{ $errors->first('email') }}</div>
                @endif

                <label for="role">Je suis un(e)<span class="required-star">*</span></label>
                <select id="role" name="role" required>
                    <option value="">-- Choisir --</option>
                    <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>Client</option>
                    <option value="proprietaire" {{ old('role') === 'proprietaire' ? 'selected' : '' }}>Propriétaire</option>
                </select>
                @if($errors->get('role'))
                    <div class="field-error">{{ $errors->first('role') }}</div>
                @endif

                <label for="password">Mot de passe<span class="required-star">*</span></label>
                <div class="password-wrap">
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                    <button type="button" class="toggle-password" onclick="togglePassword('password', this)">Afficher</button>
                </div>
                @if($errors->get('password'))
                    <div class="field-error">{{ $errors->first('password') }}</div>
                @endif

                <label for="password_confirmation">Confirmer le mot de passe<span class="required-star">*</span></label>
                <div class="password-wrap">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                    <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">Afficher</button>
                </div>
                @if($errors->get('password_confirmation'))
                    <div class="field-error">{{ $errors->first('password_confirmation') }}</div>
                @endif

                <button type="submit">S'inscrire</button>

                <div class="footer-link">
                    Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Masquer';
        } else {
            input.type = 'password';
            btn.textContent = 'Afficher';
        }
    }
</script>

</body>
</html>