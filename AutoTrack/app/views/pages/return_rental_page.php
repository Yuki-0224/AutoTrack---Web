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

        $rent_car = db()->table('rentals')
            ->select('payments.paid_amount, rentals.rental_id, customers.driver_license as driver_license, customers.first_name, customers.last_name, customers.email, customers.phone, cars.car_id, cars.car_name, cars.brand, cars.car_type, cars.plate_number, cars.price_per_day, rentals.rental_start, rentals.rental_end, rentals.fuel_level_out, rentals.odometer_out, rentals.total_amount')
            ->inner_join('customers', 'customers.customer_id = rentals.customer_id')
            ->inner_join('cars', 'cars.car_id = rentals.car_id')
             ->left_join('payments', 'payments.reservation_id = rentals.reservation_id')
            ->where('rentals.rental_id', segment(2))
            ->get();

        if($rent_car){
            $start = strtotime($rent_car['rental_start']);
            $end = strtotime($rent_car['rental_end']);
            $car_price = ($rent_car['price_per_day']);

            $days = ($end - $start) / (60 * 60 * 24);

            $sub_tot = $days * $car_price;

            $with_tax = $sub_tot * 0.10;

            $advance_deposit =  $rent_car['paid_amount'] ?? 0;

            $tot_amt = ($sub_tot + $with_tax) - $advance_deposit;

            $ful_pay = $rent_car['total_amount'] - $advance_deposit;
               
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
        <label class="box-label">Return Renatal</label>
        <div class="content-grid">
            <div class="sum-card">

                <div class="container">
                    <button class="sum-btn" onclick="rental_sum()">🎫 Rental Summary</button>
                    <button class="sum-btn" onclick="payment_sum()">💳 Payment Summary</button>
                </div>
                <div id="rental_sum_details">
                    <!-- Vehicle -->
                    <div class="sum-section">
                        <div>
                            <div class="sum-label">Vehicle</div>
                            <div class="sum-value"><?= htmlspecialchars($rent_car['car_name']) ?></div>
                        </div>
                        <div>
                            <div class="sum-label">Plate Number</div>
                            <div class="sum-value"><?= htmlspecialchars($rent_car['plate_number']) ?></div>
                        </div>
                    </div>

                    <!-- Customer -->
                    <div class="sum-section">
                        <div>
                            <div class="sum-label">Customer Name</div>
                            <div class="sum-value">
                                <?= htmlspecialchars($rent_car['first_name']) ?>, <?= htmlspecialchars($rent_car['last_name']) ?>
                            </div>
                        </div>
                        <div>
                            <div class="sum-label">Driver License</div>
                            <div class="sum-value"><?= htmlspecialchars($rent_car['driver_license']) ?></div>
                        </div>
                        <div>
                            <div class="sum-label">Phone Number</div>
                            <div class="sum-value"><?= htmlspecialchars($rent_car['phone']) ?></div>
                        </div>
                    </div>
                    <!-- Rental -->
                    <div class="sum-section">
                        <div>
                            <div class="sum-label">Rental Start</div>
                            <div class="sum-value" id="rental_start"><?= htmlspecialchars($rent_car['rental_start']) ?></div>
                        </div>
                        <div>
                            <div class="sum-label">Rental End</div>
                          <input type="datetime-local" id="rental_end" value="<?= date('Y-m-d\TH:i', strtotime($rent_car['rental_end'])) ?>"class="sum-value"/>
                        </div>
                    </div>
                </div>
                

                <div id="payment_sum_details">
                    <div class="sum-total">
                        <div class="sum-row">
                            <span>Price Per Day</span>
                            <span class="sum-amount">
                                ₱<?= number_format($rent_car['price_per_day'], 2) ?>
                            </span>
                        </div>
                        <div class=" mt-2"></div>
                        <div class="sum-row">
                            <span>Sub Total</span>
                            <span class="sum-amount">
                                ₱<?= number_format($sub_tot, 2) ?>
                            </span>
                        </div>
                        <div class=" mt-2"></div>
                        <div class="sum-row">
                            <span>Tax (10%)</span>
                            <span class="sum-amount">
                                ₱<?= number_format($with_tax, 2) ?>
                            </span>
                        </div>
                        <hr>
                        <div class=" mt-2"></div>
                        <div class="sum-row">
                            <span>Total Amount</span>
                            <span class="sum-amount">
                                ₱<?= number_format($rent_car['total_amount'], 2) ?>
                            </span>
                        </div>
                        <div class=" mt-2"></div>
                        <div class="sum-row">
                            <span>Advance Deposit</span>
                            <span class="sum-amount">
                                ₱<?= number_format($advance_deposit, 2) ?>
                            </span>
                        </div>
                    </div>
                    <div class="sum-total">
                        <div class=" mt-2"></div>
                        <div class="sum-row">
                            <span>Advance Deposit</span>
                            <span class="sum-amount">
                                ₱<?= number_format($advance_deposit, 2) ?>
                            </span>
                        </div>
                        <div class=" mt-2"></div>
                        <div class="sum-row">
                            <span>Full Payment</span>
                            <span class="sum-amount">
                                ₱<?= number_format($ful_pay, 2) ?>
                            </span>
                        </div>
                    </div>
                </div>
                
            </div>
            <div>
                <form method="POST" action="<?= url('process-rental-return/' .$rent_car['rental_id'])?>">
                    <div class="form-section" id="rental_sum_details">
                        <h3 class="section-title">Return Rental Details</h3>

                        <div class=" flex gap-4">
                            <div class="form-group w-full">
                                <label class="form-label">Fuel Level</label>
                                <input type="text" name="fuel" id="fuel" class="form-input" placeholder="Full">
                            </div>

                            <div class="form-group w-full">
                                <label class="form-label">Odometer</label>
                                <input type="text" name="odometer" id="odometer" class="form-input" placeholder="•••• •••• •••• 1234" maxlength="19">
                            </div>
                            <div class="form-group w-full">
                                <label class="form-label">return Date</label>
                                <input type="datetime-local" name="actual_date" id="actualDate" class="form-input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Car Condition</label>
                            <textarea name="description" id="desc" placeholder="Enter car description" class="desc"></textarea>
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="car_id" valu e="<?= $rent_car['car_id'] ?>">
                    <input type="hidden" name="reservation_id" value="<?= $reserve_id?>">
                    <input type="hidden" name="rental_id" value="<?= $rent_car["rental_id"]?>">
                    <input type="hidden" name="total_amount" value="<?= $tot_amt?>">
                    <input type="hidden" name="extra_day" id="extra_day">

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <div id="returns" class="btn-primary" >
                            <button type="submit">Return</button>
                        </div>
                        <div  id="pay_extra" class="btn-primary">
                            <button type="button"onclick='show_extra_pay(<?= htmlspecialchars(json_encode($rent_car), ENT_QUOTES, "UTF-8") ?>)'>Pay Extra</button>
                        </div>
                        <button type="button" class="btn-secondary" onclick="history.back()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <form method="POST" action="<?= url('process-rental-extra-pay/' .$rent_car['rental_id'])?>">
            <div id="extra_pay" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); overflow-y:auto; padding: 20px 0;">
                <div style="background-color:#fefefe; margin:20px auto; padding:30px; border-radius:12px; width:100%; max-width:1000px; box-shadow:0 10px 40px rgba(0,0,0,0.2); max-height:80vh; overflow-y:auto;">
                    <!-- <span onclick="closeRentalDetails()" style="color:#aaa; float:right; font-size:28px; font-weight:bold; cursor:pointer; line-height:20px;">&times;</span> -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="bg-gray p-5 rounded-lg grid grid-cols-1 md:grid-cols-2 gap-4">
                                <h2 style="margin-top:0; color:#1a1a1a; grid-column:1/-1;">Date Details</h2>
                                <div>
                                    <div class="text-gray-500 text-sm color-b" >Date Suppose to return</div>
                                    <div class="font-bold text-gray-900 color-b" id="date_return"></div>
                                </div>

                                <div>
                                    <div class="text-gray-500 text-sm color-b">Actual Date Return</div>
                                    <div class="font-bold text-gray-900 color-b" ><input type="text" name="actual_return" id="actual_return"></div>
                                </div>

                            </div>
                            <div class="bg-gray p-6 rounded-lg space-y-2">
                                <h2 style="margin-top:0; color:#1a1a1a; grid-column:1/-1;">Payment Details</h2>
                                <div class=" color-b flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-sm text-gray-600">Price Per Day</span>
                                    <span class="font-bold text-gray-900" id="price_per_day"></span>
                                </div>

                                <div class="color-b flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-sm text-gray-600">Day</span>
                                    <span class="font-bold text-gray-900" id="days"></span>
                                </div>
                                <HR></HR>
                                <div class=" color-b flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-sm text-gray-600">Total</span>
                                    <span class="font-bold text-gray-900" > <input type="text" id="extra_charges"></span>
                                </div>

                                <input type="hidden" id="fuel2" name="fuel2">
                                <input type="hidden" id="odometer2" name="odometer2">
                                <textarea  name="desc2" id="desc2" style="display:none;"></textarea>

                            </div>

                            <div class="summary-total">
                                <div class="total-row">
                                    <span>Total Amount:</span>
                                    <span class="total-amount" ><input type="text" name="extra_charges" id="tot_amount"></span>
                                </div>
                            </div>

                            <div class="security-badge">
                                🔒 Your payment is encrypted and secure
                            </div>

                        </div>

                        <!-- RIGHT SIDE (EMPTY FOR NOW) -->
                        <div>
                            <h3 class="section-title">Payment Details</h3>
                            <div class="payment-method-group color-b">

                                <label class="payment-item">
                                    <input type="radio" name="payment_method" value="credit" checked>
                                    💳 Credit Card
                                </label>

                                <label class="payment-item">
                                    <input type="radio" name="payment_method" value="paypal">
                                    🅿️ PayPal
                                </label>

                                <label class="payment-item">
                                    <input type="radio" name="payment_method" value="bank">
                                    🏦 Bank
                                </label>

                                <label class="payment-item">
                                    <input type="radio" name="payment_method" value="cash">
                                    💵 Cash
                                </label>
                            </div>
                            <div class="payment-form-right">

                            <div class="payment-form-section">

                                <div class="payment-field">
                                    <label>Cardholder Name *</label>
                                    <input type="text" name="cardholder_name" placeholder="John Doe" required>
                                </div>

                                <div class="payment-field">
                                    <label>Card Number *</label>
                                    <input type="text" name="card_number" placeholder="•••• •••• •••• 1234" maxlength="19" required>
                                </div>

                                <div class="payment-row">

                                    <div class="payment-field small">
                                        <label>Expiry Date *</label>
                                        <input type="text" name="expiry_date" placeholder="MM/YY" maxlength="5" required>
                                    </div>

                                    <div class="payment-field small">
                                        <label>CVV *</label>
                                        <input type="text" name="cvv" placeholder="•••" maxlength="3" required>
                                    </div>

                                    <div class="payment-field small">
                                        <label>Billing Zip Code *</label>
                                        <input type="text" name="billing_zip" placeholder="12345" required>
                                    </div>

                                </div>
                            </div>
                            <div class="section-container">
                                <div class="checkbox-container">
                                    <input type="checkbox" id="terms" name="terms" required>
                                    <label for="terms" class="checkbox-label">
                                        I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        </div>

                    </div>
                    

                    <div style="display:flex; gap:10px; margin-top:20px; flex-wrap:wrap;">
        
                        <button onclick="close_extra_pay()" 
                            style="flex:1; min-width:150px; padding:12px; background:#ff6b35; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; font-size:1rem;">
                            Cancel
                        </button>

                        <button type="submit" style="flex:1; min-width:150px; padding:12px; background:#28a745; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; font-size:1rem;">
                            Return
                        </button>

                    </div>
                </div>
            </div>
        </form>
        





   
    <script src="<?= base_url() ?>public/script/script.js"></script>
    <script src="/public/script/script.js"></script>


    <script>
        function openReservation() {
            window.location.href = "<?= url('Reservation') ?>";
        }

        function rental_sum() {
            document.getElementById('rental_sum_details').style.display = 'block';
            document.getElementById('payment_sum_details').style.display = 'none';
        }

        function payment_sum() {
            document.getElementById('payment_sum_details').style.display = 'block';
            document.getElementById('rental_sum_details').style.display = 'none';
          
        }

        function view_btn() {
            const extra = document.getElementById("extra_day").value;

            if(extra == 0){
                document.getElementById('returns').style.display = 'block';
                document.getElementById('pay_extra').style.display = 'none';
            }else{
                document.getElementById('returns').style.display = 'none';
                document.getElementById('pay_extra').style.display = 'block';
            }
            
        }

        document.addEventListener("DOMContentLoaded", function () {
           
            rental_sum();
            const now = new Date();


            const formatted = now.toISOString().slice(0,16);

            document.getElementById("actualDate").value = formatted;

            extraCharge();
            view_btn();
            
        });

       function extraCharge() {
            const dueValue = document.getElementById("rental_end").value;
            const returnValue = document.getElementById("actualDate").value;

            const description = document.getElementById("description");

            if (!dueValue || !returnValue) {
                extra_day.value = 0;
                return;
            }

           
            const dueDate = new Date(dueValue.replace("T", " "));
            const returnDate = new Date(returnValue.replace("T", " "));

            let lateDays = 0;

            if (returnDate > dueDate) {

                
                const diffTime = returnDate - dueDate;
                lateDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            }

            extra_day.value = lateDays;
        }

       function show_extra_pay(data) {
            currentRental = data;

            const returnValue = document.getElementById("actualDate").value;
            const returnDate = new Date(returnValue.replace("T", " "));
            const days = Number(document.getElementById('extra_day').value);
            const price_per_day = Number(data.price_per_day);

            const subtots = days * price_per_day;

            document.getElementById('extra_pay').style.display = 'block';
            document.getElementById('date_return').textContent = data.rental_end;

            document.getElementById("actual_return").value =  returnDate.toISOString().slice(0, 19).replace("T", " ");;

            document.getElementById('days').textContent = days;
            document.getElementById('price_per_day').textContent = price_per_day;

            document.getElementById("extra_charges").value = subtots.toFixed(2);
            document.getElementById('tot_amount').value = subtots.toFixed(2);

            document.getElementById("fuel2").value = document.getElementById("fuel").value;
            document.getElementById("odometer2").value = document.getElementById("odometer").value;
            document.getElementById("desc2").value = document.getElementById("desc").value;
        }

        function close_extra_pay() {
            document.getElementById('extra_pay').style.display = 'none';
            currentReservation = null;
        }

       
        
    </script>

   <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
</script>
</body>
</html>
