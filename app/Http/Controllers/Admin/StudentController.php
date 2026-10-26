<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    private const DEPARTMENTS = ['ICT', 'FBW', 'BL', 'CJ', 'TFD'];

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', Rule::in(self::DEPARTMENTS)],
        ]);

        $students = User::query()
            ->where('role', 'student')
            ->when($validated['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($validated['department'] ?? null, fn ($query, string $department) => $query->where('department', $department))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $studentCount = User::where('role', 'student')->count();

        return view('admin.students.index', compact('students', 'studentCount'));
    }

    public function edit(User $student): View
    {
        $this->ensureStudent($student);

        return view('admin.students.edit', [
            'student' => $student,
            'departments' => self::DEPARTMENTS,
        ]);
    }

    public function update(Request $request, User $student): RedirectResponse
    {
        $this->ensureStudent($student);

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
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', Rule::in(['student', 'admin'])],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'remove_profile_photo' => ['nullable', 'boolean'],
        ]);

        $student->name = $validated['name'];
        $student->email = $validated['email'];
        $student->department = $validated['department'];
        $student->role = $validated['role'];

        if ($student->isDirty('email')) {
            $student->email_verified_at = null;
        }

        if (! empty($validated['password'])) {
            $student->password = $validated['password'];
        }

        if ($request->boolean('remove_profile_photo')) {
            if ($student->profile_photo_path) {
                $disk = Storage::disk('public');
                if ($disk->exists($student->profile_photo_path)) {
                    $disk->delete($student->profile_photo_path);
                }
                $student->profile_photo_path = null;
            }
        } elseif ($request->hasFile('profile_photo')) {
            if ($student->profile_photo_path) {
                $disk = Storage::disk('public');
                if ($disk->exists($student->profile_photo_path)) {
                    $disk->delete($student->profile_photo_path);
                }
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $student->profile_photo_path = $path;
        }

        $student->save();

        return redirect()
            ->route('admin.students.index')
            ->with('status', 'Student account updated successfully.');
    }

    public function destroy(User $student): RedirectResponse
    {
        $this->ensureStudent($student);

        if ($student->profile_photo_path) {
            $disk = Storage::disk('public');

            if ($disk->exists($student->profile_photo_path) && ! $disk->delete($student->profile_photo_path)) {
                throw new \RuntimeException('The student profile photo could not be deleted.');
            }
        }

        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('status', 'Student account deleted successfully.');
    }

    private function ensureStudent(User $student): void
    {
        abort_unless($student->role === 'student', 404);
    }
}
