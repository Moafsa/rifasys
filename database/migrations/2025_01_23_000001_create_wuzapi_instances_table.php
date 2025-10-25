<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wuzapi_instances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('api_token');
            $table->string('instance_id')->unique();
            $table->string('webhook_url')->nullable();
            $table->string('webhook_secret')->nullable();
            $table->enum('status', ['connecting', 'connected', 'disconnected', 'error'])->default('connecting');
            $table->text('qr_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('settings')->nullable();
            $table->timestamp('last_connected_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'status']);
            $table->index('instance_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wuzapi_instances');
    }
};
