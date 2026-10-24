<?php

namespace App\Services;

use App\Models\Material;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class MaterialFileStorage
{
    public function storeForDepartment(UploadedFile $file, string $department): string
    {
        return DB::transaction(function () use ($file, $department) {
            DB::table('material_file_sequences')->insertOrIgnore([
                'department' => $department,
                'next_number' => 1,
            ]);

            $sequence = DB::table('material_file_sequences')
                ->where('department', $department)
                ->lockForUpdate()
                ->first();

            if ($sequence === null) {
                throw new RuntimeException('The material file sequence could not be initialized.');
            }

            $number = max($sequence->next_number, $this->highestUsedNumber($department) + 1);
            $path = $this->storeAs($file, $department.str_pad((string) $number, 2, '0', STR_PAD_LEFT));

            DB::table('material_file_sequences')
                ->where('department', $department)
                ->update(['next_number' => $number + 1]);

            return $path;
        });
    }

    public function replace(UploadedFile $file, string $currentPath): string
    {
        return $this->storeAs(
            $file,
            pathinfo($currentPath, PATHINFO_FILENAME),
        );
    }

    private function storeAs(UploadedFile $file, string $filename): string
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if ($extension === '') {
            throw new RuntimeException('The uploaded material file has no extension.');
        }

        $path = $file->storeAs('materials', $filename.'.'.$extension, 'public');

        if ($path === false) {
            throw new RuntimeException('The material file could not be stored.');
        }

        return $path;
    }

    private function highestUsedNumber(string $department): int
    {
        $paths = array_merge(
            Storage::disk('public')->files('materials'),
            Material::query()->pluck('file_path')->all(),
        );
        $pattern = '/^'.preg_quote($department, '/').'(\d+)\.[^.]+$/i';
        $highest = 0;

        foreach ($paths as $path) {
            if (preg_match($pattern, basename($path), $matches) === 1) {
                $highest = max($highest, (int) $matches[1]);
            }
        }

        return $highest;
    }
}
