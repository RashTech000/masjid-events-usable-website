<?php
session_start();
require_once __DIR__ . '/functions.php';
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new     = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE id = ?');
    $stmt->execute([$_SESSION['admin_id']]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($current, $user['password_hash'])) {
        header('Location: dashboard.php?tab=akaunti&err=' . urlencode('Nenosiri la sasa si sahihi.'));
        exit;
    }
    if (strlen($new) < 6) {
        header('Location: dashboard.php?tab=akaunti&err=' . urlencode('Nenosiri jipya linahitaji angalau herufi/namba 6.'));
        exit;
    }
    if ($new !== $confirm) {
        header('Location: dashboard.php?tab=akaunti&err=' . urlencode('Nenosiri jipya na urudiaji hazifanani.'));
        exit;
    }

    $hash = password_hash($new, PASSWORD_DEFAULT);
    $upd = $pdo->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?');
    $upd->execute([$hash, $user['id']]);

    header('Location: dashboard.php?tab=akaunti&msg=' . urlencode('Nenosiri limebadilishwa kikamilifu.'));
    exit;
}
header('Location: dashboard.php?tab=akaunti');
exit;
