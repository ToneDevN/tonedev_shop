<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ImageUploadService
{
    /**
     * แปลงไฟล์ PNG หรือ JPEG เป็น WebP แล้วจัดเก็บใน storage
     *
     * @param  UploadedFile  $file      ไฟล์ที่อัปโหลด (jpeg/jpg/png)
     * @param  string        $directory โฟลเดอร์ปลายทางภายใน storage/app/public/
     * @param  int           $quality   คุณภาพของ WebP (0–100)
     * @return string                   path สัมพัทธ์ที่ใช้กับ Storage::url()
     */
    public function upload(UploadedFile $file, string $directory = 'uploads', int $quality = 85): string
    {
        $mime = $file->getMimeType();

        $image = match ($mime) {
            'image/jpeg' => \imagecreatefromjpeg($file->getRealPath()),
            'image/png'  => $this->createFromPng($file->getRealPath()),
            default      => throw new RuntimeException("Unsupported image type: {$mime}"),
        };

        $filename    = Str::uuid() . '.webp';
        $storagePath = "{$directory}/{$filename}";

        // สร้าง WebP ใน memory แล้วบันทึกผ่าน Storage
        ob_start();
        \imagewebp($image, null, $quality);
        $webpData = ob_get_clean();
        \imagedestroy($image);

        Storage::disk('public')->put($storagePath, $webpData);

        return $storagePath;
    }

    /**
     * สร้าง GD resource จาก PNG โดยรักษา alpha channel
     */
    private function createFromPng(string $path): \GdImage
    {
        $image = \imagecreatefrompng($path);

        // PNG แบบ palette/indexed (PNG-8) ไม่รองรับ imagewebp() ต้องแปลงเป็น true color ก่อน
        if (!\imageistruecolor($image)) {
            \imagepalettetotruecolor($image);
        }

        \imagealphablending($image, false);
        \imagesavealpha($image, true);

        return $image;
    }
}
