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

    ?>

    <div class="div-sidenav">
        <nav class="sidenav">
            <a href="<?= url('admin_dashboard') ?>" class="nav-link"> OverView </a>
            <a href="<?= url('manage_car') ?>" class="nav-link"> Manage Cars </a>
            <a href="" class="nav-link"> Manage Reservation </a>
            <a href="<?= url('manage_rental') ?>" class="nav-link nav-link-focus"> Manage Rentals </a>
            <a href="#contact" class="nav-link"> Manage Payments </a>
            <a href="#contact" class="nav-link"> Manage Maintenance </a>
            <a href="#contact" class="nav-link"> Manage Damage </a>    
        </nav>
    </div>
    <div class="div-admin-dash">
        <label class="box-label">Manage Rental</label>
       
        <div class="div-panel">
            <div class="pick-container">
                <button onclick="" class="pick-btn">Customer</button>
                <button onclick="" class="pick-btn">Car</button>
                <button onclick="" class="pick-btn">last</button>
            </div>

            <div id="customer_div">
                <button><a href="">Create Account</a></button>
                <form action="">
                    <input type="text">
                    <button><a href=""></a></button>
                </form>
                <div>
                    <div>
                        <label for="customer_name">Name</label>
                        <input type="text">
                    </div>
                    <div>
                        <label for="customer_phone">Phone Number</label>
                        <input type="text">
                    </div>
                    <div>
                        <label for="customer_address">Address</label>
                        <input type="text">
                    </div>
                    <div>
                        <label for="customer_driver_license">Driver License</label>
                        <input type="text">
                    </div>
                </div>
            </div>

            <div id="car_div">
                

            </div>
        </div>
        

        

        
        
    </div>




   
    <script src="<?= base_url() ?>public/script/script.js"></script>


    <script>
        function openReservation() {
            window.location.href = "<?= url('Reservation') ?>";
        }
    </script>

   <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
</script>
</body>
</html>
