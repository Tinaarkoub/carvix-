<x-app-layout>
<div class="container mt-4">
<h2>Modifier le véhicule</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('seller.products.update', $vehicule) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" value="{{ old('nom', $vehicule->nom) }}">
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description', $vehicule->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label>Marque</label>
        <input type="text" name="marque" class="form-control" value="{{ old('marque', $vehicule->marque) }}">
    </div>

    <div class="mb-3">
        <label>Modèle</label>
        <input type="text" name="modele" class="form-control" value="{{ old('modele', $vehicule->modele) }}">
    </div>

    <div class="mb-3">
        <label>Immatriculation</label>
        <input type="text" name="immatriculation" class="form-control" value="{{ old('immatriculation', $vehicule->immatriculation) }}">
    </div>

    <div class="mb-3">
        <label>Kilométrage (km)</label>
        <input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage', $vehicule->kilometrage) }}" min="0" placeholder="Ex : 45000">
    </div>

    <div class="mb-3">
        <label>Prix par jour (€)</label>
        <input type="number" step="0.01" name="prix_par_jour" class="form-control" value="{{ old('prix_par_jour', $vehicule->prix_par_jour) }}">
    </div>

    <div class="mb-3">
        <label>Carburant</label>
        <select name="carburant" class="form-control">
            <option value="essence" @selected($vehicule->carburant === 'essence')>Essence</option>
            <option value="diesel" @selected($vehicule->carburant === 'diesel')>Diesel</option>
            <option value="electrique" @selected($vehicule->carburant === 'electrique')>Électrique</option>
            <option value="hybride" @selected($vehicule->carburant === 'hybride')>Hybride</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Transmission</label>
        <select name="transmission" class="form-control">
            <option value="manuelle" @selected($vehicule->transmission === 'manuelle')>Manuelle</option>
            <option value="automatique" @selected($vehicule->transmission === 'automatique')>Automatique</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Disponible</label>
        <select name="disponibilite" class="form-control">
            <option value="1" @selected($vehicule->disponibilite == 1)>Oui</option>
            <option value="0" @selected($vehicule->disponibilite == 0)>Non</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Catégorie</label>
        <select name="category_id" class="form-control">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected($category->id === $vehicule->category_id)>
                    {{ $category->nom }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Photo du véhicule</label><br>

        @if($vehicule->image)
            <img src="{{ asset('storage/' . $vehicule->image) }}" alt="{{ $vehicule->nom }}" width="120" class="mb-2 d-block rounded">
        @endif

        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="text-muted">Laisse vide pour garder l'image actuelle.</small>
    </div>

    <button type="submit" class="btn btn-primary">Mettre à jour</button>
    <a href="{{ route('seller.products') }}" class="btn btn-secondary">Annuler</a>
</form>
</div>
</x-app-layout>