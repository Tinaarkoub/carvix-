<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('proprietaires', 'adresse')) {
            Schema::table('proprietaires', function (Blueprint $table) {
                $table->dropColumn('adresse');
            });
        }
    }

    public function down()
    {
        Schema::table('proprietaires', function (Blueprint $table) {
            $table->string('adresse')->nullable();
        });
    }
};