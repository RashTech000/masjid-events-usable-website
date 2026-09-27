<?php
session_start();
require_once __DIR__ . '/functions.php';
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic = trim($_POST['topic'] ?? '');
    if ($topic !== '') {
        $stmt = $pdo->prepare('INSERT INTO khutba (date_label, khatib, topic, notes) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            trim($_POST['date_label'] ?? '') ?: 'Ijumaa ijayo',
            trim($_POST['khatib'] ?? ''),
            $topic,
            trim($_POST['notes'] ?? ''),
        ]);
    }
}
header('Location: dashboard.php?tab=khutba&msg=' . urlencode('Khutba imeongezwa.'));
exit;
