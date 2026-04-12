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
            <a href="<?= url('manage_car') ?>" class="nav-link nav-link-focus"> Manage Cars </a>
            <a href="" class="nav-link"> Manage Reservation </a>
            <a href="<?= url('manage_rental') ?>" class="nav-link"> Manage Rentals </a>
            <a href="#contact" class="nav-link"> Manage Payments </a>
            <a href="#contact" class="nav-link"> Manage Maintenance </a>
            <a href="#contact" class="nav-link"> Manage Damage </a>    
        </nav>
    </div>
    <div class="div-admin-dash">
        <label class="box-label">Manage Cars</label>

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
                <button class="add_btn" onclick="window.location.href='<?= url('add_new_car') ?>'">Add New Car</button>
            </div>
            <div class="table-container">
                <?php if (!empty($results)): ?>
                    <table class="car-table">
                        <tr class="car-table-row">
                            <th class="car-table-header">Car Name</th>
                            <th class="car-table-header">Brand</th>
                            <th class="car-table-header">Car Type</th>
                            <th class="car-table-header">Plate Number</th>
                            <th class="car-table-header">Color</th>
                            <th class="car-table-header">Price Per Day</th>
                            <th class="car-table-header">Status</th>
                            <th class="car-table-header">Actions</th>
                        </tr>
                        <?php foreach ($results as $car): ?>
                            <tr>
                                <td class="car-table-cell"><?= htmlspecialchars(esc($car['car_name'])) ?></td>
                                <td class="car-table-cell"><?= htmlspecialchars(esc($car['brand'])) ?></td>
                                <td class="car-table-cell"><?= htmlspecialchars(esc($car['car_type'])) ?></td>
                                <td class="car-table-cell"><?= htmlspecialchars(esc($car['plate_number'])) ?></td>
                                <td class="car-table-cell"><?= htmlspecialchars(esc($car['color'])) ?></td>
                                <td class="car-table-cell"><?= htmlspecialchars(esc($car['price_per_day'])) ?></td>
                                <td class="car-table-cell"><?= htmlspecialchars(esc($car['status'])) ?></td>
                                <td class="car-table-cell action-cell">
                                    <a href="<?= url('/edit_car/'.esc($car['car_id'])) ?>" class="btn btn-edit">Edit</a>
                                    <a href="<?= url('/delete_car/'.esc($car['car_id'])) ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>   
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No results found.</p>
                <?php endif; ?>
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
