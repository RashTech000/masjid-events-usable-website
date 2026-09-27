<?php
session_start();
require_once __DIR__ . '/functions.php';
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids     = $_POST['id'] ?? [];
    $names   = $_POST['name'] ?? [];
    $adhanas = $_POST['adhana'] ?? [];
    $iqamas  = $_POST['iqama'] ?? [];

    $stmt = $pdo->prepare('UPDATE prayer_times SET name = ?, adhana = ?, iqama = ? WHERE id = ?');
    foreach ($ids as $i => $id) {
        $stmt->execute([
            trim($names[$i] ?? ''),
            trim($adhanas[$i] ?? ''),
            trim($iqamas[$i] ?? ''),
            (int)$id,
        ]);
    }
}
header('Location: dashboard.php?tab=ratiba&msg=' . urlencode('Ratiba za Swala zimehifadhiwa.'));
exit;
