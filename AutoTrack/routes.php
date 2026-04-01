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

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
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
