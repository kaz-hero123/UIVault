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
            'images'   => ['required', 'array', 'min:1', 'max:15'],
            'images.*' => ['required', 'file', 'mimes:jpeg,jpg,png,gif,webp', 'max:10240'], // max 10MB per file
        ];
    }

    public function messages(): array
    {
        return [
            'images.required'  => 'Pilih minimal 1 gambar untuk diupload.',
            'images.max'       => 'Maksimal 15 gambar per upload.',
            'images.*.mimes'   => 'Format yang didukung: JPEG, PNG, GIF, WebP.',
            'images.*.max'     => 'Ukuran maksimal per gambar: 10MB.',
        ];
    }
}
