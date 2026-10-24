<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    private const DEPARTMENTS = ['ICT', 'FBW', 'BL', 'CJ', 'TFD'];

    public function dashboard(): View
    {
        $student = auth()->user();

        $materialsQuery = Material::query()
            ->where('department', $student->department);

        $materialCounts = (clone $materialsQuery)
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $recentMaterials = (clone $materialsQuery)
            ->latest()
            ->take(6)
            ->get();

        return view('student.dashboard', compact('materialCounts', 'recentMaterials'));
    }

    public function library(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', Rule::in(['pdf', 'presentation', 'document', 'video', 'image'])],
        ]);

        $student = $request->user();
        $query = Material::query()
            ->where('department', $student->department)
            ->when($validated['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($validated['type'] ?? null, fn ($query, string $type) => $query->where('type', $type))
            ->latest();

        $materials = $query->paginate(12)->withQueryString();
        $materialCounts = Material::query()
            ->where('department', $student->department)
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        return view('student.library.index', compact('materials', 'materialCounts'));
    }

    public function show(Material $material): View
    {
        abort_unless($material->department === auth()->user()->department, 404);

        return view('student.library.show', compact('material'));
    }

    public function download(Material $material)
    {
        abort_unless($material->department === auth()->user()->department, 404);

        $disk = Storage::disk('public');
        abort_unless($disk->exists($material->file_path), 404, 'The resource file could not be found.');

        return $disk->download($material->file_path, basename($material->file_path));
    }

    public function editProfile(Request $request): View
    {
        return view('student.profile', [
            'student' => $request->user(),
            'departments' => self::DEPARTMENTS,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $student */
        $student = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($student->id),
            ],
            'department' => ['required', Rule::in(self::DEPARTMENTS)],
            'current_password' => ['required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $student->name = $validated['name'];
        $student->email = $validated['email'];
        $student->department = $validated['department'];

        if ($student->isDirty('email')) {
            $student->email_verified_at = null;
        }

        if (! empty($validated['password'])) {
            $student->password = $validated['password'];
        }

        $student->save();

        return redirect()
            ->route('student.profile')
            ->with('status', 'Your profile has been updated.');
    }
}
