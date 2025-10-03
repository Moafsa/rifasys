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
        Schema::create('brazil_states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 2)->unique();
            $table->string('region');
            $table->timestamps();
        });

        Schema::create('brazil_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('state_id')->constrained('brazil_states')->onDelete('cascade');
            $table->string('ibge_code')->nullable();
            $table->timestamps();
            
            $table->index(['state_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brazil_cities');
        Schema::dropIfExists('brazil_states');
    }
};


