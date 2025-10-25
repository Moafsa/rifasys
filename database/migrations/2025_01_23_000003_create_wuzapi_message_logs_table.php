<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wuzapi_message_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wuzapi_instance_id')->constrained()->onDelete('cascade');
            $table->string('message_id')->nullable();
            $table->string('phone_number');
            $table->string('message_type');
            $table->json('content');
            $table->enum('status', ['pending', 'sent', 'delivered', 'read', 'failed'])->default('pending');
            $table->json('response')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index(['wuzapi_instance_id', 'status']);
            $table->index(['wuzapi_instance_id', 'message_type']);
            $table->index(['phone_number', 'created_at']);
            $table->index('message_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wuzapi_message_logs');
    }
};
