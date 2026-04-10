<?php
/**
 * CLI-based Payment Records Fixer
 * Run with: php fix_payments_cli.php
 * 
 * This script fixes existing payment records to have proper paid_amount values
 * and ensures reservation_id is properly linked
 */

// Show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "\n╔════════════════════════════════════════════════════════════╗\n";
echo "║          AutoTrack Payment Records Fixer (CLI)             ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Database Configuration
$db_config = [
    'host' => 'localhost',
    'port' => '3306',
    'name' => 'web',
    'user' => 'root',
    'pass' => ''
];

echo "📌 Connecting to database...\n";
echo "   Host: {$db_config['host']}\n";
echo "   Database: {$db_config['name']}\n\n";

try {
    $mysqli = new mysqli(
        $db_config['host'], 
        $db_config['user'], 
        $db_config['pass'], 
        $db_config['name']
    );
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    $mysqli->set_charset('utf8mb4');
    echo "✅ Connected successfully\n\n";
    
} catch (Exception $e) {
    echo "❌ Connection Error: " . $e->getMessage() . "\n";
    echo "\n⚠️  Troubleshooting:\n";
    echo "   1. Check if MySQL is running\n";
    echo "   2. Verify database credentials in fix_payments_cli.php\n";
    echo "   3. Make sure 'web' database exists\n";
    exit(1);
}

// Step 1: Check payments table
echo "📋 Step 1: Checking payments table...\n";

$result = $mysqli->query("SELECT COUNT(*) as count FROM payments");
if (!$result) {
    echo "❌ Error accessing payments table: " . $mysqli->error . "\n";
    exit(1);
}

$row = $result->fetch_assoc();
$total_payments = $row['count'];
echo "   Total payment records: $total_payments\n\n";

if ($total_payments === 0) {
    echo "⚠️  No payment records found. Nothing to fix.\n";
    $mysqli->close();
    exit(0);
}

// Step 2: Show current state
echo "📊 Step 2: Current state of payment records...\n";

$result = $mysqli->query("SELECT COUNT(*) as count FROM payments WHERE paid_amount = 0");
$row = $result->fetch_assoc();
echo "   Records with paid_amount = 0: {$row['count']}\n";

$result = $mysqli->query("SELECT COUNT(*) as count FROM payments WHERE paid_amount IS NULL");
$row = $result->fetch_assoc();
echo "   Records with paid_amount = NULL: {$row['count']}\n";

$result = $mysqli->query("SELECT COUNT(*) as count FROM payments WHERE reservation_id IS NULL");
$row = $result->fetch_assoc();
echo "   Records with reservation_id = NULL: {$row['count']}\n\n";

// Step 3: Fix paid_amount
echo "🔧 Step 3: Fixing paid_amount values...\n";

$update1 = $mysqli->query("UPDATE payments SET paid_amount = amount WHERE (paid_amount = 0 OR paid_amount IS NULL) AND amount > 0");
if (!$update1) {
    echo "❌ Error updating paid_amount: " . $mysqli->error . "\n";
    $mysqli->close();
    exit(1);
}
echo "   ✅ Updated paid_amount from amount column\n";
echo "   Rows affected: " . $mysqli->affected_rows . "\n\n";

// Step 4: Fix reservation_id
echo "🔧 Step 4: Fixing reservation_id references...\n";

