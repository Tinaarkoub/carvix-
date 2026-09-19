<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carvix - Location de voitures</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root{
            --page-bg:#f4f5f1;
            --hero-bg:#cfdccb;
            --text-dark:#20291f;
            --text-muted:#5c6b57;
            --pill-dark:#232a24;
            --pill-dark-hover:#333d33;
            --accent:#f2a154;
        }

        * { box-sizing: border-box; }

        body{
            font-family: Arial, Helvetica, sans-serif;
            background:var(--page-bg);
            color:var(--text-dark);
            margin:0;
        }

        .hero-section{
            background:var(--hero-bg);
            border-radius:28px;
            margin:20px;
            padding:32px 40px 0;
            overflow:hidden;
        }

        .top-nav{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:40px;
        }

        .top-nav .brand{
            font-weight:bold;
            font-size:22px;
            color:var(--text-dark);
            text-decoration:none;
        }

        .top-nav .links{
            display:flex;
            gap:32px;
        }

        .top-nav .links a{
            color:var(--text-dark);
            text-decoration:none;
            font-size:15px;
            opacity:.85;
        }

        .top-nav .links a:hover{ opacity:1; }

        .top-nav .actions{
            display:flex;
            gap:12px;
            align-items:center;
        }

        .btn-pill-dark{
            background:var(--pill-dark);
            color:#fff;
            border:none;
            border-radius:30px;
            padding:12px 28px;
            font-weight:600;
            text-decoration:none;
            display:inline-block;
            transition:background .2s ease;
        }

        .btn-pill-dark:hover{
            background:var(--pill-dark-hover);
            color:#fff;
        }

        .btn-pill-outline{
            background:transparent;
            color:var(--pill-dark);
            border:2px solid var(--pill-dark);
            border-radius:30px;
            padding:10px 24px;
            font-weight:600;
            text-decoration:none;
            display:inline-block;
            transition:background .2s ease, color .2s ease;
        }

        .btn-pill-outline:hover{
            background:var(--pill-dark);
            color:#fff;
        }

        .hero-content{
            display:flex;
            align-items:center;
            gap:40px;
            flex-wrap:wrap;
        }

        .hero-text{
            flex:1;
            min-width:280px;
            padding-bottom:40px;
        }

        .hero-text h1{
            font-size:44px;
            font-weight:800;
            line-height:1.15;
            margin:0 0 20px;
        }

        .hero-text p{
            color:var(--text-muted);
            font-size:16px;
            margin-bottom:28px;
            max-width:420px;
        }

        .hero-image-wrap{
            flex:1;
            min-width:320px;
            background:#fff;
            border-radius:24px;
            padding:14px;
            box-shadow:0 20px 40px rgba(0,0,0,.08);
        }

        .hero-image-wrap img{
            width:100%;
            height:320px;
            object-fit:cover;
            border-radius:16px;
            display:block;
        }

        .filter-bar{
            background:var(--pill-dark);
            border-radius:20px;
            padding:24px 32px;
            margin:0 20px 40px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:24px;
            flex-wrap:wrap;
            transform:translateY(-30px);
            color:#dfe3dc;
        }

        .filter-item .field-label{
            font-size:13px;
            opacity:.7;
            margin-bottom:4px;
            display:flex;
            align-items:center;
            gap:6px;
        }

        .filter-item .field-value{
            font-weight:700;
            font-size:15px;
            color:#fff;
        }

        .filter-input{
            background:transparent;
            border:none;
            border-bottom:1px solid rgba(255,255,255,.3);
            color:#fff;
            font-weight:700;
            font-size:15px;
            padding:2px 0;
            width:140px;
        }

        .filter-input::placeholder{
            color:rgba(255,255,255,.5);
            font-weight:400;
        }

        .filter-input:focus{
            outline:none;
            border-bottom-color:#fff;
        }

        .btn-search-circle{
            background:var(--accent);
            border:none;
            border-radius:50%;
            width:52px;
            height:52px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:18px;
            cursor:pointer;
            flex-shrink:0;
        }

        @media (max-width:768px){
            .top-nav .links{ display:none; }
            .hero-text h1{ font-size:32px; }
            .filter-bar{ justify-content:flex-start; }
        }
    </style>
</head>
<body>

<div class="hero-section">

    <div class="top-nav">
        <a href="{{ route('home') }}" class="brand">Carvix</a>
        <div class="links">
            <a href="{{ route('home') }}">Accueil</a>
            <a href="{{ route('catalogue.index') }}">Catalogue</a>
            <a href="mailto:carvixcarvix@gmail.com">Contactez-nous</a>
        </div>
        <div class="actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-pill-dark">Mon espace</a>
            @else
                <a href="{{ route('register') }}" class="btn-pill-outline">Inscription</a>
                <a href="{{ route('login') }}" class="btn-pill-dark">Connexion</a>
            @endauth
        </div>
    </div>

    <div class="hero-content">
        <div class="hero-text">
            <h1>Louez la voiture parfaite avec nous</h1>
            <p>Réservez votre voiture de location dès aujourd'hui. Nous garantissons les meilleurs prix.</p>
            <a href="{{ route('catalogue.index') }}" class="btn-pill-dark">Commencer</a>
        </div>

        <div class="hero-image-wrap">
            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=80" alt="Voiture de location">
        </div>
    </div>

</div>

<form action="{{ route('catalogue.index') }}" method="GET" class="filter-bar">
    <div class="filter-item">
        <div class="field-label">🚗 Marque</div>
        <input type="text" name="marque" placeholder="Ex: Peugeot" class="filter-input">
    </div>
    <div class="filter-item">
        <div class="field-label">🚘 Modèle</div>
        <input type="text" name="modele" placeholder="Ex: 208" class="filter-input">
    </div>
    <div class="filter-item">
        <div class="field-label">💶 Prix max / jour</div>
        <input type="number" name="prix_max" min="1" step="1" placeholder="Ex: 100" class="filter-input">
    </div>
    <button type="submit" class="btn-search-circle">🔍</button>
</form>

<x-cookie-consent />
<x-accessibility-bar />

@include('partials.footer')

</body>
</html>