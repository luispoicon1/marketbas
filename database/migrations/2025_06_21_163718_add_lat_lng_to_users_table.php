<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->decimal('lat', 10, 7)->nullable()->after('referencia');
        $table->decimal('lng', 10, 7)->nullable()->after('lat');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['lat', 'lng']);
    });
}

};
