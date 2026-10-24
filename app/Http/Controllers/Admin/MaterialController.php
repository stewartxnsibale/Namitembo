<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function create(): View
    {
        return view('admin.materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department' => ['required', Rule::in(['ICT', 'FBW', 'BL', 'CJ', 'TFD'])],
            'type' => ['required', Rule::in(['pdf', 'presentation', 'document', 'video', 'image'])],
            'description' => ['required', 'string', 'max:500'],
            'file' => ['required', 'file', 'max:102400'],
        ]);

        $path = $request->file('file')->store('materials', 'public');

        Material::create([
            'title' => $validated['title'],
            'department' => $validated['department'],
            'type' => $validated['type'],
            'description' => $validated['description'],
            'file_path' => $path,
        ]);

        return redirect()
            ->route('admin.materials.index')
            ->with('status', 'Material uploaded successfully.');
    }

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', Rule::in(['pdf', 'presentation', 'document', 'video', 'image'])],
            'department' => ['nullable', Rule::in(['ICT', 'FBW', 'BL', 'CJ', 'TFD'])],
        ]);

        $materials = Material::query()
            ->when($validated['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($validated['type'] ?? null, fn ($query, string $type) => $query->where('type', $type))
            ->when($validated['department'] ?? null, fn ($query, string $department) => $query->where('department', $department))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $materialCounts = Material::query()
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $totalMaterials = Material::count();

        return view('admin.materials.index', compact('materials', 'materialCounts', 'totalMaterials'));
    }

    public function show(Material $material): View
    {
        return view('admin.materials.show', compact('material'));
    }

    public function edit(Material $material): View
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department' => ['required', Rule::in(['ICT', 'FBW', 'BL', 'CJ', 'TFD'])],
            'type' => ['required', Rule::in(['pdf', 'presentation', 'document', 'video', 'image'])],
            'description' => ['required', 'string', 'max:500'],
            'file' => ['nullable', 'file', 'max:102400'],
        ]);

        $material->title = $validated['title'];
        $material->department = $validated['department'];
        $material->type = $validated['type'];
        $material->description = $validated['description'];

        if ($request->hasFile('file')) {
            $disk = Storage::disk('public');
            if ($material->file_path && $disk->exists($material->file_path)) {
                $disk->delete($material->file_path);
            }
            $material->file_path = $request->file('file')->store('materials', 'public');
        }

        $material->save();

        return redirect()
            ->route('admin.materials.index')
            ->with('status', 'Material updated successfully.');
    }

    public function destroy(Material $material): RedirectResponse
    {
        $disk = Storage::disk('public');
        if ($material->file_path && $disk->exists($material->file_path)) {
            $disk->delete($material->file_path);
        }

        $material->delete();

        return redirect()
            ->route('admin.materials.index')
            ->with('status', 'Material deleted successfully.');
    }

    public function view(Material $material)
    {
        $path = storage_path('app/public/'.$material->file_path);

        abort_unless(file_exists($path), 404, 'File not found on the server.');

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
        ]);
    }
}
