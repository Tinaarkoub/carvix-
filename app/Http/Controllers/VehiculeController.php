<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
    // Catalogue public (tous les véhicules disponibles, vue client)
    public function catalogue(Request $request)
    {
        $query = Vehicule::with(['categorie', 'reservations' => function ($q) {
            $q->whereIn('statut', ['en_attente', 'confirmee']);
        }])
            ->where('disponibilite', true);

        if ($request->filled('marque')) {
            $query->where('marque', 'like', '%' . $request->marque . '%');
        }

        if ($request->filled('modele')) {
            $query->where('modele', 'like', '%' . $request->modele . '%');
        }

        if ($request->filled('prix_max')) {
            $query->where('prix_par_jour', '<=', $request->prix_max);
        }

        $vehicules = $query->latest()->get();

        return view('catalogue.index', compact('vehicules'));
    }

    // Liste des véhicules du propriétaire connecté
    public function sellerProducts()
    {
        $vehicules = Vehicule::where('proprietaire_id', Auth::id())->latest()->get();
        return view('seller.products.index', compact('vehicules'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'marque' => 'required',
            'modele' => 'required',
            'immatriculation' => 'required|unique:vehicules',
            'kilometrage' => 'nullable|integer|min:0',
            'capacite' => 'nullable|integer|min:1',
            'prix_par_jour' => 'required|numeric',
            'carburant' => 'required',
            'transmission' => 'required',
            'category_name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // On récupère la catégorie existante, ou on la crée si elle n'existe pas encore
        $categorie = Categorie::firstOrCreate(
            ['nom' => $request->category_name]
        );

        $data = $request->only([
            'nom', 'description', 'marque', 'modele', 'immatriculation', 'kilometrage', 'capacite',
            'prix_par_jour', 'carburant', 'transmission'
        ]);
        $data['category_id'] = $categorie->id;
        $data['disponibilite'] = true;
        $data['proprietaire_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicules', 'public');
        }

        $vehicule = Vehicule::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('vehicules/galerie', 'public');
                $vehicule->images()->create(['chemin' => $path]);
            }
        }

        return redirect()->route('seller.products')->with('success', 'Véhicule ajouté !');
    }

    public function edit(Vehicule $product)
    {
        $this->authorizeOwner($product);

        $categories = Categorie::all();
        return view('seller.products.edit', ['vehicule' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, Vehicule $product)
    {
        $this->authorizeOwner($product);

        $request->validate([
            'nom' => 'required',
            'marque' => 'required',
            'modele' => 'required',
            'immatriculation' => 'required|unique:vehicules,immatriculation,' . $product->id,
            'kilometrage' => 'nullable|integer|min:0',
            'capacite' => 'nullable|integer|min:1',
            'prix_par_jour' => 'required|numeric',
            'carburant' => 'required',
            'transmission' => 'required',
            'category_name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // On récupère la catégorie existante, ou on la crée si elle n'existe pas encore
        $categorie = Categorie::firstOrCreate(
            ['nom' => $request->category_name]
        );

        $data = $request->only([
            'nom', 'description', 'marque', 'modele', 'immatriculation', 'kilometrage', 'capacite',
            'prix_par_jour', 'carburant', 'transmission', 'disponibilite'
        ]);
        $data['category_id'] = $categorie->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicules', 'public');
        }

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('vehicules/galerie', 'public');
                $product->images()->create(['chemin' => $path]);
            }
        }

        return redirect()->route('seller.products')->with('success', 'Véhicule modifié !');
    }

    public function destroy(Vehicule $product)
    {
        $this->authorizeOwner($product);

        $product->delete();
        return redirect()->route('seller.products')->with('success', 'Véhicule supprimé !');
    }

    private function authorizeOwner(Vehicule $product): void
    {
        if ($product->proprietaire_id !== Auth::id()) {
            abort(403, 'Ce vehicule ne vous appartient pas.');
        }
    }
}