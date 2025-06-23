<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('telefono')->nullable();
    });

    Schema::table('negocios', function (Blueprint $table) {
        $table->string('telefono')->nullable();
        $table->string('numero_tienda')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('telefono');
    });

    Schema::table('negocios', function (Blueprint $table) {
        $table->dropColumn('telefono');
        $table->dropColumn('numero_tienda');
    });
}

};
