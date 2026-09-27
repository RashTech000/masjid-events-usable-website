/* ============================================================
   Masjid Kisota — app.js
   1) PWA install (Android/Chrome prompt + iOS instructions modal)
   2) Live clock + Hijri (approx) date on the Ratiba board
   3) Live "next salah" countdown, highlighting the upcoming prayer
   ============================================================ */

(function () {
  'use strict';

  /* ---------------- 1) INSTALL / DOWNLOAD APP ---------------- */

  var deferredPrompt = null;
  var installBtns = document.querySelectorAll('[data-install-btn]');
  var iosBtns = document.querySelectorAll('[data-ios-btn]');
  var iosModal = document.getElementById('iosInstallModal');
  var iosModalClose = document.getElementById('iosModalClose');
  var installBanner = document.getElementById('installBanner');

  function isStandalone() {
    return window.matchMedia('(display-mode: standalone)').matches ||
      window.navigator.standalone === true;
  }

  function isIOS() {
    return /iphone|ipad|ipod/i.test(navigator.userAgent) ||
      (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
  }

  function showEl(el) { if (el) el.style.display = ''; }
  function hideEl(el) { if (el) el.style.display = 'none'; }

  if (isStandalone()) {
    // Tayari imewekwa kama app — hakuna haja ya kuonyesha banner ya kupakua.
    hideEl(installBanner);
  } else if (isIOS()) {
    // iOS haitoi "beforeinstallprompt" — onyesha maelekezo badala yake.
    installBtns.forEach(hideEl);
    iosBtns.forEach(showEl);
  } else {
    // Android/Desktop Chrome — subiri tukio la beforeinstallprompt.
    iosBtns.forEach(hideEl);
    window.addEventListener('beforeinstallprompt', function (e) {
      e.preventDefault();
      deferredPrompt = e;
      installBtns.forEach(showEl);
    });
    window.addEventListener('appinstalled', function () {
      hideEl(installBanner);
      deferredPrompt = null;
    });
  }

  installBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      if (!deferredPrompt) return;
      deferredPrompt.prompt();
      deferredPrompt.userChoice.finally(function () { deferredPrompt = null; });
    });
  });

  iosBtns.forEach(function (btn) {
    btn.addEventListener('click', function () { showEl(iosModal); });
  });
  if (iosModalClose) iosModalClose.addEventListener('click', function () { hideEl(iosModal); });
  if (iosModal) iosModal.addEventListener('click', function (e) { if (e.target === iosModal) hideEl(iosModal); });

  /* ---------------- 2 & 3) CLOCK, HIJRI DATE, NEXT-SALAH COUNTDOWN ---------------- */

  var clockEl = document.getElementById('liveClock');
  var hijriEl = document.getElementById('hijriDate');
  var gregEl = document.getElementById('gregDate');
  var nextNameEl = document.getElementById('nextSalahName');
  var countdownEl = document.getElementById('nextSalahCountdown');
  var salahCards = document.querySelectorAll('.salah-card');

  // window.KISOTA_PRAYERS imewekwa na index.php: [{name, adhana}, ...]
  var prayers = (window.KISOTA_PRAYERS || []).map(function (p) {
    var m = String(p.adhana || '').match(/(\d{1,2}):(\d{2})/);
    return {
      name: p.name,
      h: m ? parseInt(m[1], 10) : null,
      min: m ? parseInt(m[2], 10) : null
    };
  }).filter(function (p) { return p.h !== null; });

  function pad(n) { return String(n).padStart(2, '0'); }

  function updateClock() {
    var now = new Date();

    if (clockEl) clockEl.textContent = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());

    if (gregEl) {
      try {
        gregEl.textContent = new Intl.DateTimeFormat('sw-TZ', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).format(now);
      } catch (e) { gregEl.textContent = now.toDateString(); }
    }

    if (hijriEl) {
      try {
        hijriEl.textContent = new Intl.DateTimeFormat('en-u-ca-islamic', { day: 'numeric', month: 'long', year: 'numeric' }).format(now) + ' AH';
      } catch (e) { hijriEl.textContent = ''; }
    }

    if (!prayers.length) return;

    // Tafuta swala inayofuata kwa kulinganisha na muda wa sasa (kwa dakika).
    var nowMin = now.getHours() * 60 + now.getMinutes();
    var upcoming = null, upcomingIdx = -1;
    for (var i = 0; i < prayers.length; i++) {
      var pm = prayers[i].h * 60 + prayers[i].min;
      if (pm > nowMin) { upcoming = prayers[i]; upcomingIdx = i; break; }
    }
    var isTomorrow = false;
    if (!upcoming) { upcoming = prayers[0]; upcomingIdx = 0; isTomorrow = true; }

    var targetMin = upcoming.h * 60 + upcoming.min;
    var diff = isTomorrow ? (1440 - nowMin + targetMin) : (targetMin - nowMin);
    var diffSeconds = diff * 60 - now.getSeconds();
    if (diffSeconds < 0) diffSeconds = 0;
    var hh = Math.floor(diffSeconds / 3600);
    var mm = Math.floor((diffSeconds % 3600) / 60);
    var ss = diffSeconds % 60;

    if (nextNameEl) nextNameEl.textContent = upcoming.name;
    if (countdownEl) countdownEl.textContent = pad(hh) + ':' + pad(mm) + ':' + pad(ss);

    salahCards.forEach(function (card, idx) {
      card.classList.toggle('is-next', idx === upcomingIdx);
    });
  }

  updateClock();
  setInterval(updateClock, 1000);
})();
