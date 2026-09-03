<x-app-layout>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>

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

    .catalogue-wrap{
        background:var(--page-bg);
        color:var(--text-dark);
        margin:-1.5rem;
        padding:1px 0 40px;
    }

    .hero-section{
        background:var(--hero-bg);
        border-radius:24px;
        margin:20px;
        padding:24px 32px 0;
        overflow:hidden;
    }

    .hero-content{
        display:flex;
        align-items:center;
        gap:32px;
        flex-wrap:wrap;
    }

    .hero-text{
        flex:1;
        min-width:260px;
        padding-bottom:32px;
    }

    .hero-text h1{
        font-size:32px;
        font-weight:800;
        line-height:1.15;
        margin:0 0 10px;
    }

    .hero-text p{
        color:var(--text-muted);
        font-size:15px;
        margin:0;
    }

    .hero-image-wrap{
        flex:1;
        min-width:260px;
        background:#fff;
        border-radius:18px;
        padding:10px;
        box-shadow:0 12px 24px rgba(0,0,0,.08);
    }

    .hero-image-wrap img{
        width:100%;
        height:180px;
        object-fit:cover;
        border-radius:12px;
        display:block;
    }

    .filter-bar{
        background:#ffffff;
        border:1px solid rgba(0,0,0,.06);
        border-radius:20px;
        padding:22px 28px;
        margin:0 20px;
        color:var(--text-dark);
        transform:translateY(-24px);
        box-shadow:0 12px 24px rgba(0,0,0,.06);
    }

    .filter-bar .field-label{
        font-size:12px;
        opacity:.7;
        margin-bottom:4px;
    }

    .filter-bar select,
    .filter-bar input{
        width:100%;
        background:var(--page-bg);
        border:1px solid rgba(0,0,0,.1);
        border-radius:10px;
        padding:8px 10px;
        color:var(--text-dark);
        font-size:14px;
    }

    .filter-bar select option{
        color:#20291f;
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

    .container-cars{
        padding:0 20px;
        margin-top:-10px;
    }

    .card{
        background:var(--card-bg);
        border:1px solid rgba(0,0,0,.05);
        border-radius:18px;
        overflow:hidden;
        color:var(--text-dark);
        transition:transform .2s ease, box-shadow .2s ease;
    }

    .card:hover{
        transform:translateY(-4px);
        box-shadow:0 12px 24px rgba(0,0,0,.08);
    }

    .card img{
        height:180px;
        object-fit:cover;
    }

    .card .price{
        font-weight:800;
        color:var(--text-dark);
        font-size:17px;
    }

    .card .price span{
        font-size:12px;
        font-weight:400;
        color:var(--text-muted);
    }

    .car-specs{
        font-size:12px;
        color:var(--text-muted);
        margin:6px 0 12px;
    }

    .car-specs span{
        margin-right:10px;
    }

    .btn-pill-dark{
        background:var(--pill-dark);
        color:#fff;
        border:none;
        border-radius:30px;
        padding:10px 24px;
        font-weight:600;
        text-decoration:none;
        display:inline-block;
        transition:background .2s ease;
    }

    .btn-pill-dark:hover{
        background:var(--pill-dark-hover);
        color:#fff;
    }

    .reserve-dates input{
        border-radius:10px;
        padding:6px 10px;
        font-size:13px;
        margin-bottom:6px;
    }

    .empty-state{
        text-align:center;
        padding:60px 20px;
        color:var(--text-muted);
    }

    .alert-message{
        padding:14px 20px;
        border-radius:12px;
        margin:20px 20px 0;
        font-weight:600;
        font-size:14px;
    }

    .alert-error{
        background:#f8d7da;
        color:#842029;
        border:1px solid #f1aeb5;
    }

    .alert-success{
        background:#d1e7dd;
        color:#0f5132;
        border:1px solid #a3cfbb;
    }

    .flatpickr-calendar {
        z-index: 9999 !important;
    }

    .flatpickr-day {
        color: var(--text-dark) !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    .flatpickr-day.flatpickr-disabled,
    .flatpickr-day.flatpickr-disabled:hover {
        color: #cfcfcf !important;
        text-decoration: line-through;
        cursor: not-allowed;
        pointer-events: none !important;
    }

    .flatpickr-day.selected {
        background: var(--pill-dark) !important;
        border-color: var(--pill-dark) !important;
    }

    .flatpickr-day.today {
        border-color: var(--accent) !important;
    }
</style>

<div class="catalogue-wrap">

    @if (session('error'))
        <div class="alert-message alert-error">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert-message alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="hero-section">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Notre catalogue de voitures</h1>
                <p>Trouvez la voiture idéale parmi notre sélection, prête à réserver en quelques clics.</p>
            </div>
            <div class="hero-image-wrap">
                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=600&q=80" alt="Voiture">
            </div>
        </div>
    </div>

    <form action="{{ route('catalogue.index') }}" method="GET" class="filter-bar">
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
                <input type="number" name="prix_max" min="1" step="1" placeholder="Ex: 100" value="{{ request('prix_max') }}">
            </div>

            <div class="col-12">
                <button type="submit" class="btn-search">🔍 Rechercher</button>
            </div>
        </div>
    </form>

    <div class="container-cars">

        @if($vehicules->count())

            <div class="row g-4">

                @foreach($vehicules as $vehicule)

                <div class="col-md-4">
                    <div class="card h-100">

                        @if($vehicule->image)
                            <img src="{{ asset('storage/'.$vehicule->image) }}"
                                 class="card-img-top"
                                 alt="{{ $vehicule->nom }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light"
                                 style="height:180px;">
                                <span class="text-muted">Aucune image</span>
                            </div>
                        @endif

                        <div class="card-body">

                            <h5 class="mb-1">{{ $vehicule->marque }} {{ $vehicule->modele }}</h5>

                            <div class="car-specs">
                                @if($vehicule->categorie)
                                    <span>🏷️ {{ $vehicule->categorie->nom }}</span>
                                @endif
                                <span>⛽ {{ $vehicule->carburant }}</span>
                                <span>⚙️ {{ $vehicule->transmission }}</span>
                            </div>

                            <div class="price mb-2">
                                {{ $vehicule->prix_par_jour }} € <span>/ jour</span>
                            </div>

                            @auth
                                @if(Auth::user()->role === 'client')

                                    @php
                                        $disabledRanges = $vehicule->reservations->map(function ($r) {
                                            return [
                                                'from' => $r->date_debut->format('Y-m-d'),
                                                'to' => $r->date_fin->format('Y-m-d'),
                                            ];
                                        });
                                    @endphp

                                    <form method="POST" action="{{ route('reservations.store', $vehicule) }}" class="reserve-dates">
                                        @csrf

                                        <label style="font-size:12px; color:var(--text-muted); font-weight:600; display:block; margin-bottom:2px;">
                                            Date de début
                                        </label>
                                        <input type="text"
                                               name="date_debut"
                                               class="form-control flatpickr-debut"
                                               placeholder="jj/mm/aaaa"
                                               data-disabled="{{ $disabledRanges->toJson() }}"
                                               required
                                               readonly>

                                        <label style="font-size:12px; color:var(--text-muted); font-weight:600; display:block; margin:8px 0 2px;">
                                            Date de fin
                                        </label>
                                        <input type="text"
                                               name="date_fin"
                                               class="form-control flatpickr-fin"
                                               placeholder="jj/mm/aaaa"
                                               data-disabled="{{ $disabledRanges->toJson() }}"
                                               required
                                               readonly>

                                        <button type="submit" class="btn-pill-dark w-100" style="border:none; margin-top:10px;">
                                            Réserver
                                        </button>
                                    </form>

                                @endif
                            @endauth

                        </div>

                    </div>
                </div>

                @endforeach

            </div>

        @else

            <div class="empty-state">
                @if(request()->hasAny(['marque', 'modele', 'date_mise_en_circulation', 'prix_max']))
                    <h3>😕 Aucun véhicule ne correspond à votre recherche</h3>
                    <p>Essayez de modifier ou de réinitialiser vos critères de recherche.</p>
                    <a href="{{ route('catalogue.index') }}" class="btn-pill-dark" style="border:none; margin-top:10px;">
                        Réinitialiser les filtres
                    </a>
                @else
                    <h3>😕 Aucune voiture disponible pour le moment</h3>
                    <p>Reviens un peu plus tard, de nouveaux véhicules arrivent bientôt.</p>
                @endif
            </div>

        @endif

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.flatpickr-debut').forEach(function (el) {
        const disabled = JSON.parse(el.dataset.disabled || '[]');

        const fp = flatpickr(el, {
            locale: 'fr',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd/m/Y',
            minDate: 'today',
            disable: disabled,
        });

        el.closest('form').addEventListener('reservation:fin-changed', function () {});
    });

    document.querySelectorAll('.flatpickr-fin').forEach(function (el) {
        const disabled = JSON.parse(el.dataset.disabled || '[]');

        flatpickr(el, {
            locale: 'fr',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd/m/Y',
            minDate: 'today',
            disable: disabled,
        });
    });

});
</script>

</x-app-layout>