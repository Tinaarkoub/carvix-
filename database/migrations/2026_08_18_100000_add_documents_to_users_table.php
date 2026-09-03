<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ajoute les champs pour l'upload et la validation des documents
     * (pièce d'identité : CNI ou passeport, et permis de conduire).
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Type de pièce d'identité fournie
            $table->enum('type_piece_identite', ['cni', 'passeport'])->nullable()->after('permis_conduire');

            // Chemin du fichier uploadé pour la pièce d'identité
            $table->string('piece_identite_fichier')->nullable()->after('type_piece_identite');

            // Chemin du fichier uploadé pour le permis de conduire
            $table->string('permis_fichier')->nullable()->after('piece_identite_fichier');

            // Statut global de la vérification des documents
            $table->enum('statut_documents', ['non_soumis', 'en_attente', 'valide', 'refuse'])
                ->default('non_soumis')
                ->after('permis_fichier');

            // Raison du refus (optionnel, utile pour informer le client)
            $table->string('motif_refus')->nullable()->after('statut_documents');

            // Date de validation par l'admin
            $table->timestamp('documents_valides_at')->nullable()->after('motif_refus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'type_piece_identite',
                'piece_identite_fichier',
                'permis_fichier',
                'statut_documents',
                'motif_refus',
                'documents_valides_at',
            ]);
        });
    }
};