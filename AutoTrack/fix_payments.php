<?php
/**
 * AutoTrack Payment Records Fixer - Web Version
 * Access via: http://localhost:3040/fix_payments.php
 */

define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'web');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$mysqli->set_charset('utf8mb4');

if ($mysqli->connect_error) {
    die("<h2>❌ Connection failed</h2><p>" . $mysqli->connect_error . "</p>");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Records Fixer</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 800px; margin: 0 auto; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .status { padding: 15px; margin: 15px 0; border-radius: 4px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .section { margin: 20px 0; padding: 15px; background: #f8f9fa; border-left: 4px solid #007bff; }
        code { background: #f5f5f5; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 AutoTrack Payment Records Fixer</h1>
        
        <div class="status success">
            ✅ Database connection successful
        </div>
        
        <?php
        // Step 1: Fix paid_amount
        $update1 = $mysqli->query("UPDATE payments SET paid_amount = amount WHERE (paid_amount = 0 OR paid_amount IS NULL) AND amount > 0");
        if ($update1) {
            echo '<div class="status success">✅ Step 1: Fixed paid_amount values</div>';
        }
        
        // Step 2: Fix reservation_id
        $update2 = $mysqli->query("UPDATE payments p SET p.reservation_id = (SELECT r.reservation_id FROM rentals r WHERE r.rental_id = p.rental_id LIMIT 1) WHERE p.rental_id > 0 AND (p.reservation_id IS NULL OR p.reservation_id = 0)");
        if ($update2) {
            echo '<div class="status success">✅ Step 2: Fixed reservation_id references</div>';
        }
        
        // Verification
        $result = $mysqli->query("SELECT COUNT(*) as count FROM payments");
        $row = $result->fetch_assoc();
        ?>
        
        <div class="section">
            <h3>📊 Verification Results</h3>
            <p><strong>Total payment records:</strong> <?php echo $row['count']; ?></p>
            
            <?php
            $result = $mysqli->query("SELECT COUNT(*) as count FROM payments WHERE paid_amount > 0");
            $row = $result->fetch_assoc();
            echo "<p><strong>Records with paid_amount > 0:</strong> " . $row['count'] . "</p>";
            
            $result = $mysqli->query("SELECT COUNT(*) as count FROM payments WHERE reservation_id IS NOT NULL");
            $row = $result->fetch_assoc();
            echo "<p><strong>Records linked to reservation:</strong> " . $row['count'] . "</p>";
            ?>
        </div>
        
        <div class="section">
            <h3>✨ Success!</h3>
            <p>The payment records have been fixed. Now verify it works:</p>
            <ol>
                <li>Go to <a href="/dashboard" target="_blank">Dashboard</a></li>
                <li>Click "View" on any reservation</li>
                <li>Check that "Amount Paid" shows the correct amount (not ₱0.00)</li>
            </ol>
        </div>
        
        <div class="section">
            <h3>📝 Sample Records (First 5)</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="background: #e9ecef; border-bottom: 1px solid #ddd;">
                    <th style="padding: 8px; text-align: left;">Payment ID</th>
                    <th style="padding: 8px; text-align: left;">Rental ID</th>
                    <th style="padding: 8px; text-align: left;">Amount</th>
                    <th style="padding: 8px; text-align: left;">Paid Amount</th>
                    <th style="padding: 8px; text-align: left;">Reservation ID</th>
                    <th style="padding: 8px; text-align: left;">Status</th>
                </tr>
                <?php
                $result = $mysqli->query("SELECT payment_id, rental_id, amount, paid_amount, reservation_id, payment_status FROM payments LIMIT 5");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='border-bottom: 1px solid #ddd;'>";
                        echo "<td style='padding: 8px;'>" . ($row['payment_id'] ?? 'N/A') . "</td>";
                        echo "<td style='padding: 8px;'>" . ($row['rental_id'] ?? 'N/A') . "</td>";
                        echo "<td style='padding: 8px;'>₱" . ($row['amount'] ?? '0') . "</td>";
                        echo "<td style='padding: 8px;'><strong>₱" . ($row['paid_amount'] ?? '0') . "</strong></td>";
                        echo "<td style='padding: 8px;'>" . ($row['reservation_id'] ?? 'NULL') . "</td>";
                        echo "<td style='padding: 8px;'>" . ($row['payment_status'] ?? 'N/A') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='padding: 8px;'>No records found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php
$mysqli->close();
?>
