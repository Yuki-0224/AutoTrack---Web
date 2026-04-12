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
        <label class="box-label">Add New Renatal</label>

        <form action="<?= url('save-rental') ?>" method="post" enctype="multipart/form-data" class="div-panel">
            <?= csrf_field() ?>

            <label for="">Customer Info</label>

            <div class="form-grid">
                
                <div class="input-wrapper">
                    <label for="description">Last Name</label>
                    <input type="text" name="last_name" id="lastNameInput" placeholder="Last Name" autocomplete="off">


                    <div id="nameList" class="dropdown-list"></div>
                </div>

                <div class="input-wrapper">
                    <label for="description">First Name</label>
                    <input type="text" name="first_name" id="firstNameInput" placeholder="First Name">
                </div>
                
                <div class="input-wrapper">
                    <label for="description">Driver License</label>
                    <input type="text" name="driver_license" id="licenseInput" placeholder="Driver License">
                </div>

                <div class="input-wrapper">
                    <label for="description">Address</label>
                    <input type="text" name="address" id="AddressInput" placeholder="Address">
                </div>

                <div class="input-wrapper">
                    <label for="description">Email</label>
                    <input type="text" name="email" id="EmailInput" placeholder="Email">
                </div>

                <div class="input-wrapper">
                    <label for="description">Contact Number</label>
                    <input type="text" name="contact_num" id="ContactInput" placeholder="Contact Number">
                </div>

                <hr  style="margin-top:1rem; grid-column:1/-1;">

                <label for="" style="margin-top:1rem; grid-column:1/-1;">Car Info</label>

                <div class="input-wrapper">
                    <label for="description">Plate Number</label>
                    <input type="text" name="plate_number" id="plate_numberInput" placeholder="Plate Number" autocomplete="off">
                    <div id="carList" class="dropdown-list"></div>
                </div>

                <div class="input-wrapper">
                    <label for="description">Car Name</label>
                    <input type="text" name="car_name" id="NameInput" placeholder="Car Name">
                </div>

                <div class="input-wrapper">
                    <label for="description">Brand</label>
                    <input type="text" name="brand" id="BrandInput" placeholder="Brand">
                </div>

                <div class="input-wrapper">
                    <label for="description">Model</label>
                    <input type="text" name="model" id="ModelInput" placeholder="Model">
                </div>

                <div class="input-wrapper">
                    <label for="description">Year</label>
                    <input type="text" name="year" id="YearInput" placeholder="Year">
                </div>

                <div class="input-wrapper">
                    <label for="description">Car Type</label>
                    <input type="text" name="car_type" id="CarTypeInput" placeholder="Car Type">
                </div>

                <div class="input-wrapper">
                    <label for="description">Color</label>
                    <input type="text" name="color" id="ColorInput" placeholder="Color">
                </div>

                <div class="input-wrapper">
                    <label for="description">Price Per Day</label>
                    <input type="text" name="price_per_day" id="PricePerDayInput" placeholder="Price Per Day">
                </div>

                <hr  style="margin-top:1rem; grid-column:1/-1;">

                <label for="" style="margin-top:1rem; grid-column:1/-1;">Transaction Info</label>

                <div class="div_date_rent">
                    <div class="input-wrapper">
                        <label>Date Rental Start</label>
                        <input type="datetime-local" name="date_rental_start">
                    </div>

                    <div class="input-wrapper">
                        <label>Date Rental End</label>
                        <input type="datetime-local" name="date_rental_end">
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
