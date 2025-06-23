<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // subpedidos
public function up()
{
    Schema::create('subpedidos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pedido_id')->constrained()->onDelete('cascade');
        $table->foreignId('negocio_id')->constrained()->onDelete('cascade');
        $table->decimal('subtotal', 10, 2);
        $table->string('estado')->default('pendiente'); // pendiente, pagado, entregado
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subpedidos');
    }
};
