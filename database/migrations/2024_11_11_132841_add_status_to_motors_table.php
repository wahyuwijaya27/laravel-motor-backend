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
        Schema::table('motors', function (Blueprint $table) {
            $table->string('status')->default('available'); // 'available' untuk motor yang belum terjual
        });
    }

    public function down()
    {
        Schema::table('motors', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

};
