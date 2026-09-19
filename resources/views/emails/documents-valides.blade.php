<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Documents validés</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Bonjour {{ $user->name }},</h2>

    <p>Bonne nouvelle ! Vos documents (pièce d'identité et permis de conduire) ont été <strong>validés</strong> par notre équipe.</p>

    <p>Vous pouvez désormais réserver un véhicule et procéder au paiement sur Carvix.</p>

    <p>
        <a href="{{ url('/catalogue') }}" style="background-color: #2d6a4f; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Voir le catalogue
        </a>
    </p>

    <p>Merci de votre confiance,<br>L'équipe Carvix</p>
</body>
</html>