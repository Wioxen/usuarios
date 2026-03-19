/* ============================================================
   Digite SaaS — usuario.js
   Módulo: CRUD completo de Usuários
   Depende de: jQuery, Bootstrap 5, app.js (showToast, escHtml)
   ============================================================ */

const USUARIO_API = 'https://api-usuario.digite.com.br/Usuario';

let userModalBS     = null;
let deleteModalBS   = null;
let pendingDeleteId = null;

/* ── INIT ──────────────────────────────────────────────────
   Chamado pelo app.js no boot da aplicação
──────────────────────────────────────────────────────────── */
function initUsuarioModals() {
  userModalBS   = new bootstrap.Modal(document.getElementById('userModal'));
  deleteModalBS = new bootstrap.Modal(document.getElementById('deleteModal'));
}

/* ── LIST ──────────────────────────────────────────────────
   GET /Usuario
──────────────────────────────────────────────────────────── */
function loadUsuarios() {
  $('#tableBody').html(`
    <tr class="loading-row">
      <td colspan="4">
        <div class="spinner"></div>
        <div class="loading-text">Carregando…</div>
      </td>
    </tr>`);

  $.ajax({ url: USUARIO_API, method: 'GET' })
    .done(function (data) {
      renderTable(Array.isArray(data) ? data : []);
    })
    .fail(function (xhr) {
      showToast(
        'Erro ao carregar usuários: ' + (xhr.responseJSON?.message || xhr.status),
        'error'
      );
      _renderError();
    });
}

function _renderError() {
  $('#tableBody').html(`
    <tr><td colspan="4">
      <div class="empty-state">
        <div class="empty-icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8"  x2="12"    y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
        </div>
        <div class="empty-title">Erro ao conectar à API</div>
        <div class="empty-text">Verifique a conexão e tente novamente.</div>
      </div>
    </td></tr>`);
}

/* ── RENDER TABLE ──────────────────────────────────────────── */
function renderTable(users) {
  if (!users.length) {
    $('#tableBody').html(`
      <tr><td colspan="4">
        <div class="empty-state">
          <div class="empty-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
            </svg>
          </div>
          <div class="empty-title">Nenhum usuário encontrado</div>
          <div class="empty-text">Clique em "Novo Usuário" para começar.</div>
        </div>
      </td></tr>`);
    return;
  }

  const rows = users.map(u => {
    const initial = (u.nome || '?').charAt(0).toUpperCase();
    return `
      <tr data-name="${escHtml((u.nome || '').toLowerCase())}"
          data-email="${escHtml((u.email || '').toLowerCase())}">
        <td><span class="id-badge">${u.id}</span></td>
        <td>
          <div class="avatar-cell">
            <div class="avatar-mini">${initial}</div>
            <span>${escHtml(u.nome)}</span>
          </div>
        </td>
        <td><span class="email-cell">${escHtml(u.email)}</span></td>
        <td>
          <div class="actions-cell">
            <button class="btn-icon" title="Editar" onclick="editUser(${u.id})">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
              </svg>
            </button>
            <button class="btn-icon danger" title="Excluir" onclick="confirmDelete(${u.id})">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6"/><path d="M14 11v6"/>
              </svg>
            </button>
          </div>
        </td>
      </tr>`;
  }).join('');

  $('#tableBody').html(rows);
  filterTable();
}

/* ── FILTER ────────────────────────────────────────────────── */
function filterTable() {
  const q = ($('#searchInput').val() || '').toLowerCase().trim();
  $('#tableBody tr[data-name]').each(function () {
    const match = !q
      || ($(this).data('name')  || '').includes(q)
      || ($(this).data('email') || '').includes(q);
    $(this).toggle(match);
  });
}

/* ── OPEN MODAL ────────────────────────────────────────────── */
function openModal(id, nome, email) {
  $('#userId').val(id   || '');
  $('#userName').val(nome  || '');
  $('#userEmail').val(email || '');

  if (id) {
    $('#modalTitleText').text('Editar Usuário');
    $('#modalIconWrap').html(`
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
           stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
      </svg>`);
  } else {
    $('#modalTitleText').text('Novo Usuário');
    $('#modalIconWrap').html(`
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
           stroke="currentColor" stroke-width="2.5">
        <line x1="12" y1="5"  x2="12" y2="19"/>
        <line x1="5"  y1="12" x2="19" y2="12"/>
      </svg>`);
  }

  userModalBS.show();

  /* Foca o primeiro campo após abrir */
  $('#userModal').one('shown.bs.modal', function () {
    $('#userName').trigger('focus');
  });
}

/* ── GET + OPEN (edição) ────────────────────────────────────── */
function editUser(id) {
  $.get(USUARIO_API + '/' + id)
    .done(function (u) { openModal(u.id, u.nome, u.email); })
    .fail(function ()  { showToast('Erro ao carregar usuário.', 'error'); });
}

/* ── SAVE — POST ou PUT ─────────────────────────────────────── */
function saveUser() {
  const id    = $('#userId').val();
  const nome  = $('#userName').val().trim();
  const email = $('#userEmail').val().trim();

  if (!nome || !email) {
    showToast('Preencha nome e e-mail.', 'error');
    return;
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    showToast('Informe um e-mail válido.', 'error');
    return;
  }

  const payload = { nome, email };
  if (id) payload.id = parseInt(id, 10);

  const method = id ? 'PUT'                 : 'POST';
  const url    = id ? USUARIO_API + '/' + id : USUARIO_API;

  const $btn = $('#btnSave');
  $btn.prop('disabled', true).html(`
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
          style="width:13px;height:13px;border-width:2px;"></span>
    Salvando…`);

  $.ajax({
    url,
    method,
    contentType: 'application/json',
    data: JSON.stringify(payload),
  })
    .done(function () {
      userModalBS.hide();
      showToast(id ? 'Usuário atualizado com sucesso!' : 'Usuário criado com sucesso!', 'success');
      loadUsuarios();
    })
    .fail(function (xhr) {
      showToast('Erro: ' + (xhr.responseJSON?.message || xhr.status), 'error');
    })
    .always(function () {
      $btn.prop('disabled', false).html(`
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
          <polyline points="20 6 9 17 4 12"/>
        </svg> Salvar`);
    });
}

/* ── CONFIRM DELETE ─────────────────────────────────────────── */
function confirmDelete(id) {
  pendingDeleteId = id;
  $('#btnConfirmDelete').off('click').on('click', function () {
    deleteUser(pendingDeleteId);
  });
  deleteModalBS.show();
}

/* ── DELETE — DELETE /Usuario/{id} ─────────────────────────── */
function deleteUser(id) {
  const $btn = $('#btnConfirmDelete');
  $btn.prop('disabled', true).html(`
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
          style="width:12px;height:12px;border-width:2px;"></span>
    Excluindo…`);

  $.ajax({ url: USUARIO_API + '/' + id, method: 'DELETE' })
    .done(function () {
      deleteModalBS.hide();
      showToast('Usuário excluído com sucesso.', 'success');
      loadUsuarios();
    })
    .fail(function (xhr) {
      deleteModalBS.hide();
      showToast('Erro ao excluir: ' + (xhr.responseJSON?.message || xhr.status), 'error');
    })
    .always(function () {
      $btn.prop('disabled', false).html(`
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
          <polyline points="3 6 5 6 21 6"/>
          <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
        </svg> Confirmar`);
    });
}
