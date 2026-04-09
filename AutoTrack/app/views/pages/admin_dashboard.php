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
            <a href="<?= url('admin_dashboard') ?>" class="nav-link nav-link-focus"> OverView </a>
            <a href="<?= url('manage_car') ?>" class="nav-link"> Manage Cars </a>
            <a href="" class="nav-link"> Manage Reservation </a>
            <a href="<?= url('manage_rental') ?>" class="nav-link"> Manage Rentals </a>
            <a href="#contact" class="nav-link"> Manage Payments </a>
            <a href="#contact" class="nav-link"> Manage Maintenance </a>
            <a href="#contact" class="nav-link"> Manage Damage </a>    
        </nav>
    </div>
    <div class="div-admin-dash">
        <label for="title" class="title-font">Quick Stats</label>
        <div class="div_summ">
            <div class="box">
                <label for="" class="box-label">Total Cars</label>
                <label for="" class="box-tot">150</label>
            </div>
            <div class="box">
                <label for="" class="box-label">Active Rentals</label>
                <label for="" class="box-tot">10</label>
            </div>
            <div class="box">
                <label for="" class="box-label">Prending</label>
                <label for="" class="box-label mt-9">Reservation</label>
                <label for="" class="box-tot">12</label>
            </div>
            <div class="box">
                <label for="" class="box-label">Revenue Today</label>
                <label for="" class="box-tot">100</label>
            </div>
        </div>
        <div class="div_recent">
            <div class="rec-div-table">
                <label for="" class="box-label">Recent Reservation</label>
                <table>
                    <tr>
                        <th class="rec-title">Reservation ID</th>
                        <th class="rec-title">Customer</th>
                        <th class="rec-title">Car</th>
                        <th class="rec-title">Status</th>
                    </tr>
                    <tr>
                        <td class="rec-data"></td>
                        <td class="rec-data"></td>
                        <td class="rec-data"></td>
                        <td class="rec-data"></td>
                    </tr>
                </table>
            </div>
            <div class="rec-div-table">
                <label for="" class="box-label">Recent Payments</label>
                <table>
                    <tr>
                        <th class="rec-title">Payment ID</th>
                        <th class="rec-title">Customer</th>
                        <th class="rec-title">Amount</th>
                        <th class="rec-title">Date</th>
                        <th class="rec-title">Status</th>
                    </tr>
                    <tr>
                        <td class="rec-data"></td>
                        <td class="rec-data"></td>
                        <td class="rec-data"></td>
                        <td class="rec-data"></td>
                        <td class="rec-data"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="quick-actions">
            <label class="box-label">Quick Actions</label>
            <div class="btn-grid">
                <button class="qa-btn" onclick="window.location.href='<?= url('add_new_car') ?>'">Add New Car</button>
                <button class="qa-btn">Process Reservation</button>
                <button class="qa-btn" >Add Maintenace Record</button>
                <button class="qa-btn">Issue Refund</button>
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
