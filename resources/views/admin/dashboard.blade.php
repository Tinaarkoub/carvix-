<x-app-layout>
    <div class="container mt-4">
        <h2>Dashboard Administrateur</h2>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card p-3">Utilisateurs : {{ $users }}</div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3">Propriétaires : {{ $proprietaires }}</div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3">Clients : {{ $clients }}</div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3">Véhicules : {{ $vehicules }}</div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3">Catégories : {{ $categories }}</div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3">Réservations : {{ $reservations }}</div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3">Chiffre d'affaires : {{ $ca }} €</div>
            </div>
        </div>
    </div>
</x-app-layout>