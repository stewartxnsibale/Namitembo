@extends('admin.layouts.app')

@section('title', 'Students')
@section('page-kicker', 'People')
@section('page-title', 'Students')

@section('content')
    <div class="page-head">
        <div>
            <div class="breadcrumb">
                <span>Admin</span>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <span>Students</span>
            </div>
            <h1>Student accounts</h1>
            <p>Manage the {{ number_format($studentCount) }} students registered on the digital campus.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.materials.index') }}" class="btn btn-outline">
                <svg class="icon icon-sm"><use href="#icon-library"></use></svg>
                Resource library
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-gold">
                <svg class="icon icon-sm"><use href="#icon-grid"></use></svg>
                Dashboard
            </a>
        </div>
    </div>

    <form action="{{ route('admin.students.index') }}" method="GET" class="toolbar">
        <div class="toolbar-group">
            <div class="toolbar-search">
                <svg class="icon"><use href="#icon-search"></use></svg>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." aria-label="Search students">
            </div>
            <select name="department" aria-label="Filter by department">
                <option value="">All departments</option>
                @foreach (['ICT', 'FBW', 'CJ', 'TFD', 'BL'] as $department)
                    <option value="{{ $department }}" @selected(request('department') === $department)>{{ $department }}</option>
                @endforeach
            </select>
        </div>
        <div class="toolbar-group">
            @if (request()->filled('search') || request()->filled('department'))
                <a href="{{ route('admin.students.index') }}" class="btn btn-ghost btn-sm">Clear filters</a>
            @endif
            <button type="submit" class="btn btn-outline btn-sm">
                <svg class="icon icon-sm"><use href="#icon-filter"></use></svg>
                Apply
            </button>
        </div>
    </form>

    <div class="table-panel">
        @if ($students->isEmpty())
            <div class="empty-state" style="border:0;border-radius:0">
                <div class="empty-icon"><svg class="icon"><use href="#icon-users"></use></svg></div>
                <h3>No students found</h3>
                <p>{{ request()->filled('search') || request()->filled('department') ? 'Try a different search term or department filter.' : 'Student accounts will appear here once they register.' }}</p>
                @if (request()->filled('search') || request()->filled('department'))
                    <a href="{{ route('admin.students.index') }}" class="btn btn-outline btn-sm">Clear filters</a>
                @endif
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Department</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th style="text-align:right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>
                                    <div class="table-user">
                                        @include('shared.avatar', ['user' => $student])
                                        <div>
                                            <strong>{{ $student->name }}</strong>
                                            <span>{{ $student->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-gold">{{ $student->department }}</span></td>
                                <td>{{ $student->created_at->format('d M Y') }}</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td>
                                    <div class="table-actions" style="justify-content:flex-end">
                                        <a href="{{ route('admin.students.edit', $student) }}" class="icon-btn" aria-label="Edit {{ $student->name }}" title="Edit student">
                                            <svg class="icon"><use href="#icon-edit"></use></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.students.destroy', $student) }}" data-confirm="Delete {{ $student->name }}? This action cannot be undone.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-btn" aria-label="Delete {{ $student->name }}" title="Delete student" style="color:var(--ntc-danger)">
                                                <svg class="icon"><use href="#icon-trash"></use></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span>Showing {{ $students->firstItem() }}–{{ $students->lastItem() }} of {{ $students->total() }} students</span>

                @if ($students->hasPages())
                    <nav class="pagination" aria-label="Student pages">
                        @if ($students->onFirstPage())
                            <span class="disabled">Previous</span>
                        @else
                            <a href="{{ $students->previousPageUrl() }}" rel="prev">Previous</a>
                        @endif

                        @foreach ($students->getUrlRange(max(1, $students->currentPage() - 2), min($students->lastPage(), $students->currentPage() + 2)) as $page => $url)
                            @if ($page == $students->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($students->hasMorePages())
                            <a href="{{ $students->nextPageUrl() }}" rel="next">Next</a>
                        @else
                            <span class="disabled">Next</span>
                        @endif
                    </nav>
                @endif
            </div>
        @endif
    </div>
@endsection
