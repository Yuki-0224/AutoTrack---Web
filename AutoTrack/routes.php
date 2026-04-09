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
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
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
            ->where('user_id', '=', $user['id'])
            ->get();
    } catch (Exception $e) {
        // Customer record might not exist
    }

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'customer_id' => $customer['customer_id'] ?? null,
    ];

    header('Location: ' . url('dashboard'));
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
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
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
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    $existing = db()->table('users')
        ->select('id')
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

    if ($car_id && $pickup_date && $return_date) {
        db()->table('reservations')->insert([
            'customer_id' => $customer_id,
            'car_id' => $car_id,
            'pickup_date' => $pickup_date,
            'return_date' => $return_date,
            'pickup_location' => $pickup_location,
            'dropoff_location' => $dropoff_location,
            'reservation_status' => 'Pending'
        ]);
        set_flash('success', 'Reservation created successfully!');
        header('Location: ' . url('payment') . '?car_id=' . $car_id);
        exit;
    }
    set_flash('error', 'Failed to create reservation.');
    header('Location: ' . url('dashboard'));
    exit;
})->middleware('auth');

$router->get('payment', 'app/views/pages/payment')->middleware('auth');

$router->get('logout', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_unset();
    session_destroy();
    header('Location: ' . url('login'));
    exit;
})->middleware('auth');
