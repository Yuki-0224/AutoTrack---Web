<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>
<body class="hero-bg-auth auth-body">
    <header class="page-header">
        <a href="<?= url('') ?>" class="brand-link">AutoTrack</a>
        <nav class="header-nav">
            <a href="<?= url('') ?>" class="header-link">Home</a>
            <a href="<?= url('logout') ?>" class="hero-button-secondary">Logout</a>
        </nav>
    </header>

    <main class="auth-main">
        <section class="auth-section hero-card">
            <div class="auth-card">
                <div class="auth-glow-left"></div>
                <div class="hero-grid hero-grid--dashboard">
                    <div class="stack-large">
                        <span class="hero-pill">Dashboard</span>
                        <h1 class="hero-heading text-4xl font-semibold sm:text-5xl">Welcome back, <?= esc($_SESSION['user']['name'] ?? 'Driver') ?></h1>
                        <p class="hero-copy max-w-2xl text-lg">Your AutoTrack session is active. Continue managing rentals, reservations, and fleet status from one secure dashboard.</p>
                    </div>
                    <div class="glass-panel auth-panel">
                        <p class="text-sm uppercase tracking-[0.35em] text-orange-300">Session status</p>
                        <p class="mt-4 text-3xl font-semibold text-slate-950">Active</p>
                        
                    </div>
                </div>
            </div>
        </section>

        <section class="hero-card mt-10 px-8 py-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10">
                <div class="max-w-xl car-type">
                    <h1 class="hero-heading text-5xl font-semibold sm:text-4xl">Car Types</h1>
                    <p class="hero-copy w-50 text-lg"> Browse our wide selection of rental cars, including compact cars, vans, and SUVs—perfect for any trip and budget.</p>
                </div>
                <div class="swiper lg:w-2/3 w-full pb-12">
                    <div class="swiper-wrapper">
                        <div class="card-list swiper-slide">
                            <div class="card-item bg-white">
                                <img src="images/universal.png" class="car-image">
                                <p class="text-sm font-medium text-slate-700">Universal</p>
                            </div>
                        </div>
                        <div class="card-list swiper-slide">
                            <div class="card-item bg-white">
                                <img src="images/sedan.png" class="car-image">
                                <p class="text-sm font-medium text-slate-700">Sedan</p>
                            </div>
                        </div>
                        <div class="card-list swiper-slide">
                            <div class="card-item bg-white">
                                <img src="images/crossover.png" class="car-image">
                                <p class="text-sm font-medium text-slate-700">Crossover</p>
                            </div>
                        </div>
                        <div class="card-list swiper-slide">
                            <div class="card-item bg-white">
                                <img src="images/pickup.png" class="car-image">
                                <p class="text-sm font-medium text-slate-700">Pickup</p>
                            </div>
                        </div>
                        <div class="card-list swiper-slide ">
                            <div class="card-item bg-white">
                                <img src="images/van.png" class="car-image h-10">
                                <p class="text-sm font-medium text-slate-700 mt-1">Van</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-pagination mt-6"></div>
                </div>
            </div>
        </section>

        <section class="stats-grid">
            <article class="stat-card" onclick="openReservation()">
                <span class="feature-tag">Reservation</span>
                <strong>Booking overview</strong>
                <p>Review current bookings and confirm upcoming pickup schedules.</p>
            </article>
            <article class="stat-card">
                <span class="feature-tag">Fleet</span>
                <strong>Vehicle monitoring</strong>
                <p>See the latest status for your active cars and available units.</p>
            </article>
            <article class="stat-card">
                <span class="feature-tag">Support</span>
                <strong>Account control</strong>
                <p>Use the navigation above to return home or log out securely.</p>
            </article>
        </section>
    </main>

    <footer class="page-footer">
        AutoTrack • Web-based car rental, reservation, and vehicle monitoring system.
    </footer>

    <script src="<?= base_url() ?>public/script/script.js"></script>


    <script>
        function openReservation() {
            window.location.href = "<?= url('Reservation') ?>";
        }
    </script>

   <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
</script>
</body>
</html>
