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

    $search = $_GET['search'] ?? '';

    $query = db()->table('cars'); 

    if (!empty($search)) {
        $query->grouped(function($q) use ($search) {
            $q->like('car_name', '%' . $search . '%')
            ->or_like('brand', '%' . $search . '%');
        });
    }

    $results = $query->get_all();


    $rent_car = db()->table('rentals')
             ->select('customers.driver_license as driver_license, customers.first_name, customers.last_name, customers.email, customers.phone, cars.car_name, cars.brand, cars.car_type, cars.plate_number, rentals.rental_start, rentals.rental_end, rentals.fuel_level_out, rentals.odometer_out, rentals.total_amount')
             ->inner_join('customers', 'customers.customer_id = rentals.customer_id')
             ->inner_join('cars', 'cars.car_id = rentals.car_id')
             ->get_all();

    ?>

    <div class="div-sidenav">
        <nav class="sidenav">
            <a href="<?= url('admin_dashboard') ?>" class="nav-link"> OverView </a>
            <a href="<?= url('manage_car') ?>" class="nav-link"> Manage Cars </a>
            <a href="<?= url('manage_reservation') ?>" class="nav-link"> Manage Reservation </a>
            <a href="<?= url('manage_rental') ?>" class="nav-link nav-link-focus"> Manage Rentals </a>
            <a href="" class="nav-link"> Manage Payments </a>
            <a href="#contact" class="nav-link"> Manage Maintenance </a>
            <a href="#contact" class="nav-link"> Manage Damage </a>    
        </nav>
    </div>
    <div class="div-admin-dash">
        <label class="box-label">Manage Rental</label>

       
       
        <div class="div-panel">
            <div class="search-container">
                <form method="get">
                    <input type="text" placeholder="Search....." class="search-input" name="search" value="<?= esc($search) ?>">
                    <button class="search-btn" >Search</button>
                </form>
                <!-- <select name="type" id=""  class="search-select">
                        <option value="">-- Select Car Type --</option>
                        <?php foreach ($results as $car): ?>
                            <option value="<?= htmlspecialchars(esc($car['car_name'])) ?>"> </option>
                        <?php endforeach; ?>
                </select> -->
                <button class="add_btn" onclick="window.location.href='<?= url('add_new_rental') ?>'">Add New Rental</button>
            </div>

            <table class="table-container">
                <tr class="car-table-row">
                    <th class="car-table-header">Driver License</th>
                    <th class="car-table-header">Customer Name</th>
                    <th class="car-table-header">Car Name</th>
                    <th class="car-table-header">Plate Number</th>
                    <th class="car-table-header">Date supposed to return</th>
                    <th class="car-table-header">Action</th>
                </tr>
                <?php foreach ($rent_car as $rent_row): ?>
                    <tr>
                        <td class="car-table-cell" ><?= htmlspecialchars($rent_row['driver_license']) ?></td>
                        <td class="car-table-cell"><?= htmlspecialchars($rent_row['first_name']) ?>, <?= htmlspecialchars($rent_row['last_name']) ?></td>
                        <td class="car-table-cell"><?= htmlspecialchars($rent_row['car_name']) ?></td>
                        <td class="car-table-cell"><?= htmlspecialchars($rent_row['plate_number']) ?></td>
                        <td class="car-table-cell"><?= htmlspecialchars($rent_row['rental_end']) ?></td>
                        <td class="car-table-cell">
                            <button  onclick="showRentalDetails(<?= htmlspecialchars(json_encode($rent_row), ENT_QUOTES) ?>); return false;"><a href="">View</a></button>
                            <button onclick="showRentalReturn(<?= htmlspecialchars(json_encode($rent_row), ENT_QUOTES) ?>); return false;">Return</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <!-- Rental Details View -->
    <div id="rental_details" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); overflow-y:auto; padding: 20px 0;">
        <div style="background-color:#fefefe; margin:20px auto; padding:30px; border-radius:12px; width:90%; max-width:600px; box-shadow:0 10px 40px rgba(0,0,0,0.2); max-height:80vh; overflow-y:auto;">
            <!-- <span onclick="closeRentalDetails()" style="color:#aaa; float:right; font-size:28px; font-weight:bold; cursor:pointer; line-height:20px;">&times;</span> -->
            <h2 style="margin-top:0; color:#1a1a1a;">Rental Details</h2>

            <div style="background:#f8f9fa; padding:20px; border-radius:8px; margin:20px 0;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Customer Driver License</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="driver_license"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Customer Name</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="name"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Email</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="email"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Phone Number</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="phone"></div>
                    </div>
                    <hr style="grid-column:1/-1;">
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Car Name</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="car_name"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Plate Number</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="plate_number"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Barnd</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="brand"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Car type</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="car_type"></div>
                    </div>
                    <hr style="grid-column:1/-1;">
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Rental Start Date</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="rental_start"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Rental End Date</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="rental_end"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Fuel Level Out</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="fuel_level_out"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Odometer Out</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="odometer_out"></div>
                    </div>
                    <div style="grid-column:1/-1;">
                        <div style="color:#666; font-size:0.9rem;">Total Amount</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="total_amount"></div>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:20px; flex-wrap:wrap;">
                <button onclick="closeRentalDetails()" style="flex:1; min-width:150px; padding:12px; background:#ff6b35; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; font-size:1rem;">close</button>
            </div>
        </div>
    </div>

    <!-- rental return -->
    <div id="rental_return" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); overflow-y:auto; padding: 20px 0;">
        <div style="background-color:#fefefe; margin:20px auto; padding:30px; border-radius:12px; width:90%; max-width:600px; box-shadow:0 10px 40px rgba(0,0,0,0.2); max-height:80vh; overflow-y:auto;">
            <!-- <span onclick="closeRentalDetails()" style="color:#aaa; float:right; font-size:28px; font-weight:bold; cursor:pointer; line-height:20px;">&times;</span> -->
            <h2 style="margin-top:0; color:#1a1a1a;">Rental Details</h2>

            <div style="background:#f8f9fa; padding:20px; border-radius:8px; margin:20px 0;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Customer Driver License</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="driver_license_return"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Customer Name</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="name_return"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Email</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="email_return"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Phone Number</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="phone_return"></div>
                    </div>
                    <hr style="grid-column:1/-1;">
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Car Name</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="car_name_return"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Plate Number</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="plate_number_return"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Barnd</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="brand_return"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Car type</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="car_type_return"></div>
                    </div>
                    <hr style="grid-column:1/-1;">
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Rental Start Date</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="rental_start_return"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Rental End Date</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="rental_end_return"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Fuel Level Out</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="fuel_level_out_return"></div>
                    </div>
                    <div>
                        <div style="color:#666; font-size:0.9rem;">Odometer Out</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="odometer_out_return"></div>
                    </div>
                    <div style="grid-column:1/-1;">
                        <div style="color:#666; font-size:0.9rem;">Total Amount</div>
                        <div style="font-weight:bold; color:#1a1a1a;" id="total_amount_return"></div>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:20px; flex-wrap:wrap;">
                <button onclick="closeRentalReturn()" style="flex:1; min-width:150px; padding:12px; background:#ff6b35; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; font-size:1rem;">Damage</button>
                <button><a href=""> Return </a></button>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>public/script/script.js"></script>
    
    <script>

        // view button
        function openReservation() {
            window.location.href = "<?= url('Reservation') ?>";
        }

        function showRentalDetails(rental) {

            document.getElementById('driver_license').textContent = rental.driver_license;
            document.getElementById('name').textContent = rental.first_name +  ", " + rental.last_name;
            document.getElementById('email').textContent = rental.email;
            document.getElementById('phone').textContent = rental.phone;
            document.getElementById('car_name').textContent = rental.car_name;
            document.getElementById('plate_number').textContent = rental.plate_number;
            document.getElementById('brand').textContent = rental.brand;
            document.getElementById('car_type').textContent = rental.car_type;
            document.getElementById('rental_start').textContent = rental.rental_start;
            document.getElementById('rental_end').textContent = rental.rental_end;
            document.getElementById('fuel_level_out').textContent = rental.fuel_level_out;
            document.getElementById('odometer_out').textContent = rental.odometer_out;
            document.getElementById('total_amount').textContent = rental.total_amount;
            

            document.getElementById('rental_details').style.display = 'block';
        }

        function closeRentalDetails() {
            document.getElementById('rental_details').style.display = 'none';
            currentReservation = null;
        }


        // return button
        function showRentalReturn(rental) {

            document.getElementById('driver_license_return').textContent = rental.driver_license;
            document.getElementById('name_return').textContent = rental.first_name +  ", " + rental.last_name;
            document.getElementById('email_return').textContent = rental.email;
            document.getElementById('phone_return').textContent = rental.phone;
            document.getElementById('car_name_return').textContent = rental.car_name;
            document.getElementById('plate_number_return').textContent = rental.plate_number;
            document.getElementById('brand_return').textContent = rental.brand;
            document.getElementById('car_type_return').textContent = rental.car_type;
            document.getElementById('rental_start_return').textContent = rental.rental_start;
            document.getElementById('rental_end_return').textContent = rental.rental_end;
            document.getElementById('fuel_level_out_return').textContent = rental.fuel_level_out;
            document.getElementById('odometer_out_return').textContent = rental.odometer_out;
            document.getElementById('total_amount_return').textContent = rental.total_amount;
            

            document.getElementById('rental_return').style.display = 'block';
        }

        function closeRentalReturn() {
            document.getElementById('rental_return').style.display = 'none';
            currentReservation = null;
        }
    </script>

   <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
</script>
</body>
</html>
