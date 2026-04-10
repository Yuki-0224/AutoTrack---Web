<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Car Details - AutoTrack</title>
    <link href="<?= base_url() ?>public/css/styles.css" rel="stylesheet">
    <style>
        :root {
            --primary: #ff6b35;
            --primary-dark: #e55a24;
            --bg-light: #f8f9fa;
            --text-dark: #1a1a1a;
            --text-gray: #666;
            --border-color: #e0e0e0;
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

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        header .brand-link {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        header .header-nav {
            display: flex;
            gap: 1.5rem;
        }

        header .header-link {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        header .header-link:hover {
            color: white;
        }

        main {
            flex: 1;
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        /* Hero Section */
        .hero-section {
            margin-bottom: 3rem;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1.5rem;
            transition: gap 0.3s ease;
        }

        .back-button:hover {
            gap: 1rem;
        }

        .car-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .car-subtitle {
            color: var(--text-gray);
            font-size: 1.1rem;
        }

        /* Image Gallery */
        .image-section {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }

        .main-image {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
            color: rgba(255,255,255,0.2);
        }

        .main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Specs Grid */
        .specs-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        .specs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .spec-card {
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }

        .spec-card:hover {
            background: rgba(255, 107, 53, 0.05);
            transform: translateX(4px);
        }

        .spec-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .spec-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* Description */
        .description-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .section-content {
            color: var(--text-gray);
            line-height: 1.8;
        }

        /* Features List */
        .features-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .feature-item {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.8rem;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            border-color: var(--primary);
            background: rgba(255, 107, 53, 0.05);
        }

        .feature-check {
            font-size: 1.2rem;
            color: var(--primary);
        }

        .feature-text {
            font-size: 0.95rem;
        }

        /* Pricing Card */
        .pricing-section {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1) 0%, rgba(230, 90, 36, 0.05) 100%);
            border-radius: 12px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 2px solid rgba(255, 107, 53, 0.2);
            text-align: center;
        }

        .price-label {
            color: var(--text-gray);
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .price-display {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .price-period {
            color: var(--text-gray);
            font-size: 1rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .btn-primary, .btn-secondary {
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: rgba(255, 107, 53, 0.05);
        }

        /* Footer */
        footer {
            background: var(--text-dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            main {
                padding: 2rem 1rem;
            }

            .car-title {
                font-size: 1.8rem;
            }

            .main-image {
                height: 300px;
                font-size: 60px;
            }

            .specs-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1rem;
            }

            .spec-card {
                padding: 1rem;
            }

            .specs-section, .description-section, .features-section {
                padding: 1.5rem;
            }

            .action-buttons {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem;
            }

            header .header-nav {
                flex-direction: column;
                width: 100%;
                gap: 0.5rem;
            }

            .pricing-section {
                padding: 1.5rem;
            }

            .price-display {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            main {
                padding: 1.5rem 1rem;
            }

            .back-button {
                margin-bottom: 1rem;
            }

            .car-title {
                font-size: 1.5rem;
            }

            .main-image {
                height: 250px;
                font-size: 50px;
            }

            .specs-grid {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 1.2rem;
            }

            .price-display {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <header>
            <a href="<?= url('dashboard') ?>" class="brand-link">AutoTrack</a>
            <nav class="header-nav">
                <a href="<?= url('dashboard') ?>" class="header-link">Dashboard</a>
                <a href="<?= url('logout') ?>" class="header-link">Logout</a>
            </nav>
        </header>

        <main>
            <?php
            $carId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $car = null;

            if ($carId > 0) {
                try {
                    $car = db()->table('cars')->where('car_id', '=', $carId)->get();
                } catch (Exception $e) {
                    $car = null;
                }
            }

            if ($car):
            ?>
            <!-- Hero Section -->
            <section class="hero-section">
                <a href="<?= url('dashboard') ?>" class="back-button">← Back to Dashboard</a>
                <h1 class="car-title"><?= $car['brand'] ?> <?= $car['model'] ?></h1>
                <p class="car-subtitle"><?= $car['year'] ?> • <?= $car['color'] ?> • <?= $car['plate_number'] ?></p>
            </section>

            <!-- Image Gallery -->
            <div class="image-section">
                <div class="main-image">
                    <?php if (!empty($car['image'])): ?>
                        <img src="<?= base_url() ?><?= $car['image'] ?>" alt="<?= $car['model'] ?>">
                    <?php else: ?>
                        🚗
                    <?php endif; ?>
                </div>
            </div>

            <!-- Specs -->
            <div class="specs-section">
                <h3 class="section-title">Vehicle Specifications</h3>
                <div class="specs-grid">
                    <div class="spec-card">
                        <div class="spec-label">Model</div>
                        <div class="spec-value"><?= $car['model'] ?></div>
                    </div>
                    <div class="spec-card">
                        <div class="spec-label">Year</div>
                        <div class="spec-value"><?= $car['year'] ?></div>
                    </div>
                    <div class="spec-card">
                        <div class="spec-label">Color</div>
                        <div class="spec-value"><?= $car['color'] ?></div>
                    </div>
                    <div class="spec-card">
                        <div class="spec-label">Transmission</div>
                        <div class="spec-value">Automatic</div>
                    </div>
                    <div class="spec-card">
                        <div class="spec-label">Fuel Type</div>
                        <div class="spec-value">Petrol</div>
                    </div>
                    <div class="spec-card">
                        <div class="spec-label">Status</div>
                        <div class="spec-value" style="color: #27ae60;"><?= $car['status'] ?></div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="description-section">
                <h3 class="section-title">About This Vehicle</h3>
                <p class="section-content">
                    This <?= $car['year'] ?> <?= $car['brand'] ?> <?= $car['model'] ?> is a premium vehicle designed for comfort and performance. With modern amenities, advanced safety features, and reliable engineering, it's perfect for both short trips and long journeys. Regular maintenance and professional inspections ensure optimal condition and your peace of mind.
                </p>
            </div>

            <!-- Features -->
            <div class="features-section">
                <h3 class="section-title">Features & Amenities</h3>
                <div class="features-grid">
                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        <span class="feature-text">Air Conditioning</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        <span class="feature-text">Power Windows</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        <span class="feature-text">Backup Camera</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        <span class="feature-text">Cruise Control</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        <span class="feature-text">Bluetooth Audio</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        <span class="feature-text">ABS Brakes</span>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="pricing-section">
                <p class="price-label">Price From</p>
                <div class="price-display">$<?= number_format($car['price_per_day'], 2) ?></div>
                <p class="price-period">per day</p>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="btn-primary" onclick="makeReservation(<?= $car['car_id'] ?>)">Make a Reservation</button>
                <button class="btn-secondary" onclick="history.back()">Go Back</button>
            </div>

            <?php else: ?>
            <div style="text-align: center; padding: 4rem 2rem;">
                <div style="font-size: 3.5rem; margin-bottom: 1rem;">❌</div>
                <h1 class="car-title">Car Not Found</h1>
                <p style="color: var(--text-gray); margin-bottom: 2rem;">The vehicle you're looking for doesn't exist or has been removed.</p>
                <a href="<?= url('dashboard') ?>" class="btn-primary" style="text-decoration: none; display: inline-block;">Back to Dashboard</a>
            </div>
            <?php endif; ?>
        </main>

        <footer>
            &copy; 2026 AutoTrack. All rights reserved. | Web-based car rental system
        </footer>
    </div>

    <script>
        function makeReservation(carId) {
            window.location.href = "<?= url('car-reservation') ?>?id=" + carId;
        }
    </script>
</body>
</html>
