<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInspirationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'images' => ['required', 'array', 'min:1', 'max:15'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Pilih minimal 1 gambar untuk diupload.',
            'images.max' => 'Maksimal 15 gambar per upload.',
        ];
    }
}
