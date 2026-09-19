<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('vehicules', 'date_mise_en_circulation')) {
            Schema::table('vehicules', function (Blueprint $table) {
                $table->dropColumn('date_mise_en_circulation');
            });
        }
    }

    public function down()
    {
        Schema::table('vehicules', function (Blueprint $table) {
            $table->date('date_mise_en_circulation')->nullable()->after('immatriculation');
        });
    }
};