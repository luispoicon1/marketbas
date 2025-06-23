<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('departamento')->nullable()->after('telefono');
        $table->string('provincia')->nullable();
        $table->string('distrito')->nullable();
        $table->string('direccion')->nullable();
        $table->text('referencia')->nullable(); // más espacio para detalles
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['departamento', 'provincia', 'distrito', 'direccion', 'referencia']);
    });
}

};
