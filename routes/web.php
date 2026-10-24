<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MaterialController as AdminMaterialController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\MaterialViewerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route(
        auth()->user()->role === 'admin' ? 'admin.dashboard' : 'student.dashboard'
    );
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', AdminDashboardController::class)->name('dashboard');

        Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
        Route::get('/students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
        Route::match(['patch', 'put'], '/students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [AdminStudentController::class, 'destroy'])->name('students.destroy');

        Route::get('/materials', [AdminMaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/create', [AdminMaterialController::class, 'create'])->name('materials.create');
        Route::post('/materials', [AdminMaterialController::class, 'store'])->name('materials.store');
        // delete material route
        Route::delete('/materials/{material}', [AdminMaterialController::class, 'destroy'])->name('materials.destroy');
        Route::get('/materials/{material}', [AdminMaterialController::class, 'show'])->name('materials.show');
        Route::get('/materials/{material}/edit', [AdminMaterialController::class, 'edit'])->name('materials.edit');
        Route::match(['patch', 'put'], '/materials/{material}', [AdminMaterialController::class, 'update'])->name('materials.update');
        Route::get('/materials/{material}/file', [MaterialViewerController::class, 'file'])->name('materials.file');
    });

Route::middleware(['auth', 'verified', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/library', [StudentController::class, 'library'])->name('library.index');
        Route::get('/library/{material}', [StudentController::class, 'show'])->name('library.show');
        Route::get('/library/{material}/file', [MaterialViewerController::class, 'file'])->name('library.file');
        Route::get('/library/{material}/download', [StudentController::class, 'download'])->name('library.download');
        Route::get('/profile', [StudentController::class, 'editProfile'])->name('profile');
        Route::patch('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
