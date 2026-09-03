<x-app-layout>

<style>
    :root{
        --page-bg:#f4f5f1;
        --text-dark:#20291f;
        --text-muted:#5c6b57;
        --card-bg:#ffffff;
        --accent:#f2a154;
        --pill-dark:#232a24;
    }

    .doc-detail-wrap{
        background:var(--page-bg);
        margin:-1.5rem;
        padding:40px 20px;
        min-height:100%;
    }

    .doc-detail-card{
        max-width:760px;
        margin:0 auto;
        background:var(--card-bg);
        border-radius:20px;
        padding:32px;
        box-shadow:0 12px 24px rgba(0,0,0,.06);
    }

    .doc-detail-card h1{
        font-size:22px;
        font-weight:800;
        color:var(--text-dark);
        margin-bottom:4px;
    }

    .doc-detail-card p.subtitle{
        color:var(--text-muted);
        font-size:14px;
        margin-bottom:24px;
    }

    .doc-preview{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:20px;
        margin-bottom:28px;
    }

    .doc-preview-item{
        border:1px solid rgba(0,0,0,.08);
        border-radius:14px;
        padding:14px;
        text-align:center;
    }

    .doc-preview-item h4{
        font-size:13px;
        color:var(--text-muted);
        margin-bottom:10px;
        text-transform:uppercase;
    }

    .doc-preview-item a{
        display:inline-block;
        margin-top:10px;
        background:var(--pill-dark);
        color:#fff;
        padding:8px 18px;
        border-radius:30px;
        text-decoration:none;
        font-size:13px;
        font-weight:600;
    }

    .doc-actions{
        display:flex;
        gap:16px;
        margin-top:20px;
    }

    .btn-approve{
        flex:1;
        background:#2f9e44;
        color:#fff;
        border:none;
        border-radius:30px;
        padding:12px;
        font-weight:700;
        cursor:pointer;
    }

    .btn-reject{
        flex:1;
        background:#c1121f;
        color:#fff;
        border:none;
        border-radius:30px;
        padding:12px;
        font-weight:700;
        cursor:pointer;
    }

    .back-link{
        display:inline-block;
        margin-bottom:20px;
        color:var(--text-muted);
        text-decoration:none;
        font-size:14px;
    }
</style>

<div class="doc-detail-wrap">
    <div class="doc-detail-card">

        <a href="{{ route('admin.documents.index') }}" class="back-link">← Retour à la liste</a>

        <h1>{{ $user->name }}</h1>
        <p class="subtitle">{{ $user->email }} — Type de pièce : {{ $user->type_piece_identite === 'cni' ? 'Carte d\'identité' : 'Passeport' }}</p>

        <div class="doc-preview">
            <div class="doc-preview-item">
                <h4>Pièce d'identité</h4>
                <a href="{{ route('admin.documents.file', [$user, 'identite']) }}" target="_blank">
                    Voir le fichier
                </a>
            </div>
            <div class="doc-preview-item">
                <h4>Permis de conduire</h4>
                <a href="{{ route('admin.documents.file', [$user, 'permis']) }}" target="_blank">
                    Voir le fichier
                </a>
            </div>
        </div>

        @if($user->statut_documents === 'en_attente')

            <div class="doc-actions">

                <form method="POST" action="{{ route('admin.documents.approve', $user) }}" style="flex:1;">
                    @csrf
                    <button type="submit" class="btn-approve" style="width:100%;">
                        ✅ Valider
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.documents.reject', $user) }}" style="flex:1;" onsubmit="return prepareReject(event)">
                    @csrf
                    <input type="hidden" name="motif_refus" id="motif_refus_input">
                    <button type="submit" class="btn-reject" style="width:100%;">
                        ❌ Refuser
                    </button>
                </form>

            </div>

            <script>
                function prepareReject(event) {
                    const motif = prompt("Merci d'indiquer le motif du refus (visible par le client) :");
                    if (!motif) {
                        event.preventDefault();
                        return false;
                    }
                    document.getElementById('motif_refus_input').value = motif;
                    return true;
                }
            </script>

        @else

            <p style="text-align:center; color:var(--text-muted); font-size:14px;">
                Ce document a déjà été traité (statut actuel :
                <strong>{{ $user->statut_documents === 'valide' ? 'validé' : 'refusé' }}</strong>).
            </p>

        @endif

    </div>
</div>

</x-app-layout>