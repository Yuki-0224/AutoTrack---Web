<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
</head>
<body class="hero-bg page-body">
    <header class="page-header">
        <a href="<?= url('') ?>" class="brand-link">AutoTrack</a>
        <div class="header-actions">
            <button id="theme-toggle" type="button" class="theme-toggle">
                <span id="theme-toggle-label">Light</span>
                <span aria-hidden="true" class="theme-toggle-track">
                    <span class="theme-toggle-thumb"></span>
                </span>
            </button>
            <nav class="header-nav">
                <a href="<?= url('') ?>" class="header-link">Home</a>
                <a href="<?= url('register') ?>" class="header-link">Register</a>
                <a href="<?= url('login') ?>" class="hero-button-secondary">Login</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero-section">
            <div class="hero-container">
                <div class="hero-grid hero-grid--landing">
                    <div class="stack-xlarge">
                        <div class="hero-pill">The Best Choice</div>
                        <div class="stack-medium">
                            <h1 class="hero-heading text-5xl font-semibold sm:text-6xl">Rent A Car <strong>NOW!</strong></h1>
                            <p class="hero-copy text-lg">AutoTrack is a web-based car rental, reservation, and vehicle monitoring system that helps you manage bookings, rentals, and fleet status from one dashboard.</p>
                        </div>
                        <div class="hero-cta-group">
                            <a href="<?= url('register') ?>" class="hero-button-primary">Book Now</a>
                            <a href="<?= url('login') ?>" class="hero-button-secondary">Login</a>
                        </div>
                        <div class="hero-stat-grid">
                            <div class="stat-card">
                                <span class="feature-tag">Discount</span>
                                <strong>Up to 50% off</strong>
                                <p>Save more on selected rentals.</p>
                            </div>
                            <div class="stat-card">
                                <span class="feature-tag">Reserve</span>
                                <strong>Quick booking</strong>
                                <p>Reserve cars in just a few clicks.</p>
                            </div>
                            <div class="stat-card">
                                <span class="feature-tag">Monitor</span>
                                <strong>Fleet status</strong>
                                <p>Track availability instantly.</p>
                            </div>
                        </div>
                    </div>

                    <div class="hero-visual">
                        <div class="hero-card hero-card-landing hero-visual-card">
                            <div class="flex items-center justify-between">
                                <div class="text-sm uppercase tracking-[0.35em] text-slate-500">Luxury Car</div>
                                <div class="text-sm font-semibold text-orange-300">Discount</div>
                            </div>
                            <div class="car-frame mt-8">
                                <div class="car-mock">
                                    <div class="car-silhouette"></div>
                                </div>
                            </div>
                            <div class="mt-8 flex items-center justify-between gap-4">
                                <div>
                                    <div class="text-sm text-slate-500">Price from</div>
                                    <div class="text-3xl font-semibold text-slate-950">$125<span class="ml-2 text-sm text-slate-500">/day</span></div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="car-wheel relative"></div>
                                    <div class="car-wheel relative"></div>
                                </div>
                            </div>
                        </div>
                        <div class="hero-visual-glow-left"></div>
                        <div class="hero-visual-glow-right"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="feature-section">
            <div class="hero-container">
                <div class="feature-grid">
                <article class="stat-card">
                    <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Rental management</p>
                    <h2 class="mt-4 text-2xl font-semibold text-slate-950">Car hire operations</h2>
                    <p class="text-muted">Organize your rental fleet and manage pricing with a clean, easy workflow.</p>
                </article>
                <article class="stat-card">
                    <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Reservation</p>
                    <h2 class="mt-4 text-2xl font-semibold text-slate-950">Fast bookings</h2>
                    <p class="text-muted">Keep reservations on schedule and provide customers with a smooth booking experience.</p>
                </article>
                <article class="stat-card">
                    <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Vehicle monitoring</p>
                    <h2 class="mt-4 text-2xl font-semibold text-slate-950">Fleet overview</h2>
                    <p class="text-muted">See vehicle availability, usage, and status in one responsive dashboard.</p>
                </article>
            </div>
        </section>
    </main>

    <footer class="page-footer">
        AutoTrack • Web-based car rental, reservation, and vehicle monitoring system.
    </footer>

    <script src="<?= base_url() ?>public/script/script.js"></script>
</body>
</html>
