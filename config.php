<?php
/**
 * config.php — Mipangilio ya Database ya Masjid Kisota
 *
 * MAELEKEZO (InfinityFree):
 * 1. Ingia kwenye cPanel ya InfinityFree -> "MySQL Databases" -> tengeneza database mpya.
 * 2. Utapewa: jina la host (mfano sqlXXX.infinityfree.com), jina la database,
 *    jina la mtumiaji (username) na nenosiri (password).
 * 3. Jaza taarifa hizo hapa chini kwenye nafasi husika.
 * 4. Fungua phpMyAdmin, chagua database yako, kisha "Import" faili la db.sql
 *    lililopo kwenye mfuko huu ili kutengeneza majedwali na taarifa za awali.
 */

define('DB_HOST', 'localhost');       // mfano: sql123.infinityfree.com
define('DB_NAME', 'kisota');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Imeshindikana kuunganisha na database. Tafadhali angalia taarifa zako za DB kwenye config.php. (' . htmlspecialchars($e->getMessage()) . ')');
}
