/* ============================================
   app.js — Core: boot, router, sidebar, utils
   ============================================ */

$(function() {
  // Init modals
  initUsuarioModals();

  // Boot module from PHP
  var mod = window.INITIAL_MODULE || 'dashboard';
  showModule(mod, true);

  // ESC to close sidebar
  $(document).on('keydown', function(e) {
    if (e.key === 'Escape') closeSidebar();
  });

  // Search binding
  $('#searchUsuarios').on('input', function() {
    filterTable();
  });
});

/* --- Module Router --- */
function showModule(mod, skipPush) {
  // Hide all views
  $('.view-section').removeClass('active');

  // Show target
  var target = document.getElementById('view-' + mod);
  if (target) {
    target.classList.add('active');
  } else {
    document.getElementById('view-dashboard').classList.add('active');
    mod = 'dashboard';
  }

  // Update active nav
  $('.nav-item').removeClass('active');
  $('.nav-item').each(function() {
    var onclick = $(this).attr('onclick') || '';
    if (onclick.indexOf("'" + mod + "'") > -1) {
      $(this).addClass('active');
    }
  });

  // Update topbar
  var titles = {
    'dashboard': 'Dashboard',
    'usuarios':  'Usuários'
  };
  $('#topbarTitle').text(titles[mod] || mod);
  $('#breadcrumbModule').text(titles[mod] || mod);

  // Load module data
  if (mod === 'dashboard') {
    loadDashStats();
  } else if (mod === 'usuarios') {
    loadUsuarios();
  }

  // Update URL
  if (!skipPush) {
    var url = mod === 'dashboard' ? '/' : '?module=' + mod;
    history.replaceState(null, '', url);
  }

  // Close sidebar on mobile
  closeSidebar();
}

/* --- Sidebar Controls --- */
function toggleSidebar() {
  var sb = document.getElementById('sidebar');
  var ov = document.getElementById('sidebarOverlay');
  sb.classList.toggle('open');
  ov.classList.toggle('show');
}

function openSidebar() {
  document.getElementById('sidebar').classList.add('open');
  document.getElementById('sidebarOverlay').classList.add('show');
}

function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('sidebarOverlay').classList.remove('show');
}

/* --- Dashboard Stats --- */
function loadDashStats() {
  var el = document.getElementById('statTotalUsers');
  if (!el) return;

  el.textContent = '...';

  $.ajax({
    url: USUARIO_API,
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      var count = Array.isArray(data) ? data.length : 0;
      el.textContent = count;
    },
    error: function() {
      el.textContent = '—';
    }
  });
}

/* --- Toast Notifications --- */
function showToast(msg, type) {
  type = type || 'info';
  var container = document.getElementById('toastContainer');
  if (!container) return;

  var icons = {
    success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
    error:   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
    info:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
  };

  var toast = document.createElement('div');
  toast.className = 'toast-msg ' + type;
  toast.innerHTML = (icons[type] || icons.info) + '<span>' + escHtml(msg) + '</span>';
  container.appendChild(toast);

  setTimeout(function() {
    toast.classList.add('fade-out');
    setTimeout(function() {
      toast.remove();
    }, 300);
  }, 3500);
}

/* --- Escape HTML --- */
function escHtml(str) {
  if (!str) return '';
  var div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}
