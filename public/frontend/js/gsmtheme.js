$(window).on('load', function () {
    setTimeout(function () {
        $('#gsmtheme-loader').remove();
        $('#gsmtheme-content').removeClass('d-none').hide().fadeIn(200);
    }, 1000);
});

function getDeviceFingerprint() {
  try {

    let deviceId = localStorage.getItem('device_id');

    if (!deviceId) {
      if (window.crypto && crypto.randomUUID) {
        deviceId = crypto.randomUUID();
      } else {
        deviceId = 'dev-' + Math.random().toString(36).slice(2) + Date.now();
      }
      localStorage.setItem('device_id', deviceId);
    }

    const data = {
      device_id: deviceId,
      user_agent: navigator.userAgent || '',
      platform: navigator.platform || '',
      language: navigator.language || '',
      timezone: (
        Intl &&
        Intl.DateTimeFormat &&
        Intl.DateTimeFormat().resolvedOptions
      )
        ? Intl.DateTimeFormat().resolvedOptions().timeZone
        : '',
      screen: (screen && screen.width && screen.height)
        ? screen.width + 'x' + screen.height
        : ''
    };

    return btoa(unescape(encodeURIComponent(JSON.stringify(data))));

  } catch (e) {

    return btoa(JSON.stringify({
      device_id: 'fallback-' + Date.now()
    }));
  }
}

const notyf = new Notyf({
  limit: 1,
  duration: 5000,
  dismissible: false,
  position: {
    x: 'left',
    y: 'bottom',
  },
  types: [
    {
      type: 'success',
      className: 'toast-250',
    },
    {
      type: 'error',
      className: 'toast-250',
    }
  ]
});
function successToast(message) {
  notyf.dismissAll();
  notyf.success(message);
}
function errorToast(message) {
  notyf.dismissAll();
  notyf.error(message);
}

function successModal(message) {
  $('#successModalText').text(message);
  $('#successModal').modal('show');
}

function confirmLogout(element) {
  var logoutUrl = $(element).data('logout-url');
  if (confirm("Are you sure to logout?")) {
    window.location.href = logoutUrl;
  }
}

$('.menu-login-btn').on('click', function () {
  $('#menuOffcanvas').offcanvas('hide');
})

$(document).ajaxSend(function (event, jqxhr, settings) {
  NProgress.start()
}
);

$(document).ajaxComplete(function (event, jqxhr, settings) {
  NProgress.done()
});

// header
const $wrap = $('#navWrap');
const $track = $('#navTrack');
const $arrowLeft = $('#arrowLeft');
const $arrowRight = $('#arrowRight');

let currentTX = 0;
let dragging = false, startX = 0, startTX = 0, moved = false;

/* ── Clamp helper ── */
function maxLeft() {
  const overflow = $track[0].offsetWidth - $wrap[0].offsetWidth;
  return overflow > 0 ? -overflow : 0;
}
function applyTX(x, animated) {
  currentTX = Math.min(0, Math.max(maxLeft(), x));
  if (animated) {
    $track.removeClass('no-transition');
  } else {
    $track.addClass('no-transition');
  }
  $track.css('transform', `translateX(${currentTX}px)`);
  updateArrows();
}

/* ── Show/hide arrows based on scroll position ── */
function updateArrows() {
  const ml = maxLeft();
  const hasOverflow = ml < 0;

  $arrowLeft.toggleClass('visible', hasOverflow && currentTX < 0);
  $arrowRight.toggleClass('visible', hasOverflow && currentTX > ml);
}

/* ── Arrow click scroll (160px per click) ── */
$arrowLeft.on('click', () => applyTX(currentTX + 160, true));
$arrowRight.on('click', () => applyTX(currentTX - 160, true));

/* ── Drag scroll ── */
$track.on('mousedown', function (e) {
  if (e.button !== 0) return;
  dragging = true; moved = false;
  startX = e.clientX; startTX = currentTX;
  $track.addClass('grabbing');
  e.preventDefault();
});
$(window).on('mousemove', function (e) {
  if (!dragging) return;
  const d = e.clientX - startX;
  if (Math.abs(d) > 3) moved = true;
  applyTX(startTX + d, false);
});
$(window).on('mouseup', function () {
  dragging = false;
  $track.removeClass('grabbing');
});

/* Prevent accidental link clicks after drag */
$track.find('a').on('click', function (e) {
  if (moved) { e.preventDefault(); moved = false; }
});

/* Touch support */
$track[0].addEventListener('touchstart', e => {
  startX = e.touches[0].clientX; startTX = currentTX; dragging = true;
}, { passive: true });
$track[0].addEventListener('touchmove', e => {
  if (!dragging) return;
  applyTX(startTX + (e.touches[0].clientX - startX), false);
}, { passive: true });
$track.on('touchend', () => { dragging = false; });

/* Initial check + on resize */
updateArrows();
$(window).on('resize', () => { applyTX(currentTX, false); });

/* ── DROPDOWNS ── */
let activeItem = null, hideTimer = null;

function showDrop(li) {
  clearTimeout(hideTimer);
  if (activeItem && activeItem !== li) closeDrop(activeItem, true);
  const $li = $(li);
  const $drop = $('#' + $li.data('drop'));
  if (!$drop.length) return;
  const r = li.getBoundingClientRect();
  $drop.css({ top: (r.bottom + 2) + 'px', left: r.left + 'px' })
    .addClass('visible');
  $li.addClass('is-open');
  activeItem = li;
}
function closeDrop(li, immediate) {
  const $li = $(li);
  const $drop = $('#' + $li.data('drop'));
  if (!$drop.length) return;
  const run = () => {
    $drop.removeClass('visible');
    $li.removeClass('is-open');
    if (activeItem === li) activeItem = null;
  };
  immediate ? run() : (hideTimer = setTimeout(run, 120));
}

$('.has-drop').each(function () {
  const li = this;
  const $li = $(li);
  const $drop = $('#' + $li.data('drop'));
  if (!$drop.length) return;

  $li.on('mouseenter', () => showDrop(li));
  $li.on('mouseleave', e => {
    if (!$drop[0].contains(e.relatedTarget)) closeDrop(li, false);
  });
  $drop.on('mouseenter', () => { clearTimeout(hideTimer); $li.addClass('is-open'); });
  $drop.on('mouseleave', e => {
    if (!$li[0].contains(e.relatedTarget)) closeDrop(li, false);
  });
});

$(document).on('click', function (e) {
  if (!$(e.target).closest('.has-drop').length && !$(e.target).closest('.gsm-dropdown').length) {
    $('.has-drop').each(function () { closeDrop(this, true); });
  }
});


