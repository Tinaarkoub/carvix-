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
        background:linear-gradient(135deg, #20291f 0%, #3a4a3a 100%);
        border-radius:24px;
        padding:36px 40px;
        margin:24px 20px 40px;
        position:relative;
        overflow:hidden;
    }

    .stat-bar::before{
        content:"";
        position:absolute;
        top:-40px;
        right:-40px;
        width:180px;
        height:180px;
        background:rgba(242,161,84,.15);
        border-radius:50%;
    }

    .stat-bar::after{
        content:"";
        position:absolute;
        bottom:-60px;
        left:30%;
        width:140px;
        height:140px;
        background:rgba(255,255,255,.05);
        border-radius:50%;
    }

    .stat-inner{
        position:relative;
        display:flex;
        align-items:center;
        justify-content:space-between;
        flex-wrap:wrap;
        gap:30px;
    }

    .stat-group{
        display:flex;
        gap:50px;
        flex-wrap:wrap;
    }

    .stat-divider{
        width:1px;
        background:rgba(255,255,255,.15);
    }

    .stat-item .field-value{
        font-size:42px;
        font-weight:800;
        color:#fff;
        line-height:1;
    }

    .stat-item .field-label{
        font-size:13px;
        color:#c8d0c4;
        margin-top:6px;
    }

    .btn-catalogue-premium{
        background:var(--accent);
        color:#20291f;
        padding:14px 28px;
        border-radius:30px;
        font-weight:700;
        font-size:14px;
        text-decoration:none;
        display:flex;
        align-items:center;
        gap:8px;
        box-shadow:0 8px 20px rgba(242,161,84,.3);
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
        margin-bottom:32px;
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

    .filter-bar{
        background:#ffffff;
        border:1px solid rgba(0,0,0,.06);
        border-radius:20px;
        padding:22px 28px;
        margin-bottom:24px;
    }
    .filter-bar .field-label{
        font-size:12px;
        opacity:.7;
        margin-bottom:4px;
    }
    .filter-bar input{
        width:100%;
        background:var(--page-bg);
        border:1px solid rgba(0,0,0,.1);
        border-radius:10px;
        padding:8px 10px;
        color:var(--text-dark);
        font-size:14px;
    }
    .filter-bar .btn-search{
        background:var(--accent);
        border:none;
        border-radius:12px;
        padding:10px 18px;
        font-weight:600;
        color:#20291f;
        width:100%;
    }

    .card{
        background:var(--card-bg);
        border:1px solid rgba(0,0,0,.05);
        border-radius:18px;
        overflow:hidden;
        color:var(--text-dark);
    }
    .card img{ height:180px; object-fit:cover; }
    .price{ font-weight:800; color:var(--text-dark); font-size:17px; }
    .price span{ font-size:12px; font-weight:400; color:var(--text-muted); }
    .car-specs{ font-size:12px; color:var(--text-muted); margin:6px 0 12px; }
    .btn-pill-dark{
        background:var(--pill-dark);
        color:#fff;
        border:none;
        border-radius:30px;
        padding:10px 24px;
        font-weight:600;
        text-decoration:none;
        display:inline-block;
    }
</style>

<div class="dash-wrap">

    <div class="page-header">
        <h1>Bonjour {{ Auth::user()->name }} 👋</h1>
        <p>Voici un aperçu de votre espace client.</p>
    </div>

    <div class="stat-bar">
        <div class="stat-inner">
            <div class="stat-group">
                <div class="stat-item">
                    <div class="field-value">{{ $enCours }}</div>
                    <div class="field-label">🚗 Réservations en cours</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="field-value">{{ $reservations->count() }}</div>
                    <div class="field-label">📋 Total réservations</div>
                </div>
            </div>
            <a href="#vehicules" class="btn-catalogue-premium">🔍 Voir les véhicules</a>
        </div>
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
        @endif

        <h3 id="vehicules" style="font-weight:800; color:var(--text-dark); margin-bottom:16px;">Nos véhicules disponibles</h3>

        <form action="{{ route('dashboard') }}" method="GET" class="filter-bar">
            <div class="row g-3 align-items-end">
                <div class="col-6 col-md-3">
                    <div class="field-label">🚗 Marque</div>
                    <input type="text" name="marque" placeholder="Ex: Peugeot" value="{{ request('marque') }}">
                </div>
                <div class="col-6 col-md-3">
                    <div class="field-label">🚘 Modèle</div>
                    <input type="text" name="modele" placeholder="Ex: 208" value="{{ request('modele') }}">
                </div>
                <div class="col-6 col-md-3">
                    <div class="field-label">📅 Mise en circulation min.</div>
                    <input type="date" name="date_mise_en_circulation" value="{{ request('date_mise_en_circulation') }}">
                </div>
                <div class="col-6 col-md-3">
                    <div class="field-label">💶 Prix max / jour</div>
                    <input type="number" name="prix_max" min="1" placeholder="Ex: 100" value="{{ request('prix_max') }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn-search">🔍 Rechercher</button>
                </div>
            </div>
        </form>

        @if($vehicules->count())
            <div class="row g-4">
                @foreach($vehicules as $vehicule)
                <div class="col-md-4">
                    <div class="card h-100">
                        @if($vehicule->image)
                            <img src="{{ asset('storage/'.$vehicule->image) }}" class="card-img-top" alt="{{ $vehicule->nom }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height:180px;">
                                <span class="text-muted">Aucune image</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="mb-1">{{ $vehicule->marque }} {{ $vehicule->modele }}</h5>
                            <div class="car-specs">
                                @if($vehicule->categorie)
                                    <span>🏷️ {{ $vehicule->categorie->nom }}</span>
                                @endif
                                <span> ⛽ {{ $vehicule->carburant }}</span>
                            </div>
                            <div class="price mb-2">{{ $vehicule->prix_par_jour }} € <span>/ jour</span></div>

                            @php
                                $disabledRanges = $vehicule->reservations->map(function ($r) {
                                    return ['from' => $r->date_debut->format('Y-m-d'), 'to' => $r->date_fin->format('Y-m-d')];
                                });
                            @endphp
                            <form method="POST" action="{{ route('reservations.store', $vehicule) }}" class="reserve-dates">
                                @csrf
                                <input type="text" name="date_debut" class="form-control flatpickr-debut mb-2" placeholder="Date début" data-disabled="{{ $disabledRanges->toJson() }}" required readonly>
                                <input type="text" name="date_fin" class="form-control flatpickr-fin mb-2" placeholder="Date fin" data-disabled="{{ $disabledRanges->toJson() }}" required readonly>
                                <button type="submit" class="btn-pill-dark w-100" style="border:none;">Réserver</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>😕 Aucun véhicule ne correspond à votre recherche</h3>
                <a href="{{ route('dashboard') }}" class="btn-pill-dark" style="border:none; margin-top:10px;">Réinitialiser les filtres</a>
            </div>
        @endif

    </div>

</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.flatpickr-debut, .flatpickr-fin').forEach(function (el) {
        const disabled = JSON.parse(el.dataset.disabled || '[]');
        flatpickr(el, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd/m/Y', minDate: 'today', disable: disabled });
    });
});
</script>

</x-app-layout>