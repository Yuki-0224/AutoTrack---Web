<?php
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

echo "Dropping old tables...\n";
$mysqli->query("DROP TABLE IF EXISTS reservations");
$mysqli->query("DROP TABLE IF EXISTS customers");

echo "Creating fixed tables...\n";

// Create customers table with proper AUTO_INCREMENT
$mysqli->query("CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    driver_license VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

// Create reservations table with proper AUTO_INCREMENT (no foreign keys for now)
$mysqli->query("CREATE TABLE reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    car_id INT NOT NULL,
    pickup_date DATETIME NOT NULL,
    return_date DATETIME NOT NULL,
    pickup_location VARCHAR(100),
    dropoff_location VARCHAR(100),
    reservation_status ENUM('Pending','Confirmed','Cancelled','Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

echo "Inserting customer for John Adrian Clapis (user_id 2)...\n";
$mysqli->query("INSERT INTO customers (user_id, first_name, last_name, email, phone, address, driver_license)
VALUES (2, 'John Adrian', 'Clapis', 'johnclapis24@gmail.com', '09123456789', '123 Main St', 'DL123456')");

$customerId = $mysqli->insert_id;
echo "Customer inserted with ID: $customerId\n";

echo "Inserting test reservations...\n";
$reservations = [
    "INSERT INTO reservations (customer_id, car_id, pickup_date, return_date, pickup_location, dropoff_location, reservation_status)
    VALUES ($customerId, 1, '2026-04-15 10:00:00', '2026-04-18 10:00:00', 'Main Branch', 'Airport', 'Confirmed')",

    "INSERT INTO reservations (customer_id, car_id, pickup_date, return_date, pickup_location, dropoff_location, reservation_status)
    VALUES ($customerId, 3, '2026-04-25 09:00:00', '2026-04-28 09:00:00', 'Main Branch', 'Hotel Downtown', 'Pending')",

    "INSERT INTO reservations (customer_id, car_id, pickup_date, return_date, pickup_location, dropoff_location, reservation_status)
    VALUES ($customerId, 5, '2026-05-01 14:00:00', '2026-05-05 14:00:00', 'Airport', 'Main Branch', 'Confirmed')"
];

foreach ($reservations as $sql) {
    if ($mysqli->query($sql)) {
        echo "✓ Reservation inserted (ID: " . $mysqli->insert_id . ")\n";
    } else {
        echo "✗ Error: " . $mysqli->error . "\n";
    }
}

echo "\n=== VERIFICATION ===\n";
$result = $mysqli->query("SELECT * FROM customers WHERE user_id = 2");
$cust = $result->fetch_assoc();
echo "Customer: {$cust['first_name']} {$cust['last_name']} (ID: {$cust['customer_id']})\n";

$result = $mysqli->query("SELECT r.*, c.brand, c.model FROM reservations r LEFT JOIN cars c ON r.car_id = c.car_id WHERE r.customer_id = {$cust['customer_id']}");
echo "Reservations: {$result->num_rows} found\n";
while($row = $result->fetch_assoc()) {
    echo "  - #{$row['reservation_id']}: {$row['brand']} {$row['model']} (Status: {$row['reservation_status']})\n";
}

$mysqli->close();
echo "\nDone! Refresh your dashboard to see reservations.\n";
?>
