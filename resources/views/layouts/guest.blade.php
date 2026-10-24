<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('shared.head', ['title' => request()->routeIs('register') ? 'Create account | Namitembo Technical College' : 'Log in | Namitembo Technical College'])
</head>
<body class="auth-page">
    @include('shared.icons')

    <header class="auth-header">
        <a href="{{ url('/') }}" class="ntc-brand" aria-label="Namitembo Technical College home">
            <img src="{{ asset('images/namitembo-logo.svg') }}" alt="">
            <span class="ntc-brand-name">
                <strong>Namitembo</strong>
                <span>Technical College</span>
            </span>
        </a>
        <a href="{{ url('/') }}" class="auth-back">
            <svg class="icon icon-sm"><use href="#icon-arrow-left"></use></svg>
            <span>Back to home</span>
        </a>
    </header>

    <main class="auth-main">
        <div class="auth-shell">
            <aside class="auth-story">
                <div class="auth-story-logo">
                    <img src="{{ asset('images/namitembo-logo.svg') }}" alt="">
                    <span>NTC Digital Campus</span>
                </div>

                <div class="auth-story-copy">
                    @if (request()->routeIs('register'))
                        <h2>Begin your journey at Namitembo.</h2>
                        <p>Create your account to join a connected learning community built around your department and your course.</p>
                    @else
                        <h2>Your campus, always within reach.</h2>
                        <p>Pick up where you left off. Your resources, your department and your progress are waiting in one secure place.</p>
                    @endif

                    <div class="auth-story-points">
                        <div class="auth-story-point">
                            <span><svg class="icon"><use href="#icon-check"></use></svg></span>
                            Department-specific resources
                        </div>
                        <div class="auth-story-point">
                            <span><svg class="icon"><use href="#icon-check"></use></svg></span>
                            Secure student and staff accounts
                        </div>
                        <div class="auth-story-point">
                            <span><svg class="icon"><use href="#icon-check"></use></svg></span>
                            Access from any device
                        </div>
                    </div>
                </div>

                <div class="auth-story-footer">Namitembo Technical College · Malawi</div>
            </aside>

            <section class="auth-form-wrap">
                {{ $slot }}
            </section>
        </div>
    </main>

    <div class="auth-page-footer">
        &copy; <span data-current-year>2026</span> Namitembo Technical College. All rights reserved.
    </div>

    <script src="{{ asset('assets/js/custom.js') }}" defer></script>
</body>
</html>
