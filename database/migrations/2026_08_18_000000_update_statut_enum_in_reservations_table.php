<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE reservations MODIFY statut ENUM('en_attente', 'confirmee', 'annulee', 'terminee', 'payee') DEFAULT 'en_attente'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE reservations MODIFY statut ENUM('en_attente', 'confirmee', 'annulee', 'terminee') DEFAULT 'en_attente'");
    }
};