<x-app-layout>
<div class="container mt-4">
<h2>Mes Véhicules</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('seller.products.create') }}"
class="btn btn-primary mb-3">
Ajouter un véhicule
</a>
<table class="table table-bordered">
<thead>
<tr>
<th>ID</th>
<th>Image</th>
<th>Nom</th>
<th>Marque / Modèle</th>
<th>Prix/jour</th>
<th>Disponible</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
@forelse($vehicules as $vehicule)

    <tr>
        <td>{{ $vehicule->id }}</td>

        <td>
            @if($vehicule->image)
                <img src="{{ asset('storage/' . $vehicule->image) }}" alt="{{ $vehicule->nom }}" width="60" class="rounded">
            @else
                <span class="text-muted">Aucune image</span>
            @endif
        </td>

        <td>{{ $vehicule->nom }}</td>

        <td>{{ $vehicule->marque }} {{ $vehicule->modele }}</td>

        <td>{{ $vehicule->prix_par_jour }} €</td>

        <td>{{ $vehicule->disponibilite ? 'Oui' : 'Non' }}</td>

        <td>
            <a href="{{ route('seller.products.edit', $vehicule) }}"
               class="btn btn-warning btn-sm">
                Modifier
            </a>

            <form method="POST"
                  action="{{ route('seller.products.destroy', $vehicule) }}"
                  style="display:inline">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm">
                    Supprimer
                </button>

            </form>
        </td>
    </tr>

@empty

    <tr>
        <td colspan="7">
            Aucun véhicule trouvé
        </td>
    </tr>

@endforelse

</tbody>

</table>

</div>

</x-app-layout>