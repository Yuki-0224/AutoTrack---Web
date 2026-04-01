<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>403 | Forbidden</title>

<link rel="stylesheet" href="<?= function_exists('base_url') ? base_url() : '/' ?>public/css/styles.css">
</head>
</head>

<body class="error-page">
<main class="card" role="main">
  <div class="code">403 • Forbidden</div>
  <h1>Forbidden Error</h1>
  <p><?= $error ?></p>

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
