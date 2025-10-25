<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wuzapi_webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wuzapi_instance_id')->constrained()->onDelete('cascade');
            $table->string('event_type');
            $table->json('payload');
            $table->json('response')->nullable();
            $table->integer('status_code')->nullable();
            $table->float('processing_time')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['wuzapi_instance_id', 'event_type']);
            $table->index(['wuzapi_instance_id', 'created_at']);
            $table->index('status_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wuzapi_webhook_logs');
    }
};
