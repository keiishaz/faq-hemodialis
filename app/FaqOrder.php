<?php

namespace App;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FaqOrder
{
    /**
     * @param  Collection<int, Faq>  $faqs
     */
    public function snapshot(Collection $faqs): string
    {
        $records = $faqs->map(fn (Faq $faq): array => [
            $faq->id,
            $faq->sort_order,
            $faq->is_active,
            $faq->question,
            $faq->short_answer,
            $faq->full_answer,
            $faq->updated_at?->format('Y-m-d H:i:s.u'),
        ])->all();

        return hash('sha256', json_encode($records, JSON_THROW_ON_ERROR));
    }

    /**
     * @param  list<int>  $ids
     */
    public function save(array $ids, string $snapshot): string
    {
        return DB::transaction(function () use ($ids, $snapshot): string {
            $faqs = Faq::query()->ordered()->lockForUpdate()->get();
            $currentIds = $faqs->pluck('id')->all();
            $submittedIds = $ids;

            sort($currentIds, SORT_NUMERIC);
            sort($submittedIds, SORT_NUMERIC);

            if ($submittedIds !== $currentIds || ! hash_equals($this->snapshot($faqs), $snapshot)) {
                abort(409, 'Daftar FAQ telah berubah. Muat ulang sebelum mengurutkan.');
            }

            foreach ($ids as $position => $id) {
                DB::table('faqs')->where('id', $id)->update(['sort_order' => $position + 1]);
            }

            return $this->snapshot(Faq::query()->ordered()->get());
        }, attempts: 3);
    }
}
