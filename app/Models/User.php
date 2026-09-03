<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'type_piece_identite',
        'piece_identite_fichier',
        'permis_fichier',
        'statut_documents',
        'motif_refus',
        'documents_valides_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'documents_valides_at' => 'datetime',
    ];

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function proprietaire()
    {
        return $this->hasOne(Proprietaire::class);
    }

    public function administrateur()
    {
        return $this->hasOne(Administrateur::class);
    }

    /**
     * Vérifie si les documents d'identité et de permis
     * ont été validés par un administrateur.
     */
    public function hasValidatedDocuments()
    {
        return $this->statut_documents === 'valide';
    }
}