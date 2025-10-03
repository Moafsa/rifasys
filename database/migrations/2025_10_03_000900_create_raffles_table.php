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
        Schema::create('raffles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('prize_description');
            $table->string('prize_image')->nullable();
            $table->decimal('price_per_ticket', 10, 2);
            $table->integer('total_tickets');
            $table->integer('sold_tickets')->default(0);
            $table->datetime('draw_date');
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');
            $table->string('category')->default('general');
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->boolean('featured')->default(false);
            $table->integer('min_tickets_to_draw')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->text('contact_info')->nullable();
            $table->decimal('goal_amount', 12, 2)->nullable();
            $table->decimal('current_amount', 12, 2)->default(0);
            $table->json('payment_methods')->nullable();
            $table->json('social_media_links')->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('auto_draw')->default(true);
            $table->boolean('notify_winners')->default(true);
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['status', 'is_public']);
            $table->index(['draw_date']);
            $table->index(['featured']);
            $table->index(['category']);
            $table->index(['organizer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffles');
    }
};


