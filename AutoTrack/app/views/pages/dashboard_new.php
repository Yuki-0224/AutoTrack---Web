<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
    <style>
        :root {
            --primary: #ff6b35;
            --primary-dark: #e55a24;
            --bg-light: #f8f9fa;
            --text-dark: #1a1a1a;
            --text-gray: #666;
            --border-color: #e0e0e0;
            --success: #27ae60;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styling */
        header.page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            width: 100%;
        }

        header.page-header > div {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }

        header.page-header .brand-link {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            white-space: nowrap;
        }

        header.page-header .header-nav {
            display: flex;
            gap: 2rem;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        header.page-header .header-link {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        header.page-header .header-link:hover {
            opacity: 1;
            color: white;
        }

        /* Main Content */
        main {
            flex: 1;
            padding: 3rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 16px;
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: var(--text-gray);
            max-width: 600px;
        }

        /* Tabs */
        .tabs-container {
            display: flex;
            gap: 0;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 3rem;
            overflow-x: auto;
        }

        .tab-button {
            padding: 1rem 2rem;
            background: none;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-gray);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .tab-button:hover {
            color: var(--primary);
        }

        .tab-button.active {
            color: var(--primary);
        }

        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary);
            border-radius: 2px 2px 0 0;
        }

        /* Tab Content */
        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease-in;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Search and Filter */
        .search-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .search-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .search-grid label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .search-grid input, .search-grid select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .search-grid input:focus, .search-grid select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .search-button {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-button:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        /* Featured Cars Section */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .view-all-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .view-all-link:hover {
            color: var(--primary-dark);
        }

        /* Cars Grid */
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .car-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .car-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        .car-image {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            overflow: hidden;
        }

        .car-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .car-info {
            padding: 1.5rem;
        }

        .car-brand {
            display: inline-block;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
        }

        .car-model {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .car-details {
            font-size: 0.9rem;
            color: var(--text-gray);
            margin-bottom: 1rem;
        }

        .car-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .price-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .car-button {
            width: 100%;
            padding: 0.8rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .car-button:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Reservations Table */
        .reservations-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .reservations-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .reservations-table th {
            background: #f5f5f5;
            padding: 1.2rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 2px solid var(--border-color);
        }

        .reservations-table td {
            padding: 1.2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .reservations-table tr:hover {
            background: #f9f9f9;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-confirmed {
            background: rgba(39, 174, 96, 0.1);
            color: var(--success);
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #f39c12;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }

        .empty-state-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .empty-state-text {
            color: var(--text-gray);
            margin-bottom: 2rem;
        }

        /* Footer */
        footer.page-footer {
            background: var(--text-dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: auto;
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            main {
                padding: 2rem 1rem;
            }

            .hero-section {
                padding: 2rem 1rem;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .cars-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 1.5rem;
            }

            .search-grid {
                grid-template-columns: 1fr;
            }

            .tabs-container {
                margin-bottom: 2rem;
            }

            .tab-button {
                padding: 0.8rem 1.5rem;
                font-size: 0.95rem;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .reservations-table {
                overflow-x: auto;
            }

            header.page-header {
                padding: 1rem;
            }

            header.page-header .header-nav {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            main {
                padding: 1.5rem 1rem;
            }

            .hero-title {
                font-size: 1.5rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .cars-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .car-model {
                font-size: 1.1rem;
            }

            .search-button {
                padding: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <header class="page-header">
            <div>
                <a href="<?= url('dashboard') ?>" class="brand-link">AutoTrack</a>
                <nav class="header-nav">
                    <a href="<?= url('dashboard') ?>" class="header-link">Dashboard</a>
                    <a href="<?= url('logout') ?>" class="header-link">Logout</a>
                </nav>
            </div>
        </header>

        <main>
            <!-- Welcome Hero -->
            <section class="hero-section">
                <h1 class="hero-title">Welcome, <?= esc($_SESSION['user']['name'] ?? 'Driver') ?></h1>
                <p class="hero-subtitle">Browse available cars, make reservations, and manage your bookings with ease.</p>
            </section>

            <!-- Tabs -->
            <div class="tabs-container">
                <button class="tab-button active" onclick="switchTab(this, 'available')">Available Cars</button>
                <button class="tab-button" onclick="switchTab(this, 'reservations')">My Reservations</button>
            </div>

            <!-- Tab 1: Available Cars -->
            <div id="available" class="tab-content active">
                <!-- Search Section -->
                <div class="search-section">
                    <form method="GET" class="search-grid">
                        <div>
                            <label>Brand</label>
                            <input type="text" name="brand" placeholder="Search brand...">
                        </div>
                        <div>
                            <label>Location</label>
                            <input type="text" name="location" placeholder="Dropoff location...">
                        </div>
                        <div>
                            <label>Pickup Date</label>
                            <input type="date" name="pickup_date">
                        </div>
                        <div style="display: flex; align-items: flex-end;">
                            <button type="submit" class="search-button">Search</button>
                        </div>
                    </form>
                </div>

                <!-- Featured Cars -->
                <div class="section-header">
                    <h2 class="section-title">Featured Cars</h2>
                </div>
                <div class="cars-grid">
                    <?php
                    $cars = [];
                    try {
                        $cars = db()->table('cars')->where('status', '=', 'Available')->get_all();
                        if (!is_array($cars)) {
                            $cars = [];
                        }
                    } catch (Exception $e) {
                        $cars = [];
                    }

                    if (!empty($cars)):
                        foreach ($cars as $car):
                    ?>
                    <div class="car-card" onclick="goToCarInfo(<?= $car['car_id'] ?>)">
                        <div class="car-image">
                            <?php if (!empty($car['image'])): ?>
                                <img src="<?= base_url() ?><?= $car['image'] ?>" alt="<?= $car['model'] ?>">
                            <?php else: ?>
                                🚗
                            <?php endif; ?>
                        </div>
                        <div class="car-info">
                            <div class="car-brand"><?= $car['brand'] ?></div>
                            <div class="car-model"><?= $car['model'] ?></div>
                            <div class="car-details"><?= $car['year'] ?> • <?= $car['color'] ?></div>
                            <div class="car-price">
                                <div class="price-amount">₱<?= number_format($car['price_per_day'], 0) ?></div>
                                <span style="color: var(--text-gray); font-size: 0.9rem;">/day</span>
                            </div>
                            <button class="car-button" onclick="goToCarInfo(<?= $car['car_id'] ?>)">View Details</button>
                        </div>
                    </div>
                    <?php
                        endforeach;
                    else:
                    ?>
                    <div style="grid-column: 1/-1;">
                        <div class="empty-state">
                            <div class="empty-state-icon">🚗</div>
                            <div class="empty-state-title">No Cars Available</div>
                            <p class="empty-state-text">Check back later for more vehicles</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tab 2: My Reservations -->
            <div id="reservations" class="tab-content">
                <?php
                $customerId = $_SESSION['user']['customer_id'] ?? null;
                $reservations = [];

                if ($customerId) {
                    try {
                        $result = db()->raw("
                            SELECT r.*, c.brand, c.model, c.price_per_day,
                                   COALESCE(p.total_paid, 0) as paid_amount,
                                   p.payment_status
                            FROM reservations r
                            LEFT JOIN cars c ON r.car_id = c.car_id
                            LEFT JOIN (
                                 SELECT rt.reservation_id, SUM(COALESCE(pay.paid_amount, pay.amount, 0)) as total_paid, MAX(pay.payment_status) as payment_status
                                FROM rentals rt
                                LEFT JOIN payments pay ON rt.rental_id = pay.rental_id
                                GROUP BY rt.reservation_id
                            ) p ON r.reservation_id = p.reservation_id
                            WHERE r.customer_id = ?
                            ORDER BY r.pickup_date DESC
                        ", [$customerId]);

                        if ($result) {
                            $reservations = $result->fetchAll(PDO::FETCH_ASSOC);
                        }
                    } catch (Exception $e) {
                        $reservations = [];
                    }
                }
                ?>

                <?php if (!empty($reservations)): ?>
                <div class="reservations-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Reservation ID</th>
                                <th>Car</th>
                                <th>Pickup Date</th>
                                <th>Pickup Location</th>
                                <th>Dropoff Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rows = is_array($reservations) ? $reservations : (isset($reservations) ? [$reservations] : []);
                            foreach ($rows as $res):
                            ?>
                            <tr>
                                <td>#RES-<?= str_pad($res['reservation_id'], 3, '0', STR_PAD_LEFT) ?></td>
                                <td><?= ($res['brand'] ?? 'N/A') . ' ' . ($res['model'] ?? '') ?></td>
                                <td><?= date('M d, Y', strtotime($res['pickup_date'])) ?></td>
                                <td><?= $res['pickup_location'] ?? 'N/A' ?></td>
                                <td><?= date('M d, Y', strtotime($res['return_date'])) ?></td>
                                <td>
                                    <?php
                                    $statusClass = 'status-pending';
                                    if ($res['reservation_status'] === 'Confirmed') $statusClass = 'status-confirmed';
                                    elseif ($res['reservation_status'] === 'Completed') $statusClass = 'status-confirmed';
                                    ?>
                                    <span class="status-badge <?= $statusClass ?>">
                                        <?= ucfirst($res['reservation_status']) ?>
                                    </span>
                                </td>
                                <td><a href="#" onclick="showReservationModal(<?= htmlspecialchars(json_encode($res), ENT_QUOTES) ?>); return false;" style="color: var(--primary); text-decoration: none; font-weight: 600;">View</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <div class="empty-state-title">No Reservations Yet</div>
                    <p class="empty-state-text">Start by browsing and reserving a car from our collection</p>
                    <button class="car-button" onclick="switchTab(document.querySelector('.tab-button'), 'available')" style="width: 200px; margin: 0 auto;">Browse Cars</button>
                </div>
                <?php endif; ?>
            </div>
        </main>

        <!-- Reservation Details Modal -->
        <div id="reservationModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); overflow-y:auto; padding: 20px 0;">
            <div style="background-color:#fefefe; margin:20px auto; padding:30px; border-radius:12px; width:90%; max-width:600px; box-shadow:0 10px 40px rgba(0,0,0,0.2); max-height:80vh; overflow-y:auto;">
                <span onclick="closeReservationModal()" style="color:#aaa; float:right; font-size:28px; font-weight:bold; cursor:pointer; line-height:20px;">&times;</span>
                <h2 style="margin-top:0; color:#1a1a1a;">Reservation Details</h2>

                <div style="background:#f8f9fa; padding:20px; border-radius:8px; margin:20px 0;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                        <div>
                            <div style="color:#666; font-size:0.9rem;">Reservation ID</div>
                            <div style="font-weight:bold; color:#1a1a1a;" id="modalResId"></div>
                        </div>
                        <div>
                            <div style="color:#666; font-size:0.9rem;">Status</div>
                            <div style="font-weight:bold; color:#1a1a1a;" id="modalStatus"></div>
                        </div>
                        <div>
                            <div style="color:#666; font-size:0.9rem;">Vehicle</div>
                            <div style="font-weight:bold; color:#1a1a1a;" id="modalCar"></div>
                        </div>
                        <div>
                            <div style="color:#666; font-size:0.9rem;">Daily Rate</div>
                            <div style="font-weight:bold; color:#1a1a1a;">₱<span id="modalRate">0.00</span></div>
                        </div>
                        <div>
                            <div style="color:#666; font-size:0.9rem;">Pickup Date</div>
                            <div style="font-weight:bold; color:#1a1a1a;" id="modalPickupDate"></div>
                        </div>
                        <div>
                            <div style="color:#666; font-size:0.9rem;">Dropoff Date</div>
                            <div style="font-weight:bold; color:#1a1a1a;" id="modalDropoffDate"></div>
                        </div>
                        <div style="grid-column:1/-1;">
                            <div style="color:#666; font-size:0.9rem;">Pickup Location</div>
                            <div style="font-weight:bold; color:#1a1a1a;" id="modalPickupLoc"></div>
                        </div>
                        <div>
                            <div style="color:#666; font-size:0.9rem;">Payment Status</div>
                            <div style="font-weight:bold; color:#1a1a1a;" id="modalPaymentStatus"></div>
                        </div>
                        <div>
                            <div style="color:#666; font-size:0.9rem;">Amount Paid</div>
                            <div style="font-weight:bold; color:#1a1a1a;">₱<span id="modalAmountPaid">0.00</span></div>
                        </div>
                        <div>
                            <div style="color:#666; font-size:0.9rem;">Total Amount</div>
                            <div style="font-weight:bold; color:#1a1a1a;">₱<span id="modalTotalAmount">0.00</span></div>
                        </div>
                        <div>
                            <div style="color:#666; font-size:0.9rem;">Balance Due</div>
                            <div style="font-weight:bold; color:#ff6b35;" id="modalBalanceDue">₱0.00</div>
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:10px; margin-top:20px; flex-wrap:wrap;">
                    <button onclick="cancelReservation()" style="flex:1; min-width:150px; padding:12px; background:#ff6b35; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; font-size:1rem;">Cancel Reservation</button>
                    <button id="paymentBtn" onclick="openPaymentModal()" style="flex:1; min-width:150px; padding:12px; background:#27ae60; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; font-size:1rem; display:none;">Pay Remaining</button>
                </div>
            </div>
        </div>

        <!-- Payment Modal for Partial Payments -->
        <div id="paymentModal" style="display:none; position:fixed; z-index:1001; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.7); overflow-y:auto; padding: 20px 0;">
            <div style="background-color:#fefefe; margin:20px auto; padding:30px; border-radius:12px; width:90%; max-width:500px; box-shadow:0 10px 40px rgba(0,0,0,0.3);">
                <span onclick="closePaymentModal()" style="color:#aaa; float:right; font-size:28px; font-weight:bold; cursor:pointer; line-height:20px;">&times;</span>
                <h2 style="margin-top:0; color:#1a1a1a;">Pay Remaining Balance</h2>

                <div style="background:#f0f8ff; padding:20px; border-radius:8px; margin:20px 0; border-left: 4px solid #27ae60;">
                    <div style="margin-bottom:15px;">
                        <span style="color:#666; font-size:0.9rem;">Balance Due:</span>
                        <div style="font-size:1.5rem; font-weight:bold; color:#27ae60;" id="paymentBalanceDue">₱0.00</div>
                    </div>
                    <div>
                        <span style="color:#666; font-size:0.9rem;">Payment Method:</span>
                        <select id="paymentMethod" style="width:100%; padding:10px; margin-top:8px; border:1px solid #ddd; border-radius:4px; font-size:1rem;">
                            <option value="paypal">PayPal</option>
                            <option value="credit">Credit Card</option>
                            <option value="debit">Debit Card</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                </div>

                <div style="display:flex; gap:10px; margin-top:30px;">
                    <button onclick="closePaymentModal()" style="flex:1; padding:12px; background:#e0e0e0; color:#333; border:none; border-radius:8px; font-weight:600; cursor:pointer; font-size:1rem;">Cancel</button>
                    <button onclick="confirmPayment()" style="flex:1; padding:12px; background:#27ae60; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; font-size:1rem;">Confirm Payment</button>
                </div>
            </div>
        </div>

        <footer class="page-footer">
            &copy; 2026 AutoTrack. All rights reserved. | Web-based car rental system
        </footer>
    </div>

    <script type="text/javascript">
function switchTab(button, tabName) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    const selectedTab = document.getElementById(tabName);
    if (selectedTab) {
        selectedTab.classList.add('active');
    }
    button.classList.add('active');
}

function goToCarInfo(carId) {
    const url = "<?= url('car-info') ?>?id=" + carId;
    window.location.href = url;
}

let currentReservation = null;

function showReservationModal(reservation) {
    currentReservation = reservation;
    const price_per_day = parseFloat(reservation.price_per_day) || 0;
    const paid_amount = parseFloat(reservation.paid_amount) || 0;
    const pickup = new Date(reservation.pickup_date);
    const dropoff = new Date(reservation.return_date);
    const days = Math.ceil((dropoff - pickup) / (1000 * 60 * 60 * 24)) || 1;
    const subtotal = price_per_day * days;
    const tax = subtotal * 0.10;
    const total_amount = subtotal + tax;
    const balance = Math.max(0, total_amount - paid_amount);

    document.getElementById('modalResId').textContent = '#RES-' + String(reservation.reservation_id).padStart(3, '0');
    document.getElementById('modalStatus').textContent = reservation.reservation_status;
    document.getElementById('modalCar').textContent = (reservation.brand || 'N/A') + ' ' + (reservation.model || '');
    document.getElementById('modalRate').textContent = price_per_day.toFixed(2);
    document.getElementById('modalPickupDate').textContent = pickup.toLocaleDateString('en-US', {year:'numeric', month:'short', day:'numeric'});
    document.getElementById('modalDropoffDate').textContent = dropoff.toLocaleDateString('en-US', {year:'numeric', month:'short', day:'numeric'});
    document.getElementById('modalPickupLoc').textContent = reservation.pickup_location || 'N/A';
    document.getElementById('modalPaymentStatus').textContent = reservation.payment_status || 'Not Paid';
    document.getElementById('modalAmountPaid').textContent = paid_amount.toFixed(2);
    document.getElementById('modalTotalAmount').textContent = total_amount.toFixed(2);
    document.getElementById('modalBalanceDue').textContent = reservation.reservation_status === 'Confirmed' ? 'Fully Paid' : '₱' + balance.toFixed(2);

    if (balance > 0 || reservation.reservation_status === 'Pending') {
        document.getElementById('paymentBtn').style.display = 'block';
        document.getElementById('paymentBtn').textContent = balance > 0 ? 'Pay Remaining ₱' + balance.toFixed(2) : 'Complete Payment';
    } else {
        document.getElementById('paymentBtn').style.display = 'none';
    }

    document.getElementById('reservationModal').style.display = 'block';
}

function closeReservationModal() {
    document.getElementById('reservationModal').style.display = 'none';
    currentReservation = null;
}

function cancelReservation() {
    if (!currentReservation || !confirm('Are you sure you want to cancel this reservation?')) {
        return;
    }
    fetch("<?= url('cancel-reservation') ?>", {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'reservation_id=' + currentReservation.reservation_id
    }).then(response => {
        if (response.ok) {
            alert('Reservation cancelled successfully!');
            location.reload();
        }
    });
}

function openPaymentModal() {
    if (!currentReservation) return;
    
    const price_per_day = parseFloat(currentReservation.price_per_day) || 0;
    const paid_amount = parseFloat(currentReservation.paid_amount) || 0;
    const pickup = new Date(currentReservation.pickup_date);
    const dropoff = new Date(currentReservation.return_date);
    const days = Math.ceil((dropoff - pickup) / (1000 * 60 * 60 * 24)) || 1;
    const subtotal = price_per_day * days;
    const tax = subtotal * 0.10;
    const total_amount = subtotal + tax;
    const balance = Math.max(0, total_amount - paid_amount);
    
    document.getElementById('paymentBalanceDue').textContent = '₱' + balance.toFixed(2);
    document.getElementById('paymentModal').style.display = 'block';
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
    document.getElementById('paymentMethod').value = 'paypal';
}

function confirmPayment() {
    if (!currentReservation) return;
    
    const paymentMethod = document.getElementById('paymentMethod').value;
    
    const price_per_day = parseFloat(currentReservation.price_per_day) || 0;
    const paid_amount = parseFloat(currentReservation.paid_amount) || 0;
    const pickup = new Date(currentReservation.pickup_date);
    const dropoff = new Date(currentReservation.return_date);
    const days = Math.ceil((dropoff - pickup) / (1000 * 60 * 60 * 24)) || 1;
    const subtotal = price_per_day * days;
    const tax = subtotal * 0.10;
    const total_amount = subtotal + tax;
    const balance = Math.max(0, total_amount - paid_amount);
    
    const formData = new FormData();
    formData.append('reservation_id', currentReservation.reservation_id);
    formData.append('car_id', currentReservation.car_id);
    formData.append('payment_method', paymentMethod);
    formData.append('payment_amount', balance);
    formData.append('total_amount', total_amount);
    
    fetch("<?= url('process-payment') ?>", {
        method: 'POST',
        body: formData
    }).then(response => {
        if (response.ok) {
            alert('Payment successful! Balance updated.');
            closePaymentModal();
            closeReservationModal();
            location.reload();
        } else {
            alert('Payment failed. Please try again.');
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

window.onclick = function(event) {
    const modal = document.getElementById('reservationModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
    </script>
</body>
</html>
