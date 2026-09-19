<x-app-layout>
<div class="container mt-4">
<h2>Ajouter un véhicule</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" value="{{ old('nom') }}">
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Marque</label>
        <input type="text" name="marque" class="form-control" value="{{ old('marque') }}">
    </div>

    <div class="mb-3">
        <label>Modèle</label>
        <input type="text" name="modele" class="form-control" value="{{ old('modele') }}">
    </div>

    <div class="mb-3">
        <label>Immatriculation</label>
        <input type="text" name="immatriculation" class="form-control" value="{{ old('immatriculation') }}">
    </div>

    <div class="mb-3">
        <label>Kilométrage (km)</label>
        <input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage') }}" min="0" placeholder="Ex : 45000">
    </div>

    <div class="mb-3">
        <label>Capacité d'accueil (places)</label>
        <input type="number" name="capacite" class="form-control" value="{{ old('capacite') }}" min="1" placeholder="Ex : 5">
    </div>

    <div class="mb-3">
        <label>Prix par jour (€)</label>
        <input type="number" step="0.01" name="prix_par_jour" class="form-control" value="{{ old('prix_par_jour') }}">
    </div>

    <div class="mb-3">
        <label>Carburant</label>
        <select name="carburant" class="form-control">
            <option value="essence">Essence</option>
            <option value="diesel">Diesel</option>
            <option value="electrique">Électrique</option>
            <option value="hybride">Hybride</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Transmission</label>
        <select name="transmission" class="form-control">
            <option value="manuelle">Manuelle</option>
            <option value="automatique">Automatique</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Catégorie</label>
        <input type="text" name="category_name" list="categories-list" class="form-control"
               value="{{ old('category_name') }}" placeholder="Ex : SUV, Peugeot 208, Luxe...">
        <datalist id="categories-list">
            @foreach($categories as $category)
                <option value="{{ $category->nom }}">
            @endforeach
        </datalist>
    </div>

    <div class="mb-3">
        <label>Photo principale du véhicule</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <label>Photos supplémentaires (galerie)</label>
        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
        <small class="text-muted">Vous pouvez sélectionner plusieurs images à la fois (Ctrl + clic).</small>
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="{{ route('seller.products') }}" class="btn btn-secondary">Annuler</a>
</form>
</div>
</x-app-layout>