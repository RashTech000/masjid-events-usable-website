<?php
session_start();
require_once __DIR__ . '/functions.php';
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$tab = $_GET['tab'] ?? 'ratiba';
if (!in_array($tab, ['ratiba','matangazo','khutba','akaunti'], true)) $tab = 'ratiba';

$msg = $_GET['msg'] ?? '';
$err = $_GET['err'] ?? '';

$prayerTimes   = get_prayer_times();
$announcements = get_announcements();
$khutbaList    = get_khutba();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashibodi — Msimamizi wa Masjid Kisota</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body style="background:var(--bg-alt);">

<div class="dash-shell">
  <div class="dash-top">
    <div>
      <h1>Dashibodi ya Msimamizi</h1>
      <div class="sub">Umeingia kama <strong><?= e($_SESSION['admin_username']) ?></strong> — mabadiliko yanaonekana papo hapo kwa waumini wote.</div>
    </div>
    <div style="display:flex;gap:10px;">
      <a class="logout-btn" href="index.php" target="_blank">Ona Tovuti</a>
      <a class="logout-btn" href="logout.php">Toka</a>
    </div>
  </div>

  <?php if ($msg): ?><div class="alert alert-ok"><?= e($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert alert-err"><?= e($err) ?></div><?php endif; ?>

  <div class="dash-tabs">
    <a class="dash-tab <?= $tab==='ratiba'?'active':'' ?>" href="?tab=ratiba">Ratiba za Swala</a>
    <a class="dash-tab <?= $tab==='matangazo'?'active':'' ?>" href="?tab=matangazo">Matangazo</a>
    <a class="dash-tab <?= $tab==='khutba'?'active':'' ?>" href="?tab=khutba">Khutba za Ijumaa</a>
    <a class="dash-tab <?= $tab==='akaunti'?'active':'' ?>" href="?tab=akaunti">Akaunti</a>
  </div>

  <div class="dash-panel">

    <?php if ($tab === 'ratiba'): ?>
      <h2>Hariri Ratiba za Swala</h2>
      <form method="post" action="save_prayer.php">
        <?php foreach ($prayerTimes as $p): ?>
          <div class="row-3" style="margin-bottom:14px;align-items:end;">
            <input type="hidden" name="id[]" value="<?= (int)$p['id'] ?>">
            <div class="field" style="margin-bottom:0;"><label>Jina</label><input type="text" name="name[]" value="<?= e($p['name']) ?>" required></div>
            <div class="field" style="margin-bottom:0;"><label>Adhana</label><input type="text" name="adhana[]" value="<?= e($p['adhana']) ?>"></div>
            <div class="field" style="margin-bottom:0;"><label>Iqama</label><input type="text" name="iqama[]" value="<?= e($p['iqama']) ?>"></div>
          </div>
        <?php endforeach; ?>
        <div class="save-row"><button type="submit" class="btn btn-emerald" style="border:none;">Hifadhi Ratiba</button></div>
      </form>

    <?php elseif ($tab === 'matangazo'): ?>
      <h2>Matangazo yaliyopo</h2>
      <?php if (!$announcements): ?>
        <p style="color:var(--ink-soft);font-style:italic;">Bado hakuna matangazo.</p>
      <?php else: foreach ($announcements as $a): ?>
        <div class="dash-list-item">
          <div class="txt"><strong><?= e($a['title']) ?></strong><span><?= e($a['date_label']) ?><?= $a['tag'] ? ' · '.e($a['tag']) : '' ?></span></div>
          <form method="post" action="delete_announcement.php" onsubmit="return confirm('Una uhakika unataka kufuta tangazo hili?');">
            <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
            <button type="submit" class="del-btn">Futa</button>
          </form>
        </div>
      <?php endforeach; endif; ?>

      <hr class="dash-hr">
      <h2>Ongeza tangazo jipya</h2>
      <form method="post" action="save_announcement.php">
        <div class="row-2">
          <div class="field"><label>Tarehe / lini</label><input type="text" name="date_label" placeholder="Mfano: Ijumaa hii" required></div>
          <div class="field"><label>Lebo (hiari)</label><input type="text" name="tag" placeholder="Mfano: Elimu"></div>
        </div>
        <div class="field"><label>Kichwa cha habari</label><input type="text" name="title" required></div>
        <div class="field"><label>Maelezo</label><textarea name="body"></textarea></div>
        <button type="submit" class="btn btn-emerald" style="border:none;">+ Ongeza Tangazo</button>
      </form>

    <?php elseif ($tab === 'khutba'): ?>
      <h2>Khutba zilizopo</h2>
      <?php if (!$khutbaList): ?>
        <p style="color:var(--ink-soft);font-style:italic;">Bado hakuna khutba.</p>
      <?php else: foreach ($khutbaList as $k): ?>
        <div class="dash-list-item">
          <div class="txt"><strong><?= e($k['topic']) ?></strong><span><?= e($k['date_label']) ?><?= $k['khatib'] ? ' · '.e($k['khatib']) : '' ?></span></div>
          <form method="post" action="delete_khutba.php" onsubmit="return confirm('Una uhakika unataka kufuta khutba hii?');">
            <input type="hidden" name="id" value="<?= (int)$k['id'] ?>">
            <button type="submit" class="del-btn">Futa</button>
          </form>
        </div>
      <?php endforeach; endif; ?>

      <hr class="dash-hr">
      <h2>Ongeza khutba mpya</h2>
      <form method="post" action="save_khutba.php">
        <div class="row-2">
          <div class="field"><label>Tarehe</label><input type="text" name="date_label" placeholder="Mfano: Ijumaa, 26 Sept 2026" required></div>
          <div class="field"><label>Khatibu</label><input type="text" name="khatib"></div>
        </div>
        <div class="field"><label>Mada ya Khutba</label><input type="text" name="topic" required></div>
        <div class="field"><label>Muhtasari (hiari)</label><textarea name="notes"></textarea></div>
        <button type="submit" class="btn btn-emerald" style="border:none;">+ Ongeza Khutba</button>
      </form>

    <?php elseif ($tab === 'akaunti'): ?>
      <h2>Badilisha Nenosiri</h2>
      <p style="color:var(--ink-soft);font-size:.92rem;margin-top:-10px;margin-bottom:20px;">Kwa usalama, badilisha nenosiri la default (kisota2026) mara moja baada ya kupakia tovuti.</p>
      <form method="post" action="change_password.php">
        <div class="field"><label>Nenosiri la sasa</label><input type="password" name="current_password" required></div>
        <div class="field"><label>Nenosiri jipya</label><input type="password" name="new_password" required minlength="6"></div>
        <div class="field"><label>Rudia nenosiri jipya</label><input type="password" name="confirm_password" required minlength="6"></div>
        <button type="submit" class="btn btn-emerald" style="border:none;">Badilisha Nenosiri</button>
      </form>
    <?php endif; ?>

  </div>
</div>

</body>
</html>
