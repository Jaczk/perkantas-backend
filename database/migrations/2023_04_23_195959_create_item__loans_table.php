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
            $table->integer('loan_id')->unsigned();
            $table->integer('good_id')->unsigned();
            $table->integer('user_id')->unsigned();  
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
