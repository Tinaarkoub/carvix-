<x-app-layout>
<div class="container mt-4" style="max-width: 500px;">
    <h2>Paiement de la réservation #{{ $order->id }}</h2>
    <p>Montant à payer : <strong>{{ number_format($order->montant_total, 2) }} €</strong></p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('orders.pay.process', $order) }}">
        @csrf

        <div class="mb-3">
            <label>Nom du titulaire</label>
            <input type="text" name="card_name" class="form-control" placeholder="Jean Dupont" required>
        </div>

        <div class="mb-3">
            <label>Numéro de carte</label>
            <input type="text" name="card_number" class="form-control" placeholder="4242 4242 4242 4242" maxlength="19" required>
        </div>

        <div class="row">
            <div class="col-6 mb-3">
                <label>Date d'expiration</label>
                <input type="text" name="card_expiry" class="form-control" placeholder="MM/AA" required>
            </div>
            <div class="col-6 mb-3">
                <label>CVV</label>
                <input type="text" name="card_cvv" class="form-control" placeholder="123" maxlength="4" required>
            </div>
        </div>

        <p class="text-muted small">
            Ceci est une simulation de paiement à des fins de démonstration. Aucune vraie transaction n'est effectuée.
        </p>

        <button type="submit" class="btn btn-primary w-100">Payer {{ number_format($order->montant_total, 2) }} €</button>
    </form>
</div>
</x-app-layout>