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

                            <!-- Account Information -->
                            <div class="mb-6 pb-6 border-b border-slate-200">
                                <h3 class="text-sm font-semibold text-slate-900 mb-4">Account Information</h3>

                                <div class="space-y-2">
                                    <label for="name" class="text-sm font-medium text-slate-700">Full Name</label>
                                    <input id="name" name="name" type="text" required class="input-field" placeholder="Jane Doe" />
                                </div>

                                <div class="space-y-2 mt-3">
                                    <label for="email" class="text-sm font-medium text-slate-700">Email address</label>
                                    <input id="email" name="email" type="email" required class="input-field" placeholder="name@example.com" />
                                </div>

                                <div class="form-grid mt-3">
                                    <div class="space-y-2">
                                        <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                                        <input id="password" name="password" type="password" required class="input-field" placeholder="********" />
                                    </div>
                                    <div class="space-y-2">
                                        <label for="password_confirmation" class="text-sm font-medium text-slate-700">Confirm Password</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password" required class="input-field" placeholder="********" />
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-slate-900 mb-4">Customer Details</h3>

                                <div class="form-grid">
                                    <div class="space-y-2">
                                        <label for="first_name" class="text-sm font-medium text-slate-700">First Name</label>
                                        <input id="first_name" name="first_name" type="text" required class="input-field" placeholder="Jane" />
                                    </div>
                                    <div class="space-y-2">
                                        <label for="last_name" class="text-sm font-medium text-slate-700">Last Name</label>
                                        <input id="last_name" name="last_name" type="text" required class="input-field" placeholder="Doe" />
                                    </div>
                                </div>

                                <div class="space-y-2 mt-3">
                                    <label for="phone" class="text-sm font-medium text-slate-700">Phone Number</label>
                                    <input id="phone" name="phone" type="tel" required class="input-field" placeholder="+1 (555) 123-4567" />
                                </div>

                                <div class="space-y-2 mt-3">
                                    <label for="address" class="text-sm font-medium text-slate-700">Address</label>
                                    <textarea id="address" name="address" required class="input-field" placeholder="123 Main Street, City, State 12345" rows="2"></textarea>
                                </div>

                                <div class="space-y-2 mt-3">
                                    <label for="driver_license" class="text-sm font-medium text-slate-700">Driver's License Number</label>
                                    <input id="driver_license" name="driver_license" type="text" required class="input-field" placeholder="DL1234567890" />
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
