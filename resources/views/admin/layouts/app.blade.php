<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('shared.head', ['title' => trim($__env->yieldContent('title', 'Dashboard')).' | Namitembo Admin'])
</head>
<body class="admin-page">
    @include('shared.icons')

    <div class="app-shell">
        <div class="mobile-overlay" data-sidebar-overlay></div>

        <aside class="sidebar" data-sidebar aria-label="Admin navigation">
            <a href="{{ route('admin.dashboard') }}" class="ntc-brand">
                <img src="{{ asset('images/namitembo-logo.svg') }}" alt="">
                <span class="ntc-brand-name">
                    <strong>Namitembo</strong>
                    <span>Admin workspace</span>
                </span>
            </a>

            <p class="sidebar-label">Workspace</p>
            <nav class="side-nav">
                <a href="{{ route('admin.dashboard') }}" class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="icon"><use href="#icon-grid"></use></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.students.index') }}" class="side-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <svg class="icon"><use href="#icon-users"></use></svg>
                    Students
                    @isset($studentCount)
                        <span class="side-link-count">{{ $studentCount }}</span>
                    @endisset
                </a>
                <a href="{{ route('admin.materials.index') }}" class="side-link {{ request()->routeIs('admin.materials.index') ? 'active' : '' }}">
                    <svg class="icon"><use href="#icon-library"></use></svg>
                    Resource library
                </a>
                <a href="{{ route('admin.materials.create') }}" class="side-link {{ request()->routeIs('admin.materials.create') ? 'active' : '' }}">
                    <svg class="icon"><use href="#icon-upload"></use></svg>
                    Upload material
                </a>
            </nav>

            <p class="sidebar-label" style="margin-top:26px">Account</p>
            <nav class="side-nav">
                <a href="{{ route('profile.edit') }}" class="side-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <svg class="icon"><use href="#icon-user"></use></svg>
                    My profile
                </a>
                <a href="{{ url('/') }}" class="side-link">
                    <svg class="icon"><use href="#icon-external"></use></svg>
                    View website
                </a>
            </nav>

            <div class="sidebar-spacer"></div>

            <div class="sidebar-note">
                <svg class="icon"><use href="#icon-sparkle"></use></svg>
                <strong>Keep the library growing</strong>
                <p>Add fresh notes, videos and presentations for your students.</p>
                <a href="{{ route('admin.materials.create') }}">
                    Upload a resource
                    <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg>
                </a>
            </div>

            <div class="sidebar-user">
                @include('shared.avatar', ['user' => auth()->user()])
                <div class="sidebar-user-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>{{ ucfirst(auth()->user()->role) }} · {{ auth()->user()->department }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="icon-btn" aria-label="Log out" title="Log out" style="width:32px;height:32px">
                        <svg class="icon icon-sm"><use href="#icon-logout"></use></svg>
                    </button>
                </form>
            </div>
        </aside>

        <div class="app-main">
            <header class="topbar">
                <button type="button" class="icon-btn menu-toggle" data-sidebar-toggle aria-label="Open navigation" aria-expanded="false">
                    <svg class="icon"><use href="#icon-menu"></use></svg>
                </button>

                <div class="topbar-context">
                    <span>@yield('page-kicker', 'Administration')</span>
                    <strong>@yield('page-title', 'Dashboard')</strong>
                </div>

                <div class="topbar-tools">
                    <form action="{{ route('admin.students.index') }}" method="GET" class="topbar-search" role="search">
                        <svg class="icon icon-sm"><use href="#icon-search"></use></svg>
                        <input type="search" name="search" placeholder="Search students..." value="{{ request()->routeIs('admin.students.index') ? request('search') : '' }}" aria-label="Search students">
                    </form>

                    <div class="dropdown" data-dropdown>
                        <button type="button" class="icon-btn notification-button" data-dropdown-trigger aria-label="Notifications" aria-expanded="false">
                            <svg class="icon"><use href="#icon-bell"></use></svg>
                            <span class="notification-dot"></span>
                        </button>
                        <div class="dropdown-menu" style="min-width:270px">
                            <div style="padding:10px 11px 8px">
                                <strong style="display:block;font-size:11px;color:var(--ntc-navy)">Notifications</strong>
                                <span style="font-size:9px;color:var(--ntc-slate)">Recent campus activity</span>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.materials.index') }}">
                                <svg class="icon icon-sm"><use href="#icon-upload"></use></svg>
                                New learning resources are in the library
                            </a>
                            <a href="{{ route('admin.students.index') }}">
                                <svg class="icon icon-sm"><use href="#icon-users"></use></svg>
                                Review student accounts
                            </a>
                        </div>
                    </div>

                    <div class="dropdown" data-dropdown>
                        <button type="button" class="profile-trigger" data-dropdown-trigger aria-expanded="false">
                            @include('shared.avatar', ['user' => auth()->user()])
                            <span class="profile-trigger-info">
                                <strong>{{ auth()->user()->name }}</strong>
                                <span>Administrator</span>
                            </span>
                            <svg class="icon"><use href="#icon-chevron-down"></use></svg>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('profile.edit') }}">
                                <svg class="icon icon-sm"><use href="#icon-user"></use></svg>
                                My profile
                            </a>
                            <a href="{{ route('admin.dashboard') }}">
                                <svg class="icon icon-sm"><use href="#icon-grid"></use></svg>
                                Admin dashboard
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">
                                    <svg class="icon icon-sm"><use href="#icon-logout"></use></svg>
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="page-content">
                @include('shared.flash')
                @yield('content')
            </main>
        </div>
    </div>

    @include('shared.material-preview-modal')
    <script src="{{ asset('assets/js/custom.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
