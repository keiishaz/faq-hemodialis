<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PublicVideoController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $kategori = trim((string) $request->query('kategori', ''));

        $videos = Video::query()
            ->active()
            ->available()
            ->ordered()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search): void {
                $like = '%'.addcslashes($search, '%_\\').'%';
                $query->where('judul', 'like', $like)
                    ->orWhere('pembicara', 'like', $like)
                    ->orWhere('kategori', 'like', $like);
            }))
            ->when($kategori !== '', fn ($query) => $query->where('kategori', $kategori))
            ->get();

        $kategoris = Video::query()
            ->active()
            ->available()
            ->ordered()
            ->pluck('kategori')
            ->unique()
            ->values();

        $total = Video::query()->active()->available()->count();

        return view('public.videos.index', [
            'videos' => $videos,
            'kategoris' => $kategoris,
            'search' => $search,
            'kategoriAktif' => $kategori,
            'total' => $total,
            'pageTitle' => 'Video Edukasi',
        ]);
    }

    public function show(Video $video): View|Response
    {
        // Video yang belum punya tautan YouTube tidak ditampilkan ke publik.
        if (! $video->is_active || ! $video->hasVideo()) {
            return response()->view('public.not-found', [], 404);
        }

        $lainnya = Video::query()
            ->active()
            ->available()
            ->ordered()
            ->whereKeyNot($video->getKey())
            ->where('kategori', $video->kategori)
            ->limit(6)
            ->get();

        if ($lainnya->count() < 4) {
            $lainnya = $lainnya->merge(
                Video::query()
                    ->active()
                    ->available()
                    ->ordered()
                    ->whereKeyNot($video->getKey())
                    ->where('kategori', '!=', $video->kategori)
                    ->limit(6 - $lainnya->count())
                    ->get()
            );
        }

        return view('public.videos.show', [
            'video' => $video,
            'lainnya' => $lainnya,
            'pageTitle' => $video->judul,
        ]);
    }
}
