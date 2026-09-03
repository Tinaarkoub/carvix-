<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $table = 'vehicules';

    protected $fillable = [
        'nom',
        'description',
        'marque',
        'modele',
        'immatriculation',
        'date_mise_en_circulation',
        'kilometrage',
        'prix_par_jour',
        'carburant',
        'transmission',
        'disponibilite',
        'category_id',
        'proprietaire_id',
        'image',
    ];

    protected $casts = [
        'disponibilite' => 'boolean',
        'prix_par_jour' => 'float',
        'kilometrage' => 'integer',
        'date_mise_en_circulation' => 'date',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }

    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}