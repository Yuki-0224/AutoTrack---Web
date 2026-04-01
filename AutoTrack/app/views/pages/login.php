<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
</head>
<body class="hero-bg-auth auth-body">
    <header class="page-header">
        <a href="<?= url('') ?>" class="brand-link">AutoTrack</a>
        <nav class="header-nav">
            <a href="<?= url('') ?>" class="header-link">Home</a>
            <a href="<?= url('register') ?>" class="hero-button-secondary">Register</a>
        </nav>
    </header>

    <main class="auth-main">
        <section class="auth-section hero-card">
            <div class="auth-card">
                <div class="auth-glow-right"></div>
                <div class="auth-grid">
                    <div class="stack-large">
                        <span class="hero-pill">Secure login</span>
                        <h1 class="hero-heading text-4xl font-semibold sm:text-5xl">Access your AutoTrack account</h1>
                        <p class="hero-copy max-w-xl text-lg">Log in securely to manage reservations, monitor vehicles, and control your fleet from a polished dashboard.</p>
                    </div>

                    <div class="glass-panel auth-panel">
                        <?php if ($error = get_flash('error')): ?>
                            <div class="mb-6 rounded-2xl border border-red-500/20 bg-red-500/10 px-5 py-4 text-red-100">
                                <?= esc($error) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($message = get_flash('success')): ?>
                            <div class="mb-6 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-emerald-100">
                                <?= esc($message) ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= url('login') ?>" method="post" class="form-stack">
                            <?= csrf_field() ?>
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                                <input id="email" name="email" type="email" required class="input-field" placeholder="name@example.com" />
                            </div>

                            <div class="space-y-2">
                                <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                                <input id="password" name="password" type="password" required class="input-field" placeholder="********" />
                            </div>

                            <button type="submit" class="hero-button-primary full-width">Sign In</button>
                        </form>

                        <p class="form-footer">New to AutoTrack? <a href="<?= url('register') ?>">Create an account</a></p>
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
