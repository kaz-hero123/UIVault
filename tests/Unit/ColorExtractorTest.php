<?php

namespace Tests\Unit;

use App\Services\ColorExtractor;
use Tests\TestCase;

class ColorExtractorTest extends TestCase
{
    private ColorExtractor $extractor;

    private string $tempImage;

    private string $tempTextFile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->extractor = new ColorExtractor;

        // Create a temporary red image
        $img = imagecreatetruecolor(10, 10);
        $red = imagecolorallocate($img, 255, 0, 0);
        imagefill($img, 0, 0, $red);

        $this->tempImage = tempnam(sys_get_temp_dir(), 'color_test_').'.jpg';
        imagejpeg($img, $this->tempImage);
        imagedestroy($img);

        // Create a non-image file
        $this->tempTextFile = tempnam(sys_get_temp_dir(), 'color_test_').'.txt';
        file_put_contents($this->tempTextFile, 'This is not an image file.');
    }

    protected function tearDown(): void
    {
        if (file_exists($this->tempImage)) {
            unlink($this->tempImage);
        }
        if (file_exists($this->tempTextFile)) {
            unlink($this->tempTextFile);
        }
        parent::tearDown();
    }

    public function test_extracts_dominant_colors_in_hex_format(): void
    {
        $colors = $this->extractor->extract($this->tempImage);

        $this->assertNotEmpty($colors);
        foreach ($colors as $color) {
            $this->assertMatchesRegularExpression('/^#[0-9a-f]{6}$/i', $color);
        }
    }

    public function test_does_not_exceed_requested_count(): void
    {
        $colors = $this->extractor->extract($this->tempImage, 2);
        $this->assertLessThanOrEqual(2, count($colors));
    }

    public function test_returns_empty_array_for_non_image_path(): void
    {
        $colors = $this->extractor->extract($this->tempTextFile);
        $this->assertEmpty($colors);
    }
}
