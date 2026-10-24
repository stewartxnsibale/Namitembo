<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $studentsQuery = User::where('role', 'student');

        $totalStudents = (clone $studentsQuery)->count();
        $totalBooks = Material::whereIn('type', ['pdf', 'document', 'presentation'])->count();
        $totalVideos = Material::where('type', 'video')->count();
        $totalMaterials = Material::count();
        $totalDepartments = 5;

        $departmentCounts = (clone $studentsQuery)
            ->select('department', DB::raw('COUNT(*) as total'))
            ->groupBy('department')
            ->pluck('total', 'department');

        $recentStudents = (clone $studentsQuery)
            ->latest()
            ->take(5)
            ->get();

        $recentUploads = Material::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalBooks',
            'totalVideos',
            'totalMaterials',
            'totalDepartments',
            'departmentCounts',
            'recentStudents',
            'recentUploads',
        ));
    }
}
