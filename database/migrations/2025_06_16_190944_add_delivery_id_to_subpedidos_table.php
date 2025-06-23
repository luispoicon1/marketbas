<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('subpedidos', function (Blueprint $table) {
        $table->unsignedBigInteger('delivery_id')->nullable()->after('negocio_id');
        $table->foreign('delivery_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('subpedidos', function (Blueprint $table) {
        $table->dropForeign(['delivery_id']);
        $table->dropColumn('delivery_id');
    });
}

};
