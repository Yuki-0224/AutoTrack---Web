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
                    <th class="car-table-header">Date supposed to return</th>
                    <th class="car-table-header">blanck</th>
                    <th class="car-table-header">Action</th>
                </tr>
                <tr>
                    <td class="car-table-cell"></td>
                    <td class="car-table-cell"></td>
                    <td class="car-table-cell"></td>
                    <td class="car-table-cell"></td>
                    <td class="car-table-cell"></td>
                    <td class="car-table-cell">
                        <button>View    </button>
                        <button>Return</button>
                    </td>
                </tr>
            </table>
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
