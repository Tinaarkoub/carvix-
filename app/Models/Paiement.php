<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    protected $fillable = [
        'reservation_id',
        'montant',
        'mode_paiement',
        'date_paiement',
        'statut',
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'montant' => 'float',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}