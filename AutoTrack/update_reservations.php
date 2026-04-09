<?php
$mysqli = new mysqli('localhost', 'root', '', 'web');
$mysqli->set_charset('utf8mb4');

echo "Updating reservations with valid car IDs...\n";

// Delete old reservations
$mysqli->query("DELETE FROM reservations WHERE customer_id = 1");

// Insert with valid car IDs (7, 8, 9 exist)
$reservations = [
    "INSERT INTO reservations (customer_id, car_id, pickup_date, return_date, pickup_location, dropoff_location, reservation_status)
    VALUES (1, 7, '2026-04-15 10:00:00', '2026-04-18 10:00:00', 'Main Branch', 'Airport', 'Confirmed')",

    "INSERT INTO reservations (customer_id, car_id, pickup_date, return_date, pickup_location, dropoff_location, reservation_status)
    VALUES (1, 8, '2026-04-25 09:00:00', '2026-04-28 09:00:00', 'Main Branch', 'Hotel Downtown', 'Pending')",

    "INSERT INTO reservations (customer_id, car_id, pickup_date, return_date, pickup_location, dropoff_location, reservation_status)
    VALUES (1, 9, '2026-05-01 14:00:00', '2026-05-05 14:00:00', 'Airport', 'Main Branch', 'Confirmed')"
];

foreach ($reservations as $sql) {
    if ($mysqli->query($sql)) {
        echo "✓ Inserted reservation ID: " . $mysqli->insert_id . "\n";
    } else {
        echo "✗ Error: " . $mysqli->error . "\n";
    }
}

echo "\n=== FINAL CHECK ===\n";
$result = $mysqli->query("SELECT r.reservation_id, r.customer_id, r.pickup_date, r.return_date, r.reservation_status, c.brand, c.model
FROM reservations r
LEFT JOIN cars c ON r.car_id = c.car_id
WHERE r.customer_id = 1");

echo "Reservations for customer 1:\n";
while($row = $result->fetch_assoc()) {
    echo "  #{$row['reservation_id']}: {$row['brand']} {$row['model']} - {$row['reservation_status']}\n";
}

$mysqli->close();
echo "\nNow refresh your dashboard!\n";
?>
