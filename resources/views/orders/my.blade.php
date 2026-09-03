<x-app-layout>
    <div class="container mt-4">
        <h2>Mes Réservations</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Véhicule</th>
                    <th>Du</th>
                    <th>Au</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                    <th>Avis</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->vehicule->marque }} {{ $order->vehicule->modele }}</td>
                    <td>{{ $order->date_debut->format('d/m/Y') }}</td>
                    <td>{{ $order->date_fin->format('d/m/Y') }}</td>
                    <td>{{ $order->montant_total }} €</td>
                    <td>
                        <span class="badge bg-{{ $order->statut === 'confirmee' ? 'success' : ($order->statut === 'annulee' ? 'danger' : 'secondary') }}">
                            {{ $order->statut }}
                        </span>
                    </td>
                    <td>
                        @if($order->statut === 'en_attente')
                            <a href="{{ route('orders.pay', $order) }}" class="btn btn-success btn-sm">Payer</a>
                            <form method="POST" action="{{ route('orders.cancel', $order) }}" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-danger btn-sm">Annuler</button>
                            </form>
                        @elseif($order->statut === 'payee')
                            <a href="{{ route('orders.contract', $order) }}" class="btn btn-primary btn-sm">Signer le contrat</a>
                        @elseif($order->statut === 'confirmee')
                            <span class="text-success">✔ Réservation confirmée</span>
                        @endif
                    </td>
                    <td style="min-width:220px;">
                        @if(now()->gt($order->date_fin) && $order->statut !== 'annulee')

                            @if($order->avis)
                                <div style="font-size:13px;">
                                    <strong>{{ $order->avis->note }}/5</strong>
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= $order->avis->note ? '⭐' : '☆' }}
                                    @endfor
                                    @if($order->avis->commentaire)
                                        <p class="mb-0 mt-1 text-muted">{{ $order->avis->commentaire }}</p>
                                    @endif
                                </div>
                            @else
                                <form method="POST" action="{{ route('avis.store', $order) }}">
                                    @csrf
                                    <select name="note" class="form-select form-select-sm mb-1" required>
                                        <option value="">Note</option>
                                        <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                                        <option value="4">⭐⭐⭐⭐ (4)</option>
                                        <option value="3">⭐⭐⭐ (3)</option>
                                        <option value="2">⭐⭐ (2)</option>
                                        <option value="1">⭐ (1)</option>
                                    </select>
                                    <textarea name="commentaire" class="form-control form-control-sm mb-1" placeholder="Votre commentaire (optionnel)" rows="2"></textarea>
                                    <button type="submit" class="btn btn-dark btn-sm w-100">Envoyer l'avis</button>
                                </form>
                            @endif

                        @else
                            <span class="text-muted" style="font-size:12px;">Disponible après la location</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">Aucune réservation pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>