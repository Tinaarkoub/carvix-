
Navigation.blade · PHP
<div style="background:#cfdccb; border-radius:24px; margin:20px; padding:18px 32px; display:flex; justify-content:space-between; align-items:center; font-family:Arial,Helvetica,sans-serif;">
 
    <a href="{{ route('home') }}" style="font-weight:bold; font-size:20px; color:#20291f; text-decoration:none;">
        carvix
    </a>
 
    <div style="display:flex; gap:28px; align-items:center;">
        <a href="{{ route('home') }}" style="color:#20291f; text-decoration:none; opacity:.85; font-size:15px;">Accueil</a>
 
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" style="color:#20291f; text-decoration:none; opacity:.85; font-size:15px;">Dashboard admin</a>
                <a href="{{ route('categories.index') }}" style="color:#20291f; text-decoration:none; opacity:.85; font-size:15px;">Catégories</a>
            @endif
 
            @if(Auth::user()->role === 'proprietaire')
                <a href="{{ route('seller.products') }}" style="color:#20291f; text-decoration:none; opacity:.85; font-size:15px;">Mes véhicules</a>
            @endif
 
            @if(Auth::user()->role === 'client')
                <a href="{{ route('orders.my') }}" style="color:#20291f; text-decoration:none; opacity:.85; font-size:15px;">Mes réservations</a>
 
                <a href="{{ route('documents.show') }}" style="color:#20291f; text-decoration:none; opacity:.85; font-size:15px; position:relative;">
                    Mes documents
                    @if(Auth::user()->statut_documents === 'non_soumis' || Auth::user()->statut_documents === 'refuse')
                        <span style="display:inline-block; width:8px; height:8px; background:#c1121f; border-radius:50%; margin-left:5px; vertical-align:middle;"></span>
                    @elseif(Auth::user()->statut_documents === 'en_attente')
                        <span style="display:inline-block; width:8px; height:8px; background:#e8a33d; border-radius:50%; margin-left:5px; vertical-align:middle;"></span>
                    @elseif(Auth::user()->statut_documents === 'valide')
                        <span style="display:inline-block; width:8px; height:8px; background:#2f9e44; border-radius:50%; margin-left:5px; vertical-align:middle;"></span>
                    @endif
                </a>
            @endif
        @endauth
    </div>
 
    <div style="display:flex; gap:12px; align-items:center;">
        @auth
            <span style="color:#20291f; font-size:14px; opacity:.75;">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background:#232a24; color:#fff; border:none; border-radius:30px; padding:10px 20px; font-weight:600; font-size:14px; cursor:pointer;">
                    Déconnexion
                </button>
            </form>
        @else
            <a href="{{ route('register') }}" style="background:transparent; color:#232a24; border:2px solid #232a24; border-radius:30px; padding:8px 20px; font-weight:600; text-decoration:none; font-size:14px;">
                Inscription
            </a>
            <a href="{{ route('login') }}" style="background:#232a24; color:#fff; border-radius:30px; padding:10px 22px; font-weight:600; text-decoration:none; font-size:14px;">
                Connexion
            </a>
        @endauth
    </div>
 
</div>
 
