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

    $reserve_car = db()->table('reservations')
             ->select('customers.driver_license as driver_license, customers.first_name, customers.last_name, customers.email, customers.phone, customers.address, cars.car_name, cars.brand, cars.car_type, cars.plate_number, cars.model, cars.color, cars.price_per_day, reservations.pickup_date, reservations.return_date, reservations.reservation_id' )
             ->inner_join('customers', 'customers.customer_id = reservations.customer_id')
             ->inner_join('cars', 'cars.car_id = reservations.car_id')
             ->where('reservations.reservation_id', segment(2))
             ->get();
           

    ?>


    <div class="div-sidenav">
        <nav class="sidenav">
            <a href="<?= url('admin_dashboard') ?>" class="nav-link"> OverView </a>
            <a href="<?= url('manage_car') ?>" class="nav-link"> Manage Cars </a>
            <a href="<?= url('manage_reservation') ?>" class="nav-link"> Manage Reservation </a>
            <a href="<?= url('manage_rental') ?>" class="nav-link  nav-link-focus"> Manage Rentals </a>
            <a href="#contact" class="nav-link"> Manage Payments </a>
            <a href="#contact" class="nav-link"> Manage Maintenance </a>
            <a href="#contact" class="nav-link"> Manage Damage </a>    
        </nav>
    </div>
    <div class="div-admin-dash">
        <label class="box-label">Add New Renatal</label>

        <form action="<?= url('save-rental') ?>" method="post" enctype="multipart/form-data" class="div-panel">
            <?= csrf_field() ?>

            <label for="">Customer Info</label>

            <div class="form-grid">
                
                <div class="input-wrapper">
                    <label for="description">Last Name</label>
                    <input type="text" name="last_name" id="lastNameInput" placeholder="Last Name" autocomplete="off" value="<?= isset($reserve_car['last_name']) ? htmlspecialchars(esc($reserve_car['last_name'])) : '' ?>">


                    <div id="nameList" class="dropdown-list"></div>
                </div>

                <div class="input-wrapper">
                    <label for="description">First Name</label>
                    <input type="text" name="first_name" id="firstNameInput" placeholder="First Name" value="<?= isset($reserve_car['first_name']) ? htmlspecialchars(esc($reserve_car['first_name'])) : '' ?>">
                </div>
                
                <div class="input-wrapper">
                    <label for="description">Driver License</label>
                    <input type="text" name="driver_license" id="licenseInput" placeholder="Driver License" value="<?= isset($reserve_car['driver_license']) ? htmlspecialchars(esc($reserve_car['driver_license'])) : '' ?>">
                </div>

                <div class="input-wrapper">
                    <label for="description">Address</label>
                    <input type="text" name="address" id="AddressInput" placeholder="Address" value="<?= isset($reserve_car['address']) ? htmlspecialchars(esc($reserve_car['address'])) : '' ?>">
                </div>

                <div class="input-wrapper">
                    <label for="description">Email</label>
                    <input type="text" name="email" id="EmailInput" placeholder="Email" value="<?= isset($reserve_car['email']) ? htmlspecialchars(esc($reserve_car['email'])) : '' ?>">
                </div>

                <div class="input-wrapper">
                    <label for="description">Contact Number</label>
                    <input type="text" name="contact_num" id="ContactInput" placeholder="Contact Number" value="<?= isset($reserve_car['phone']) ? htmlspecialchars(esc($reserve_car['phone'])) : '' ?>">
                </div>

                <hr  style="margin-top:1rem; grid-column:1/-1;">

                <label for="" style="margin-top:1rem; grid-column:1/-1;">Car Info</label>

                <div class="input-wrapper">
                    <label for="description">Plate Number</label>
                    <input type="text" name="plate_number" id="plate_numberInput" placeholder="Plate Number" autocomplete="off" value="<?= isset($reserve_car['plate_number']) ? htmlspecialchars(esc($reserve_car['plate_number'])) : '' ?>">
                    <div id="carList" class="dropdown-list"></div>
                </div>

                <div class="input-wrapper">
                    <label for="description">Car Name</label>
                    <input type="text" name="car_name" id="NameInput" placeholder="Car Name" value="<?= isset($reserve_car['car_name']) ? htmlspecialchars(esc($reserve_car['car_name'])) : '' ?>">
                </div>

                <div class="input-wrapper">
                    <label for="description">Brand</label>
                    <input type="text" name="brand" id="BrandInput" placeholder="Brand" value="<?= isset($reserve_car['brand']) ? htmlspecialchars(esc($reserve_car['brand'])) : '' ?>">
                </div>

                <div class="input-wrapper">
                    <label for="description">Model</label>
                    <input type="text" name="model" id="ModelInput" placeholder="Model" value="<?= isset($reserve_car['model']) ? htmlspecialchars(esc($reserve_car['model'])) : '' ?>">
                </div>

                <div class="input-wrapper">
                    <label for="description">Year</label>
                    <input type="text" name="year" id="YearInput" placeholder="Year" value="<?= isset($reserve_car['year']) ? htmlspecialchars(esc($reserve_car['year'])) : '' ?>">
                </div>

                <div class="input-wrapper">
                    <label for="description">Car Type</label>
                    <input type="text" name="car_type" id="CarTypeInput" placeholder="Car Type" value="<?= isset($reserve_car['car_type']) ? htmlspecialchars(esc($reserve_car['car_type'])) : '' ?>">
                </div>

                <div class="input-wrapper">
                    <label for="description">Color</label>
                    <input type="text" name="color" id="ColorInput" placeholder="Color" value="<?= isset($reserve_car['color']) ? htmlspecialchars(esc($reserve_car['color'])) : '' ?>">
                </div>

                <div class="input-wrapper">
                    <label for="description">Price Per Day</label>
                    <input type="text" name="price_per_day" id="PricePerDayInput" placeholder="Price Per Day" value="<?= isset($reserve_car['price_per_day']) ? htmlspecialchars(esc($reserve_car['price_per_day'])) : '' ?>">
                </div>

                <hr  style="margin-top:1rem; grid-column:1/-1;">

                <label for="" style="margin-top:1rem; grid-column:1/-1;">Transaction Info</label>

                
                <div class="div_date_rent">
                    <div class="input-wrapper">
                        <label>Date Rental Start</label>
                        <input type="datetime-local" name="date_rental_start" value="<?= isset($reserve_car['pickup_date']) ? htmlspecialchars(esc($reserve_car['pickup_date'])) : '' ?>">
                    </div>

                    <div class="input-wrapper">
                        <label>Date Rental End</label>
                        <input type="datetime-local" name="date_rental_end" value="<?= isset($reserve_car['return_date']) ? htmlspecialchars(esc($reserve_car['return_date'])) : '' ?>">
                    </div>

                    <div class="input-wrapper">
                        <label>Days</label>
                        <input type="text" name="days">
                    </div>

                </div>

                <div class="input-wrapper">
                    <label for="description">Fuel Level</label>
                    <input type="text" name="fuel_level" placeholder="Fuel Level">
                </div>

                <div class="input-wrapper">
                    <label for="description">Odometer</label>
                    <input type="text" name="odometer" placeholder="Odometer">
                </div>

                <div class="input-wrapper" style="margin-top:1rem; grid-column:1/-1;">
                    <label for="description">Car Condition</label>
                    <textarea name="car_condition" placeholder="Enter car condition"></textarea>
                  
                </div>
                
                  <input for="" type="hidden" name="reservation_id" value="<?= isset($reserve_car['reservation_id']) ? htmlspecialchars(esc($reserve_car['reservation_id'])) : '' ?>">
                

            </div>                              
            <button type="submit" class="ac-btn">Go to Payment</button>
        </form>
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
