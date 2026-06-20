<?php

namespace Tests\Feature;

use App\Models\UiInspiration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_can_upload_valid_images_massively(): void
    {
        $files = [
            UploadedFile::fake()->image('test1.jpg'),
            UploadedFile::fake()->image('test2.png'),
            UploadedFile::fake()->image('test3.webp'),
        ];

        $response = $this->post(route('upload.store'), [
            'images' => $files,
        ]);

        $response->assertRedirect(route('inbox'));
        $response->assertSessionHas('upload_result', [
            'success_count' => 3,
            'failed' => [],
        ]);

        $this->assertDatabaseCount('ui_inspirations', 3);

        $items = UiInspiration::all();
        foreach ($items as $index => $item) {
            $this->assertEquals('inbox', $item->status);
            $this->assertNotEmpty($item->dominant_colors);
            $this->assertNotNull($item->image_path);
            $this->assertTrue(Storage::disk('public')->exists($item->image_path));
        }
    }

    public function test_uploading_more_than_fifteen_files_is_rejected(): void
    {
        $files = [];
        for ($i = 0; $i < 16; $i++) {
            $files[] = UploadedFile::fake()->image("test_{$i}.jpg");
        }

        $response = $this->post(route('upload.store'), [
            'images' => $files,
        ]);

        $response->assertSessionHasErrors(['images']);
        $this->assertDatabaseCount('ui_inspirations', 0);
    }

    public function test_uploading_invalid_mime_type_is_rejected(): void
    {
        $files = [
            UploadedFile::fake()->create('test.pdf', 100, 'application/pdf'),
        ];

        $response = $this->post(route('upload.store'), [
            'images' => $files,
        ]);

        $response->assertRedirect(route('inbox'));
        $response->assertSessionHas('upload_result', [
            'success_count' => 0,
            'failed' => [
                [
                    'filename' => 'test.pdf',
                    'reason' => 'File harus berupa gambar.',
                ],
            ],
        ]);
        $this->assertDatabaseCount('ui_inspirations', 0);
    }
}
