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
        Schema::table('checkouts', function (Blueprint $table) {
            $table->unsignedBigInteger('users_id')->nullable()->after('id');
            
            // Jika ada relasi user dengan tabel users
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropForeign(['users_id']);
            $table->dropColumn('users_id');
        });
    }


    /**
     * Reverse the migrations.
     */
   
};
