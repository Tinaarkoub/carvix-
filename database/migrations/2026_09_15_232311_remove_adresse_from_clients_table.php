<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('clients', 'adresse')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('adresse');
            });
        }
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('adresse')->nullable();
        });
    }
};