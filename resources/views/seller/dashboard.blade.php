<x-app-layout>

<style>
    :root{
        --page-bg:#f4f5f1;
        --hero-bg:#cfdccb;
        --text-dark:#20291f;
        --text-muted:#5c6b57;
        --pill-dark:#232a24;
        --pill-dark-hover:#333d33;
        --card-bg:#ffffff;
        --accent:#f2a154;
    }

    .dash-wrap{
        background:var(--page-bg);
        margin:-1.5rem;
        padding:1px 0 40px;
    }

    .dash-hero{
        background:var(--hero-bg);
        border-radius:24px;
        margin:20px;
        padding:40px;
        position:relative;
        overflow:hidden;
        min-height:220px;
        display:flex;
        align-items:center;
    }

    .dash-hero-content{
        position:relative;
        z-index:2;
        max-width:55%;
    }

    .dash-hero h1{
        font-size:32px;
        font-weight:800;
        color:var(--text-dark);
        margin-bottom:8px;
    }

    .dash-hero p{
        color:var(--text-muted);
        font-size:15px;
    }

    .dash-hero-img{
        position:absolute;
        right:-20px;
        bottom:0;
        height:100%;
        width:55%;
        object-fit:cover;
        object-position:left center;
        mask-image:linear-gradient(to left, rgba(0,0,0,1) 70%, rgba(0,0,0,0) 100%);
        -webkit-mask-image:linear-gradient(to left, rgba(0,0,0,1) 70%, rgba(0,0,0,0) 100%);
    }

    .dash-stats{
        padding:0 20px;
    }

    .stat-card{
        background:var(--card-bg);
        border-radius:20px;
        padding:24px;
        border:1px solid rgba(0,0,0,.05);
        height:100%;
    }

    .stat-card .stat-label{
        color:var(--text-muted);
        font-size:13px;
        margin-bottom:6px;
    }

    .stat-card .stat-value{
        font-size:36px;
        font-weight:800;
        color:var(--text-dark);
    }

    .action-card{
        background:var(--pill-dark);
        border-radius:20px;
        padding:24px;
        display:flex;
        flex-direction:column;
        gap:10px;
        justify-content:center;
        height:100%;
    }

    .btn-pill-dark{
        background:#fff;
        color:var(--pill-dark);
        border:none;
        border-radius:30px;
        padding:12px 20px;
        font-weight:600;
        text-decoration:none;
        text-align:center;
        display:block;
        transition:opacity .2s ease;
    }

    .btn-pill-dark:hover{
        opacity:.85;
        color:var(--pill-dark);
    }

    .btn-pill-outline{
        background:transparent;
        color:#fff;
        border:1.5px solid rgba(255,255,255,.35);
        border-radius:30px;
        padding:12px 20px;
        font-weight:600;
        text-decoration:none;
        text-align:center;
        display:block;
        transition:border-color .2s ease;
    }

    .btn-pill-outline:hover{
        border-color:#fff;
        color:#fff;
    }

    @media (max-width:768px){
        .dash-hero-content{ max-width:100%; }
        .dash-hero-img{ display:none; }
    }
</style>

<div class="dash-wrap">

    <div class="dash-hero">
        <img class="dash-hero-img"
             src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=80"
             alt="Véhicule">
        <div class="dash-hero-content">
            <h1>Bonjour {{ Auth::user()->name }}</h1>
            <p>Voici un aperçu de votre activité de propriétaire sur Carvix.</p>
        </div>
    </div>

    <div class="dash-stats">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-label">Mes véhicules</div>
                    <div class="stat-value">{{ $vehicules }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-label">Réservations reçues</div>
                    <div class="stat-value">{{ $reservations }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-label">Revenus</div>
                    <div class="stat-value">{{ $revenus }} €</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="action-card">
                    <a href="{{ route('seller.products') }}" class="btn-pill-dark">Mes véhicules</a>
                    <a href="{{ route('seller.products.create') }}" class="btn-pill-outline">Ajouter un véhicule</a>
                </div>
            </div>
        </div>
    </div>

</div>

</x-app-layout>