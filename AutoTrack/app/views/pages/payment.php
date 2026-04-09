<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Secure Payment - AutoTrack</title>
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
        $carId = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;
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
            $estimatedTotal = $_GET['total'] ?? ($car['price_per_day'] * 3);
        ?>
        <!-- Header Section -->
        <section class="hero-section">
            <div class="hero-container">
                <div class="stack-large">
                    <div class="hero-pill">Payment</div>
                    <h1 class="hero-heading text-4xl font-semibold sm:text-5xl">Secure Your Payment</h1>
                    <p class="hero-copy text-lg">Complete payment to confirm your reservation</p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="feature-section">
            <div class="hero-container">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Booking Summary -->
                    <div>
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200 sticky top-8">
                            <h3 class="text-lg font-semibold text-slate-900 mb-6">Booking Summary</h3>

                            <div class="space-y-4 border-b border-slate-200 pb-4 mb-4">
                                <div>
                                    <p class="text-sm text-slate-600 font-medium">Selected Car</p>
                                    <p class="font-semibold text-slate-900"><?= $car['brand'] ?> <?= $car['model'] ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-600 font-medium">Year</p>
                                    <p class="font-semibold text-slate-900"><?= $car['year'] ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-600 font-medium">Plate Number</p>
                                    <p class="font-semibold text-slate-900"><?= $car['plate_number'] ?></p>
                                </div>
                            </div>

                            <div class="space-y-3 border-b border-slate-200 pb-4 mb-4">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Rental Days:</span>
                                    <span class="font-semibold">3 days</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Daily Rate:</span>
                                    <span class="font-semibold">$<?= number_format($car['price_per_day'], 2) ?></span>
                                </div>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Subtotal:</span>
                                    <span class="font-semibold">$<?= number_format($car['price_per_day'] * 3, 2) ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Taxes (10%):</span>
                                    <span class="font-semibold">$<?= number_format($car['price_per_day'] * 3 * 0.10, 2) ?></span>
                                </div>
                                <div class="border-t border-slate-200 pt-3 flex justify-between text-lg">
                                    <span class="font-bold text-slate-900">Total Amount:</span>
                                    <span class="font-bold text-orange-500">$<?= number_format($car['price_per_day'] * 3 * 1.10, 2) ?></span>
                                </div>
                            </div>

                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm text-green-800">
                                ✓ Reservation pending upon payment
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Payment Form -->
                    <div class="lg:col-span-2">
                        <form class="space-y-6">
                            <!-- Payment Method -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200">
                                <h3 class="text-lg font-semibold text-slate-900 mb-4">Payment Method</h3>
                                <div class="space-y-3">
                                    <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-400 has-[:checked]:bg-orange-50">
                                        <input type="radio" name="payment_method" value="credit" checked class="w-4 h-4">
                                        <span class="ml-3 font-semibold text-slate-900">Credit Card (Visa, Mastercard)</span>
                                    </label>
                                    <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-400 has-[:checked]:bg-orange-50">
                                        <input type="radio" name="payment_method" value="paypal" class="w-4 h-4">
                                        <span class="ml-3 font-semibold text-slate-900">PayPal Account</span>
                                    </label>
                                    <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-orange-400 has-[:checked]:border-orange-400 has-[:checked]:bg-orange-50">
                                        <input type="radio" name="payment_method" value="bank" class="w-4 h-4">
                                        <span class="ml-3 font-semibold text-slate-900">Bank Transfer</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Payment Details -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200">
                                <h3 class="text-lg font-semibold text-slate-900 mb-4">Payment Details</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-900 mb-2">Cardholder Name *</label>
                                        <input type="text" placeholder="John Doe" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-900 mb-2">Card Number *</label>
                                        <input type="text" placeholder="•••• •••• •••• 1234" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-900 mb-2">Expiry Date *</label>
                                            <input type="text" placeholder="MM/YY" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-900 mb-2">CVV *</label>
                                            <input type="text" placeholder="•••" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-900 mb-2">Billing Zip Code *</label>
                                        <input type="text" placeholder="12345" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-200">
                                <label class="flex items-start">
                                    <input type="checkbox" class="mt-1" required>
                                    <span class="ml-3 text-slate-700">I agree to the <a href="#" class="text-orange-500 font-semibold hover:underline">Terms of Service</a> and <a href="#" class="text-orange-500 font-semibold hover:underline">Privacy Policy</a></span>
                                </label>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <button type="submit" onclick="processPayment(event)" class="hero-button-primary w-full py-3">Complete Payment & Reserve</button>
                                <a href="<?= url('car-reservation') ?>?id=<?= $carId ?>" class="hero-button-secondary w-full py-3 text-center block">Go Back</a>
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
        function processPayment(event) {
            event.preventDefault();
            alert('✓ Payment processed successfully!\nYour reservation is confirmed.');
            window.location.href = "<?= url('dashboard') ?>";
        }
    </script>
</body>
</html>
