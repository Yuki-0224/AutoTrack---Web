<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Complete Reservation - AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
    <style>
        :root {
            --primary: #ff6b35;
            --primary-dark: #e55a24;
            --bg-light: #f8f9fa;
            --text-dark: #1a1a1a;
            --text-gray: #666;
            --border-color: #e0e0e0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        header .brand-link {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        header .header-nav {
            display: flex;
            gap: 1.5rem;
        }

        header .header-link {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        main {
            flex: 1;
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 2rem;
            transition: gap 0.3s ease;
        }

        .back-button:hover {
            gap: 1rem;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: var(--text-gray);
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        /* Car Preview Card */
        .car-preview {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .car-preview-image {
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .car-preview-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .car-preview-info {
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.5rem;
        }

        .preview-label {
            font-size: 0.85rem;
            color: var(--text-gray);
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .preview-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .price-box {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1) 0%, rgba(230, 90, 36, 0.05) 100%);
            border: 2px solid rgba(255, 107, 53, 0.2);
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
        }

        .price-label {
            color: var(--text-gray);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .price-amount {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Form Section */
        .form-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.9rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        /* Cost Summary */
        .cost-summary {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.05) 0%, rgba(230, 90, 36, 0.02) 100%);
            border: 2px solid rgba(255, 107, 53, 0.2);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .summary-label {
            color: var(--text-gray);
            font-weight: 500;
        }

        .summary-value {
            font-weight: 700;
            color: var(--text-dark);
        }

        .summary-divider {
            border-top: 2px solid rgba(255, 107, 53, 0.2);
            margin: 1rem 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .summary-total-label {
            color: var(--text-dark);
        }

        .summary-total-value {
            color: var(--primary);
        }

        /* Action Buttons */
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .btn-primary, .btn-secondary {
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: rgba(255, 107, 53, 0.05);
        }

        footer {
            background: var(--text-dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            main {
                padding: 2rem 1rem;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .car-preview {
                position: static;
                margin-bottom: 2rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-section, .cost-summary {
                padding: 1.5rem;
            }

            .action-buttons {
                grid-template-columns: 1fr;
            }

            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem;
            }

            header .header-nav {
                flex-direction: column;
                width: 100%;
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            main {
                padding: 1.5rem 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .form-section, .cost-summary {
                padding: 1rem;
            }

            .section-title {
                font-size: 1.1rem;
            }

            .price-amount {
                font-size: 1.5rem;
            }

            .summary-row {
                font-size: 0.9rem;
            }

            .summary-total {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <header>
            <a href="<?= url('dashboard') ?>" class="brand-link">AutoTrack</a>
            <nav class="header-nav">
                <a href="<?= url('dashboard') ?>" class="header-link">Dashboard</a>
                <a href="<?= url('logout') ?>" class="header-link">Logout</a>
            </nav>
        </header>

        <main>
            <?php
            $carId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $car = null;

            if ($carId > 0) {
                try {
                    $car = db()->table('cars')->where('car_id', '=', $carId)->get();
                } catch (Exception $e) {
                    $car = null;
                }
            }

            if ($car):
            ?>
            <!-- Page Header -->
            <a href="<?= url('dashboard') ?>" class="back-button">← Back</a>
            <h1 class="page-title">Complete Your Reservation</h1>
            <p class="page-subtitle">Fill in the details below to secure your <?= $car['brand'] ?> <?= $car['model'] ?></p>

            <div class="content-grid">
                <!-- Left: Car Preview -->
                <div class="car-preview">
                    <div class="car-preview-image">
                        <?php if (!empty($car['image'])): ?>
                            <img src="<?= base_url() ?><?= $car['image'] ?>" alt="<?= $car['model'] ?>">
                        <?php else: ?>
                            🚗
                        <?php endif; ?>
                    </div>
                    <div class="car-preview-info">
                        <div class="preview-label">Vehicle</div>
                        <div class="preview-value"><?= $car['model'] ?></div>
                        <div class="preview-label" style="margin-top: 0.8rem;">Brand</div>
                        <div class="preview-value"><?= $car['brand'] ?></div>
                    </div>
                    <div class="price-box">
                        <div class="price-label">Daily Rate</div>
                        <div class="price-amount">₱<?= number_format($car['price_per_day'], 2) ?></div>
                    </div>
                </div>

                <!-- Right: Form -->
                <div>
                    <form method="POST" action="<?= url('save-reservation') ?>">
                        <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
                        <input type="hidden" name="car_name" value="<?= $car['brand'] ?> <?= $car['model'] ?>">
                        <input type="hidden" name="total_amount" id="totalAmount" value="0">

                        <!-- Personal Information -->
                        <div class="form-section">
                            <h3 class="section-title">Personal Information</h3>
                            <div class="form-group">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="full_name" class="form-input" placeholder="John Doe" value="<?= esc(($_SESSION['user']['first_name'] ?? '') . ' ' . ($_SESSION['user']['last_name'] ?? '')) ?>" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-input" placeholder="john@example.com" value="<?= esc($_SESSION['user']['email'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" name="phone" class="form-input" placeholder="+1 (555) 123-4567" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Driver's License *</label>
                                <input type="text" name="driver_license" class="form-input" placeholder="DL12345678" required>
                            </div>
                        </div>

                        <!-- Rental Period -->
                        <div class="form-section">
                            <h3 class="section-title">Rental Period</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Pickup Date & Time *</label>
                                    <input type="datetime-local" name="pickup_date" id="pickupDate" class="form-input" required onchange="calculateTotal()">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Return Date & Time *</label>
                                    <input type="datetime-local" name="return_date" id="returnDate" class="form-input" required onchange="calculateTotal()">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Pickup Location *</label>
                                    <select name="pickup_location" class="form-select" required>
                                        <option value="">Select a location</option>
                                        <option value="Main Office">Main Office - Downtown</option>
                                        <option value="Airport">Airport Terminal</option>
                                        <option value="Hotel">Hotel District</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Dropoff Location *</label>
                                    <select name="dropoff_location" class="form-select" required>
                                        <option value="">Select a location</option>
                                        <option value="Main Office">Main Office - Downtown</option>
                                        <option value="Airport">Airport Terminal</option>
                                        <option value="Hotel">Hotel District</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Cost Summary -->
                        <div class="cost-summary">
                            <div class="summary-row">
                                <span class="summary-label">Daily Rate:</span>
                                <span class="summary-value">₱<?= number_format($car['price_per_day'], 2) ?></span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Number of Days:</span>
                                <span class="summary-value"><span id="daysCount">0</span> days</span>
                            </div>
                            <div class="summary-divider"></div>
                            <div class="summary-row">
                                <span class="summary-label">Subtotal:</span>
                                <span class="summary-value">₱<span id="subtotal">0.00</span></span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Tax (10%):</span>
                                <span class="summary-value">₱<span id="tax">0.00</span></span>
                            </div>
                            <div class="summary-divider"></div>
                            <div class="summary-total">
                                <span class="summary-total-label">Total:</span>
                                <span class="summary-total-value">₱<span id="total">0.00</span></span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button type="submit" class="btn-primary">Proceed to Payment</button>
                            <button type="button" class="btn-secondary" onclick="history.back()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php else: ?>
            <div style="text-align: center; padding: 4rem 2rem;">
                <div style="font-size: 3.5rem; margin-bottom: 1rem;">❌</div>
                <h1 class="page-title">Car Not Found</h1>
                <p style="color: var(--text-gray); margin-bottom: 2rem;">The vehicle you're looking for doesn't exist.</p>
                <a href="<?= url('dashboard') ?>" class="btn-primary" style="text-decoration: none; display: inline-block;">Back to Dashboard</a>
            </div>
            <?php endif; ?>
        </main>

        <footer>
            &copy; 2026 AutoTrack. All rights reserved. | Web-based car rental system
        </footer>
    </div>

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

                const subtotal = diffDays * pricePerDay;
                const taxAmount = subtotal * 0.10;
                const totalAmount = subtotal + taxAmount;

                document.getElementById('daysCount').textContent = diffDays;
                document.getElementById('subtotal').textContent = subtotal.toFixed(2);
                document.getElementById('tax').textContent = taxAmount.toFixed(2);
                document.getElementById('total').textContent = totalAmount.toFixed(2);

                // Update hidden total field for form submission
                document.getElementById('totalAmount').value = totalAmount.toFixed(2);
            }
        }

        window.addEventListener('load', calculateTotal);
    </script>
</body>
</html>
