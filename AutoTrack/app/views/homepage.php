<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>LavaLite - Keep it light. Build it fast</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= function_exists('base_url') ? base_url() : '/' ?>public/css/styles.css" rel="stylesheet">
</head>
<body class="homepage-page">

    <div class="container">

        <header>
            <h1><span class="lava">Lava</span>Lite</h1>
            <div class="subtitle">Routing + SQL Builder. Zero bloat.</div>

            <p class="tagline">
                The lightweight PHP framework that gets out of your way<br>
                and lets you ship fast — with a warm orange soul.
            </p>

            <div class="buttons">
                <a href="https://lavalite.netlify.app" class="btn btn-primary">Get Started →</a>
                <a href="https://github.com/ronmarasigan/lavalite" target="_blank" class="btn btn-outline">View on GitHub</a>
            </div>
        </header>

        <section class="features">
            <h2 class="section-heading">Why LavaLite?</h2>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🚀</div>
                    <div class="feature-title">Lightning Fast Routing</div>
                    <p>Simple, expressive routes with zero magic. Just works.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🧱</div>
                    <div class="feature-title">Clean SQL Builder</div>
                    <p>Fluent, safe queries — no more string concatenation nightmares.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🪶</div>
                    <div class="feature-title">Ultra Lightweight</div>
                    <p>Only what you need. No heavy dependencies. ~58 KB.</p>
                </div>
            </div>
        </section>

        <footer>
            <p>LavaLite • 2025–2026</p>
        </footer>

    </div>
    <script src="<?= function_exists('base_url') ? base_url() : '/' ?>public/script/script.js"></script>
</body>
</html>