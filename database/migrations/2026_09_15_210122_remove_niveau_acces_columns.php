<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Suppression dans la table users
        if (Schema::hasColumn('users', 'niveau_acces')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('niveau_acces');
            });
        }

        // Suppression dans la table administrateurs
        if (Schema::hasColumn('administrateurs', 'niveau_acces')) {
            Schema::table('administrateurs', function (Blueprint $table) {
                $table->dropColumn('niveau_acces');
            });
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('niveau_acces')->nullable()->after('permis_conduire');
        });

        Schema::table('administrateurs', function (Blueprint $table) {
            $table->string('niveau_acces')->nullable();
        });
    }
};