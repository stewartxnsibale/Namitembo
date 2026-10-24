<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('shared.head', ['title' => 'Namitembo Technical College | Digital Campus'])
    <meta name="description" content="The Namitembo Technical College digital campus. A secure library and management system for students, lecturers and administrators.">
</head>
<body class="landing-page">
    @include('shared.icons')

    <header class="site-header">
        <div class="landing-container">
            <nav class="site-nav" aria-label="Main navigation">
                <a href="{{ url('/') }}" class="ntc-brand" aria-label="Namitembo Technical College home">
                    <img src="{{ asset('images/namitembo-logo.png') }}" alt="Namitembo Technical College">
                    <span class="ntc-brand-name">
                        <strong>Namitembo</strong>
                        <span>Technical College</span>
                    </span>
                </a>

                <div class="site-links" data-site-links>
                    <a href="#home" class="active">Home</a>
                    <a href="#features">Platform</a>
                    <a href="#departments">Departments</a>
                    <a href="#how-it-works">How it works</a>
                    <a href="#contact">Contact</a>
                </div>

                <div class="site-actions">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-navy btn-sm">
                            Open dashboard
                            <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Log in</a>
                        <a href="{{ route('register') }}" class="btn btn-gold btn-sm">Get started</a>
                    @endauth
                    <button type="button" class="icon-btn nav-toggle" data-nav-toggle aria-label="Open navigation" aria-expanded="false">
                        <svg class="icon"><use href="#icon-menu"></use></svg>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <main id="home">
        <section class="hero">
            <div class="landing-container">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <span class="eyebrow">Knowledge. Skills. Opportunity.</span>
                        <h1>A smarter campus starts with <em>one shared space.</em></h1>
                        <p>The digital home of Namitembo Technical College. Students discover course resources, lecturers share knowledge, and administrators keep every department moving.</p>

                        <div class="hero-actions">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-gold btn-lg">
                                    Go to your dashboard
                                    <svg class="icon"><use href="#icon-arrow-right"></use></svg>
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-gold btn-lg">
                                    Create your account
                                    <svg class="icon"><use href="#icon-arrow-right"></use></svg>
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline btn-lg">
                                    <svg class="icon"><use href="#icon-lock"></use></svg>
                                    Log in to the portal
                                </a>
                            @endauth
                        </div>

                        <div class="hero-stats">
                            <div class="hero-stat">
                                <strong>05</strong>
                                <span>Departments</span>
                            </div>
                            <div class="hero-stat">
                                <strong>24/7</strong>
                                <span>Resource access</span>
                            </div>
                            <div class="hero-stat">
                                <strong>100%</strong>
                                <span>College focused</span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-visual" aria-hidden="true">
                        <div class="hero-glow"></div>
                        <div class="hero-dashboard">
                            <div class="dash-top">
                                <div class="dash-brand">
                                    <img src="{{ asset('images/namitembo-logo.png') }}" alt="Namitembo Technical College">
                                    NTC Digital Campus
                                </div>
                                <div class="dash-dots"><span></span><span></span><span></span></div>
                            </div>
                            <div class="dash-body">
                                <div class="dash-sidebar">
                                    <span class="active"><svg class="icon"><use href="#icon-grid"></use></svg></span>
                                    <span><svg class="icon"><use href="#icon-library"></use></svg></span>
                                    <span><svg class="icon"><use href="#icon-users"></use></svg></span>
                                    <span><svg class="icon"><use href="#icon-chart"></use></svg></span>
                                </div>
                                <div class="dash-main">
                                    <div class="dash-greeting">
                                        <span>Student portal</span>
                                        <h3>Welcome back, Chisomo.</h3>
                                    </div>
                                    <div class="dash-kpis">
                                        <div class="dash-kpi">
                                            <svg class="icon"><use href="#icon-book"></use></svg>
                                            <strong>42</strong>
                                            <span>Resources</span>
                                        </div>
                                        <div class="dash-kpi">
                                            <svg class="icon"><use href="#icon-video"></use></svg>
                                            <strong>12</strong>
                                            <span>Videos</span>
                                        </div>
                                        <div class="dash-kpi">
                                            <svg class="icon"><use href="#icon-clock"></use></svg>
                                            <strong>06</strong>
                                            <span>New this week</span>
                                        </div>
                                    </div>
                                    <div class="dash-panel">
                                        <div class="dash-panel-head"><span>Library activity</span><span>This week</span></div>
                                        <div class="dash-chart">
                                            <span style="--bar:42%"></span>
                                            <span style="--bar:68%"></span>
                                            <span style="--bar:52%"></span>
                                            <span style="--bar:86%"></span>
                                            <span style="--bar:61%"></span>
                                            <span style="--bar:74%"></span>
                                        </div>
                                    </div>
                                    <div class="dash-panel">
                                        <div class="dash-panel-head"><span>Recently added</span><span>View all</span></div>
                                        <div class="dash-list-row">
                                            <div class="dash-list-icon"><svg class="icon"><use href="#icon-file"></use></svg></div>
                                            <div><b>ICT Module 04 — Networking</b><small>PDF document</small></div>
                                        </div>
                                        <div class="dash-list-row">
                                            <div class="dash-list-icon"><svg class="icon"><use href="#icon-video"></use></svg></div>
                                            <div><b>Practical skills demonstration</b><small>Video lesson</small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hero-float hero-float-one">
                            <div class="float-icon gold"><svg class="icon"><use href="#icon-upload"></use></svg></div>
                            <div>
                                <strong>New resource uploaded</strong>
                                <span>ICT Department · 2 min ago</span>
                            </div>
                        </div>
                        <div class="hero-float hero-float-two">
                            <div class="float-icon"><svg class="icon"><use href="#icon-shield"></use></svg></div>
                            <div>
                                <strong>Secure, role-based access</strong>
                                <span>Students and staff, connected</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="logo-strip">
            <div class="landing-container">
                <div class="logo-strip-inner">
                    <span class="logo-strip-label">Built around every department</span>
                    <div class="logo-strip-items">
                        <span class="logo-strip-item">ICT</span>
                        <span class="logo-strip-item">FBW</span>
                        <span class="logo-strip-item">CJ</span>
                        <span class="logo-strip-item">TFD</span>
                        <span class="logo-strip-item">BL</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="landing-section alt" id="features">
            <div class="landing-container">
                <div class="section-heading">
                    <span class="eyebrow">One campus, one platform</span>
                    <h2>Everything the college needs, thoughtfully connected.</h2>
                    <p>From the first login to the final download, the Namitembo digital campus keeps learning organised, accessible and secure.</p>
                </div>

                <div class="feature-grid">
                    <article class="feature-card">
                        <div class="feature-icon"><svg class="icon icon-lg"><use href="#icon-library"></use></svg></div>
                        <h3>A focused e-library</h3>
                        <p>Course notes, presentations, videos and reference material grouped by department and easy to find.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon"><svg class="icon icon-lg"><use href="#icon-users"></use></svg></div>
                        <h3>Student management</h3>
                        <p>Administrators can search, review and update student accounts from one clear, responsive workspace.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon"><svg class="icon icon-lg"><use href="#icon-chart"></use></svg></div>
                        <h3>Useful insight</h3>
                        <p>See library activity, department totals and recent uploads at a glance so nothing important is missed.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon"><svg class="icon icon-lg"><use href="#icon-shield"></use></svg></div>
                        <h3>Access you can trust</h3>
                        <p>Students only see resources for their department, while staff get the tools they need to manage the college.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing-section" id="departments">
            <div class="landing-container">
                <div class="section-heading left">
                    <span class="eyebrow">Made for your course</span>
                    <h2>Every department has a home here.</h2>
                    <p>Each department gets its own resource collection, so students always land in the right place.</p>
                </div>

                <div class="departments-grid">
                    <article class="dept-card">
                        <div class="dept-icon"><svg class="icon icon-lg"><use href="#icon-grid"></use></svg></div>
                        <h3>ICT Department</h3>
                        <p>Digital skills, networking, software and technical practice resources.</p>
                        <span class="dept-link">Explore resources <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg></span>
                    </article>
                    <article class="dept-card">
                        <div class="dept-icon"><svg class="icon icon-lg"><use href="#icon-sparkle"></use></svg></div>
                        <h3>FBW Department</h3>
                        <p>Practical guides, class notes and creative learning material.</p>
                        <span class="dept-link">Explore resources <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg></span>
                    </article>
                    <article class="dept-card">
                        <div class="dept-icon"><svg class="icon icon-lg"><use href="#icon-presentation"></use></svg></div>
                        <h3>CJ Department</h3>
                        <p>Presentations, coursework and media-rich study resources.</p>
                        <span class="dept-link">Explore resources <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg></span>
                    </article>
                    <article class="dept-card">
                        <div class="dept-icon"><svg class="icon icon-lg"><use href="#icon-folder"></use></svg></div>
                        <h3>TFD Department</h3>
                        <p>Technical files, design references and step-by-step practicals.</p>
                        <span class="dept-link">Explore resources <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg></span>
                    </article>
                    <article class="dept-card">
                        <div class="dept-icon"><svg class="icon icon-lg"><use href="#icon-building"></use></svg></div>
                        <h3>BL Department</h3>
                        <p>Business notes, leadership material and shared case studies.</p>
                        <span class="dept-link">Explore resources <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg></span>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing-section alt" id="how-it-works">
            <div class="landing-container">
                <div class="section-heading">
                    <span class="eyebrow">Simple from day one</span>
                    <h2>Your campus, three steps away.</h2>
                    <p>No complicated setup. Create an account, choose your department and start learning.</p>
                </div>

                <div class="how-grid">
                    <article class="how-card">
                        <div class="how-number">1</div>
                        <h3>Create your account</h3>
                        <p>Register with your college details and select your department. Administrators can also set up student accounts.</p>
                    </article>
                    <article class="how-card">
                        <div class="how-number">2</div>
                        <h3>Open your library</h3>
                        <p>Your dashboard brings together the resources that matter to your course, all in one organised space.</p>
                    </article>
                    <article class="how-card">
                        <div class="how-number">3</div>
                        <h3>Learn and share</h3>
                        <p>Preview, download and revisit materials whenever you need them. Staff can upload new resources in seconds.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing-section" id="contact">
            <div class="landing-container">
                <div class="cta-panel">
                    <div>
                        <span class="eyebrow" style="color:var(--ntc-gold)">Ready when you are</span>
                        <h2>Your next lesson is already waiting.</h2>
                        <p>Join the Namitembo Technical College digital campus and keep your learning moving, wherever you are.</p>
                    </div>
                    <div class="cta-actions">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-gold btn-lg">Open dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-gold btn-lg">Create your account</a>
                            <a href="{{ route('login') }}" class="btn btn-outline btn-lg" style="color:var(--ntc-white);background:transparent;border-color:rgba(255,255,255,.24)">Log in</a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="landing-container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="{{ url('/') }}" class="ntc-brand">
                        <img src="{{ asset('images/namitembo-logo.png') }}" alt="Namitembo Technical College">
                        <span class="ntc-brand-name">
                            <strong>Namitembo</strong>
                            <span>Technical College</span>
                        </span>
                    </a>
                    <p>A shared digital campus for learning, teaching and college administration. Built to keep knowledge within reach.</p>
                </div>
                <div class="footer-col">
                    <h4>Platform</h4>
                    <a href="#features">Features</a>
                    <a href="#departments">Departments</a>
                    <a href="#how-it-works">How it works</a>
                    <a href="{{ route('login') }}">Portal login</a>
                </div>
                <div class="footer-col">
                    <h4>Departments</h4>
                    <span>ICT</span>
                    <span>FBW</span>
                    <span>CJ</span>
                    <span>TFD</span>
                    <span>BL</span>
                </div>
                <div class="footer-col">
                    <h4>Visit us</h4>
                    <span>Namitembo Technical College</span>
                    <span>Malawi</span>
                    <a href="mailto:info@namitembo.ac.mw">info@namitembo.ac.mw</a>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; <span data-current-year>2026</span> Namitembo Technical College. All rights reserved.</span>
                <span>Designed for a connected campus.</span>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/custom.js') }}" defer></script>
</body>
</html>
