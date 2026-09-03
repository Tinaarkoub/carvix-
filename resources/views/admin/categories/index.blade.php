<x-app-layout>
    <div class="container mt-4">
        <h2>Liste des catégories</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">
            Ajouter
        </a>

        <table class="table table-bordered">
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            @forelse($categories as $category)
            <tr>
                <td>{{ $category->nom }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Aucune catégorie pour le moment.</td>
            </tr>
            @endforelse
        </table>
    </div>
</x-app-layout>