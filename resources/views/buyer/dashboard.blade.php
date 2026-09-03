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

    .page-header{
        padding:40px 20px 0;
        text-align:center;
    }

    .page-header h1{
        font-size:34px;
        font-weight:800;
        color:var(--text-dark);
    }

    .page-header p{
        color:var(--text-muted);
    }

    .stat-bar{
        background:var(--pill-dark);
        border-radius:20px;
        padding:28px 32px;
        margin:24px 20px 40px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:24px;
        flex-wrap:wrap;
        color:#dfe3dc;
    }

    .stat-item .field-label{
        font-size:13px;
        opacity:.7;
        margin-bottom:4px;
    }

    .stat-item .field-value{
        font-weight:700;
        font-size:22px;
        color:#fff;
    }

    .btn-search-pill{
        background:var(--accent);
        border:none;
        border-radius:12px;
        padding:12px 26px;
        font-weight:600;
        color:#20291f;
        text-decoration:none;
        white-space:nowrap;
    }

    .container-cards{
        padding:0 20px;
    }

    .info-card{
        background:var(--card-bg);
        border:1px solid rgba(0,0,0,.05);
        border-radius:20px;
        padding:28px;
    }

    .info-card h5{
        font-weight:700;
        color:var(--text-dark);
        margin-bottom:14px;
    }

    .empty-state{
        text-align:center;
        padding:60px 20px;
        color:var(--text-muted);
    }

    .badge-pill{
        display:inline-block;
        padding:6px 14px;
        border-radius:20px;
        font-size:12px;
        font-weight:600;
    }
    .badge-confirmee{ background:#dff0e0; color:#1d7a3c; }
    .badge-annulee{ background:#fbe0df; color:#b23b34; }
    .badge-autre{ background:#eee; color:var(--text-muted); }
</style>

<div class="dash-wrap">

    <div class="page-header">
        <h1>Bonjour {{ Auth::user()->name }} 👋</h1>
        <p>Voici un aperçu de votre espace client.</p>
    </div>

    <div class="stat-bar">
        <div class="stat-item">
            <div class="field-label">🚗 Réservations en cours</div>
            <div class="field-value">{{ $enCours }}</div>
        </div>
        <div class="stat-item">
            <div class="field-label">📋 Total réservations</div>
            <div class="field-value">{{ $reservations->count() }}</div>
        </div>
        <a href="{{ route('catalogue.index') }}" class="btn-search-pill">🔍 Voir le catalogue</a>
    </div>

    <div class="container-cards">

        @if($derniere)
        <div class="info-card">
            <h5>Dernière réservation</h5>
            <p class="mb-1" style="font-size:17px; font-weight:700; color:var(--text-dark);">
                {{ $derniere->vehicule->marque }} {{ $derniere->vehicule->modele }}
            </p>
            <p class="mb-2" style="color:var(--text-muted);">
                Du {{ $derniere->date_debut->format('d/m/Y') }} au {{ $derniere->date_fin->format('d/m/Y') }}
                &middot; {{ $derniere->montant_total }} €
            </p>
            <span class="badge-pill badge-{{ $derniere->statut === 'confirmee' ? 'confirmee' : ($derniere->statut === 'annulee' ? 'annulee' : 'autre') }}">
                {{ $derniere->statut }}
            </span>
        </div>
        @else
        <div class="empty-state">
            <h3>😕 Aucune réservation pour le moment</h3>
            <p>Découvrez notre catalogue et réservez votre première voiture.</p>
            <a href="{{ route('catalogue.index') }}" class="btn-search-pill" style="display:inline-block; margin-top:12px;">Découvrir le catalogue</a>
        </div>
        @endif

    </div>

</div>

</x-app-layout>