<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('subpedidos', function (Blueprint $table) {
        $table->string('foto_entrega')->nullable()->after('estado');
    });
}

public function down()
{
    Schema::table('subpedidos', function (Blueprint $table) {
        $table->dropColumn('foto_entrega');
    });
}

};
