<?php

use App\Models\Material;
use App\Models\User;

function adminUser(): User
{
    return User::factory()->create([
        'role' => 'admin',
        'department' => 'ICT',
    ]);
}

function studentUser(): User
{
    return User::factory()->create([
        'role' => 'student',
        'department' => 'ICT',
    ]);
}

test('admin portal pages render', function () {
    $admin = adminUser();
    $student = studentUser();

    Material::create([
        'title' => 'Networking fundamentals',
        'department' => 'ICT',
        'type' => 'pdf',
        'description' => 'An introduction to computer networking.',
        'file_path' => 'materials/networking.pdf',
    ]);

    $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    $this->actingAs($admin)->get(route('admin.students.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin.students.edit', $student))->assertOk();
    $this->actingAs($admin)->get(route('admin.materials.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin.materials.create'))->assertOk();
});

test('student portal pages render', function () {
    $student = studentUser();

    $material = Material::create([
        'title' => 'Networking fundamentals',
        'department' => 'ICT',
        'type' => 'pdf',
        'description' => 'An introduction to computer networking.',
        'file_path' => 'materials/networking.pdf',
    ]);

    $this->actingAs($student)->get(route('student.dashboard'))->assertOk();
    $this->actingAs($student)->get(route('student.library.index'))->assertOk();
    $this->actingAs($student)->get(route('student.library.show', $material))->assertOk();
    $this->actingAs($student)->get(route('student.profile'))->assertOk();
});

test('dashboard redirects each role to the correct portal', function () {
    $this->actingAs(adminUser())
        ->get(route('dashboard'))
        ->assertRedirect(route('admin.dashboard'));

    $this->actingAs(studentUser())
        ->get(route('dashboard'))
        ->assertRedirect(route('student.dashboard'));
});

test('students cannot access admin routes', function () {
    $this->actingAs(studentUser())
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});
