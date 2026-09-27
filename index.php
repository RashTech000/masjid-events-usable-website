<?php
require_once __DIR__ . '/functions.php';
$prayerTimes   = get_prayer_times();
$announcements = get_announcements();
$khutbaList    = get_khutba();
?>
<!DOCTYPE html>
<html lang="sw">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="log.png">

<title>Masjid Kisota — Mjimwema, Kigamboni</title>
<meta name="description" content="Masjid Kisota, Mjimwema - Kigamboni: ratiba za swala, matangazo, khutba za Ijumaa na Madrasatu Kisota.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<!-- PWA: hii ndiyo inaifanya website iwe "app" inayowekwa kwenye simu -->
<link rel="manifest" href="manifest.json">
<meta name="theme-color" content="#0B6B53">
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Kisota">
</head>
<body>

<header class="site">
  <div class="nav">
    <a class="brand" href="#top">
      <img src="log.png" alt="Logo yangu" class="brand-logo" style="width:38px;height:38px;margin-left:0px; border-radius:10px;">
      <span class="brand-text">Masjid Kisota</span>
    </a>
    <nav class="links" id="navLinks">
      <a class="nl" href="#historia">Kuhusu</a>
      <a class="nl" href="#ratiba">Ratiba za Swala</a>
      <a class="nl" href="#matangazo">Matangazo</a>
      <a class="nl" href="#khutba">Khutba</a>
      <a class="nl" href="#madrasa">Madrasa</a>
      <a class="nl" href="#mchango">Mchango</a>
      <a class="nl" href="#mawasiliano">Mawasiliano</a>
      <button class="install-link" data-install-btn style="display:none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12m0 0 4-4m-4 4-4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
        Pakua App
      </button>
      <button class="install-link" data-ios-btn style="display:none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12m0 0 4-4m-4 4-4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
        Pakua App
      </button>
      <a class="admin-link" href="login.php">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
        Msimamizi
      </a>
    </nav>
    <button class="menu-btn" id="menuBtn" aria-label="Fungua menyu">☰</button>
  </div>
</header>

<!-- TICKER: bar inayopita ikionyesha taarifa mbalimbali -->
<div class="ticker-bar" role="marquee" aria-label="Taarifa za haraka">
  <div class="ticker-track">
    <?php
      $tickerItems = [];
      $tickerItems[] = '🕌 Karibu Masjid Kisota — Mjimwema, Kigamboni';
      foreach (array_slice($announcements, 0, 4) as $a) { $tickerItems[] = '📢 ' . $a['title']; }
      foreach (array_slice($khutbaList, 0, 2) as $k) { $tickerItems[] = '🎙️ Khutba: ' . $k['topic'] . ($k['date_label'] ? ' — ' . $k['date_label'] : ''); }
      $tickerItems[] = '📖 Madrasatu Kisota — Jumatatu hadi Alhamisi, baada ya Magharibi';
      $tickerItems[] = '🤲 Changia ujenzi na uendeshaji wa Masjid — angalia sehemu ya Mchango';
      if (!$tickerItems) $tickerItems[] = 'Karibu Masjid Kisota';
      // Rudia mara mbili ili mzunguko wa animation usionekane na pengo.
      $tickerDouble = array_merge($tickerItems, $tickerItems);
      foreach ($tickerDouble as $i => $txt):
    ?>
      <span class="ticker-item"><?= e($txt) ?></span><span class="ticker-sep">•</span>
    <?php endforeach; ?>
  </div>
</div>

<!-- INSTALL BANNER -->
<div class="install-banner" id="installBanner">
  <div class="wrap install-banner-in">
    <div class="install-banner-txt">
      <strong>📲 Pakua App ya Masjid Kisota</strong>
      <span>Iweke kwenye simu yako (Android au iPhone) upate ratiba na matangazo haraka zaidi, hata bila internet.</span>
    </div>
    <div class="install-banner-btns">
      <button class="btn btn-gold" data-install-btn style="display:none;">⬇ Pakua kwa Android</button>
      <button class="btn btn-gold" data-ios-btn style="display:none;">⬇ Pakua kwa iPhone</button>
    </div>
  </div>
