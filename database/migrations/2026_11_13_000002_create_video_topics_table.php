<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_topics', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->unique();
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });

        // Isi awal dari topik yang sudah dipakai video.
        $existing = DB::table('videos')
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $urutan = 1;
        foreach ($existing as $nama) {
            $nama = trim((string) $nama);
            if ($nama === '') {
                continue;
            }

            DB::table('video_topics')->insert([
                'nama' => $nama,
                'urutan' => $urutan++,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('video_topics');
    }
};
