<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotorsTable extends Migration
{
    public function up()
    {
        Schema::create('motors', function (Blueprint $table) {
            $table->id(); // ID motor
            $table->string('name'); // Nama motor
            $table->string('brand'); // Merk motor
            $table->integer('year'); // Tahun
            $table->decimal('price', 10, 2); // Harga
            $table->string('image')->nullable(); // Menambahkan kolom image
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('motors');
    }
}

