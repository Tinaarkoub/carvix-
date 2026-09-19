<x-guest-layout>

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

    body{
        font-family: Arial, Helvetica, sans-serif;
        background:var(--pill-dark);
        margin:0;
    }

    .auth-wrap{
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:20px;
    }

    .split-card{
        background:#fff;
        border-radius:28px;
        overflow:hidden;
        display:flex;
        max-width:720px;
        width:100%;
        box-shadow:0 30px 60px rgba(0,0,0,.3);
        flex-wrap:wrap;
    }

    .split-left{
        background:var(--hero-bg);
        flex:1;
        min-width:260px;
        padding:40px;
        display:flex;
        flex-direction:column;
        justify-content:center;
    }

    .split-left .brand{
        font-size:22px;
        font-weight:800;
        color:var(--text-dark);
        margin:0 0 12px;
    }

    .split-left p{
        color:var(--text-muted);
        font-size:13px;
        margin:0;
        line-height:1.5;
    }

    .split-right{
        flex:1;
        min-width:260px;
        padding:40px;
        display:flex;
        flex-direction:column;
        justify-content:center;
    }

    .split-right h1{
        font-size:24px;
        font-weight:800;
        color:var(--text-dark);
        margin:0 0 20px;
    }

    .split-right label{
        display:block;
        font-size:13px;
        font-weight:600;
        color:var(--text-dark);
        margin-bottom:6px;
    }

    .split-right input[type="email"]{
        width:100%;
        background:var(--page-bg);
        border:1px solid rgba(0,0,0,.08);
        border-radius:12px;
        padding:12px 16px;
        font-size:14px;
        color:var(--text-dark);
        margin-bottom:20px;
        box-sizing:border-box;
    }

    .split-right input[type="email"]:focus{
        outline:2px solid var(--accent);
    }

    .btn-pill-dark{
        background:var(--pill-dark);
        color:#fff;
        border:none;
        border-radius:30px;
        padding:12px 28px;
        font-weight:600;
        width:100%;
        cursor:pointer;
        font-size:14px;
        transition:background .2s ease;
    }

    .btn-pill-dark:hover{
        background:var(--pill-dark-hover);
    }

    .status-message{
        background:#d1e7dd;
        color:#0f5132;
        border-radius:12px;
        padding:10px 14px;
        font-size:13px;
        margin-bottom:16px;
    }

    .error-message{
        color:#c1121f;
        font-size:12px;
        margin:-12px 0 16px;
    }

    @media (max-width:600px){
        .split-card{ flex-direction:column; }
    }
</style>

<div class="auth-wrap">
    <div class="split-card">

        <div class="split-left">
            <div class="brand">🚗 carvix</div>
            <p>Réserve la voiture parfaite en quelques clics, où que tu sois en France.</p>
        </div>

        <div class="split-right">
            <h1>Mot de passe oublié</h1>

            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <label for="email">Adresse email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="toi@exemple.com">

                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-pill-dark">
                    Envoyer le lien
                </button>
            </form>
        </div>

    </div>
</div>

</x-guest-layout>