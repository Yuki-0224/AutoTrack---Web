<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
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

       
    </main>

    <footer class="page-footer">
        AutoTrack • Web-based car rental, reservation, and vehicle monitoring system.
    </footer>
    <script src="<?= base_url() ?>public/script/script.js"></script>
</body>
</html>
