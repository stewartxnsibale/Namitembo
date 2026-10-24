<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MaterialViewerController extends Controller
{
    public function file(Request $request, Material $material): BinaryFileResponse
    {
        $this->authorizeMaterial($request, $material);

        $disk = Storage::disk('public');
        abort_unless($disk->exists($material->file_path), 404, 'The resource file could not be found.');

        $path = $disk->path($material->file_path);
        $extension = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
        $contentType = match ($material->type) {
            'pdf' => 'application/pdf',
            'document' => match ($extension) {
                'doc' => 'application/msword',
                default => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            },
            'presentation' => match ($extension) {
                'ppt' => 'application/vnd.ms-powerpoint',
                default => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            },
            'video' => match ($extension) {
                'webm' => 'video/webm',
                'ogv' => 'video/ogg',
                default => 'video/mp4',
            },
            'image' => match ($extension) {
                'png' => 'image/png',
                'webp' => 'image/webp',
                'jpg', 'jpeg' => 'image/jpeg',
                default => 'application/octet-stream',
            },
        };

        return response()->file($path, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'inline',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    private function authorizeMaterial(Request $request, Material $material): void
    {
        $user = $request->user();
        abort_unless(
            $user->role === 'admin'
                || ($user->role === 'student' && $user->department === $material->department),
            404,
        );
    }
}
