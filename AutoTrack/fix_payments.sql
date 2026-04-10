-- =============================================================
-- AutoTrack Payment Records Fix - SQL Script
-- =============================================================
-- Run these SQL commands directly in phpMyAdmin or MySQL CLI
-- 
-- This script fixes:
-- 1. Sets paid_amount = amount for all payment records
-- 2. Links payment records to reservations via rental relationships
-- =============================================================

-- Step 1: Fix paid_amount values (set from amount column)
-- This updates all records where paid_amount is 0 or NULL
UPDATE payments 
SET paid_amount = amount 
WHERE (paid_amount = 0 OR paid_amount IS NULL) AND amount > 0;

-- Step 2: Link payments to reservations
-- This updates reservation_id by looking up the rental relationship
UPDATE payments p
SET p.reservation_id = (
    SELECT r.reservation_id FROM rentals r 
    WHERE r.rental_id = p.rental_id 
    LIMIT 1
)
WHERE p.rental_id > 0 AND (p.reservation_id IS NULL OR p.reservation_id = 0);

-- =============================================================
-- VERIFICATION QUERIES (Run these to check if fix worked)
-- =============================================================

-- Check 1: How many records were fixed?
SELECT COUNT(*) as total_payments FROM payments;

-- Check 2: How many records have paid_amount > 0?
SELECT COUNT(*) as records_with_paid_amount FROM payments WHERE paid_amount > 0;

-- Check 3: How many records are linked to reservations?
SELECT COUNT(*) as linked_to_reservation FROM payments WHERE reservation_id IS NOT NULL;

-- Check 4: Show all payment records (to verify fix)
SELECT 
    payment_id, 
    rental_id, 
    amount, 
    paid_amount, 
    reservation_id, 
    payment_status
FROM payments
ORDER BY payment_id ASC;

-- Check 5: Show payments linked to reservations (with reservation details)
SELECT 
    r.reservation_id,
    CONCAT('#RES-', LPAD(r.reservation_id, 3, '0')) as res_id,
    CONCAT(c.brand, ' ', c.model) as vehicle,
    r.pickup_date,
    r.reservation_status,
    SUM(p.paid_amount) as total_paid,
    p.payment_status
FROM reservations r
LEFT JOIN cars c ON r.car_id = c.car_id
LEFT JOIN rentals rt ON r.reservation_id = rt.reservation_id
LEFT JOIN payments p ON rt.rental_id = p.rental_id
GROUP BY r.reservation_id
ORDER BY r.pickup_date DESC;

-- =============================================================
-- If something goes wrong, you can reset with this:
-- (Only if you need to undo the changes)
-- =============================================================

-- Reset paid_amount to 0 (CAUTION: This undoes the fix!)
-- UPDATE payments SET paid_amount = 0;

-- Reset reservation_id to NULL (CAUTION: This undoes the fix!)
-- UPDATE payments SET reservation_id = NULL;
