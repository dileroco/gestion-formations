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
        Schema::create('training_sessions', function (Blueprint $table) {
        $table->id();

        // Formation relation
        $table->foreignId('formation_id')
              ->constrained()
              ->cascadeOnDelete();

        // Trainer relation (users table)
        $table->foreignId('trainer_id')
              ->constrained('users')
              ->cascadeOnDelete();

        $table->timestamp('start_date');
        $table->timestamp('end_date');

        $table->integer('capacity');

        $table->enum('mode', ['presentiel', 'online', 'hybride']);

        $table->string('city')->nullable();
        $table->string('meeting_link')->nullable();

        $table->string('status')->default('scheduled');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
