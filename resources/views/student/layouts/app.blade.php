<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('shared.head', ['title' => trim($__env->yieldContent('title', 'Dashboard')).' | Namitembo Student'])
</head>
<body class="student-page">
    @include('shared.icons')

    <div class="app-shell">
        <div class="mobile-overlay" data-sidebar-overlay></div>

        <aside class="sidebar" data-sidebar aria-label="Student navigation">
            <a href="{{ route('student.dashboard') }}" class="ntc-brand">
                <img src="{{ asset('images/namitembo-logo.svg') }}" alt="">
                <span class="ntc-brand-name">
                    <strong>Namitembo</strong>
                    <span>Student portal</span>
                </span>
            </a>

            <p class="sidebar-label">Learning</p>
            <nav class="side-nav">
                <a href="{{ route('student.dashboard') }}" class="side-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <svg class="icon"><use href="#icon-grid"></use></svg>
                    Dashboard
                </a>
                <a href="{{ route('student.library.index') }}" class="side-link {{ request()->routeIs('student.library.*') ? 'active' : '' }}">
                    <svg class="icon"><use href="#icon-library"></use></svg>
                    My library
                </a>
                <a href="{{ route('student.profile') }}" class="side-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <svg class="icon"><use href="#icon-user"></use></svg>
                    My profile
                </a>
            </nav>

            <p class="sidebar-label" style="margin-top:26px">Quick find</p>
            <nav class="side-nav">
                <a href="{{ route('student.library.index', ['type' => 'pdf']) }}" class="side-link">
                    <svg class="icon"><use href="#icon-file"></use></svg>
                    PDF documents
                </a>
                <a href="{{ route('student.library.index', ['type' => 'video']) }}" class="side-link">
                    <svg class="icon"><use href="#icon-video"></use></svg>
                    Video lessons
                </a>
                <a href="{{ route('student.library.index', ['type' => 'presentation']) }}" class="side-link">
                    <svg class="icon"><use href="#icon-presentation"></use></svg>
                    Presentations
                </a>
            </nav>

            <div class="sidebar-spacer"></div>

            <div class="sidebar-note">
                <svg class="icon"><use href="#icon-graduation"></use></svg>
                <strong>{{ auth()->user()->department }} Department</strong>
                <p>Your library is tailored to the resources for your course.</p>
                <a href="{{ route('student.library.index') }}">
                    Open my library
                    <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg>
                </a>
            </div>

            <div class="sidebar-user">
                @include('shared.avatar', ['user' => auth()->user()])
                <div class="sidebar-user-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>Student · {{ auth()->user()->department }}</span>
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
                    <span>@yield('page-kicker', 'Student portal')</span>
                    <strong>@yield('page-title', 'Dashboard')</strong>
                </div>

                <div class="topbar-tools">
                    <form action="{{ route('student.library.index') }}" method="GET" class="topbar-search" role="search">
                        <svg class="icon icon-sm"><use href="#icon-search"></use></svg>
                        <input type="search" name="search" placeholder="Search your library..." value="{{ request()->routeIs('student.library.index') ? request('search') : '' }}" aria-label="Search your library">
                    </form>

                    <div class="dropdown" data-dropdown>
                        <button type="button" class="icon-btn notification-button" data-dropdown-trigger aria-label="Notifications" aria-expanded="false">
                            <svg class="icon"><use href="#icon-bell"></use></svg>
                            <span class="notification-dot"></span>
                        </button>
                        <div class="dropdown-menu" style="min-width:270px">
                            <div style="padding:10px 11px 8px">
                                <strong style="display:block;font-size:11px;color:var(--ntc-navy)">Notifications</strong>
                                <span style="font-size:9px;color:var(--ntc-slate)">What's new for you</span>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('student.library.index') }}">
                                <svg class="icon icon-sm"><use href="#icon-library"></use></svg>
                                New resources in your library
                            </a>
                            <a href="{{ route('student.profile') }}">
                                <svg class="icon icon-sm"><use href="#icon-user"></use></svg>
                                Keep your profile up to date
                            </a>
                        </div>
                    </div>

                    <div class="dropdown" data-dropdown>
                        <button type="button" class="profile-trigger" data-dropdown-trigger aria-expanded="false">
                            @include('shared.avatar', ['user' => auth()->user()])
                            <span class="profile-trigger-info">
                                <strong>{{ auth()->user()->name }}</strong>
                                <span>Student</span>
                            </span>
                            <svg class="icon"><use href="#icon-chevron-down"></use></svg>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('student.profile') }}">
                                <svg class="icon icon-sm"><use href="#icon-user"></use></svg>
                                My profile
                            </a>
                            <a href="{{ route('student.library.index') }}">
                                <svg class="icon icon-sm"><use href="#icon-library"></use></svg>
                                My library
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
