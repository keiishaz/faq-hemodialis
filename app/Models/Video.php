<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['judul', 'slug', 'pembicara', 'kategori', 'youtube_url', 'durasi', 'deskripsi', 'is_active', 'sort_order'])]
class Video extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Ambil ID video YouTube dari berbagai bentuk URL.
     */
    public function youtubeId(): ?string
    {
        $url = trim((string) $this->youtube_url);

        if ($url === '') {
            return null;
        }

        $patterns = [
            '~youtu\.be/([A-Za-z0-9_-]{11})~',
            '~youtube\.com/(?:watch\?(?:.*&)?v=)([A-Za-z0-9_-]{11})~',
            '~youtube\.com/(?:embed|shorts|live|v)/([A-Za-z0-9_-]{11})~',
            '~^([A-Za-z0-9_-]{11})$~',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches) === 1) {
                return $matches[1];
            }
        }

        return null;
    }

    public function hasVideo(): bool
    {
        return $this->youtubeId() !== null;
    }

    public function embedUrl(): ?string
    {
        $id = $this->youtubeId();

        return $id === null ? null : 'https://www.youtube-nocookie.com/embed/'.$id.'?rel=0&modestbranding=1';
    }

    public function thumbnailUrl(): ?string
    {
        $id = $this->youtubeId();

        return $id === null ? null : 'https://i.ytimg.com/vi/'.$id.'/hqdefault.jpg';
    }

    public function watchUrl(): ?string
    {
        $id = $this->youtubeId();

        return $id === null ? null : 'https://www.youtube.com/watch?v='.$id;
    }

    public static function uniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $base = Str::slug($judul) ?: 'video';
        $slug = $base;
        $counter = 1;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId !== null, fn (Builder $query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = $base.'-'.(++$counter);
        }

        return $slug;
    }
}
