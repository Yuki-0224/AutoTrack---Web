<?php
$mysqli = new mysqli('localhost', 'root', '', 'web');
$mysqli->set_charset('utf8mb4');

echo "Cars in database:\n";
$result = $mysqli->query("SELECT car_id, brand, model FROM cars ORDER BY car_id LIMIT 10");
while($row = $result->fetch_assoc()) {
    echo "ID {$row['car_id']}: {$row['brand']} {$row['model']}\n";
}
$mysqli->close();
?>
