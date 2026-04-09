<?php
/**
 * Debug Payment Records for Reservation #RES-012
 */

$mysqli = new mysqli('localhost', 'root', '', 'web');
$mysqli->set_charset('utf8mb4');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug Payment Records</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 1000px; margin: 0 auto; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: bold; }
        tr:hover { background: #f5f5f5; }
        .section { margin: 30px 0; padding: 20px; background: #f8f9fa; border-left: 4px solid #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Payment Debug Report - Reservation #RES-012</h1>
        
        <div class="section">
            <h3>All Payments for Reservation ID = 12</h3>
            <table>
                <tr>
                    <th>Payment ID</th>
                    <th>Rental ID</th>
                    <th>Amount</th>
                    <th>Paid Amount</th>
                    <th>Reservation ID</th>
                    <th>Payment Status</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                </tr>
                <?php
                $result = $mysqli->query("
                    SELECT p.* 
                    FROM payments p
                    WHERE p.reservation_id = 12
                    ORDER BY p.payment_id DESC
                ");
                
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . ($row['payment_id'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($row['rental_id'] ?? 'N/A') . "</td>";
                        echo "<td>₱" . ($row['amount'] ?? '0') . "</td>";
                        echo "<td><strong>₱" . ($row['paid_amount'] ?? '0') . "</strong></td>";
                        echo "<td>" . ($row['reservation_id'] ?? 'NULL') . "</td>";
                        echo "<td>" . ($row['payment_status'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($row['payment_method'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($row['payment_date'] ?? 'N/A') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No payments found</td></tr>";
                }
                ?>
            </table>
        </div>
        
        <div class="section">
            <h3>Total Paid Calculation (Query)</h3>
            <?php
            $result = $mysqli->query("
                SELECT 
                    SUM(COALESCE(p.paid_amount, p.amount, 0)) as total_paid,
                    COUNT(*) as payment_count
                FROM payments p
                WHERE p.reservation_id = 12
            ");
            
            if ($result) {
                $row = $result->fetch_assoc();
                echo "<p><strong>Total Paid (from database SUM):</strong> ₱" . ($row['total_paid'] ?? '0') . "</p>";
                echo "<p><strong>Number of payments:</strong> " . ($row['payment_count'] ?? '0') . "</p>";
            }
            ?>
        </div>
        
        <div class="section">
            <h3>Reservation & Rental Info</h3>
            <?php
            $result = $mysqli->query("
                SELECT r.*, c.brand, c.model, c.price_per_day
                FROM reservations r
                LEFT JOIN cars c ON r.car_id = c.car_id
                WHERE r.reservation_id = 12
            ");
            
            if ($result) {
                $res = $result->fetch_assoc();
                echo "<p><strong>Reservation ID:</strong> " . ($res['reservation_id'] ?? 'N/A') . "</p>";
                echo "<p><strong>Vehicle:</strong> " . (($res['brand'] ?? '') . ' ' . ($res['model'] ?? '')) . "</p>";
                echo "<p><strong>Daily Rate:</strong> ₱" . ($res['price_per_day'] ?? '0') . "</p>";
                echo "<p><strong>Pickup Date:</strong> " . ($res['pickup_date'] ?? 'N/A') . "</p>";
                echo "<p><strong>Return Date:</strong> " . ($res['return_date'] ?? 'N/A') . "</p>";
                
                // Calculate days
                if (isset($res['pickup_date']) && isset($res['return_date'])) {
                    $pickup = new DateTime($res['pickup_date']);
                    $return = new DateTime($res['return_date']);
                    $days = $return->diff($pickup)->days;
                    $subtotal = ($res['price_per_day'] ?? 0) * $days;
                    $tax = $subtotal * 0.10;
                    $total = $subtotal + $tax;
                    
                    echo "<p><strong>Duration:</strong> " . $days . " days</p>";
                    echo "<p><strong>Subtotal:</strong> ₱" . number_format($subtotal, 2) . "</p>";
                    echo "<p><strong>Tax (10%):</strong> ₱" . number_format($tax, 2) . "</p>";
                    echo "<p><strong>Total Amount:</strong> ₱" . number_format($total, 2) . "</p>";
                }
            }
            ?>
        </div>
        
        <div class="section">
            <h3>Related Rentals</h3>
            <table>
                <tr>
                    <th>Rental ID</th>
                    <th>Reservation ID</th>
                    <th>Rental Start</th>
                    <th>Rental End</th>
                    <th>Status</th>
                </tr>
                <?php
                $result = $mysqli->query("
                    SELECT rental_id, reservation_id, rental_start, rental_end, rental_status
                    FROM rentals
                    WHERE reservation_id = 12
                ");
                
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['rental_id'] . "</td>";
                        echo "<td>" . $row['reservation_id'] . "</td>";
                        echo "<td>" . $row['rental_start'] . "</td>";
                        echo "<td>" . $row['rental_end'] . "</td>";
                        echo "<td>" . $row['rental_status'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No rentals found</td></tr>";
                }
                ?>
            </table>
        </div>
        
        <div class="section">
            <h3>Dashboard Query Result</h3>
            <?php
            $result = $mysqli->query("
                SELECT r.*, c.brand, c.model, c.price_per_day,
                       COALESCE(p.total_paid, 0) as paid_amount,
                       p.payment_status
                FROM reservations r
                LEFT JOIN cars c ON r.car_id = c.car_id
                LEFT JOIN (
                    SELECT rt.reservation_id, SUM(COALESCE(pay.paid_amount, pay.amount, 0)) as total_paid, pay.payment_status
                    FROM rentals rt
                    LEFT JOIN payments pay ON rt.rental_id = pay.rental_id
                    GROUP BY rt.reservation_id
                ) p ON r.reservation_id = p.reservation_id
                WHERE r.reservation_id = 12
            ");
            
            if ($result) {
                $row = $result->fetch_assoc();
                echo "<p><strong>Reservation ID:</strong> #RES-" . str_pad($row['reservation_id'], 3, '0', STR_PAD_LEFT) . "</p>";
                echo "<p><strong>Paid Amount (from dashboard query):</strong> ₱" . ($row['paid_amount'] ?? '0') . "</p>";
                echo "<p><strong>Payment Status:</strong> " . ($row['payment_status'] ?? 'N/A') . "</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
<?php
$mysqli->close();
?>
