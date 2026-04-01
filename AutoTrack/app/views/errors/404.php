<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>404 | Not Found</title>

<link rel="stylesheet" href="<?= function_exists('base_url') ? base_url() : '/' ?>public/css/styles.css">
</head>
</head>

<body class="error-page">
<main class="card" role="main">
  <div class="code">404 • Not Found</div>
  <h1>404 Page Not Found</h1>
  <p>The page you requested was not found.</p>

  <div class="actions">
    <a class="btn primary" href="/">Home</a>
    <a class="btn" href="javascript:history.back()">Back</a>
  </div>

  <div class="hint">
    Tip: Press <span class="kbd">Ctrl</span> + <span class="kbd">L</span> to retype the URL.
  </div>
</main>
<script src="<?= base_url() ?>public/script/script.js"></script>
</body>
</html>
