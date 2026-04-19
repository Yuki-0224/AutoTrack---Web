<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>

<body class="hero-bg-auth auth-body ">

    <?php
            $carId = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;
            $car = null;

            $reserve_id = isset($_GET['reserve_id']) ? (int)$_GET['reserve_id'] : 0;
            $reserve = null;    

            if ($carId > 0) {
                try {
                    $car = db()->table('cars')->where('car_id', '=', $carId)->get();
                } catch (Exception $e) {
                    $car = null;
                }
            }

            if ($reserve_id > 0) {
                try {
                    $reserve = db()->table('payments')->select('paid_amount')->where('reservation_id', '=', $reserve_id)->get();
                } catch (Exception $e) {
                    $reserve = null;
                }
            }

            if ($car):
                $estimatedTotal = $_GET['total'] ?? ($car['price_per_day'] * 3 * 1.10);

                $rentId = isset($_GET['ren']) ? (int)$_GET['ren'] : 0;
                $rent = null;

                

                if ($rentId > 0) {
                    try {
                        $rent = db()->table('rentals')->where('rental_id', '=', $rentId)->get();
                    } catch (Exception $e) {
                        $rent = null;
                    }
            }

            if($car && $rent){
                $start = strtotime($rent['rental_start']);
                $end = strtotime($rent['rental_end']);
                $car_price = ($car['price_per_day']);

                $days = ($end - $start) / (60 * 60 * 24);

                $sub_tot = $days * $car_price;

                $with_tax = $sub_tot * 0.10;

                $advance_deposit =  $reserve['paid_amount'] ?? 0;

                $tot_amt = ($sub_tot + $with_tax) - $advance_deposit;

               
            }

    ?>

    <div class="div-sidenav">
        <nav class="sidenav">
            <a href="<?= url('admin_dashboard') ?>" class="nav-link"> OverView </a>
            <a href="<?= url('manage_car') ?>" class="nav-link"> Manage Cars </a>
            <a href="" class="nav-link"> Manage Reservation </a>
            <a href="<?= url('manage_rental') ?>" class="nav-link  nav-link-focus"> Manage Rentals </a>
            <a href="#contact" class="nav-link"> Manage Payments </a>
            <a href="#contact" class="nav-link"> Manage Maintenance </a>
            <a href="#contact" class="nav-link"> Manage Damage </a>    
        </nav>
    </div>
    <div class="div-admin-dash">
        <label class="box-label">Payment Renatal</label>

        <div class="content-grid">
            <!-- Left: Booking Summary -->
            <div class="summary-card">
                <h3 class="summary-title">🎫 Rental Summary</h3>

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
                        <div class="summary-value"><?= $car['price_per_day'] ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Rental Days</div>
                        <div class="summary-value"><?= $days?></div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Subtotal</div>
                        <div class="summary-value"><?= $sub_tot?></div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Tax (10%)</div>
                        <div class="summary-value"><?= $with_tax?></div>
                    </div>
                    <div class="summary-item" id="advanceDepositBox">
                            <div class="summary-label">Advance Deposit</div>
                            <div class="summary-value" id="reserveId">₱<?= number_format($advance_deposit) ?></div>
                    </div>
                </div>

                <div class="summary-total">
                    <div class="total-row">
                        <span>Total Amount:</span>
                        <span class="total-amount"><?= $tot_amt?></span>
                    </div>
                </div>

                <div class="security-badge">
                    🔒 Your payment is encrypted and secure
                </div>
            </div>

                <!-- Right: Payment Form -->
                <div>
                    <form method="POST" action="<?= url('process-payment-rent') ?>" onsubmit="return validatePayment(event)">
                        <!-- Payment Method -->
                         <input type="hidden" name="rent_id" value="<?= $rentId?>">
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
                                <div class="payment-option">
                                    <input type="radio" id="cash" name="payment_method" value="cash">
                                    <label class="payment-label" for="cash">🏦 Cash</label>
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
                                <input type="number" name="payment_amount" class="form-input" placeholder="0.00" value="<?= $tot_amt?>" step="0.01" required>
                            </div>
                            <p class="form-label" style="color: #666; margin-top: 0.5rem;"> Full payment:</p>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="car_id" value="<?= $carId ?>">
                        <input type="hidden" name="reservation_id" value="<?= $reserve_id?>">
                        <input type="hidden" name="total_amount" value="<?= $tot_amt?>">

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
            <?php else: ?>
                <div style="text-align: center; padding: 4rem 2rem;">
                    <div style="font-size: 3.5rem; margin-bottom: 1rem;">❌</div>
                    <h1 class="page-title">Payment Error</h1>
                    <p style="color: var(--text-gray); margin-bottom: 2rem;">Unable to process your payment. Please try again.</p>
                    <a href="<?= url('dashboard') ?>" style="display: inline-block; padding: 1rem 2rem; background: var(--primary); color: white; text-decoration: none; border-radius: 8px; font-weight: 700;">Back to Dashboard</a>
                </div>
            <?php endif; ?>
        </div>
    </div>




   
    <script src="<?= base_url() ?>public/script/script.js"></script>
    <script src="/public/script/script.js"></script>


    <script>
        function openReservation() {
            window.location.href = "<?= url('Reservation') ?>";
        }
    </script>

   <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
</script>
</body>
</html>
