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
        role VARCHAR(15) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    $user = db()->table('users')
        ->select('id,name,email,password,role')
        ->where('email', '=', $email)
        ->get();


    if (!$user || !password_verify($password, $user['password'])) {
        set_flash('error', 'Invalid email or password.');
        header('Location: ' . url('login'));
        exit;
    }

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],    
        'email' => $user['email'],
        'role' => $user['role'],
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

    if ($name === '' || $email === '' || $password === '' || $confirm === '') {
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
        'role' => "user",
    ]);

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $userId,
        'name' => $name,
        'email' => $email,
    ];

    header('Location: ' . url('dashboard'));
    exit;
})->middleware('guest');

$router->get('dashboard', 'app/views/pages/dashboard')->middleware('auth');

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
        'image'    => trim($_POST['existing_image'])
    ];

   foreach ($data as $value) {
        if (empty($value)) {
            set_flash('error', 'All fields are required.');
            header('Location: ' . url('manage_car'));
            exit;
        }
    }   

    $res = db()->table('cars')->where('car_id', segment(2))->update($data);
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

