<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Secure Payment - AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
    <style>
        :root {
            --primary: #ff6b35;
            --primary-dark: #e55a24;
            --bg-light: #f8f9fa;
            --text-dark: #1a1a1a;
            --text-gray: #666;
            --border-color: #e0e0e0;
            --success: #27ae60;
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

        .page-header {
            margin-bottom: 2rem;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1rem;
            transition: gap 0.3s ease;
        }

        .back-button:hover {
            gap: 1rem;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
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

        /* Booking Summary */
        .summary-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .summary-item {
            margin-bottom: 1.2rem;
        }

        .summary-label {
            font-size: 0.9rem;
            color: var(--text-gray);
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .summary-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .summary-section {
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-section:last-child {
            border-bottom: none;
        }

        .summary-total {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1) 0%, rgba(230, 90, 36, 0.05) 100%);
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            border: 2px solid rgba(255, 107, 53, 0.2);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .total-amount {
            color: var(--primary);
        }

        /* Security Badge */
        .security-badge {
            background: rgba(39, 174, 96, 0.1);
            border: 1px solid rgba(39, 174, 96, 0.3);
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: var(--success);
            font-weight: 600;
            font-size: 0.95rem;
            margin-top: 1.5rem;
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

        /* Payment Methods */
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .payment-option {
            position: relative;
        }

        .payment-option input[type="radio"] {
            display: none;
        }

        .payment-label {
            display: block;
            padding: 1.2rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .payment-option input[type="radio"]:checked + .payment-label {
            border-color: var(--primary);
            background: rgba(255, 107, 53, 0.05);
            color: var(--primary);
        }

        .payment-label:hover {
            border-color: var(--primary);
        }

        /* Form Input */
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

        .form-input {
            width: 100%;
            padding: 0.9rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        /* Checkbox */
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: var(--primary);
            flex-shrink: 0;
        }

        .checkbox-text {
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .checkbox-text a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .checkbox-text a:hover {
            text-decoration: underline;
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

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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

            .summary-card {
                position: static;
                margin-bottom: 2rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-section, .summary-card {
                padding: 1.5rem;
            }

            .payment-methods {
                grid-template-columns: 1fr;
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

            .form-section, .summary-card {
                padding: 1rem;
            }

            .section-title {
                font-size: 1.1rem;
            }

            .total-row {
                font-size: 1.1rem;
            }

            .checkbox-group {
                padding: 1rem;
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
            $carId = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;
            $car = null;

            if ($carId > 0) {
                try {
                    $car = db()->table('cars')->where('car_id', '=', $carId)->get();
                } catch (Exception $e) {
                    $car = null;
                }
            }

            if ($car):
                $estimatedTotal = $_GET['total'] ?? ($car['price_per_day'] * 3 * 1.10);
            ?>
            <!-- Page Header -->
            <div class="page-header">
                <a href="javascript:history.back()" class="back-button">← Back</a>
                <h1 class="page-title">Secure Your Payment</h1>
                <p class="page-subtitle">Complete payment to confirm your reservation</p>
            </div>

            <div class="content-grid">
                <!-- Left: Booking Summary -->
                <div class="summary-card">
                    <h3 class="summary-title">🎫 Booking Summary</h3>

                    <div class="summary-section">
                        <div class="summary-item">
                            <div class="summary-label">Vehicle</div>
                            <div class="summary-value"><?= $car['brand'] ?> <?= $car['model'] ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Year</div>
                            <div class="summary-value"><?= $car['year'] ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Plate Number</div>
                            <div class="summary-value"><?= $car['plate_number'] ?></div>
                        </div>
                    </div>

                    <div class="summary-section">
                        <div class="summary-item">
                            <div class="summary-label">Daily Rate</div>
                            <div class="summary-value">₱<?= number_format($car['price_per_day'], 2) ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Rental Days</div>
                            <div class="summary-value">3 days</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Subtotal</div>
                            <div class="summary-value">₱<?= number_format($car['price_per_day'] * 3, 2) ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-label">Tax (10%)</div>
                            <div class="summary-value">₱<?= number_format($car['price_per_day'] * 3 * 0.10, 2) ?></div>
                        </div>
                    </div>

                    <div class="summary-total">
                        <div class="total-row">
                            <span>Total Amount:</span>
                            <span class="total-amount">₱<?= number_format($estimatedTotal, 2) ?></span>
                        </div>
                    </div>

                    <div class="security-badge">
                        🔒 Your payment is encrypted and secure
                    </div>
                </div>

                <!-- Right: Payment Form -->
                <div>
                    <form method="POST" action="<?= url('process-payment') ?>" onsubmit="return validatePayment(event)">
                        <!-- Payment Method -->
                        <div class="form-section">
                            <h3 class="section-title">Payment Method</h3>
                            <div class="payment-methods">
                                <div class="payment-option">
                                    <input type="radio" id="credit" name="payment_method" value="credit" checked>
                                    <label class="payment-label" for="credit">💳 Credit Card</label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" id="paypal" name="payment_method" value="paypal">
                                    <label class="payment-label" for="paypal">🅿️ PayPal</label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" id="bank" name="payment_method" value="bank">
                                    <label class="payment-label" for="bank">🏦 Bank</label>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="form-section">
                            <h3 class="section-title">Payment Details</h3>

                            <div class="form-group">
                                <label class="form-label">Cardholder Name *</label>
                                <input type="text" name="cardholder_name" class="form-input" placeholder="John Doe" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Card Number *</label>
                                <input type="text" name="card_number" class="form-input" placeholder="•••• •••• •••• 1234" maxlength="19" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Expiry Date *</label>
                                    <input type="text" name="expiry_date" class="form-input" placeholder="MM/YY" maxlength="5" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">CVV *</label>
                                    <input type="text" name="cvv" class="form-input" placeholder="•••" maxlength="3" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Billing Zip Code *</label>
                                    <input type="text" name="billing_zip" class="form-input" placeholder="12345" required>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Amount -->
                        <div class="form-section">
                            <h3 class="section-title">Payment Amount</h3>
                            <div class="form-group">
                                <label class="form-label">Payment Amount (₱) *</label>
                                <input type="number" name="payment_amount" class="form-input" placeholder="0.00" value="<?= number_format($estimatedTotal, 2) ?>" step="0.01" required>
                            </div>
                            <p class="form-label" style="color: #666; margin-top: 0.5rem;">💡 Enter the amount you want to pay now. Full payment: ₱<?= number_format($estimatedTotal, 2) ?></p>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="car_id" value="<?= $carId ?>">
                        <input type="hidden" name="reservation_id" value="<?= $_GET['reservation_id'] ?? '' ?>">
                        <input type="hidden" name="total_amount" value="<?= $estimatedTotal ?>">

                        <!-- Terms & Conditions -->
                        <div class="form-section">
                            <div class="checkbox-group">
                                <input type="checkbox" id="terms" name="terms" required>
                                <label for="terms" class="checkbox-text">
                                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button type="submit" class="btn-primary">Complete Payment</button>
                            <button type="button" class="btn-secondary" onclick="history.back()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php else: ?>
            <div style="text-align: center; padding: 4rem 2rem;">
                <div style="font-size: 3.5rem; margin-bottom: 1rem;">❌</div>
                <h1 class="page-title">Payment Error</h1>
                <p style="color: var(--text-gray); margin-bottom: 2rem;">Unable to process your payment. Please try again.</p>
                <a href="<?= url('dashboard') ?>" style="display: inline-block; padding: 1rem 2rem; background: var(--primary); color: white; text-decoration: none; border-radius: 8px; font-weight: 700;">Back to Dashboard</a>
            </div>
            <?php endif; ?>
        </main>

        <footer>
            &copy; 2026 AutoTrack. All rights reserved. | Web-based car rental system
        </footer>
    </div>

    <script>
        function validatePayment(event) {
            return true; // Form will submit to process-payment route
        }
    </script>
</body>
</html>
