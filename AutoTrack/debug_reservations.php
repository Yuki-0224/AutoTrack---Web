<?php
// Setup database connection
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'web');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$mysqli->set_charset('utf8mb4');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== USER ACCOUNTS ===\n";
$result = $mysqli->query("SELECT id, name, email FROM users");
while($row = $result->fetch_assoc()) {
    echo "ID: {$row['id']}, Name: {$row['name']}, Email: {$row['email']}\n";
}

echo "\n=== CUSTOMERS ===\n";
$result = $mysqli->query("SELECT * FROM customers");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Customer ID: {$row['customer_id']}, User ID: {$row['user_id']}, Name: {$row['first_name']} {$row['last_name']}\n";
    }
} else {
    echo "No customer records found\n";
}

echo "\n=== RESERVATIONS ===\n";
$result = $mysqli->query("SELECT r.*, c.brand, c.model FROM reservations r LEFT JOIN cars c ON r.car_id = c.car_id");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Reservation ID: {$row['reservation_id']}, Customer ID: {$row['customer_id']}, Car: {$row['brand']} {$row['model']}\n";
    }
} else {
    echo "No reservations found\n";
}

$mysqli->close();
?>
