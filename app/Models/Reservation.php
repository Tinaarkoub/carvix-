<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';


    protected $fillable = [
        'client_id',
        'vehicule_id',
        'date_debut',
        'date_fin',
        'montant_total',
        'statut',
        'signature',
        'signed_at',
        'depart_confirme',
        'confirmation_deadline',
        'retour_action',
        'retour_rappel_envoye_at',
    ];


    protected $casts = [

        'date_debut' => 'date',

        'date_fin' => 'date',

        'montant_total' => 'float',

        'signed_at' => 'datetime',

        'depart_confirme' => 'boolean',

        'confirmation_deadline' => 'datetime',

        'retour_rappel_envoye_at' => 'datetime',

    ];



    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }



    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function avis()
    {
        return $this->hasOne(Avis::class);
    }
}