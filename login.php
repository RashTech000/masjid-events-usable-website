<?php
session_start();
require_once __DIR__ . '/functions.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Jina la mtumiaji au nenosiri sio sahihi.';
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ingia — Msimamizi wa Masjid Kisota</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="admin-page">
  <div class="admin-card">
    <svg class="login-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
    <h1>Sehemu ya Msimamizi</h1>
    <div class="sub">Ingia kusimamia Ratiba za Swala, Matangazo na Khutba za Ijumaa — Masjid Kisota.</div>
    <?php if ($error): ?><div class="alert alert-err"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
      <div class="field">
        <label for="username">Jina la mtumiaji</label>
        <input type="text" id="username" name="username" required autocomplete="username">
      </div>
      <div class="field">
        <label for="password">Nenosiri</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">
      </div>
      <button type="submit" class="btn btn-emerald" style="width:100%;text-align:center;border:none;">Ingia</button>
    </form>
    <div style="margin-top:18px;"><a href="index.php" style="font-size:.85rem;color:var(--ink-soft);">← Rudi kwenye tovuti</a></div>
  </div>
</div>
</body>
</html>
