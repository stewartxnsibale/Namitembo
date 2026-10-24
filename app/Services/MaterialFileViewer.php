<?php

namespace App\Services;

use App\Models\Material;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Vish4395\LaravelFileViewer\LaravelFileViewer as LaravelFileViewerPackage;

class MaterialFileViewer
{
    public function show(Material $material, string $fileUrl): View
    {
        $disk = Storage::disk('public');
        abort_unless($disk->exists($material->file_path), 404, 'The resource file could not be found.');

        return LaravelFileViewerPackage::show(
            fileName: $material->title,
            filePath: $material->file_path,
            fileUrl: $fileUrl,
            disk: 'public',
        );
    }
}
