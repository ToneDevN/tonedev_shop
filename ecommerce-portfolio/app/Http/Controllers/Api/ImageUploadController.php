<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ImageUploadController extends Controller
{
    public function __construct(private readonly ImageUploadService $imageUploadService) {}

    /**
     * รับไฟล์รูปภาพ (jpeg/png) แปลงเป็น WebP แล้วคืน image_path
     *
     * POST /api/upload/image
     * Body (multipart/form-data):
     *   image      - ไฟล์รูป (jpeg, jpg, png) ขนาดไม่เกิน 5 MB  [required]
     *   directory  - โฟลเดอร์ปลายทาง เช่น "products" หรือ "avatars"  [optional, default: uploads]
     *   quality    - คุณภาพ WebP 1–100  [optional, default: 85]
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image'     => ['required', 'file', 'mimes:jpeg,jpg,png', 'max:5120'],
            'directory' => ['sometimes', 'string', 'max:100', 'regex:/^[a-zA-Z0-9_\-\/]+$/'],
            'quality'   => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $directory = $request->input('directory', 'uploads');
        $quality   = (int) $request->input('quality', 85);

        try {
            $imagePath = $this->imageUploadService->upload(
                file: $request->file('image'),
                directory: $directory,
                quality: $quality,
            );
        } catch (RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'image_path' => $imagePath,
            'url'        => Storage::disk('public')->url($imagePath),
        ], 201);
    }
}
