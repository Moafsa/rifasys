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
        Schema::table('raffles', function (Blueprint $table) {
            $table->string('state')->nullable()->after('category');
            $table->string('city')->nullable()->after('state');
            $table->string('neighborhood')->nullable()->after('city');
            $table->text('address')->nullable()->after('neighborhood');
            $table->string('zip_code')->nullable()->after('address');
            
            // Indexes for location filtering
            $table->index(['state', 'city']);
            $table->index('state');
            $table->index('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raffles', function (Blueprint $table) {
            $table->dropIndex(['state', 'city']);
            $table->dropIndex(['state']);
            $table->dropIndex(['city']);
            $table->dropColumn(['state', 'city', 'neighborhood', 'address', 'zip_code']);
        });
    }
};


