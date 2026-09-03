<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Reservation;
use App\Mail\ReservationConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ReservationController extends Controller
{

    // Créer une réservation depuis le catalogue
    public function store(Request $request, Vehicule $vehicule)
    {
        $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        // ✅ Vérification de disponibilité du véhicule sur la période demandée
        $conflit = Reservation::where('vehicule_id', $vehicule->id)
            ->whereIn('statut', ['en_attente', 'confirmee'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
                      ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('date_debut', '<=', $request->date_debut)
                            ->where('date_fin', '>=', $request->date_fin);
                      });
            })->exists();

        if ($conflit) {
            return back()
                ->withInput()
                ->with('error', 'Ce véhicule n\'est pas disponible sur ces dates. Merci de choisir d\'autres dates.');
        }

        $jours = Carbon::parse($request->date_debut)
            ->diffInDays(Carbon::parse($request->date_fin));

        $jours = max($jours, 1);

        $montant = $jours * $vehicule->prix_par_jour;

        $reservation = Reservation::create([
            'client_id' => Auth::id(),
            'vehicule_id' => $vehicule->id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'montant_total' => $montant,
            'statut' => 'en_attente',
            'depart_confirme' => false,
            'confirmation_deadline' => now()->addHours(24),
        ]);

        Mail::to(Auth::user()->email)->send(new ReservationConfirmationMail($reservation));

        return redirect()
            ->route('orders.my')
            ->with('success','Réservation créée avec succès. Un email de confirmation vous a été envoyé, vous avez 24h pour confirmer.');
    }


    // Confirmation de la réservation via le lien reçu par email
    public function confirm(Reservation $reservation)
    {
        if ($reservation->client_id !== Auth::id()) {
            abort(403, 'Cette réservation ne vous appartient pas.');
        }

        if ($reservation->depart_confirme) {
            return redirect()->route('orders.my')->with('success', 'Votre réservation est déjà confirmée.');
        }

        if ($reservation->statut === 'annulee') {
            return redirect()->route('orders.my')->with('error', 'Cette réservation a été annulée car le délai de confirmation est dépassé.');
        }

        $reservation->update([
            'depart_confirme' => true,
        ]);

        return redirect()
            ->route('orders.my')
            ->with('success', 'Votre réservation est confirmée ! Vous pouvez maintenant procéder au paiement.');
    }


    // Liste des réservations du client
    public function myOrders()
    {
        $orders = Reservation::where('client_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.my', compact('orders'));
    }


    // Page paiement
    public function pay(Reservation $order)
    {
        $this->authorizeOrder($order);

        // Vérification que la réservation a été confirmée par le client
        if (!$order->depart_confirme) {
            return redirect()
                ->route('orders.my')
                ->with('error', 'Merci de confirmer votre réservation (via l\'email reçu) avant de procéder au paiement.');
        }

        // Vérification que les documents (pièce d'identité + permis) sont validés
        if (!Auth::user()->hasValidatedDocuments()) {
            session(['pending_reservation_id' => $order->id]);

            return redirect()
                ->route('documents.show')
                ->with('warning', 'Merci de faire valider votre pièce d\'identité et votre permis avant de procéder au paiement.');
        }

        return view('orders.pay', compact('order'));
    }


    // Traitement paiement simulé
    public function processPayment(Request $request, Reservation $order)
    {
        $this->authorizeOrder($order);

        $request->validate([
            'card_name'=>'required|string',
            'card_number'=>'required|string|min:12|max:19',
            'card_expiry'=>'required|string',
            'card_cvv'=>'required|string|min:3|max:4',
        ]);

        $order->update([
            'statut'=>'payee'
        ]);

        return redirect()
            ->route('orders.contract',$order);
    }


    // Afficher contrat
    public function contract(Reservation $order)
    {
        $this->authorizeOrder($order);

        return view('orders.contract', compact('order'));
    }


    // Signature contrat
    public function signContract(Request $request, Reservation $order)
    {
        $this->authorizeOrder($order);

        $request->validate([
            'signature'=>'required|string'
        ]);

        $order->update([
            'signature'=>$request->signature,
            'signed_at'=>now(),
            'statut'=>'confirmee',
        ]);

        return redirect()
            ->route('orders.my')
            ->with('success','Contrat signé. Réservation confirmée.');
    }


    // Annulation
    public function cancel(Reservation $order)
    {
        $this->authorizeOrder($order);

        $order->update([
            'statut'=>'annulee'
        ]);

        return back()
            ->with('success','Réservation annulée.');
    }


    /**
     * Vérifie que la réservation appartient bien au client connecté.
     */
    private function authorizeOrder(Reservation $order): void
    {
        if ($order->client_id !== Auth::id()) {
            abort(403, 'Cette réservation ne vous appartient pas.');
        }
    }
}