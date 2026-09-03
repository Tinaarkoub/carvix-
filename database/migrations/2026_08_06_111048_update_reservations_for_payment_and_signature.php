<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{

    public function up()
    {

        Schema::table('reservations', function (Blueprint $table) {

            $table->text('signature')
                ->nullable();

            $table->timestamp('signed_at')
                ->nullable();

        });



        DB::statement("
            ALTER TABLE reservations 
            MODIFY statut ENUM(
                'en_attente',
                'payee',
                'confirmee',
                'annulee',
                'terminee'
            )
            DEFAULT 'en_attente'
        ");

    }



    public function down()
    {

        Schema::table('reservations', function (Blueprint $table) {

            $table->dropColumn([
                'signature',
                'signed_at'
            ]);

        });



        DB::statement("
            ALTER TABLE reservations 
            MODIFY statut ENUM(
                'en_attente',
                'confirmee',
                'annulee',
                'terminee'
            )
            DEFAULT 'en_attente'
        ");

    }

};