<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Car Details - AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
</head>
<body class="hero-bg page-body">
    <header class="page-header">
        <a href="<?= url('dashboard') ?>" class="brand-link">AutoTrack</a>
        <nav class="header-nav">
            <a href="<?= url('dashboard') ?>" class="header-link">Dashboard</a>
            <a href="<?= url('logout') ?>" class="hero-button-secondary">Logout</a>
        </nav>
    </header>

    <main>
        <?php
        $carId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $car = null;

        if ($carId > 0) {
            try {
                $car = db()->table('cars')
                    ->where('car_id', '=', $carId)
                    ->get();
            } catch (Exception $e) {
                $car = null;
            }
        }

        if ($car):
        ?>
        <!-- Header Section -->
        <section class="hero-section">
            <div class="hero-container">
                <div class="stack-large">
                    <div class="hero-pill">Car Details</div>
                    <h1 class="hero-heading text-4xl font-semibold sm:text-5xl"><?= $car['brand'] ?> <?= $car['model'] ?></h1>
                    <p class="hero-copy text-lg"><?= $car['year'] ?> • <?= $car['color'] ?> • <?= $car['plate_number'] ?></p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="feature-section">
            <div class="hero-container">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Image & Key Info -->
                    <div>
                        <!-- Car Image -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200 mb-6">
                            <div class="bg-gradient-to-br from-slate-200 to-slate-300 rounded-lg h-64 flex items-center justify-center mb-4">
                                <?php if (!empty($car['image'])): ?>
                                    <img src="<?= base_url() ?><?= $car['image'] ?>" alt="<?= $car['model'] ?>" class="w-full h-full object-cover rounded-lg">
                                <?php else: ?>
                                    <div class="text-slate-400 text-center">
                                        <div class="text-5xl mb-2">🚗</div>
                                        <p><?= $car['model'] ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Pricing Card -->
                        <article class="stat-card">
                            <p class="text-sm uppercase tracking-[0.35em] text-orange-300">Pricing</p>
                            <h2 class="mt-4 text-4xl font-semibold text-slate-950">$<?= number_format($car['price_per_day'], 2) ?></h2>
                            <p class="text-muted">/day</p>
                        </article>
                    </div>

                    <!-- Middle & Right Column: Details -->
                    <div class="lg:col-span-2">
                        <!-- Specifications -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200 mb-6">
                            <h3 class="text-xl font-semibold text-slate-900 mb-6">Specifications</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                <div>
                                    <p class="text-sm text-slate-600 font-medium mb-1">Model</p>
                                    <p class="text-lg font-semibold text-slate-900"><?= $car['model'] ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-600 font-medium mb-1">Year</p>
                                    <p class="text-lg font-semibold text-slate-900"><?= $car['year'] ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-600 font-medium mb-1">Color</p>
                                    <p class="text-lg font-semibold text-slate-900"><?= $car['color'] ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-600 font-medium mb-1">Plate Number</p>
                                    <p class="text-lg font-semibold text-slate-900"><?= $car['plate_number'] ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-600 font-medium mb-1">Transmission</p>
                                    <p class="text-lg font-semibold text-slate-900">Automatic</p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-600 font-medium mb-1">Status</p>
                                    <p class="text-lg font-semibold text-green-600"><?= $car['status'] ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200 mb-6">
                            <h3 class="text-xl font-semibold text-slate-900 mb-4">Description</h3>
                            <p class="text-slate-600 leading-relaxed">
                                This <?= $car['year'] ?> <?= $car['brand'] ?> <?= $car['model'] ?> is a premium vehicle perfect for any journey. Featuring modern comfort, advanced safety features, and reliable performance, it ensures a smooth and enjoyable driving experience. Regular maintenance and professional inspection guarantee your safety and satisfaction.
                            </p>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200">
                            <h3 class="text-xl font-semibold text-slate-900 mb-4">Terms & Conditions</h3>
                            <ul class="space-y-3 text-slate-600">
                                <li class="flex items-start"><span class="mr-3">✓</span> Valid driver's license required</li>
                                <li class="flex items-start"><span class="mr-3">✓</span> Minimum rental period: 24 hours</li>
                                <li class="flex items-start"><span class="mr-3">✓</span> Full tank at pickup required</li>
                                <li class="flex items-start"><span class="mr-3">✓</span> Insurance included in rental</li>
                                <li class="flex items-start"><span class="mr-3">✓</span> Free cancellation up to 2 hours</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 mt-8">
                    <button onclick="makeReservation(<?= $car['car_id'] ?>)" class="hero-button-primary px-8 py-3">Make a Reservation</button>
                    <a href="<?= url('dashboard') ?>" class="hero-button-secondary px-8 py-3">Go Back</a>
                </div>
            </div>
        </section>

        <?php else: ?>
        <section class="hero-section">
            <div class="hero-container text-center">
                <div class="text-6xl mb-4">❌</div>
                <h1 class="hero-heading text-4xl font-semibold mb-4">Car Not Found</h1>
                <p class="hero-copy text-lg mb-8">The car you're looking for doesn't exist or has been removed.</p>
                <a href="<?= url('dashboard') ?>" class="hero-button-primary">Back to Dashboard</a>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <footer class="page-footer">
        AutoTrack • Web-based car rental, reservation, and vehicle monitoring system.
    </footer>

    <script>
        function makeReservation(carId) {
            window.location.href = "<?= url('car-reservation') ?>?id=" + carId;
        }
    </script>
</body>
</html>
