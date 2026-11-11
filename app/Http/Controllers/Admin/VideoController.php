<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoTopic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');
        $status = in_array($status, ['all', 'active', 'inactive', 'ready', 'draft'], true) ? $status : 'all';

        $videos = Video::query()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search): void {
                $like = '%'.addcslashes($search, '%_\\').'%';
                $query->where('judul', 'like', $like)
                    ->orWhere('pembicara', 'like', $like)
                    ->orWhere('kategori', 'like', $like);
            }))
            ->when($status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->when($status === 'ready', fn ($query) => $query->whereNotNull('youtube_url')->where('youtube_url', '!=', ''))
            ->when($status === 'draft', fn ($query) => $query->where(fn ($query) => $query->whereNull('youtube_url')->orWhere('youtube_url', '')))
            ->ordered()
            ->get();

        return view('admin.videos.index', [
            'videos' => $videos,
            'search' => $search,
            'status' => $status,
            'totalSemua' => Video::query()->count(),
            'totalSiap' => Video::query()->whereNotNull('youtube_url')->where('youtube_url', '!=', '')->count(),
            'kategoris' => $this->kategoris(),
        ]);
    }

    public function create(): View
    {
        return view('admin.videos.form', [
            'video' => new Video(['kategori' => 'Hemodialisis', 'is_active' => true]),
            'kategoris' => $this->kategoris(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        // Video baru ditempatkan paling atas: seluruh urutan digeser satu tingkat.
        Video::query()->increment('sort_order');

        Video::query()->create([
            ...$validated,
            'slug' => Video::uniqueSlug($validated['judul']),
            'is_active' => (bool) ($validated['is_active'] ?? true),
            'sort_order' => 0,
        ]);

        return to_route('admin.videos.index')->with('status', 'Video berhasil ditambahkan.');
    }

    /**
     * Tambah video baru hanya dengan menempel tautan YouTube.
     * Judul diambil otomatis dari YouTube (oEmbed).
     */
    public function quickStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'youtube_url' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:100'],
        ], [
            'youtube_url.required' => 'Tempel tautan YouTube terlebih dahulu.',
        ]);

        $youtubeId = Video::parseYouTubeId($validated['youtube_url']);

        if ($youtubeId === null) {
            return back()->withInput()->with('error', 'Tautan tidak dikenali. Contoh yang benar: https://youtu.be/XXXXXXXXXXX');
        }

        $sudahAda = Video::query()->where('youtube_url', 'like', '%'.$youtubeId.'%')->first();

        if ($sudahAda !== null) {
            return back()->withInput()->with('error', 'Video ini sudah terdaftar: "'.$sudahAda->judul.'". Gunakan tombol Edit bila ingin mengganti tautannya.');
        }

        $meta = $this->fetchYouTubeMeta($youtubeId);

        $judul = $meta['judul'] ?? 'Video edukasi baru';
        $kategori = filled($validated['kategori'] ?? null) ? trim($validated['kategori']) : 'Hemodialisis';

        // Video baru ditempatkan paling atas: seluruh urutan digeser satu tingkat.
        Video::query()->increment('sort_order');

        $video = Video::query()->create([
            'judul' => mb_substr($judul, 0, 255),
            'slug' => Video::uniqueSlug($judul),
            'pembicara' => $meta['pembicara'] !== null ? mb_substr($meta['pembicara'], 0, 255) : null,
            'kategori' => $kategori,
            'youtube_url' => 'https://youtu.be/'.$youtubeId,
            'is_active' => true,
            'sort_order' => 0,
        ]);

        return to_route('admin.videos.index')
            ->with('status', 'Video "'.$video->judul.'" ditambahkan dari tautan YouTube.');
    }

    /**
     * Simpan/ganti tautan YouTube pada video yang sudah ada.
     */
    public function updateLink(Request $request, Video $video): RedirectResponse
    {
        $validated = $request->validate([
            'youtube_url' => ['required', 'string', 'max:255'],
        ], [
            'youtube_url.required' => 'Tempel tautan YouTube terlebih dahulu.',
        ]);

        $youtubeId = Video::parseYouTubeId($validated['youtube_url']);

        if ($youtubeId === null) {
            return back()->with('error', 'Tautan tidak dikenali untuk "'.$video->judul.'". Contoh: https://youtu.be/XXXXXXXXXXX');
        }

        $bentrok = Video::query()
            ->where('youtube_url', 'like', '%'.$youtubeId.'%')
            ->whereKeyNot($video->getKey())
            ->first();

        if ($bentrok !== null) {
            return back()->with('error', 'Tautan itu sudah dipakai video lain: "'.$bentrok->judul.'".');
        }

        $video->youtube_url = 'https://youtu.be/'.$youtubeId;
        $video->save();

        return back()->with('status', 'Tautan untuk "'.$video->judul.'" berhasil disimpan.');
    }

    public function edit(Video $video): View
    {
        return view('admin.videos.form', [
            'video' => $video,
            'kategoris' => $this->kategoris(),
        ]);
    }

    public function update(Request $request, Video $video): RedirectResponse
    {
        $validated = $this->validated($request);

        $video->fill($validated);
        $video->slug = $video->slug ?: Video::uniqueSlug($validated['judul'], $video->getKey());
        $video->is_active = (bool) ($validated['is_active'] ?? false);
        $video->save();

        return to_route('admin.videos.index')->with('status', 'Video berhasil diperbarui.');
    }

    public function toggle(Video $video): RedirectResponse
    {
        $video->is_active = ! $video->is_active;
        $video->save();

        return back()->with('status', $video->is_active ? 'Video ditampilkan.' : 'Video disembunyikan.');
    }

    public function destroy(Video $video): RedirectResponse
    {
        $video->delete();

        return to_route('admin.videos.index')->with('status', 'Video berhasil dihapus.');
    }

    /**
     * Ambil judul & nama kanal dari YouTube tanpa API key (oEmbed).
     *
     * @return array{judul: ?string, pembicara: ?string}
     */
    private function fetchYouTubeMeta(string $youtubeId): array
    {
        try {
            $response = Http::timeout(8)
                ->acceptJson()
                ->get('https://www.youtube.com/oembed', [
                    'url' => 'https://www.youtube.com/watch?v='.$youtubeId,
                    'format' => 'json',
                ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'judul' => isset($data['title']) ? trim((string) $data['title']) : null,
                    'pembicara' => isset($data['author_name']) ? trim((string) $data['author_name']) : null,
                ];
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return ['judul' => null, 'pembicara' => null];
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'pembicara' => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'youtube_url' => ['nullable', 'string', 'max:255'],
            'durasi' => ['nullable', 'string', 'max:40'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['youtube_url'] = filled($validated['youtube_url'] ?? null)
            ? trim($validated['youtube_url'])
            : null;

        return $validated;
    }

    /**
     * @return \Illuminate\Support\Collection<int, string>
     */
    private function kategoris()
    {
        return VideoTopic::namaList();
    }
}
