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
    Schema::create('formations', function (Blueprint $table) {
        $table->id();

        $table->foreignId('category_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->string('title_fr');
        $table->string('title_en');

        $table->string('slug_fr')->unique();
        $table->string('slug_en')->unique();

        $table->text('short_description_fr');
        $table->text('short_description_en');

        $table->longText('description_fr');
        $table->longText('description_en');

        $table->string('image')->nullable();

        $table->decimal('price', 10, 2);
        $table->integer('duration'); 
        $table->string('level');

        $table->string('status')->default('draft');

        $table->timestamp('published_at')->nullable();

        $table->string('seo_title_fr')->nullable();
        $table->string('seo_title_en')->nullable();

        $table->text('meta_description_fr')->nullable();
        $table->text('meta_description_en')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
