<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comentarios_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('comentario');
            $table->unsignedTinyInteger('calificacion'); // de 1 a 5 estrellas
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comentarios_productos');
    }
};
