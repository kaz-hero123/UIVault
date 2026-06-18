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
        Schema::create('ui_inspirations', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image_path');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('status', 20)->default('inbox');
            $table->boolean('is_favorite')->default(false);
            $table->text('notes')->nullable();
            $table->string('source_url', 512)->nullable();
            $table->json('dominant_colors')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ui_inspirations');
    }
};
