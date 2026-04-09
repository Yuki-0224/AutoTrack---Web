<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Complete Reservation - AutoTrack</title>
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
                    <div class="hero-pill">Reservation</div>
                    <h1 class="hero-heading text-4xl font-semibold sm:text-5xl">Complete Your Reservation</h1>
                    <p class="hero-copy text-lg">Fill in your details to reserve this <?= $car['brand'] ?> <?= $car['model'] ?></p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="feature-section">
            <div class="hero-container">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Selected Car -->
                    <div>
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200 sticky top-8">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Selected Vehicle</h3>

                            <div class="bg-gradient-to-br from-slate-200 to-slate-300 rounded-lg h-48 flex items-center justify-center mb-4">
                                <?php if (!empty($car['image'])): ?>
                                    <img src="<?= base_url() ?><?= $car['image'] ?>" alt="<?= $car['model'] ?>" class="w-full h-full object-cover rounded-lg">
                                <?php else: ?>
                                    <div class="text-slate-400 text-center">
                                        <div class="text-4xl mb-2">🚗</div>
                                        <p><?= $car['model'] ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="space-y-3 border-b border-slate-200 pb-4 mb-4">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Brand:</span>
                                    <span class="font-semibold text-slate-900"><?= $car['brand'] ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Model:</span>
                                    <span class="font-semibold text-slate-900"><?= $car['model'] ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Year:</span>
                                    <span class="font-semibold text-slate-900"><?= $car['year'] ?></span>
                                </div>
                            </div>

                            <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                                <p class="text-sm text-slate-600 mb-1">Price Per Day</p>
                                <p class="text-3xl font-bold text-orange-500">$<?= number_format($car['price_per_day'], 2) ?></p>
                            </div>

                            <div class="mt-4 bg-slate-100 p-4 rounded-lg">
                                <p class="text-sm text-slate-600 mb-1">Estimated Total</p>
                                <p class="text-2xl font-bold text-slate-900" id="totalCost">$0.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Reservation Form -->
                    <div class="lg:col-span-2">
                        <form method="POST" action="<?= url('save-reservation') ?>" class="space-y-6">
                            <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">

                            <!-- Personal Information -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200">
                                <h3 class="text-lg font-semibold text-slate-900 mb-4">Personal Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-900 mb-2">Full Name *</label>
                                        <input type="text" name="full_name" placeholder="John Doe" value="<?= esc(($_SESSION['user']['first_name'] ?? '') . ' ' . ($_SESSION['user']['last_name'] ?? '')) ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-900 mb-2">Email Address *</label>
                                        <input type="email" name="email" placeholder="john@example.com" value="<?= esc($_SESSION['user']['email'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-900 mb-2">Phone Number *</label>
                                        <input type="tel" name="phone" placeholder="123-456-7890" value="<?= esc($_POST['phone'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-900 mb-2">Driver's License *</label>
                                        <input type="text" name="driver_license" placeholder="DL12345678" value="<?= esc($_POST['driver_license'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Pickup & Dropoff -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200">
                                <h3 class="text-lg font-semibold text-slate-900 mb-4">Pickup & Dropoff</h3>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-900 mb-2">Pickup Date & Time *</label>
                                            <input type="datetime-local" name="pickup_date" id="pickupDate" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required onchange="calculateTotal()">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-900 mb-2">Return Date & Time *</label>
                                            <input type="datetime-local" name="return_date" id="returnDate" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required onchange="calculateTotal()">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-900 mb-2">Pickup Location *</label>
                                        <select name="pickup_location" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                            <option value="">Select a location</option>
                                            <option value="Main Office">Main Office - Downtown</option>
                                            <option value="Airport">Airport Terminal</option>
                                            <option value="Hotel">Hotel District</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-900 mb-2">Dropoff Location *</label>
                                        <select name="dropoff_location" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                            <option value="">Select a location</option>
                                            <option value="Main Office">Main Office - Downtown</option>
                                            <option value="Airport">Airport Terminal</option>
                                            <option value="Hotel">Hotel District</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="bg-orange-50 rounded-lg p-6 border border-orange-200">
                                <div class="space-y-3">
                                    <div class="flex justify-between text-slate-700">
                                        <span>Daily Rate × Days:</span>
                                        <span class="font-semibold">$<?= number_format($car['price_per_day'], 2) ?> × <span id="daysCount">0</span></span>
                                    </div>
                                    <div class="border-t border-orange-200 pt-3">
                                        <div class="flex justify-between text-lg">
                                            <span class="font-bold text-slate-900">Estimated Total:</span>
                                            <span class="font-bold text-orange-600 text-2xl">$<span id="estimatedTotal">0.00</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-4">
                                <button type="submit" class="hero-button-primary px-8 py-3 flex-1">Proceed to Payment</button>
                                <a href="<?= url('car-info') ?>?id=<?= $car['car_id'] ?>" class="hero-button-secondary px-8 py-3 flex-1 text-center">Go Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php else: ?>
        <section class="hero-section">
            <div class="hero-container text-center">
                <div class="text-6xl mb-4">❌</div>
                <h1 class="hero-heading text-4xl font-semibold mb-4">Car Not Found</h1>
                <a href="<?= url('dashboard') ?>" class="hero-button-primary">Back to Dashboard</a>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <footer class="page-footer">
        AutoTrack • Web-based car rental, reservation, and vehicle monitoring system.
    </footer>

    <script>
        const pricePerDay = <?= $car['price_per_day'] ?? 0 ?>;

        function calculateTotal() {
            const pickupDate = document.getElementById('pickupDate').value;
            const returnDate = document.getElementById('returnDate').value;

            if (pickupDate && returnDate) {
                const pickup = new Date(pickupDate);
                const returnD = new Date(returnDate);
                const diffTime = Math.abs(returnD - pickup);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) || 1;

                const baseCost = diffDays * pricePerDay;
                document.getElementById('daysCount').textContent = diffDays;
                document.getElementById('estimatedTotal').textContent = baseCost.toFixed(2);
            }
        }

        window.addEventListener('load', calculateTotal);
    </script>
</body>
</html>
