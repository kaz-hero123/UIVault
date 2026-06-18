<?php

namespace App\Services;

use GdImage;
use RuntimeException;

class ColorExtractor
{
    private const THUMBNAIL_SIZE = 60;

    private const QUANTIZE_STEP = 32;

    /**
     * @return string[] Array hex color, misal ['#a3c2e0', '#1f1f1f']
     */
    public function extract(string $absoluteImagePath, int $count = 5): array
    {
        $source = $this->createImageResource($absoluteImagePath);

        if ($source === null) {
            return [];
        }

        $thumbnail = $this->resizeToThumbnail($source);

        if ($thumbnail === null) {
            return [];
        }

        $buckets = $this->countColorBuckets($thumbnail);

        if (empty($buckets)) {
            return [];
        }

        arsort($buckets);

        $topColors = array_slice(array_keys($buckets), 0, $count);

        return array_map(fn (string $key) => $this->bucketKeyToHex($key), $topColors);
    }

    private function createImageResource(string $path): ?GdImage
    {
        if (! file_exists($path)) {
            throw new RuntimeException("File gambar tidak ditemukan: {$path}");
        }

        $imageInfo = getimagesize($path);

        if ($imageInfo === false) {
            return null;
        }

        $image = match ($imageInfo[2]) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($path),
            IMAGETYPE_PNG => imagecreatefrompng($path),
            IMAGETYPE_GIF => imagecreatefromgif($path),
            IMAGETYPE_WEBP => imagecreatefromwebp($path),
            default => false,
        };

        return $image instanceof GdImage ? $image : null;
    }

    private function resizeToThumbnail(GdImage $source): ?GdImage
    {
        $thumbnail = imagecreatetruecolor(self::THUMBNAIL_SIZE, self::THUMBNAIL_SIZE);

        if (! $thumbnail instanceof GdImage) {
            return null;
        }

        // Preserve alpha agar pixel transparan tidak jadi hitam
        imagealphablending($thumbnail, false);
        imagesavealpha($thumbnail, true);
        $transparent = imagecolorallocatealpha($thumbnail, 0, 0, 0, 127);
        imagefill($thumbnail, 0, 0, $transparent);

        imagecopyresampled(
            $thumbnail,
            $source,
            0, 0, 0, 0,
            self::THUMBNAIL_SIZE,
            self::THUMBNAIL_SIZE,
            imagesx($source),
            imagesy($source)
        );

        return $thumbnail;
    }

    private function countColorBuckets(GdImage $thumbnail): array
    {
        $buckets = [];

        for ($x = 0; $x < self::THUMBNAIL_SIZE; $x++) {
            for ($y = 0; $y < self::THUMBNAIL_SIZE; $y++) {
                $rgb = imagecolorat($thumbnail, $x, $y);
                $colors = imagecolorsforindex($thumbnail, $rgb);

                // GD alpha: 0 = opaque, 127 = transparent
                if ($colors['alpha'] > 64) {
                    continue;
                }

                $bucketKey = $this->quantize($colors['red'])
                    .'-'.$this->quantize($colors['green'])
                    .'-'.$this->quantize($colors['blue']);

                $buckets[$bucketKey] = ($buckets[$bucketKey] ?? 0) + 1;
            }
        }

        return $buckets;
    }

    private function quantize(int $channelValue): int
    {
        return intdiv($channelValue, self::QUANTIZE_STEP) * self::QUANTIZE_STEP;
    }

    private function bucketKeyToHex(string $bucketKey): string
    {
        [$r, $g, $b] = array_map('intval', explode('-', $bucketKey));

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
