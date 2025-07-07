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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who receives the notification
            $table->foreignId('from_user_id')->constrained('users')->onDelete('cascade'); // Who triggered the notification
            $table->string('type'); // 'like', 'comment', etc.
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional data (post_id, comment_id, etc.)
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // Index for performance
            $table->index(['user_id', 'read_at', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
