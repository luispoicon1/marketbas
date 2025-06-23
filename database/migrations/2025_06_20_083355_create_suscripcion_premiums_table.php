<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_suscripcion_premiums_table.php
public function up()
{
    Schema::create('suscripcion_premiums', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('comprobante'); // ruta del archivo
        $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('suscripcion_premiums'); // ← este debe coincidir con el `create`
}

};
