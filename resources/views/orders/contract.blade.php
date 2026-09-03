<x-app-layout>
<div class="container mt-4" style="max-width: 700px;">
    <h2>Contrat de location — Réservation #{{ $order->id }}</h2>

    <div class="border p-3 mb-4" style="max-height: 250px; overflow-y: auto; background: #f8f9fa;">
        <p>
            Le présent contrat est conclu entre le propriétaire et le client pour la réservation n°{{ $order->id }},
            concernant le véhicule {{ $order->vehicule->marque }} {{ $order->vehicule->modele }}
            (immatriculation : {{ $order->vehicule->immatriculation }}),
            du {{ $order->date_debut->format('d/m/Y') }} au {{ $order->date_fin->format('d/m/Y') }},
            pour un montant total de {{ number_format($order->montant_total, 2) }} €.
        </p>
        <p>
            Le client reconnaît avoir pris connaissance de l'état du véhicule, de ses caractéristiques et du prix
            de la location, et confirme son accord pour la location aux conditions indiquées.
        </p>
        <p>
            Le paiement a été effectué en totalité à la date de signature du présent contrat. Le client s'engage
            à restituer le véhicule dans l'état où il lui a été confié, à la date convenue. Toute réclamation
            devra être adressée au propriétaire dans un délai de 48 heures à compter de la prise en main du véhicule.
        </p>
        <p>
            En signant ci-dessous, le client valide définitivement cette réservation.
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="signForm" method="POST" action="{{ route('orders.sign', $order) }}">
        @csrf
        <input type="hidden" name="signature" id="signatureInput">

        <label class="mb-2 d-block">Signez ci-dessous avec votre souris (ou votre doigt sur mobile) :</label>

        <canvas id="signaturePad" width="650" height="200"
            style="border:1px solid #333; background:#fff; touch-action:none; cursor:crosshair;"></canvas>

        <div class="mt-2">
            <button type="button" id="clearSignature" class="btn btn-secondary btn-sm">Effacer</button>
        </div>

        <button type="submit" id="submitSignature" class="btn btn-primary mt-3 w-100" disabled>
            Valider ma signature et confirmer la réservation
        </button>
    </form>
</div>

<script>
    const canvas = document.getElementById('signaturePad');
    const ctx = canvas.getContext('2d');
    let drawing = false;
    let hasSigned = false;

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        if (e.touches && e.touches.length > 0) {
            return {
                x: e.touches[0].clientX - rect.left,
                y: e.touches[0].clientY - rect.top
            };
        }
        return { x: e.clientX - rect.left, y: e.clientY - rect.top };
    }

    function startDraw(e) {
        drawing = true;
        hasSigned = true;
        const pos = getPos(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
        document.getElementById('submitSignature').disabled = false;
    }

    function draw(e) {
        if (!drawing) return;
        const pos = getPos(e);
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        e.preventDefault();
    }

    function stopDraw() {
        drawing = false;
    }

    canvas.addEventListener('mousedown', startDraw);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDraw);
    canvas.addEventListener('mouseleave', stopDraw);

    canvas.addEventListener('touchstart', startDraw);
    canvas.addEventListener('touchmove', draw);
    canvas.addEventListener('touchend', stopDraw);

    document.getElementById('clearSignature').addEventListener('click', function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hasSigned = false;
        document.getElementById('submitSignature').disabled = true;
    });

    document.getElementById('signForm').addEventListener('submit', function () {
        document.getElementById('signatureInput').value = canvas.toDataURL('image/png');
    });
</script>
</x-app-layout>