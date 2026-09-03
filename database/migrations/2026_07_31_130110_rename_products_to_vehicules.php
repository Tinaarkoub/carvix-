<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('products', 'vehicules');

        Schema::table('vehicules', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicules', 'marque')) {
                $table->string('marque')->nullable()->after('nom');
            }
            if (!Schema::hasColumn('vehicules', 'modele')) {
                $table->string('modele')->nullable()->after('marque');
            }
            if (!Schema::hasColumn('vehicules', 'immatriculation')) {
                $table->string('immatriculation')->nullable()->after('modele');
            }
            if (!Schema::hasColumn('vehicules', 'carburant')) {
                $table->string('carburant')->nullable()->after('immatriculation');
            }
            if (!Schema::hasColumn('vehicules', 'transmission')) {
                $table->string('transmission')->nullable()->after('carburant');
            }
            if (!Schema::hasColumn('vehicules', 'disponibilite')) {
                $table->boolean('disponibilite')->default(true)->after('transmission');
            }
        });

        if (Schema::hasColumn('vehicules', 'prix') && !Schema::hasColumn('vehicules', 'prix_par_jour')) {
            DB::statement('ALTER TABLE vehicules CHANGE prix prix_par_jour DOUBLE NOT NULL');
        }

        if (Schema::hasColumn('vehicules', 'vendeur_id') && !Schema::hasColumn('vehicules', 'proprietaire_id')) {
            DB::statement('ALTER TABLE vehicules CHANGE vendeur_id proprietaire_id BIGINT UNSIGNED NOT NULL');
        }

        if (Schema::hasColumn('vehicules', 'stock')) {
            DB::statement('UPDATE vehicules SET disponibilite = (stock > 0)');
        }
    }

    public function down(): void
    {
        Schema::table('vehicules', function (Blueprint $table) {
            $table->dropColumn(['marque', 'modele', 'immatriculation', 'carburant', 'transmission', 'disponibilite']);
        });

        if (Schema::hasColumn('vehicules', 'prix_par_jour')) {
            DB::statement('ALTER TABLE vehicules CHANGE prix_par_jour prix DOUBLE NOT NULL');
        }

        if (Schema::hasColumn('vehicules', 'proprietaire_id')) {
            DB::statement('ALTER TABLE vehicules CHANGE proprietaire_id vendeur_id BIGINT UNSIGNED NOT NULL');
        }

        Schema::rename('vehicules', 'products');
    }
};