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

    .doc-wrap{
        background:var(--page-bg);
        margin:-1.5rem;
        padding:40px 20px;
        min-height:100%;
    }

    .doc-card{
        max-width:640px;
        margin:0 auto;
        background:var(--card-bg);
        border-radius:20px;
        padding:32px;
        box-shadow:0 12px 24px rgba(0,0,0,.06);
    }

    .doc-card h1{
        font-size:24px;
        font-weight:800;
        color:var(--text-dark);
        margin-bottom:6px;
    }

    .doc-card p.subtitle{
        color:var(--text-muted);
        font-size:14px;
        margin-bottom:24px;
    }

    .status-badge{
        display:inline-block;
        padding:8px 16px;
        border-radius:30px;
        font-weight:700;
        font-size:13px;
        margin-bottom:24px;
    }

    .status-non_soumis{ background:#e9ecef; color:#495057; }
    .status-en_attente{ background:#fff3cd; color:#664d03; }
    .status-valide{ background:#d1e7dd; color:#0f5132; }
    .status-refuse{ background:#f8d7da; color:#842029; }

    .alert-message{
        padding:14px 20px;
        border-radius:12px;
        margin-bottom:20px;
        font-weight:600;
        font-size:14px;
    }

    .alert-error{ background:#f8d7da; color:#842029; border:1px solid #f1aeb5; }
    .alert-success{ background:#d1e7dd; color:#0f5132; border:1px solid #a3cfbb; }

    .doc-card label{
        font-weight:600;
        font-size:13px;
        color:var(--text-dark);
        margin-bottom:6px;
        display:block;
    }

    .doc-card select,
    .doc-card input[type="file"]{
        width:100%;
        background:var(--page-bg);
        border:1px solid rgba(0,0,0,.1);
        border-radius:10px;
        padding:10px 12px;
        color:var(--text-dark);
        font-size:14px;
        margin-bottom:18px;
    }

    .btn-submit{
        background:var(--pill-dark);
        color:#fff;
        border:none;
        border-radius:30px;
        padding:12px 24px;
        font-weight:600;
        width:100%;
        cursor:pointer;
    }

    .btn-submit:hover{
        opacity:.9;
    }

    .error-text{
        color:#c1121f;
        font-size:12px;
        margin-top:-12px;
        margin-bottom:14px;
        display:block;
    }

    .payment-ready{
        text-align:center;
        padding:20px;
        background:#d1e7dd;
        border-radius:14px;
        margin-top:10px;
    }

    .payment-ready a{
        display:inline-block;
        margin-top:12px;
        background:var(--accent);
        color:#20291f;
        padding:10px 22px;
        border-radius:30px;
        font-weight:700;
        text-decoration:none;
    }
</style>

<div class="doc-wrap">
    <div class="doc-card">

        <h1>Vérification de votre identité</h1>
        <p class="subtitle">
            Pour des raisons de sécurité, nous devons vérifier votre pièce d'identité
            et votre permis de conduire avant de valider tout paiement.
        </p>

        @php
            $statutLabels = [
                'non_soumis' => '📄 Aucun document envoyé',
                'en_attente' => '⏳ En attente de vérification',
                'valide' => '✅ Documents validés',
                'refuse' => '❌ Documents refusés',
            ];
        @endphp

        <span class="status-badge status-{{ $user->statut_documents }}">
            {{ $statutLabels[$user->statut_documents] ?? $user->statut_documents }}
        </span>

        @if (session('success'))
            <div class="alert-message alert-success">✅ {{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert-message alert-error">⚠️ {{ session('error') }}</div>
        @endif

        @if ($user->statut_documents === 'refuse' && $user->motif_refus)
            <div class="alert-message alert-error">
                Motif du refus : {{ $user->motif_refus }}
            </div>
        @endif

        @if ($user->statut_documents === 'valide')

            <div class="payment-ready">
                <strong>Vos documents sont validés !</strong><br>
                Vous pouvez maintenant procéder au paiement de vos réservations.
                <br>
                <a href="{{ route('orders.my') }}">Voir mes réservations</a>
            </div>

        @else

            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                @csrf

                <label for="type_piece_identite">Type de pièce d'identité</label>
                <select name="type_piece_identite" id="type_piece_identite" required>
                    <option value="">-- Choisissez --</option>
                    <option value="cni" {{ old('type_piece_identite', $user->type_piece_identite) === 'cni' ? 'selected' : '' }}>
                        Carte nationale d'identité
                    </option>
                    <option value="passeport" {{ old('type_piece_identite', $user->type_piece_identite) === 'passeport' ? 'selected' : '' }}>
                        Passeport
                    </option>
                </select>
                @error('type_piece_identite')
                    <span class="error-text">{{ $message }}</span>
                @enderror

                <label for="piece_identite_fichier">Photo/scan de la pièce d'identité</label>
                <input type="file" name="piece_identite_fichier" id="piece_identite_fichier" accept=".jpg,.jpeg,.png,.pdf" required>
                @error('piece_identite_fichier')
                    <span class="error-text">{{ $message }}</span>
                @enderror

                <label for="permis_fichier">Photo/scan du permis de conduire</label>
                <input type="file" name="permis_fichier" id="permis_fichier" accept=".jpg,.jpeg,.png,.pdf" required>
                @error('permis_fichier')
                    <span class="error-text">{{ $message }}</span>
                @enderror

                <button type="submit" class="btn-submit">
                    Envoyer mes documents
                </button>

            </form>

        @endif

    </div>
</div>

</x-app-layout>