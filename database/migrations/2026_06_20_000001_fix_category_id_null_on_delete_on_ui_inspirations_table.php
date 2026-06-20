<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ubah FK category_id di ui_inspirations dari cascadeOnDelete → nullOnDelete.
     * Sesuai ARCHITECTURE.md D10: menghapus Category tidak ikut menghapus item,
     * hanya melepas relasi (category_id jadi null).
     */
    public function up(): void
    {
        Schema::table('ui_inspirations', function (Blueprint $table) {
            $table->dropForeign(['category_id']);

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ui_inspirations', function (Blueprint $table) {
            $table->dropForeign(['category_id']);

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->cascadeOnDelete();
        });
    }
};
