<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('pembicara')->nullable();
            $table->string('kategori')->default('Umum');
            $table->string('youtube_url')->nullable();
            $table->string('durasi', 40)->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order', 'id']);
            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
