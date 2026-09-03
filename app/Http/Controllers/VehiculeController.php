<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Categorie;
use App\Models\Proprietaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
    // Catalogue public (tous les véhicules disponibles, vue client)
    public function catalogue(Request $request)
    {
        $query = Vehicule::with('categorie')
            ->where('disponibilite', true);

        if ($request->filled('marque')) {
            $query->where('marque', 'like', '%' . $request->marque . '%');
        }

        if ($request->filled('modele')) {
            $query->where('modele', 'like', '%' . $request->modele . '%');
        }

        if ($request->filled('date_mise_en_circulation')) {
            $query->whereDate('date_mise_en_circulation', '>=', $request->date_mise_en_circulation);
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
        $proprietaire = Proprietaire::where('user_id', Auth::id())->first();

        if (!$proprietaire) {
            abort(403, 'Aucun profil propriétaire associé à ce compte.');
        }

        $vehicules = Vehicule::where('proprietaire_id', $proprietaire->id)->latest()->get();
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
            'category_id' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $proprietaire = Proprietaire::where('user_id', Auth::id())->first();

        if (!$proprietaire) {
            abort(403, 'Aucun profil propriétaire associé à ce compte.');
        }

        $data = $request->only([
            'nom', 'description', 'marque', 'modele', 'immatriculation', 'kilometrage', 'capacite',
            'prix_par_jour', 'carburant', 'transmission', 'category_id'
        ]);
        $data['disponibilite'] = true;
        $data['proprietaire_id'] = $proprietaire->id; // ✅ corrigé

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicules', 'public');
        }

        Vehicule::create($data);

        return redirect()->route('seller.products')->with('success', 'Véhicule ajouté !');
    }

    // Le paramètre s'appelle $product car ta route utilise {product}
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
            'category_id' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'nom', 'description', 'marque', 'modele', 'immatriculation', 'kilometrage', 'capacite',
            'prix_par_jour', 'carburant', 'transmission', 'category_id', 'disponibilite'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicules', 'public');
        }

        $product->update($data);

        return redirect()->route('seller.products')->with('success', 'Véhicule modifié !');
    }

    public function destroy(Vehicule $product)
    {
        $this->authorizeOwner($product);

        $product->delete();
        return redirect()->route('seller.products')->with('success', 'Véhicule supprimé !');
    }

    /**
     * Vérifie que le véhicule appartient bien au propriétaire connecté.
     * proprietaire_id (sur vehicules) référence proprietaires.id,
     * qui lui-même référence users.id via la colonne user_id.
     */
    private function authorizeOwner(Vehicule $product): void
    {
        $proprietaire = Proprietaire::where('user_id', Auth::id())->first();

        if (!$proprietaire || $product->proprietaire_id !== $proprietaire->id) {
            abort(403, 'Ce véhicule ne vous appartient pas.');
        }
    }
}