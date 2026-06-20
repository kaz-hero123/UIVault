<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInspirationRequest;
use App\Models\UiInspiration;
use App\Services\ColorExtractor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function __construct(
        private ColorExtractor $colorExtractor
    ) {}

    public function create()
    {
        return view('upload', [
            'maxFiles' => 15,
        ]);
    }

    public function store(StoreInspirationRequest $request)
    {
        $successCount = 0;
        $failed = [];

        foreach ($request->file('images') as $image) {
            try {
                $validator = Validator::make(
                    ['image' => $image],
                    [
                        'image' => ['required', 'file', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:10240'],
                    ],
                    [
                        'image.required' => 'File gambar tidak ditemukan.',
                        'image.file' => 'Upload harus berupa file.',
                        'image.image' => 'File harus berupa gambar.',
                        'image.mimes' => 'Format yang didukung: JPEG, PNG, GIF, WebP.',
                        'image.max' => 'Ukuran maksimal per gambar: 10MB.',
                    ]
                );

                if ($validator->fails()) {
                    $failed[] = [
                        'filename' => $image->getClientOriginalName(),
                        'reason' => $validator->errors()->first('image'),
                    ];

                    continue;
                }

                $path = $image->store('inspirations', 'public');

                $absolutePath = Storage::disk('public')->path($path);
                $dominantColors = $this->colorExtractor->extract($absolutePath);

                UiInspiration::create([
                    'title' => null,
                    'image_path' => $path,
                    'status' => 'inbox',
                    'dominant_colors' => $dominantColors,
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $failed[] = [
                    'filename' => $image->getClientOriginalName(),
                    'reason' => $e->getMessage(),
                ];
            }
        }

        return redirect()
            ->route('inbox')
            ->with('upload_result', [
                'success_count' => $successCount,
                'failed' => $failed,
            ]);
    }
}
