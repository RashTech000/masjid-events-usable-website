<?php
session_start();
require_once __DIR__ . '/functions.php';
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    if ($title !== '') {
        $stmt = $pdo->prepare('INSERT INTO announcements (date_label, title, body, tag) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            trim($_POST['date_label'] ?? '') ?: 'Hivi karibuni',
            $title,
            trim($_POST['body'] ?? ''),
            trim($_POST['tag'] ?? ''),
        ]);
    }
}
header('Location: dashboard.php?tab=matangazo&msg=' . urlencode('Tangazo limeongezwa.'));
exit;
