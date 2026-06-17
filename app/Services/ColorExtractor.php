<?php

namespace App\Services;

use GdImage;
use RuntimeException;

class ColorExtractor
{
    private const THUMBNAIL_SIZE = 60;
    private const QUANTIZE_STEP = 32;

    /**
     * Ekstrak warna dominan dari gambar menggunakan histogram quantization.
     *
     * Cara kerja:
     * 1. Resize gambar ke thumbnail kecil (60×60) supaya proses cepat.
     * 2. Loop tiap pixel, bulatkan RGB ke kelipatan 32 (~512 bucket warna).
     * 3. Ambil bucket dengan frekuensi tertinggi sebagai warna dominan.
     *
     * @param  string  $absoluteImagePath  Path absolut ke file gambar.
     * @param  int     $count              Jumlah warna dominan yang diambil.
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

        // Kalau semua pixel transparan, tidak ada bucket
        if (empty($buckets)) {
            return [];
        }

        arsort($buckets);

        $topColors = array_slice(array_keys($buckets), 0, $count);

        return array_map(fn (string $key) => $this->bucketKeyToHex($key), $topColors);
    }

    /**
     * Buat GD image resource dari file.
     * Return null kalau format tidak didukung atau file tidak bisa dibaca.
     */
    private function createImageResource(string $path): ?GdImage
    {
        if (! file_exists($path)) {
            throw new RuntimeException("File gambar tidak ditemukan: {$path}");
        }

        $imageInfo = getimagesize($path);

        if ($imageInfo === false) {
            return null;
        }

        // imagecreatefrom* bisa return GdImage|false
        // Kita tangkap false dan konversi ke null supaya konsisten
        $image = match ($imageInfo[2]) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($path),
            IMAGETYPE_PNG  => imagecreatefrompng($path),
            IMAGETYPE_GIF  => imagecreatefromgif($path),
            IMAGETYPE_WEBP => imagecreatefromwebp($path),
            default        => false,
        };

        return $image instanceof GdImage ? $image : null;
    }

    /**
     * Resize gambar ke thumbnail kecil supaya proses ekstraksi warna cepat.
     */
    private function resizeToThumbnail(GdImage $source): ?GdImage
    {
        $thumbnail = imagecreatetruecolor(self::THUMBNAIL_SIZE, self::THUMBNAIL_SIZE);

        if (! $thumbnail instanceof GdImage) {
            return null;
        }

        // Pertahankan informasi alpha/transparency supaya bisa dideteksi
        imagealphablending($thumbnail, false);
        imagesavealpha($thumbnail, true);

        // Isi background dengan transparan penuh supaya pixel transparan
        // dari source tidak berubah jadi hitam
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

    /**
     * Hitung frekuensi tiap bucket warna.
     * Pixel transparan (alpha > 64, skala 0-127) di-skip supaya
     * tidak mencemari hasil warna dominan.
     */
    private function countColorBuckets(GdImage $thumbnail): array
    {
        $buckets = [];

        for ($x = 0; $x < self::THUMBNAIL_SIZE; $x++) {
            for ($y = 0; $y < self::THUMBNAIL_SIZE; $y++) {
                $rgb = imagecolorat($thumbnail, $x, $y);
                $colors = imagecolorsforindex($thumbnail, $rgb);

                // Skip pixel yang sebagian besar transparan
                // Alpha di GD: 0 = fully opaque, 127 = fully transparent
                if ($colors['alpha'] > 64) {
                    continue;
                }

                $bucketKey = $this->quantize($colors['red'])
                    . '-' . $this->quantize($colors['green'])
                    . '-' . $this->quantize($colors['blue']);

                $buckets[$bucketKey] = ($buckets[$bucketKey] ?? 0) + 1;
            }
        }

        return $buckets;
    }

    /**
     * Bulatkan nilai channel RGB ke kelipatan QUANTIZE_STEP.
     * Ini mengurangi ~16 juta kemungkinan warna jadi ~512 bucket.
     */
    private function quantize(int $channelValue): int
    {
        return intdiv($channelValue, self::QUANTIZE_STEP) * self::QUANTIZE_STEP;
    }

    /**
     * Konversi bucket key "R-G-B" ke format hex "#rrggbb".
     */
    private function bucketKeyToHex(string $bucketKey): string
    {
        [$r, $g, $b] = array_map('intval', explode('-', $bucketKey));

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
