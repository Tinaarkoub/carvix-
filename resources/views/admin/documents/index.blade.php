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

    .admin-doc-wrap{
        background:var(--page-bg);
        margin:-1.5rem;
        padding:40px 20px;
        min-height:100%;
    }

    .admin-doc-header{
        max-width:1000px;
        margin:0 auto 24px;
    }

    .admin-doc-header h1{
        font-size:26px;
        font-weight:800;
        color:var(--text-dark);
    }

    .admin-doc-table{
        max-width:1000px;
        margin:0 auto;
        background:var(--card-bg);
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 12px 24px rgba(0,0,0,.06);
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    th{
        text-align:left;
        font-size:12px;
        text-transform:uppercase;
        color:var(--text-muted);
        padding:16px 20px;
        border-bottom:1px solid rgba(0,0,0,.06);
    }

    td{
        padding:16px 20px;
        border-bottom:1px solid rgba(0,0,0,.05);
        font-size:14px;
        color:var(--text-dark);
        vertical-align:middle;
    }

    .status-badge{
        display:inline-block;
        padding:6px 14px;
        border-radius:30px;
        font-weight:700;
        font-size:12px;
    }

    .status-en_attente{ background:#fff3cd; color:#664d03; }
    .status-valide{ background:#d1e7dd; color:#0f5132; }
    .status-refuse{ background:#f8d7da; color:#842029; }

    .btn-action{
        display:inline-block;
        padding:8px 16px;
        border-radius:30px;
        font-weight:600;
        font-size:13px;
        text-decoration:none;
        margin-right:6px;
    }

    .btn-view{ background:var(--pill-dark); color:#fff; }
    .btn-view:hover{ color:#fff; opacity:.9; }

    .alert-message{
        max-width:1000px;
        margin:0 auto 20px;
        padding:14px 20px;
        border-radius:12px;
        font-weight:600;
        font-size:14px;
    }

    .alert-success{ background:#d1e7dd; color:#0f5132; border:1px solid #a3cfbb; }

    .empty-state{
        text-align:center;
        padding:60px 20px;
        color:var(--text-muted);
    }
</style>

<div class="admin-doc-wrap">

    <div class="admin-doc-header">
        <h1>Vérification des documents clients</h1>
    </div>

    @if (session('success'))
        <div class="alert-message alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="admin-doc-table">

        @if($users->count())
            <table>
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Dernière mise à jour</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="status-badge status-{{ $user->statut_documents }}">
                                    @if($user->statut_documents === 'en_attente') ⏳ En attente
                                    @elseif($user->statut_documents === 'valide') ✅ Validé
                                    @elseif($user->statut_documents === 'refuse') ❌ Refusé
                                    @endif
                                </span>
                            </td>
                            <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                         <td>
    <a href="{{ route('admin.documents.show', $user) }}" class="btn-action btn-view">
        Examiner
    </a>
</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                Aucun document à vérifier pour le moment.
            </div>
        @endif

    </div>

</div>

</x-app-layout>