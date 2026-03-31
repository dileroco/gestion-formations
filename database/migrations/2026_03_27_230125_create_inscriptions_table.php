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
    Schema::create('inscriptions', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->foreignId('session_id')
          ->constrained('training_sessions')
          ->cascadeOnDelete();

    $table->string('reference')->unique();

    $table->enum('status', ['pending', 'confirmed', 'cancelled'])
          ->default('pending');

    $table->text('note')->nullable();

    $table->timestamp('confirmed_at')->nullable();
    $table->timestamp('cancelled_at')->nullable();

    $table->timestamps();

    $table->unique(['user_id', 'session_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
