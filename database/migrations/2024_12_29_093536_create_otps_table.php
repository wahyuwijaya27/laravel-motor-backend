<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai primary key
            $table->unsignedBigInteger('user_id'); // Kolom user_id untuk relasi ke tabel users
            $table->string('otp', 6); // Kolom otp dengan panjang maksimal 6 karakter
            $table->timestamps();

            // Tambahkan foreign key untuk user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
