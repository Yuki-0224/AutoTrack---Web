<?php
/**
 * All routes here
 */

$router->get('/', 'app/views/pages/index');

$router->get('login', 'app/views/pages/login')->middleware('guest');
$router->post('login', function () {
    $email = trim(strtolower($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        set_flash('error', 'Please enter both email and password.');
        header('Location: ' . url('login'));
        exit;
    }

    db()->raw("CREATE TABLE IF NOT EXISTS users (
        user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(15) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    $user = db()->table('users')
        ->select('id,name,email,password')
        ->where('email', '=', $email)
        ->get();


    if (!$user || !password_verify($password, $user['password'])) {
        set_flash('error', 'Invalid email or password.');
        header('Location: ' . url('login'));
        exit;
    }

    // Get customer details
    $customer = null;
    try {
        $customer = db()->table('customers')
            ->where('user_id', '=', $user['user_id'])
            ->get();
    } catch (Exception $e) {
        // Customer record might not exist
    }

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
    ];

    if ($user['role'] === 'admin') {
        $_SESSION['user'];
        header('Location: ' . url('admin_dashboard'));
    } else {
        header('Location: ' . url('dashboard'));
    }

    exit;


})->middleware('guest');

$router->get('register', 'app/views/pages/register')->middleware('guest');
$router->post('register', function () {
    $name = trim($_POST['name'] ?? '');
    $email = trim(strtolower($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['password_confirmation'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $driver_license = trim($_POST['driver_license'] ?? '');

    if ($name === '' || $email === '' || $password === '' || $confirm === '' || $first_name === '' || $last_name === '' || $phone === '' || $address === '' || $driver_license === '') {
        set_flash('error', 'All fields are required to create a new account.');
        header('Location: ' . url('register'));
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        set_flash('error', 'Please provide a valid email address.');
        header('Location: ' . url('register'));
        exit;
    }

    if ($password !== $confirm) {
        set_flash('error', 'Passwords do not match.');
        header('Location: ' . url('register'));
        exit;
    }

    db()->raw("CREATE TABLE IF NOT EXISTS users (
        user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    db()->raw("CREATE TABLE IF NOT EXISTS customers (
        customer_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NOT NULL,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        address TEXT NOT NULL,
        driver_license VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    $existing = db()->table('users')
        ->select('user_id')
        ->where('email', '=', $email)
        ->get();

    if ($existing) {
        set_flash('error', 'That email is already registered.');
        header('Location: ' . url('register'));
        exit;
    }

    $userId = db()->table('users')->insert([
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ]);

    // Insert customer details
    $customerId = db()->table('customers')->insert([
        'user_id' => $userId,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'driver_license' => $driver_license,
    ]);

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $userId,
        'customer_id' => $customerId,
        'name' => $name,
        'email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
    ];

    header('Location: ' . url('dashboard'));
    exit;
})->middleware('guest');

$router->get('dashboard', 'app/views/pages/dashboard')->middleware('auth');

$router->get('Reservation', 'app/views/pages/reservation')->middleware('auth');
$router->get('car-info', 'app/views/pages/car_info')->middleware('auth');
$router->get('car-reservation', 'app/views/pages/car_reservation')->middleware('auth');
$router->post('save-reservation', function () {
    $customer_id = $_SESSION['user']['customer_id'] ?? $_SESSION['user']['id'];
    $car_id = $_POST['car_id'] ?? 0;
    $pickup_date = $_POST['pickup_date'] ?? '';
    $return_date = $_POST['return_date'] ?? '';
    $pickup_location = $_POST['pickup_location'] ?? '';
    $dropoff_location = $_POST['dropoff_location'] ?? '';
    $total_amount = $_POST['total_amount'] ?? 0;

    if ($car_id && $pickup_date && $return_date) {
        // Create reservation
        $resId = db()->table('reservations')->insert([
            'customer_id' => $customer_id,
            'car_id' => $car_id,
            'pickup_date' => $pickup_date,
            'return_date' => $return_date,
            'pickup_location' => $pickup_location,
            'dropoff_location' => $dropoff_location,
            'reservation_status' => 'Pending'
        ]);

        // Update car status to "Not Available"
        db()->table('cars')->where('car_id', '=', $car_id)->update(['status' => 'Not Available']);

        set_flash('success', 'Reservation created successfully!');
        header('Location: ' . url('payment') . '?car_id=' . $car_id . '&total=' . $total_amount . '&reservation_id=' . $resId);
        exit;
    }
    set_flash('error', 'Failed to create reservation.');
    header('Location: ' . url('dashboard'));
    exit;
})->middleware('auth');

$router->post('cancel-reservation', function () {
    $reservation_id = $_POST['reservation_id'] ?? 0;
    $customer_id = $_SESSION['user']['customer_id'] ?? $_SESSION['user']['id'];

    if ($reservation_id) {
        // Get reservation to find car_id
        $reservation = db()->table('reservations')
            ->where('reservation_id', '=', $reservation_id)
            ->where('customer_id', '=', $customer_id)
            ->get();

        if ($reservation) {
            // Delete all related payments
            db()->raw("DELETE FROM payments WHERE reservation_id = ? OR rental_id IN (SELECT rental_id FROM rentals WHERE reservation_id = ?)", [$reservation_id, $reservation_id]);

            // Delete all related rentals
            db()->table('rentals')->where('reservation_id', '=', $reservation_id)->delete();

            // Delete reservation
            db()->table('reservations')->where('reservation_id', '=', $reservation_id)->delete();

            // Set car status back to "Available"
            db()->table('cars')->where('car_id', '=', $reservation['car_id'])->update(['status' => 'Available']);

            http_response_code(200);
            echo json_encode(['success' => true]);
        }
    }
    http_response_code(400);
    echo json_encode(['success' => false]);
})->middleware('auth');

$router->get('payment', 'app/views/pages/payment')->middleware('auth');

$router->post('process-payment', function () {
    $reservation_id = $_POST['reservation_id'] ?? 0;
    $car_id = $_POST['car_id'] ?? 0;
    $payment_method = $_POST['payment_method'] ?? '';
    $payment_amount = (float)($_POST['payment_amount'] ?? 0);
    $total_amount = (float)($_POST['total_amount'] ?? 0);

    if (!$reservation_id || !$car_id || !$payment_method || $payment_amount <= 0) {
        set_flash('error', 'Invalid payment information.');
        header('Location: ' . url('dashboard'));
        exit;
    }

    try {
        // Get reservation details
        $reservation = db()->table('reservations')
            ->where('reservation_id', '=', $reservation_id)
            ->get();

        if (!$reservation) {
            set_flash('error', 'Reservation not found.');
            header('Location: ' . url('dashboard'));
            exit;
        }

        // Check if rental already exists for this reservation
        $existingRental = db()->table('rentals')
            ->where('reservation_id', '=', $reservation_id)
            ->get();

        $rentalId = null;
        
        if ($existingRental) {
            // Rental exists, use it
            $rentalId = $existingRental['rental_id'];
        } else {
            // Create new rental record
            $rentalId = db()->table('rentals')->insert([
                'customer_id' => $reservation['customer_id'],
                'car_id' => $car_id,
                'reservation_id' => $reservation_id,
                'rental_start' => $reservation['pickup_date'],
                'rental_end' => $reservation['return_date'],
                'rental_status' => 'Pending'
            ]);
        }

        // Check if payment already exists for this rental
        $existingPayment = db()->table('payments')
            ->where('rental_id', '=', $rentalId)
            ->get();

        if ($existingPayment) {
            // Update existing payment - add the new amount to the existing amount
            $newAmount = floatval($existingPayment['amount']) + $payment_amount;
            $newPaidAmount = floatval($existingPayment['paid_amount']) + $payment_amount;
            
            db()->table('payments')
                ->where('payment_id', '=', $existingPayment['payment_id'])
                ->update([
                    'amount' => $newAmount,
                    'paid_amount' => $newPaidAmount,
                    'payment_method' => $payment_method,
                    'payment_status' => ($newAmount >= $total_amount) ? 'Fully Paid' : 'Partial Payment',
                    'payment_date' => date('Y-m-d')
                ]);
        } else {
            // Create new payment record
            db()->table('payments')->insert([
                'rental_id' => $rentalId,
                'amount' => $payment_amount,
                'paid_amount' => $payment_amount,
                'payment_date' => date('Y-m-d'),
                'payment_method' => $payment_method,
                'payment_status' => ($payment_amount >= $total_amount) ? 'Fully Paid' : 'Partial Payment',
                'reservation_id' => $reservation_id
            ]);
        }

        // Get total paid amount to check reservation status
        $totalPaid = db()->raw("SELECT SUM(COALESCE(paid_amount, 0)) as total FROM payments WHERE rental_id = ?", [$rentalId]);
        $totalPaidRow = $totalPaid->fetch(PDO::FETCH_ASSOC);
        $totalPaidAmount = floatval($totalPaidRow['total'] ?? 0);
        $isFullPayment = ($totalPaidAmount >= $total_amount);

        // Update reservation status
        db()->table('reservations')
            ->where('reservation_id', '=', $reservation_id)
            ->update([
                'reservation_status' => $isFullPayment ? 'Confirmed' : 'Pending'
            ]);

        // Update rental status
        if ($isFullPayment) {
            db()->table('rentals')
                ->where('rental_id', '=', $rentalId)
                ->update(['rental_status' => 'Active']);
        }

        set_flash('success', 'Payment processed successfully! ' . ($isFullPayment ? 'Full payment received.' : 'Down payment received. Balance due: ₱' . number_format($total_amount - $totalPaidAmount, 2)));
        header('Location: ' . url('dashboard'));
        exit;
    } catch (Exception $e) {
        set_flash('error', 'Payment processing failed: ' . $e->getMessage());
        header('Location: ' . url('dashboard'));
        exit;
    }
})->middleware('auth');

$router->get('logout', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_unset();
    session_destroy();
    header('Location: ' . url('login'));
    exit;
})->middleware('auth');


$router->get('Reservation', 'app/views/pages/reservation')->middleware('auth');

$router->get('admin_dashboard', 'app/views/pages/admin_dashboard')->middleware('auth');

$router->get('manage_car', 'app/views/pages/manage_car_page')->middleware('auth');
$router->get('manage_car', function($search_input){
    $rows = db()->table('cars')->where('car_id', $search_input)->get_all();
        if($rows){
                header('Location:'.url('manage_car/.rows[car_id]'));
                exit;
        }
});

$router->get('manage_rental', 'app/views/pages/manage_rental_page')->middleware('auth');

$router->get('add_new_car', 'app/views/pages/add_car');
$router->post('add_new_car', function(){
    $name = $_POST['car_name'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $model = $_POST['model'] ?? '';
    $year = $_POST['year'] ?? '';
    $type = '';
    if ($_POST['car_type'] === 'other') {
        $type = trim($_POST['car_type_other']);
    } else {
        $type = trim($_POST['car_type']);
    }
    $plate_num = $_POST['plate_number'] ?? '';
    $color = $_POST['color'] ?? '';
    $price_per_day = trim(str_replace(['₱', ','], '', $_POST['price_per_day'] ?? ''));
    $desc = $_POST['description'] ?? '';
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $image;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            set_flash('error', 'Failed to upload image.');
            header('Location: ' . url('add_new_car'));
            exit;
        }
    } else {
        set_flash('error', 'Car image is required.');
        header('Location: ' . url('add_new_car'));
        exit;
    }
    

    if ($name === '' || $brand === '' || $model === '' || $plate_num === '' || $color=='' || $price_per_day=='' || $image=='') {
        set_flash('error', 'All fields are required.');
        header('Location: ' . url('add_new_car'));
        exit;
    }

    db()->raw("CREATE TABLE IF NOT EXISTS cars (
        car_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        car_name VARCHAR(20) NOT NULL,
        brand VARCHAR(50) NOT NULL,
        model VARCHAR(50) NOT NULL,
        year INT NOT NULL,
        car_type VARCHAR(20) NOT NULL,
        plate_number VARCHAR(20) NOT NULL UNIQUE,
        color VARCHAR(30) NOT NULL,
        price_per_day DECIMAL(10,2) NOT NULL,
        status VARCHAR(20) DEFAULT 'Available',
        description VARCHAR(200) NOT NULL,
        image VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    $existing = db()->table('cars')
        ->select('car_id')
        ->where('plate_number', '=', $plate_num)
        ->get();    

    if ($existing) {
        set_flash('error', 'That car is already registered.');
        header('Location: ' . url('add_new_car'));
        exit;
    }

    db()->table('cars')->insert([
        'car_name' => $name,
        'brand' => $brand,
        'model' => $model,
        'year' => $year,
        'car_type' => $type,
        'plate_number' => $plate_num,
        'color' => $color,
        'price_per_day' => $price_per_day,
        'description' => $desc,
        'image' => $image
    ]);

    session_regenerate_id(true);
    set_flash('success', 'Car inserted successfully.');
    header('Location: ' . url('add_new_car'));
    exit;
});


$router->get('/edit_car/{car_id}', 'app/views/pages/update_car');
$router->post('edit_car/{car_id}', function($car_id){
    
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $imageName);
    } else {
        $imageName = $_POST['existing_image'];
    }

    $data = [
        'car_name'  => trim($_POST['car_name']),
        'brand' => trim($_POST['brand']),
        'model'      => trim($_POST['model']),
        'year'     => trim($_POST['year']),
        'car_type'    => trim($_POST['car_type_update']),
        'plate_number'    => trim($_POST['plate_number']),
        'color'    => trim($_POST['color']),
        'price_per_day'    => trim(str_replace(['₱', ','], '', $_POST['price_per_day'] ?? '')),
        'description'    => trim($_POST['description']),
        'image' => $imageName
    ];

    foreach ($data as $key => $value) {
        if ($key !== 'image' && empty($value)) {
            set_flash('error', 'All fields are required.');
            header('Location: ' . url('manage_car'));
            exit;
        }
    } 

    $res = db()->table('cars')->where('car_id', $car_id)->update($data);

    if($res) {
        header('Location:'.url('manage_car'));
        exit;
    }
});


$router->get('delete_car/{car_id}', function($car_id){
    $res = db()->table('cars')->where('car_id', $car_id)->delete();
        if($res){
            echo 'account delete';
            header('Location:'.url('manage_car'));
            exit;
        }
});

