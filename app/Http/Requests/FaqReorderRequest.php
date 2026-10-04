<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class FaqReorderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'min:1', 'distinct:strict'],
            'snapshot' => ['required', 'string', 'regex:/^[a-f0-9]{64}$/'],
        ];
    }

    /**
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $ids = $this->input('ids');

                if (! is_array($ids) || ! array_is_list($ids)) {
                    $validator->errors()->add('ids', 'Kirim seluruh ID FAQ sebagai daftar berurutan.');

                    return;
                }

                foreach ($ids as $id) {
                    if (! is_int($id)) {
                        $validator->errors()->add('ids', 'Setiap ID FAQ harus berupa angka bulat.');

                        return;
                    }
                }
            },
        ];
    }
}
