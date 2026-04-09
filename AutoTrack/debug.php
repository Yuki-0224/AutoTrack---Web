<?php
session_start();

// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'web');
$mysqli->set_charset('utf8mb4');

if ($mysqli->connect_error) {
    die("DB Error: " . $mysqli->connect_error);
}

echo "<h1>Debug Dashboard</h1>";

echo "<h2>1. Session Data</h2>";
echo "<pre>";
echo "User ID: " . ($_SESSION['user']['id'] ?? 'N/A') . "\n";
echo "Customer ID: " . ($_SESSION['user']['customer_id'] ?? 'N/A') . "\n";
echo "Name: " . ($_SESSION['user']['name'] ?? 'N/A') . "\n";
echo "</pre>";

echo "<h2>2. Cars in Database</h2>";
$result = $mysqli->query("SELECT COUNT(*) as total FROM cars");
$row = $result->fetch_assoc();
echo "<p>Total cars: " . $row['total'] . "</p>";

$result = $mysqli->query("
    SELECT car_id, brand, model, price_per_day
    FROM cars
    LIMIT 10
");
echo "<pre>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: {$row['car_id']}, {$row['brand']} {$row['model']}, \${$row['price_per_day']}/day\n";
    }
} else {
    echo "NO CARS FOUND!\n";
}
echo "</pre>";

echo "<h2>3. Customers</h2>";
$result = $mysqli->query("SELECT COUNT(*) as total FROM customers");
$row = $result->fetch_assoc();
echo "<p>Total customers: " . $row['total'] . "</p>";

$result = $mysqli->query("
    SELECT customer_id, user_id, first_name, last_name
    FROM customers
    LIMIT 5
");
echo "<pre>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Customer ID: {$row['customer_id']}, User ID: {$row['user_id']}, {$row['first_name']} {$row['last_name']}\n";
    }
} else {
    echo "NO CUSTOMERS FOUND!\n";
}
echo "</pre>";

echo "<h2>4. Reservations</h2>";
$result = $mysqli->query("SELECT COUNT(*) as total FROM reservations");
$row = $result->fetch_assoc();
echo "<p>Total reservations: " . $row['total'] . "</p>";

$customerId = $_SESSION['user']['customer_id'] ?? null;
if ($customerId) {
    echo "<p>Looking for reservations for Customer ID: $customerId</p>";
    $result = $mysqli->query("
        SELECT r.*, c.brand, c.model
        FROM reservations r
        LEFT JOIN cars c ON r.car_id = c.car_id
        WHERE r.customer_id = $customerId
    ");
    echo "<pre>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Reservation ID: {$row['reservation_id']}, Car: {$row['brand']} {$row['model']}, Status: {$row['reservation_status']}\n";
        }
    } else {
        echo "No reservations for this customer.\n";
    }
    echo "</pre>";
} else {
    echo "<p style='color: red;'>ERROR: No customer_id in session!</p>";
}

$mysqli->close();
?>
