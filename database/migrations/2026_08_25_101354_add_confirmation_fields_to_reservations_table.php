<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->boolean('depart_confirme')->default(false)->after('statut');
            $table->timestamp('confirmation_deadline')->nullable()->after('depart_confirme');

            $table->string('retour_action')->nullable()->after('confirmation_deadline');
            $table->timestamp('retour_rappel_envoye_at')->nullable()->after('retour_action');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn([
                'depart_confirme',
                'confirmation_deadline',
                'retour_action',
                'retour_rappel_envoye_at',
            ]);
        });
    }
};