<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoTopic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VideoTopicController extends Controller
{
    public function index(): View
    {
        $topics = VideoTopic::query()
            ->ordered()
            ->get()
            ->map(fn (VideoTopic $topic) => [
                'model' => $topic,
                'jumlah' => $topic->jumlahVideo(),
            ]);

        $tanpaTopik = Video::query()
            ->select('kategori')
            ->distinct()
            ->pluck('kategori')
            ->map(fn ($nama) => trim((string) $nama))
            ->filter()
            ->reject(fn ($nama) => VideoTopic::query()->where('nama', $nama)->exists())
            ->values();

        return view('admin.topics.index', [
            'topics' => $topics,
            'tanpaTopik' => $tanpaTopik,
            'totalVideo' => Video::query()->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:video_topics,nama'],
        ], [
            'nama.required' => 'Nama topik wajib diisi.',
            'nama.unique' => 'Topik dengan nama itu sudah ada.',
        ]);

        VideoTopic::query()->create([
            'nama' => trim($validated['nama']),
            'urutan' => (int) VideoTopic::query()->max('urutan') + 1,
        ]);

        return back()->with('status', 'Topik "'.trim($validated['nama']).'" ditambahkan.');
    }

    public function update(Request $request, VideoTopic $topic): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:video_topics,nama,'.$topic->getKey()],
        ], [
            'nama.required' => 'Nama topik wajib diisi.',
            'nama.unique' => 'Topik dengan nama itu sudah ada.',
        ]);

        $namaBaru = trim($validated['nama']);
        $namaLama = $topic->nama;

        if ($namaBaru !== $namaLama) {
            Video::query()->where('kategori', $namaLama)->update(['kategori' => $namaBaru]);
        }

        $topic->nama = $namaBaru;
        $topic->save();

        return back()->with('status', 'Topik diperbarui menjadi "'.$namaBaru.'".');
    }

    public function destroy(VideoTopic $topic): RedirectResponse
    {
        $jumlah = $topic->jumlahVideo();

        if ($jumlah > 0) {
            return back()->with('error', 'Topik "'.$topic->nama.'" masih dipakai '.$jumlah.' video. Pindahkan videonya ke topik lain lebih dulu.');
        }

        $nama = $topic->nama;
        $topic->delete();

        return back()->with('status', 'Topik "'.$nama.'" dihapus.');
    }
}
