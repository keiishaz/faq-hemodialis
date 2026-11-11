<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'urutan'])]
class VideoTopic extends Model
{
    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
        ];
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('urutan')->orderBy('nama');
    }

    /**
     * Jumlah video yang memakai topik ini.
     */
    public function jumlahVideo(): int
    {
        return Video::query()->where('kategori', $this->nama)->count();
    }

    /**
     * Daftar nama topik untuk dropdown/datalist.
     *
     * @return \Illuminate\Support\Collection<int, string>
     */
    public static function namaList()
    {
        $dariTabel = static::query()->ordered()->pluck('nama');

        $dariVideo = Video::query()
            ->select('kategori')
            ->distinct()
            ->pluck('kategori')
            ->map(fn ($nama) => trim((string) $nama))
            ->filter();

        return $dariTabel->merge($dariVideo)->unique()->filter()->values();
    }
}
