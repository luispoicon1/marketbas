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
    Schema::create('negocios', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // dueño del negocio
        $table->string('nombre');
        $table->string('ruc')->unique();
        $table->string('direccion');
        $table->text('descripcion')->nullable();
        $table->string('categoria');
        $table->string('foto')->nullable();
        $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('negocios');
}

};
