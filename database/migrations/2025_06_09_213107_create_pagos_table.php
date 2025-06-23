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
    Schema::create('pagos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('subpedido_id')->constrained()->onDelete('cascade');
        $table->decimal('monto', 10, 2);
        $table->string('comprobante')->nullable(); // imagen que sube el admin
        $table->enum('estado', ['pendiente', 'aprobado'])->default('pendiente'); // aprobado por vendedor
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
