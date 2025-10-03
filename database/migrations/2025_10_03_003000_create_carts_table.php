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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('raffle_id')->constrained('raffles')->onDelete('cascade');
            $table->integer('ticket_quantity');
            $table->decimal('total_price', 10, 2);
            $table->string('session_id')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['user_id']);
            $table->index(['session_id']);
            $table->index(['raffle_id']);
            
            // Ensure unique cart items per user/session and raffle
            $table->unique(['user_id', 'raffle_id']);
            $table->unique(['session_id', 'raffle_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};


