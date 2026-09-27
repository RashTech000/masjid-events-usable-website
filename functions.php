<?php
require_once __DIR__ . '/config.php';

function get_prayer_times(): array {
    global $pdo;
    return $pdo->query("SELECT * FROM prayer_times ORDER BY sort_order ASC, id ASC")->fetchAll();
}

function get_announcements(): array {
    global $pdo;
    return $pdo->query("SELECT * FROM announcements ORDER BY id DESC")->fetchAll();
}

function get_khutba(): array {
    global $pdo;
    return $pdo->query("SELECT * FROM khutba ORDER BY id DESC")->fetchAll();
}

function e(?string $s): string {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}
