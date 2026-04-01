<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
</head>
<body class="hero-bg-auth auth-body">
    <header class="page-header">
        <a href="<?= url('') ?>" class="brand-link">AutoTrack</a>
        <nav class="header-nav">
            <a href="<?= url('') ?>" class="header-link">Home</a>
            <a href="<?= url('login') ?>" class="hero-button-secondary">Login</a>
        </nav>
    </header>

    <main class="auth-main">
        <section class="auth-section hero-card">
            <div class="auth-card">
                <div class="auth-glow-left"></div>
                <div class="auth-grid">
                    <div class="stack-large">
                        <span class="hero-pill">Start now</span>
                        <h1 class="hero-heading text-4xl font-semibold sm:text-5xl">Create your AutoTrack account</h1>
                        <p class="hero-copy max-w-xl text-lg">Register to begin managing car rentals, reservations, and vehicle monitoring with one modern system.</p>
                    </div>

                    <div class="glass-panel auth-panel">
                        <?php if ($error = get_flash('error')): ?>
                            <div class="mb-6 rounded-2xl border border-red-500/20 bg-red-500/10 px-5 py-4 text-red-100">
                                <?= esc($error) ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= url('register') ?>" method="post" class="form-stack">
                            <?= csrf_field() ?>
                            <div class="space-y-2">
                            <label for="name" class="text-sm font-medium text-slate-700">Full Name</label>
                                <input id="name" name="name" type="text" required class="input-field" placeholder="Jane Doe" />
                            </div>

                            <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-slate-700">Email address</label>
                                <input id="email" name="email" type="email" required class="input-field" placeholder="name@example.com" />
                            </div>

                            <div class="form-grid">
                                <div class="space-y-2">
                                    <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                                    <input id="password" name="password" type="password" required class="input-field" placeholder="********" />
                                </div>
                                <div class="space-y-2">
                                    <label for="password_confirmation" class="text-sm font-medium text-slate-700">Confirm Password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" required class="input-field" placeholder="********" />
                                </div>
                            </div>

                            <button type="submit" class="hero-button-primary full-width">Create account</button>
                        </form>

                        <p class="form-footer">Already registered? <a href="<?= url('login') ?>">Sign in instead</a></p>
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
