<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role VARCHAR(50) NOT NULL DEFAULT 'client'");

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'adresse')) {
                $table->string('adresse')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'permis_conduire')) {
                $table->string('permis_conduire')->nullable()->after('adresse');
            }
            if (!Schema::hasColumn('users', 'niveau_acces')) {
                $table->integer('niveau_acces')->nullable()->after('permis_conduire');
            }
            if (!Schema::hasColumn('users', 'telephone')) {
                $table->string('telephone')->nullable()->after('niveau_acces');
            }
        });

        DB::table('users')->where('role', 'acheteur')->update(['role' => 'client']);
        DB::table('users')->where('role', 'vendeur')->update(['role' => 'proprietaire']);
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'client')->update(['role' => 'acheteur']);
        DB::table('users')->where('role', 'proprietaire')->update(['role' => 'vendeur']);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['adresse', 'permis_conduire', 'niveau_acces', 'telephone']);
        });

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','vendeur','acheteur') NOT NULL");
    }
};