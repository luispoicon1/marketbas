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
    Schema::table('pedidos', function (Blueprint $table) {
        $table->string('tipo_entrega')->nullable(); // 'delivery' o 'tienda'
        $table->decimal('costo_delivery', 8, 2)->nullable();
        $table->string('direccion_entrega')->nullable();
        $table->decimal('distancia_km', 6, 2)->nullable(); // opcional
    });
}

public function down()
{
    Schema::table('pedidos', function (Blueprint $table) {
        $table->dropColumn(['tipo_entrega', 'costo_delivery', 'direccion_entrega', 'distancia_km']);
    });
}

};
