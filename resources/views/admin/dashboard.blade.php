@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-kicker', 'Overview')
@section('page-title', 'Dashboard')

@section('content')
    @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
        $firstName = strtok(auth()->user()->name, ' ');
        $departments = ['ICT' => 'ICT', 'FBW' => 'FBW', 'CJ' => 'CJ', 'TFD' => 'TFD', 'BL' => 'BL'];
    @endphp

    <div class="page-head">
        <div>
            <div class="breadcrumb">
                <span>Admin</span>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <span>Dashboard</span>
            </div>
            <h1>{{ $greeting }}, {{ $firstName }}</h1>
            <p>{{ now()->format('l, j F Y') }} · Here is what is happening across the college today.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.students.index') }}" class="btn btn-outline">
                <svg class="icon icon-sm"><use href="#icon-users"></use></svg>
                View students
            </a>
            <a href="{{ route('admin.materials.create') }}" class="btn btn-gold">
                <svg class="icon icon-sm"><use href="#icon-plus"></use></svg>
                Upload material
            </a>
        </div>
    </div>

    <div class="kpi-grid">
        <article class="stat-card">
            <div class="stat-card-top">
                <div class="icon-tile" style="--tile-bg:var(--ntc-pale);--tile-color:var(--ntc-navy)">
                    <svg class="icon"><use href="#icon-users"></use></svg>
                </div>
                <span class="stat-trend">Registered</span>
            </div>
            <div class="stat-value">{{ number_format($totalStudents) }}</div>
            <div class="stat-label">Student accounts</div>
        </article>

        <article class="stat-card">
            <div class="stat-card-top">
                <div class="icon-tile" style="--tile-bg:var(--ntc-warning-soft);--tile-color:var(--ntc-gold-muted)">
                    <svg class="icon"><use href="#icon-file"></use></svg>
                </div>
                <span class="stat-trend neutral">Library</span>
            </div>
            <div class="stat-value">{{ number_format($totalBooks) }}</div>
            <div class="stat-label">Documents and presentations</div>
        </article>

        <article class="stat-card">
            <div class="stat-card-top">
                <div class="icon-tile" style="--tile-bg:#ebedfb;--tile-color:#5360a8">
                    <svg class="icon"><use href="#icon-video"></use></svg>
                </div>
                <span class="stat-trend neutral">Library</span>
            </div>
            <div class="stat-value">{{ number_format($totalVideos) }}</div>
            <div class="stat-label">Video lessons</div>
        </article>

        <article class="stat-card">
            <div class="stat-card-top">
                <div class="icon-tile" style="--tile-bg:var(--ntc-success-soft);--tile-color:var(--ntc-success)">
                    <svg class="icon"><use href="#icon-building"></use></svg>
                </div>
                <span class="stat-trend neutral">Academic</span>
            </div>
            <div class="stat-value">{{ $totalDepartments }}</div>
            <div class="stat-label">Active departments</div>
        </article>
    </div>

    <div class="dashboard-grid">
        <section class="panel chart-panel">
            <div class="panel-head">
                <div>
                    <h2>Library activity</h2>
                    <p>Resources accessed across the last seven days</p>
                </div>
                <a href="{{ route('admin.materials.index') }}">
                    View library
                    <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg>
                </a>
            </div>
            <div class="panel-body">
                <div class="chart-shell">
                    <div class="chart-column"><div class="chart-bar" style="--height:42%"></div><span>Mon</span></div>
                    <div class="chart-column"><div class="chart-bar" style="--height:62%"></div><span>Tue</span></div>
                    <div class="chart-column"><div class="chart-bar" style="--height:51%"></div><span>Wed</span></div>
                    <div class="chart-column"><div class="chart-bar" style="--height:78%"></div><span>Thu</span></div>
                    <div class="chart-column"><div class="chart-bar" style="--height:66%"></div><span>Fri</span></div>
                    <div class="chart-column"><div class="chart-bar" style="--height:88%"></div><span>Sat</span></div>
                    <div class="chart-column"><div class="chart-bar" style="--height:58%"></div><span>Sun</span></div>
                </div>
                <div class="chart-legend">
                    <span><i></i> Resource views</span>
                    <span><i></i> Previous week</span>
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-head">
                <div>
                    <h2>Recent uploads</h2>
                    <p>Latest additions to the library</p>
                </div>
                <a href="{{ route('admin.materials.index') }}">See all</a>
            </div>
            <div class="panel-body">
                @if ($recentUploads->isEmpty())
                    <div class="empty-state" style="padding:32px 16px;border:0;background:var(--ntc-pale)">
                        <div class="empty-icon"><svg class="icon"><use href="#icon-upload"></use></svg></div>
                        <h3>No uploads yet</h3>
                        <p>Add the first learning resource to get the library started.</p>
                        <a href="{{ route('admin.materials.create') }}" class="btn btn-gold btn-sm">Upload material</a>
                    </div>
                @else
                    <div class="activity-list">
                        @foreach ($recentUploads as $material)
                            <div class="activity-item">
                                <div class="activity-icon {{ $material->type === 'video' ? 'gold' : ($material->type === 'image' ? 'green' : '') }}">
                                    <svg class="icon">
                                        <use href="#icon-{{ match ($material->type) { 'video' => 'video', 'image' => 'image', 'presentation' => 'presentation', default => 'file' } }}"></use>
                                    </svg>
                                </div>
                                <div class="activity-info">
                                    <strong>{{ $material->title }}</strong>
                                    <span>{{ $material->department }} · {{ ucfirst($material->type) }}</span>
                                </div>
                                <span class="activity-meta">{{ $material->created_at->diffForHumans(null, true) }} ago</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>

    <div class="dashboard-grid">
        <section class="panel">
            <div class="panel-head">
                <div>
                    <h2>Recently joined students</h2>
                    <p>The newest accounts on the campus</p>
                </div>
                <a href="{{ route('admin.students.index') }}">Manage students</a>
            </div>
            <div class="table-wrap">
                @if ($recentStudents->isEmpty())
                    <div class="empty-state" style="margin:16px;border:0;background:var(--ntc-pale)">
                        <p>No student accounts have been created yet.</p>
                    </div>
                @else
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Department</th>
                                <th>Joined</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentStudents as $student)
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
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('admin.students.edit', $student) }}" class="icon-btn" aria-label="Edit {{ $student->name }}">
                                                <svg class="icon"><use href="#icon-edit"></use></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        <div style="display:flex;flex-direction:column;gap:20px">
            <section class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Quick actions</h2>
                        <p>Shortcuts for daily tasks</p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="quick-grid">
                        <a href="{{ route('admin.materials.create') }}" class="quick-link">
                            <svg class="icon"><use href="#icon-upload"></use></svg>
                            Upload resource
                        </a>
                        <a href="{{ route('admin.students.index') }}" class="quick-link">
                            <svg class="icon"><use href="#icon-search"></use></svg>
                            Find a student
                        </a>
                        <a href="{{ route('admin.materials.index') }}" class="quick-link">
                            <svg class="icon"><use href="#icon-library"></use></svg>
                            Browse library
                        </a>
                        <a href="{{ route('profile.edit') }}" class="quick-link">
                            <svg class="icon"><use href="#icon-settings"></use></svg>
                            Account settings
                        </a>
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Students by department</h2>
                        <p>{{ number_format($totalStudents) }} students in total</p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="dept-summary">
                        @foreach ($departments as $code => $label)
                            @php
                                $count = $departmentCounts[$code] ?? 0;
                                $percent = $totalStudents > 0 ? round(($count / $totalStudents) * 100) : 0;
                            @endphp
                            <div class="dept-summary-row">
                                <span class="avatar" style="background:var(--ntc-pale);border-radius:10px">{{ $code }}</span>
                                <div class="dept-summary-info">
                                    <strong>{{ $label }} Department <span>{{ $percent }}%</span></strong>
                                    <div class="progress"><span style="--value:{{ $percent }}%"></span></div>
                                </div>
                                <span class="dept-summary-count">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
