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
        Schema::create('raffle_prizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_id')->constrained('raffles')->onDelete('cascade');
            $table->string('name');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->integer('position')->default(0); // Para ordenar os prêmios
            $table->timestamps();
            
            $table->index(['raffle_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_prizes');
    }
};


