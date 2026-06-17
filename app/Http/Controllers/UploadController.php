<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInspirationRequest;
use App\Models\UiInspiration;
use App\Services\ColorExtractor;
use Illuminate\Support\Facades\Storage;

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
        $uploaded = [];

        foreach ($request->file('images') as $image) {
            $path = $image->store('inspirations', 'public');

            $absolutePath = Storage::disk('public')->path($path);
            $dominantColors = $this->colorExtractor->extract($absolutePath);

            $inspiration = UiInspiration::create([
                'image_path'      => $path,
                'status'          => 'inbox',
                'dominant_colors' => $dominantColors,
            ]);

            $uploaded[] = $inspiration;
        }

        $count = count($uploaded);

        return redirect()
            ->route('upload.create')
            ->with('success', "{$count} gambar berhasil diupload ke Inbox.");
    }
}
