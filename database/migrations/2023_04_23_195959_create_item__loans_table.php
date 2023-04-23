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
        Schema::create('item__loans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_loan')->unsigned();
            $table->bigInteger('id_good')->unsigned();

            //Kalo mau pake foreign key di tabel foreign 

            // $table->foreign('id_loan')->references('id')->on('loans');
            // $table->foreign('id_good')->references('id')->on('goods');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item__loans');
    }
};
