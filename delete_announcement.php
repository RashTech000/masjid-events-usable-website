<?php
session_start();
require_once __DIR__ . '/functions.php';
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare('DELETE FROM announcements WHERE id = ?');
        $stmt->execute([$id]);
    }
}
header('Location: dashboard.php?tab=matangazo&msg=' . urlencode('Tangazo limefutwa.'));
exit;