$update2 = $mysqli->query("
    UPDATE payments p
    SET p.reservation_id = (
        SELECT r.reservation_id FROM rentals r WHERE r.rental_id = p.rental_id LIMIT 1
    )
    WHERE p.rental_id > 0 AND (p.reservation_id IS NULL OR p.reservation_id = 0)
");

if (!$update2) {
    echo "❌ Error updating reservation_id: " . $mysqli->error . "\n";
    $mysqli->close();
    exit(1);
}
echo "   ✅ Updated reservation_id from rental references\n";
echo "   Rows affected: " . $mysqli->affected_rows . "\n\n";

// Step 5: Verification
echo "✔️  Step 5: Verification...\n\n";

$result = $mysqli->query("
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN paid_amount > 0 THEN 1 ELSE 0 END) as with_amount,
        SUM(CASE WHEN reservation_id IS NOT NULL THEN 1 ELSE 0 END) as linked_to_reservation
    FROM payments
");

if ($result) {
    $row = $result->fetch_assoc();
    echo "   Total payment records: {$row['total']}\n";
    echo "   Records with paid_amount > 0: {$row['with_amount']}\n";
    echo "   Records linked to reservation: {$row['linked_to_reservation']}\n\n";
}

// Step 6: Show sample records
echo "📝 Sample payment records after fix:\n";
echo str_repeat("─", 100) . "\n";

$result = $mysqli->query("
    SELECT p.payment_id, p.rental_id, p.amount, p.paid_amount, p.reservation_id, p.payment_status
    FROM payments
    LIMIT 10
");

if ($result && $result->num_rows > 0) {
    printf("%-12s %-12s %-12s %-12s %-14s %-20s\n", 
           "Payment ID", "Rental ID", "Amount", "Paid Amount", "Reservation ID", "Status");
    echo str_repeat("─", 100) . "\n";
    
    while ($row = $result->fetch_assoc()) {
        printf("%-12s %-12s %-12s %-12s %-14s %-20s\n",
               $row['payment_id'] ?? 'N/A',
               $row['rental_id'] ?? 'N/A',
               '₱' . ($row['amount'] ?? '0'),
               '₱' . ($row['paid_amount'] ?? '0'),
               $row['reservation_id'] ?? 'NULL',
               $row['payment_status'] ?? 'N/A'
        );
    }
} else {
    echo "No records to display\n";
}

echo str_repeat("─", 100) . "\n\n";

// Final verification with reservations
echo "🎯 Final Check: Linking with reservations...\n\n";

$result = $mysqli->query("
    SELECT 
        r.reservation_id,
        r.pickup_date,
        CONCAT(c.brand, ' ', c.model) as vehicle,
        SUM(p.paid_amount) as total_paid,
        r.reservation_status
    FROM reservations r
    LEFT JOIN cars c ON r.car_id = c.car_id
    LEFT JOIN rentals rt ON r.reservation_id = rt.reservation_id
    LEFT JOIN payments p ON rt.rental_id = p.rental_id
    GROUP BY r.reservation_id
    ORDER BY r.pickup_date DESC
    LIMIT 5
");

if ($result && $result->num_rows > 0) {
    printf("%-15s %-20s %-20s %-15s %-15s\n",
           "Reservation ID", "Vehicle", "Pickup Date", "Total Paid", "Status");
    echo str_repeat("─", 90) . "\n";
    
    while ($row = $result->fetch_assoc()) {
        printf("#RES-%-12s %-20s %-20s ₱%-14s %-15s\n",
               str_pad($row['reservation_id'], 3, '0', STR_PAD_LEFT),
               substr($row['vehicle'] ?? 'N/A', 0, 18),
               date('M d, Y', strtotime($row['pickup_date'])),
               number_format($row['total_paid'] ?? 0, 2),
               $row['reservation_status'] ?? 'N/A'
        );
    }
    echo str_repeat("─", 90) . "\n\n";
} else {
    echo "No reservation data found.\n\n";
}

$mysqli->close();

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║              ✅ FIX COMPLETE!                              ║\n";
echo "╠════════════════════════════════════════════════════════════╣\n";
echo "║ Next Steps:                                                ║\n";
echo "║ 1. Go to Dashboard and view any reservation                ║\n";
echo "║ 2. Click 'View' to see reservation details                 ║\n";
echo "║ 3. Check that 'Amount Paid' now shows correct value        ║\n";
echo "║                                                            ║\n";
echo "║ If issues persist, check:                                  ║\n";
echo "║ • Database connection is working                           ║\n";
echo "║ • Clear browser cache (Ctrl+Shift+R)                       ║\n";
echo "║ • Refresh dashboard page                                   ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

?>
