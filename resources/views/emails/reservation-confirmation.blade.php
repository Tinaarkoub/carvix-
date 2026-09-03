<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#f4f5f1; padding:30px;">

    <div style="max-width:500px; margin:0 auto; background:#fff; border-radius:16px; padding:30px;">

        <h2 style="color:#20291f;">Confirmez votre réservation</h2>

        <p style="color:#5c6b57; font-size:15px;">
            Bonjour {{ $reservation->client->name ?? 'client' }},
        </p>

        <p style="color:#5c6b57; font-size:15px;">
            Vous avez réservé le véhicule
            <strong>{{ $reservation->vehicule->marque }} {{ $reservation->vehicule->modele }}</strong>
            du {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}
            au {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}.
        </p>

        <p style="color:#5c6b57; font-size:15px;">
            Merci de confirmer votre réservation dans les <strong>24 heures</strong>,
            sinon elle sera automatiquement annulée.
        </p>

        <a href="{{ $confirmUrl }}"
           style="display:inline-block; margin-top:16px; background:#232a24; color:#fff; padding:12px 24px; border-radius:30px; text-decoration:none; font-weight:600;">
            ✅ Confirmer ma réservation
        </a>

    </div>

</body>
</html>