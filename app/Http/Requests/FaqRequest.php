<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string|In>>
     */
    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:255', 'not_regex:/^\s*$/u'],
            'short_answer' => ['required', 'string', 'max:2000', 'not_regex:/^\s*$/u'],
            'full_answer' => ['nullable', 'string', 'max:50000'],
            'is_active' => ['required', Rule::in(['0', '1'])],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'question.required' => 'Pertanyaan wajib diisi.',
            'question.max' => 'Pertanyaan maksimal 255 karakter.',
            'question.not_regex' => 'Pertanyaan tidak boleh hanya spasi.',
            'short_answer.required' => 'Jawaban singkat wajib diisi.',
            'short_answer.max' => 'Jawaban singkat maksimal 2000 karakter.',
            'short_answer.not_regex' => 'Jawaban singkat tidak boleh hanya spasi.',
            'full_answer.max' => 'Jawaban lengkap maksimal 50000 karakter HTML.',
            'is_active.required' => 'Pilih status FAQ.',
            'is_active.in' => 'Status FAQ tidak valid.',
        ];
    }

    protected function prepareForValidation(): void
    {
        foreach (['question', 'short_answer'] as $field) {
            if (is_string($this->input($field))) {
                $this->merge([$field => trim($this->input($field))]);
            }
        }
    }
}
