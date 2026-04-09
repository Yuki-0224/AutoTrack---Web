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
        $row = db()->table('cars')->where('car_id', segment(2))->get();
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
        <label class="box-label">Update Car</label>

        <form action="<?= url('edit_car/' . $row['car_id'])?>" method="post" enctype="multipart/form-data" class="div-panel">
            <?= csrf_field() ?>
            <div class="form-grid">
                <div class="input-wrapper">
                    <label for="description">Car Name</label>
                    <input type="text" name="car_name" placeholder="Car Name" value="<?= esc($row['car_name'])?>" >
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="brand" placeholder="Car Brand" value="<?= esc($row['brand'])?>" >
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="car_type_update" id="" placeholder="Enter car type" value="<?= esc($row['car_type'])?>" >
                </div>
                
                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="model" placeholder="Car Model" value="<?= esc($row['model'])?>" >
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="year" placeholder="Year" value="<?= esc($row['year'])?>" >
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="plate_number" placeholder="Plate Number" value="<?= esc($row['plate_number'])?>" >
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="color" placeholder="Color" value="<?= esc($row['color'])?>" >
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="price_per_day" id="price" placeholder="Price per Day (₱)" value="<?= esc($row['price_per_day'])?>" >
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" placeholder="Enter car description" class="desc"> <?= esc($row['description'])?></textarea>
                </div>

                <div class="input-wrapper">
                    <label for="description">Description</label>
                    <input type="text" name="existing_image" value="<?= esc($row['image']) ?>">
                </div>
            </div>                              
            <button type="submit" class="ac-btn">Update Car</button>
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
