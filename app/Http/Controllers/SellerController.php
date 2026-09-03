<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function dashboard()
    {
        $vehiculeIds = Vehicule::where('proprietaire_id', Auth::id())->pluck('id');

        $vehicules = $vehiculeIds->count();

        $reservations = Reservation::whereIn('vehicule_id', $vehiculeIds)->count();

        $revenus = Reservation::whereIn('vehicule_id', $vehiculeIds)
            ->where('statut', 'confirmee')
            ->sum('montant_total');

        return view('seller.dashboard', compact('vehicules', 'reservations', 'revenus'));
    }
}