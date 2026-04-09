<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - AutoTrack</title>
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
        <!-- Welcome Section -->
        <section class="hero-section">
            <div class="hero-container">
                <div class="hero-grid hero-grid--landing">
                    <div class="stack-large">
                        <div class="hero-pill">Dashboard</div>
                        <div class="stack-medium">
                            <h1 class="hero-heading text-4xl font-semibold sm:text-5xl">Welcome back, <?= esc($_SESSION['user']['name'] ?? 'Driver') ?></h1>
                            <p class="hero-copy text-lg">Browse available cars, make reservations, and manage your bookings from your personal dashboard.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tabs Navigation -->
        <section class="feature-section">
            <div class="hero-container">
                <div class="flex gap-4 mb-8 border-b border-slate-200">
                    <button onclick="showTab('available-cars')" class="tab-button active px-6 py-3 font-semibold text-slate-900 border-b-2 border-orange-400">Available Cars</button>
                    <button onclick="showTab('my-reservations')" class="tab-button px-6 py-3 font-semibold text-slate-600 hover:text-slate-900">My Reservations</button>
                </div>

                <!-- Tab 1: Available Cars -->
                <div id="available-cars" class="tab-content">
                    <h2 class="text-3xl font-semibold text-slate-900 mb-8">Find Your Perfect Car</h2>

                    <!-- Search Form -->
                    <div class="bg-white rounded-lg p-6 mb-8 shadow-sm border border-slate-200">
                        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Brand</label>
                                <input type="text" name="brand" placeholder="Brand" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Dropoff Location</label>
                                <input type="text" name="location" placeholder="Location" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Pickup Date</label>
                                <input type="date" name="pickup_date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full hero-button-primary">Search</button>
                            </div>
                        </form>
                    </div>

                    <!-- Featured Cars Grid -->
                    <h3 class="text-2xl font-semibold text-slate-900 mb-6">Featured Cars</h3>
                    <div class="feature-grid">
                        <?php
                        // Fetch all cars from database
                        $cars = [];

                        // Try fetching each car ID (up to 18 available)
                        for ($carId = 1; $carId <= 18; $carId++) {
                            try {
                                $car = db()->table('cars')
                                    ->where('car_id', '=', $carId)
                                    ->get();
                                if ($car) {
                                    $cars[] = $car;
                                    if (count($cars) >= 6) break; // Stop at 6 cars
                                }
                            } catch (Exception $e) {
                                continue;
                            }
                        }

                        if (!empty($cars)):
                            foreach ($cars as $car):
                        ?>
                        <article class="stat-card">
                            <div class="flex items-center justify-between mb-4">
                                <span class="feature-tag"><?= $car['brand'] ?></span>
                                <span class="text-sm font-semibold text-orange-300">$<?= number_format($car['price_per_day'], 0) ?>/day</span>
                            </div>
                            <h3 class="text-xl font-semibold text-slate-950 mb-2"><?= $car['model'] ?></h3>
                            <p class="text-sm text-slate-600 mb-4"><?= $car['year'] ?> • <?= $car['color'] ?></p>
                            <p class="text-muted mb-4">Plate: <?= $car['plate_number'] ?></p>
                            <button onclick="goToCarInfo(<?= $car['car_id'] ?>)" class="hero-button-primary w-full">View Details</button>
                        </article>
                        <?php
                            endforeach;
                        else:
                        ?>
                        <div class="col-span-3 text-center py-12">
                            <p class="text-slate-500 text-lg">No cars available. Please check the database.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tab 2: My Reservations -->
                <div id="my-reservations" class="tab-content hidden">
                    <h2 class="text-3xl font-semibold text-slate-900 mb-8">Your Reservations</h2>

                    <?php
                    $userId = $_SESSION['user']['id'] ?? 0;
                    $hasReservations = false;

                    // Check if user has any reservations
                    try {
                        for ($i = 1; $i <= 20; $i++) {
                            $reservation = db()->table('reservations')
                                ->where('customer_id', '=', $userId)
                                ->get();
                            if ($reservation) {
                                $hasReservations = true;
                                break;
                            }
                        }
                    } catch (Exception $e) {
                        $hasReservations = false;
                    }
                    ?>

                    <?php if ($hasReservations): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-slate-100">
                                    <th class="px-4 py-3 text-left font-semibold text-slate-900">Reservation ID</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-900">Car</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-900">Pickup Date</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-900">Return Date</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-900">Status</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-900">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-3 text-slate-700">#RES-001</td>
                                    <td class="px-4 py-3 text-slate-700">Toyota Camry</td>
                                    <td class="px-4 py-3 text-slate-700">Apr 15, 2026</td>
                                    <td class="px-4 py-3 text-slate-700">Apr 18, 2026</td>
                                    <td class="px-4 py-3"><span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Confirmed</span></td>
                                    <td class="px-4 py-3"><button class="text-orange-500 hover:text-orange-600 font-semibold">View</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">📋</div>
                        <p class="text-slate-600 text-lg mb-4">No reservations yet</p>
                        <p class="text-slate-500 mb-6">Start by browsing available cars and making a reservation.</p>
                        <button onclick="showTab('available-cars')" class="hero-button-primary">Browse Cars</button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- How it Works Section -->
        <section class="feature-section">
            <div class="hero-container">
                <div class="feature-grid">
                    <article class="stat-card">
                        <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Step 1</p>
                        <h2 class="mt-4 text-2xl font-semibold text-slate-950">Browse Cars</h2>
                        <p class="text-muted">Explore our wide selection of vehicles with competitive pricing.</p>
                    </article>
                    <article class="stat-card">
                        <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Step 2</p>
                        <h2 class="mt-4 text-2xl font-semibold text-slate-950">Reserve</h2>
                        <p class="text-muted">Select your dates and complete the reservation in minutes.</p>
                    </article>
                    <article class="stat-card">
                        <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Step 3</p>
                        <h2 class="mt-4 text-2xl font-semibold text-slate-950">Enjoy</h2>
                        <p class="text-muted">Pickup your car and start your journey with confidence.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer class="page-footer">
        AutoTrack • Web-based car rental, reservation, and vehicle monitoring system.
    </footer>

    <script>
        function goToCarInfo(carId) {
            window.location.href = "<?= url('car-info') ?>?id=" + carId;
        }

        function showTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            const buttons = document.querySelectorAll('.tab-button');

            tabs.forEach(tab => {
                if (tab.id === tabName) {
                    tab.classList.remove('hidden');
                } else {
                    tab.classList.add('hidden');
                }
            });

            buttons.forEach(btn => {
                if (btn.textContent.includes(tabName === 'available-cars' ? 'Available' : 'Reservations')) {
                    btn.classList.add('active', 'border-orange-400');
                    btn.classList.remove('border-transparent');
                } else {
                    btn.classList.remove('active', 'border-orange-400');
                }
            });
        }
    </script>

    <style>
        .tab-button {
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }
        .tab-button.active {
            border-bottom-color: #ff6b35;
            color: #0f172a;
        }
        .tab-content.hidden {
            display: none;
        }
    </style>
</body>
</html>
