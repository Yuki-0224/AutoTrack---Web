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
      $rows = db()->table('cars')->select('car_type')->get_all();
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
        <label class="box-label">Add New Renatal</label>

        <form action="<?= url('add_new_car') ?>" method="post" enctype="multipart/form-data" class="div-panel">
            <?= csrf_field() ?>
            <div class="form-grid">
                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="car_name" placeholder="Car Name">
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="brand" placeholder="Car Brand">
                </div>
                
                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <div class="car-type-container">
                        <select name="car_type" id="car_type">
                            <option value="">-- Select Car Type --</option>
                            <?php foreach ($rows as $row): ?>
                                <option value="<?= htmlspecialchars($row['car_type']) ?>"> <?= htmlspecialchars($row['car_type']) ?> </option>
                            <?php endforeach; ?>
                            <option value="other">Other</option>
                        </select>

                        <input type="text" name="car_type_other" id="car_type_other" placeholder="Enter car type">
                    </div>
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="model" placeholder="Car Model">
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="year" placeholder="Year">
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="plate_number" placeholder="Plate Number">
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="color" placeholder="Color">
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="price_per_day" id="price" placeholder="Price per Day (₱)">
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" placeholder="Enter car description" class="desc"></textarea>
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="file" name="image" id="imageInput">
                </div>
            </div>                              
            <button type="submit" class="ac-btn">Add Car</button>
        </form>
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
