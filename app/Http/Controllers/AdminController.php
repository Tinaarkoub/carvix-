<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicule;
use App\Models\Categorie;
use App\Models\Reservation;
use App\Models\Paiement;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'users' => User::count(),
            'proprietaires' => User::where('role', 'proprietaire')->count(),
            'clients' => User::where('role', 'client')->count(),
            'vehicules' => Vehicule::count(),
            'categories' => Categorie::count(),
            'reservations' => Reservation::count(),
            'ca' => Paiement::where('statut', 'paye')->sum('montant'),
        ]);
    }
}