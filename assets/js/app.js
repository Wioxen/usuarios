
/* ============================================================
   Digite SaaS — app.js
   Core: inicialização, roteamento, sidebar, dashboard, utilitários
   Requer: jQuery 3.x, Bootstrap 5.x, usuario.js (carregado antes)
   ============================================================ */

/* ── BOOT ──────────────────────────────────────────────────── */
$(function () {

  /* Inicializa modais do módulo de usuários */
  initUsuarioModals();

  /* Navega para o módulo inicial injetado pelo PHP */
  showModule(window.INITIAL_MODULE || 'dashboard');

  /* Permite fechar sidebar ao pressionar ESC */
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') closeSidebar();
  });

});

/* ── SIDEBAR ────────────────────────────────────────────────── */
function toggleSidebar() {
  const isOpen = $('#sidebar').hasClass('open');
  isOpen ? closeSidebar() : openSidebar();
}

function openSidebar() {
  $('#sidebar').addClass('open');
  $('#sidebarOverlay').addClass('open');
}

function closeSidebar() {
  $('#sidebar').removeClass('open');
  $('#sidebarOverlay').removeClass('open');
}

/* ── MODULE ROUTER ──────────────────────────────────────────── */
function showModule(mod) {

  /* Oculta todas as views */
  $('#viewDashboard').hide();
  $('#viewUsuarios').hide();

  /* Exibe a view correta e configura topbar */
  if (mod === 'usuarios') {
    $('#viewUsuarios').show();
    setTopbar('Usuários', 'Usuários');
    loadUsuarios();
  } else {
    $('#viewDashboard').show();
    setTopbar('Dashboard', 'Início');
    loadDashStats();
  }

  /* Atualiza estado ativo do menu */
  $('.nav-item').removeClass('active');
  if (mod === 'dashboard') $('.nav-item').eq(0).addClass('active');
  if (mod === 'usuarios')  $('.nav-item').eq(1).addClass('active');

  /* Fecha sidebar no mobile */
  closeSidebar();

  /* Atualiza URL sem recarregar */
  const url = mod === 'dashboard' ? 'index.php' : 'index.php?module=' + mod;
  window.history.replaceState(null, '', url);
}

function setTopbar(title, breadcrumb) {
  $('#pageTitle').text(title);
  $('#breadcrumbText').text(breadcrumb);
}

/* ── DASHBOARD STATS ────────────────────────────────────────── */
function loadDashStats() {
  $.get(USUARIO_API)
    .done(function (data) {
      const total = Array.isArray(data) ? data.length : '—';
      $('#dashTotalUsers').text(total);
    })
    .fail(function () {
      $('#dashTotalUsers').text('—');
    });
}

/* ── TOAST ──────────────────────────────────────────────────── */
function showToast(msg, type = 'info') {
  const icons = {
    success: `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
              </svg>`,
    error:   `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9"  y1="9" x2="15" y2="15"/>
              </svg>`,
    info:    `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8"  x2="12"    y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
              </svg>`,
  };

  const icon = icons[type] || icons.info;
  const $t   = $(`<div class="toast-item ${type}">${icon}<span>${msg}</span></div>`);

  $('#toastContainer').append($t);

  setTimeout(() => {
    $t.fadeOut(350, function () { $(this).remove(); });
  }, 3500);
}

/* ── HELPERS ────────────────────────────────────────────────── */
function escHtml(str) {
  return $('<div>').text(str || '').html();
}
