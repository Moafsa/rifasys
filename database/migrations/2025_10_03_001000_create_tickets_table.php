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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_id')->constrained('raffles')->onDelete('cascade');
            $table->string('participant_name');
            $table->string('participant_email');
            $table->string('participant_phone')->nullable();
            $table->string('participant_document')->nullable();
            $table->integer('ticket_number');
            $table->decimal('price_paid', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'cancelled', 'refunded'])->default('pending');
            $table->string('payment_reference')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamp('purchased_at')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['raffle_id', 'ticket_number']);
            $table->index(['payment_status']);
            $table->index(['participant_email']);
            $table->index(['payment_reference']);
            
            // Ensure ticket number is unique per raffle
            $table->unique(['raffle_id', 'ticket_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};


