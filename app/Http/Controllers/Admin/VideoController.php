<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        Video::query()->create([
            ...$validated,
            'slug' => Video::uniqueSlug($validated['judul']),
            'is_active' => (bool) ($validated['is_active'] ?? true),
            'sort_order' => (int) Video::query()->max('sort_order') + 1,
        ]);

        return to_route('admin.videos.index')->with('status', 'Video berhasil ditambahkan.');
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
        return Video::query()
            ->ordered()
            ->pluck('kategori')
            ->push('Hipertensi', 'Diabetes Melitus', 'Batu Ginjal & Saluran Kemih', 'Hemodialisis', 'Kesehatan Ginjal', 'Peritoneal Dialisis')
            ->filter()
            ->unique()
            ->values();
    }
}