</div>

<!-- IOS INSTALL MODAL -->
<div class="ios-modal" id="iosInstallModal" style="display:none;">
  <div class="ios-modal-card">
    <button class="ios-modal-close" id="iosModalClose" aria-label="Funga">✕</button>
    <h3>Jinsi ya kupakua kwenye iPhone/iPad</h3>
    <ol>
      <li>Fungua tovuti hii kwa <strong>Safari</strong> (si Chrome).</li>
      <li>Bonyeza kitufe cha <strong>Share</strong> <span class="ios-ic">⬆️</span> kilichopo chini ya screen.</li>
      <li>Chagua <strong>"Add to Home Screen" / "Ongeza kwenye Skrini ya Nyumbani"</strong>.</li>
      <li>Bonyeza <strong>Add</strong> — App itaonekana kwenye skrini yako kama app ya kawaida.</li>
    </ol>
  </div>
</div>

<main id="top">

  <!-- HERO -->
  <section class="hero" style="border-bottom:none;--hero-img:url('building.jpg');">
    <div class="bg"></div>
    <div class="scrim"></div>
    <div class="wrap content">
      <div class="eyebrow">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
      <h1>Masjid Kisota</h1>
      <p class="lead">Nyumba ya ibada na kituo cha jamii ya Waislamu wa Kisota, Kata ya Mjimwema, Wilaya ya Kigamboni — Dar es Salaam.</p>
      <div class="cta-row">
        <a class="btn btn-gold" href="#ratiba">Ona ratiba za swala</a>
        <a class="btn btn-outline" href="#mawasiliano">Tufikie</a>
      </div>
    </div>
  </section>
  <div class="hero-divider"></div>

  <!-- HISTORIA -->
  <section id="historia">
    <div class="wrap">
      <div class="section-head">
        <div class="kicker">Kuhusu Masjid</div>
        <h2>Historia na dhamira yetu</h2>
      </div>
      <div class="history-grid">
        <div class="history-photo">
          <img src="mihrab.jpg" alt="Mihrabu ya Masjid Kisota">
        </div>
        <div>
          <p>Masjid Kisota imesimama kama kitovu cha ibada na maisha ya kijamii kwa Waislamu wa eneo la Kisota na maeneo jirani ya Mjimwema, Kigamboni. Ni mahali pa Waumini kukutana kwa swala tano za kila siku, Swala ya Ijumaa, na shughuli mbalimbali za kidini na kielimu ndani ya jamii.</p>
          <p>Pamoja na ibada, Masjid Kisota inaendesha <strong>Madrasatu Kisota</strong> — mafunzo ya dini kwa watoto na vijana — ikiwa na lengo la kuwajengea Waumini na kizazi kijacho msingi imara wa dini na maadili.</p>
          <div class="pillars">
            <div class="pillar">
              <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3v4M5 21v-6a7 7 0 0 1 14 0v6"/><path d="M3 21h18"/></svg></div>
              <div><h3>Ibada</h3><p>Swala tano kwa siku, Swala ya Ijumaa, na Swala za Sunna kwa jamii nzima.</p></div>
            </div>
            <div class="pillar">
              <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg></div>
              <div><h3>Elimu — Madrasatu Kisota</h3><p>Kuhifadhi Qur'an, Adhkari, Lugha ya Kiarabu na Tarbiya kwa watoto na vijana.</p></div>
            </div>
            <div class="pillar">
              <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg></div>
              <div><h3>Huduma kwa jamii</h3><p>Misaada kwa wenye mahitaji, Zakat, na shughuli za kujitolea.</p></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- RATIBA ZA SWALA -->
  <section id="ratiba">
    <div class="wrap">
      <div class="salah-wrap salah-premium">
        <div class="salah-pattern" aria-hidden="true"></div>

        <div class="salah-head">
          <div>
            <div class="kicker kicker-light">Ubao wa Masjid</div>
            <h2>Ratiba za Swala</h2>
          </div>
          <div class="salah-clock-box">
            <div class="salah-clock" id="liveClock">--:--:--</div>
            <div class="salah-greg" id="gregDate"></div>
            <div class="salah-hijri" id="hijriDate"></div>
          </div>
        </div>

        <div class="next-salah-strip">
          <span class="next-label">Swala inayofuata</span>
          <span class="next-name" id="nextSalahName">—</span>
          <span class="next-countdown" id="nextSalahCountdown">--:--:--</span>
        </div>

        <?php if (!$prayerTimes): ?>
          <div class="empty-note" style="color:#E8E3D0;">Ratiba haijawekwa bado.</div>
        <?php else: ?>
        <div class="salah-cards">
          <?php foreach ($prayerTimes as $p):
            $nm = mb_strtolower($p['name']);
            if (strpos($nm,'fajir')!==false || strpos($nm,'fajr')!==false || strpos($nm,'alfajiri')!==false) $icon='sunrise';
            elseif (strpos($nm,'adhuhuri')!==false || strpos($nm,'dhuhuri')!==false || strpos($nm,'dhuhr')!==false) $icon='sun';
            elseif (strpos($nm,'asiri')!==false || strpos($nm,'asr')!==false) $icon='sun-low';
            elseif (strpos($nm,'magharibi')!==false || strpos($nm,'maghrib')!==false) $icon='sunset';
            elseif (strpos($nm,'isha')!==false) $icon='moon';
            else $icon='star';
          ?>
          <div class="salah-card">
            <div class="salah-card-ic ic-<?= $icon ?>">
              <?php if ($icon==='sunrise'): ?><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 2v4M4.9 8.5l1.8 1.8M2 16h2M20 16h2M17.3 10.3l1.8-1.8M6 16a6 6 0 0 1 12 0"/><path d="M2 20h20"/></svg>
              <?php elseif ($icon==='sun'): ?><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="5"/><path d="M12 1v3M12 20v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M1 12h3M20 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1"/></svg>
              <?php elseif ($icon==='sun-low'): ?><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="14" r="4"/><path d="M12 3v4M4.9 9.5l1.8 1.8M2 17h2M20 17h2M17.3 11.3l1.8-1.8"/><path d="M4 21h16"/></svg>
              <?php elseif ($icon==='sunset'): ?><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 16V6M8.5 9.5 12 6l3.5 3.5"/><path d="M6 16a6 6 0 0 1 12 0"/><path d="M2 20h20M4 16h1M19 16h1"/></svg>
              <?php elseif ($icon==='moon'): ?><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a7 7 0 0 0 10.5 10.5Z"/></svg>
              <?php else: ?><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="m12 2 2.9 6.3 6.9.7-5.2 4.6 1.6 6.8L12 16.9 5.8 20.4l1.6-6.8L2.2 9l6.9-.7Z"/></svg>
              <?php endif; ?>
            </div>
            <div class="salah-card-name"><?= e($p['name']) ?></div>
            <div class="salah-card-times">
              <div><span>Adhana</span><strong><?= e($p['adhana']) ?></strong></div>
              <div><span>Iqama</span><strong><?= e($p['iqama']) ?></strong></div>
            </div>
            <div class="salah-card-badge">Inayofuata</div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="disclaimer">Muda huweza kubadilika kulingana na majira. Kama una wasiwasi, thibitisha na ubaoni wa matangazo Masjidini.</div>
      </div>
    </div>
  </section>

  <!-- MATANGAZO -->
  <section id="matangazo">
    <div class="wrap">
      <div class="section-head">
        <div class="kicker">Habari</div>
        <h2>Matangazo</h2>
        <p>Taarifa za hivi karibuni kutoka kwa Uongozi wa Masjid Kisota.</p>
      </div>
      <div class="card-grid">
        <?php if (!$announcements): ?>
          <div class="empty-note">Hakuna tangazo kwa sasa.</div>
        <?php else: foreach ($announcements as $a): ?>
          <div class="info-card">
            <div class="arch"></div>
            <div class="date"><?= e($a['date_label']) ?></div>
            <h3><?= e($a['title']) ?></h3>
            <p><?= nl2br(e($a['body'])) ?></p>
            <?php if ($a['tag']): ?><span class="tag"><?= e($a['tag']) ?></span><?php endif; ?>
          </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </section>

  <!-- KHUTBA YA IJUMAA -->
  <section id="khutba">
    <div class="wrap">
      <div class="section-head">
        <div class="kicker">Ijumaa</div>
        <h2>Khutba za Ijumaa</h2>
        <p>Mada na Makhatibu wa Swala ya Ijumaa, Masjid Kisota.</p>
      </div>
      <div class="card-grid">
        <?php if (!$khutbaList): ?>
          <div class="empty-note">Hakuna khutba iliyowekwa kwa sasa.</div>
        <?php else: foreach ($khutbaList as $k): ?>
          <div class="info-card">
            <div class="arch"></div>
            <div class="date"><?= e($k['date_label']) ?></div>
            <h3><?= e($k['topic']) ?></h3>
            <?php if ($k['khatib']): ?><p>Khatibu: <?= e($k['khatib']) ?></p><?php endif; ?>
            <?php if ($k['notes']): ?><p><?= nl2br(e($k['notes'])) ?></p><?php endif; ?>
          </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </section>

  <!-- MADRASA -->
  <section id="madrasa">
    <div class="wrap">
      <div class="section-head">
        <div class="kicker">Elimu</div>
        <h2>Madrasatu Kisota</h2>
        <p>Masomo ya dini kwa watoto, yaliyoko Masjid Kisota, Mjimwema — Kigamboni.</p>
      </div>
      <div class="madrasa-wrap">
        <div class="madrasa-grid">
          <div class="madrasa-card">
            <h3>Kuhifadhi Qur'an</h3>
            <p>Kusoma na kuhifadhi Qur'an Tukufu kwa watoto na vijana.</p>
            <div class="meta">Jumatatu – Alhamisi · Baada ya Magharibi</div>
          </div>
          <div class="madrasa-card">
            <h3>Kuhifadhi Adhkari</h3>
            <p>Dua na Adhkari za kila siku kama alizofundisha Mtume (S.A.W).</p>
            <div class="meta">Jumatatu – Alhamisi · Baada ya Magharibi</div>
          </div>
          <div class="madrasa-card">
            <h3>Lugha ya Kiarabu</h3>
            <p>Misingi ya Kiarabu kusaidia uelewa wa Qur'an na Hadithi.</p>
            <div class="meta">Jumatatu – Alhamisi · Baada ya Magharibi</div>
          </div>
          <div class="madrasa-card">
            <h3>Tarbiya</h3>
            <p>Malezi na maadili ya Kiislamu — hasa kipindi cha likizo, kwa wanafunzi wanaosubiri matokeo ya mtihani wa darasa la 7.</p>
            <div class="meta">Kipindi cha likizo</div>
          </div>
        </div>
        <div class="madrasa-side">
          <h3>Mlete mwanao apate elimu bora</h3>
          <p class="quote">"Kutafuta elimu ni lazima kwa kila Muislamu."</p>
          <ul>
            <li>Masomo: Qur'an, Kiarabu, Tarbiya, Adhkari</li>
            <li>Mahali: Madrasatu Kisota, Masjid Kisota — Mjimwema, Kigamboni</li>
            <li>Muda: Jioni baada ya Swala ya Magharibi, Jumatatu hadi Alhamisi</li>
          </ul>
          <div class="contact-mini">
            <strong>Kwa mawasiliano:</strong>
            +255 759 839 860<br>
            +255 688 410 836<br>
            masjidkisota@gmail.com
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MCHANGO -->
  <section id="mchango">
    <div class="wrap">
      <div class="section-head">
        <div class="kicker">Sadaka</div>
        <h2>Changia ujenzi na uendeshaji wa Masjid</h2>
        <p>Kila mchango unasaidia matengenezo, umeme, maji, na shughuli za Madrasa. Jazakumullahu khairan kwa ukarimu wenu.</p>
      </div>
      <div class="donate-grid">
        <div class="donate-box">
          <h3>Simu (Mobile Money)</h3>
          <div class="donate-row"><span>M-Pesa / Tigo Pesa</span><span>Wasiliana nasi</span></div>
          <div class="donate-row"><span>Namba za simu</span><span>+255 759 839 860</span></div>
          <div class="donate-row"><span></span><span>+255 688 410 836</span></div>
        </div>
        <div class="donate-box">
          <h3>Akaunti ya Benki</h3>
          <div class="donate-row"><span>Benki</span><span>Itajazwa na Uongozi</span></div>
          <div class="donate-row"><span>Namba ya Akaunti</span><span>Wasiliana nasi</span></div>
          <div class="donate-row"><span>Jina la Akaunti</span><span>Masjid Kisota</span></div>
        </div>
      </div>
    </div>
  </section>

  <!-- MAWASILIANO -->
  <section id="mawasiliano" style="border-bottom:none;">
    <div class="wrap">
      <div class="section-head">
        <div class="kicker">Wasiliana Nasi</div>
        <h2>Mawasiliano na mahali tulipo</h2>
      </div>
      <div class="contact-grid">
        <ul class="contact-list">
          <li>
            <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 1 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg></div>
            <div><div class="label">Mahali</div><div class="value">Kisota, Kata ya Mjimwema, Kigamboni — Dar es Salaam</div></div>
          </li>
          <li>
            <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.4 2.1L8 9.9a16 16 0 0 0 6 6l1.4-1.4a2 2 0 0 1 2.1-.4c.9.3 1.8.5 2.7.6a2 2 0 0 1 1.8 2Z"/></svg></div>
            <div><div class="label">Simu</div><a class="value" href="tel:+255759839860">+255 759 839 860</a><br><a class="value" href="tel:+255688410836">+255 688 410 836</a></div>
          </li>
          <li>
            <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/></svg></div>
            <div><div class="label">Barua pepe</div><a class="value" href="mailto:masjidkisota@gmail.com">masjidkisota@gmail.com</a></div>
          </li>
          <li>
            <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div>
            <div><div class="label">Saa za Ofisi</div><div class="value">Kila siku, kabla na baada ya swala tano</div></div>
          </li>
        </ul>
        <div class="map-card">
          <svg viewBox="0 0 400 260" xmlns="http://www.w3.org/2000/svg">
            <rect width="400" height="260" fill="#E4F1EA"/>
            <g stroke="#E4DAC2" stroke-width="1">
              <path d="M0 60 H400 M0 120 H400 M0 180 H400"/>
              <path d="M80 0 V260 M200 0 V260 M320 0 V260"/>
            </g>
            <path d="M0 150 C100 120 180 190 260 150 S400 110 400 130" stroke="#C98A3E" stroke-width="3" fill="none" opacity=".7"/>
            <circle cx="220" cy="120" r="6" fill="#0B6B53"/>
            <path d="M220 120 c0 14 -14 18 -14 32 c0 8 6 14 14 14 s14 -6 14 -14 c0 -14 -14 -18 -14 -32Z" fill="#C98A3E"/>
          </svg>
          <div class="cap">Masjid Kisota — Mjimwema, Kigamboni, Dar es Salaam. Bonyeza chini kufungua Ramani na kupata mwelekeo kutoka ulipo.</div>
          <a class="btn btn-gold" href="https://www.google.com/maps/search/?api=1&query=Masjid+Kisota+Mjimwema+Kigamboni+Dar+es+Salaam" target="_blank" rel="noopener">Fungua kwenye Ramani (Google Maps)</a>
        </div>
      </div>
    </div>
  </section>

</main>

<footer>
  <span class="brand-text">Masjid Kisota</span>
  Kisota · Mjimwema · Kigamboni · Dar es Salaam &nbsp;—&nbsp; © <?= date('Y') ?> Masjid Kisota
</footer>

<script>
  const menuBtn = document.getElementById('menuBtn');
  const navLinks = document.getElementById('navLinks');
  menuBtn.addEventListener('click', () => navLinks.classList.toggle('open'));
  navLinks.querySelectorAll('a.nl').forEach(a => a.addEventListener('click', () => navLinks.classList.remove('open')));

  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('service-worker.js').catch(() => {});
    });
  }
</script>

<script>
  window.KISOTA_PRAYERS = <?= json_encode(array_map(function($p){ return ['name'=>$p['name'],'adhana'=>$p['adhana']]; }, $prayerTimes), JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="app.js"></script>

</body>
</html>
