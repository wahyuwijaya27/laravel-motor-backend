<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToMotorsTable extends Migration
{
    public function up()
    {
        // Schema::table('motors', function (Blueprint $table) {
        //     $table->string('image')->nullable(); // Menambahkan kolom image
        // });
    }

    public function down()
    {
        // Schema::table('motors', function (Blueprint $table) {
        //     $table->dropColumn('image'); // Menghapus kolom image jika dibatalkan
        // });
    }
}
