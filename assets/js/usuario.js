/* ============================================
   usuario.js — Módulo CRUD de Usuários
   API: https://api-usuario.digite.com.br
   ============================================ */

const USUARIO_API = 'https://api-usuario.digite.com.br/Usuario';

let modalUsuario = null;
let modalDelete  = null;
let editingId    = null;

/* --- Inicializar modais Bootstrap --- */
function initUsuarioModals() {
  const elModal  = document.getElementById('modalUsuario');
  const elDelete = document.getElementById('modalDelete');
  if (elModal)  modalUsuario = new bootstrap.Modal(elModal);
  if (elDelete) modalDelete  = new bootstrap.Modal(elDelete);
}

/* --- Carregar lista de usuários --- */
function loadUsuarios() {
  const tbody   = document.getElementById('usuariosBody');
  const wrapper = document.getElementById('usuariosTableWrapper');
  if (!tbody || !wrapper) return;

  // Show loading
  wrapper.innerHTML = `
    <div class="loading-state">
      <div class="spinner"></div>
      <p>Carregando usuários...</p>
    </div>`;

  $.ajax({
    url: USUARIO_API,
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      if (!data || data.length === 0) {
        wrapper.innerHTML = `
          <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <line x1="18" y1="8" x2="23" y2="13"/>
              <line x1="23" y1="8" x2="18" y2="13"/>
            </svg>
            <h4>Nenhum usuário encontrado</h4>
            <p>Clique em "Novo Usuário" para adicionar o primeiro.</p>
          </div>`;
        return;
      }
      // Restore table structure
      wrapper.innerHTML = `
        <table class="data-table" id="usuariosTable">
          <thead>
            <tr>
              <th>ID <span class="sort-icon">↕</span></th>
              <th>Usuário</th>
              <th class="hide-mobile">E-mail</th>
              <th>Status</th>
              <th style="text-align:right">Ações</th>
            </tr>
          </thead>
          <tbody id="usuariosBody"></tbody>
        </table>`;
      renderTable(data);
    },
    error: function(xhr) {
      wrapper.innerHTML = `
        <div class="error-state">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <h4>Erro ao carregar usuários</h4>
          <p>Não foi possível conectar à API. Tente novamente.</p>
          <button class="btn btn-primary btn-sm" onclick="loadUsuarios()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px">
              <polyline points="23 4 23 10 17 10"/>
              <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
            </svg>
            Tentar novamente
          </button>
        </div>`;
    }
  });
}

/* --- Renderizar tabela --- */
function renderTable(users) {
  const tbody = document.getElementById('usuariosBody');
  if (!tbody) return;

  window._allUsers = users;

  tbody.innerHTML = users.map(function(u, i) {
    const initial = u.nome ? u.nome.charAt(0).toUpperCase() : '?';
    const colorClass = 'avatar-' + (u.id % 6);
    return `
      <tr>
        <td class="muted">#${u.id}</td>
        <td>
          <div class="user-cell">
            <div class="avatar ${colorClass}">${escHtml(initial)}</div>
            <div class="user-details">
              <div class="name">${escHtml(u.nome)}</div>
              <div class="email d-mobile-only">${escHtml(u.email)}</div>
            </div>
          </div>
        </td>
        <td class="hide-mobile muted">${escHtml(u.email)}</td>
        <td>
          <span class="badge-status success"><span class="dot"></span>Ativo</span>
        </td>
        <td style="text-align:right">
          <div class="action-btns" style="justify-content:flex-end">
            <button class="action-btn" onclick="editUser(${u.id})" title="Editar">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
              </svg>
            </button>
            <button class="action-btn danger" onclick="confirmDelete(${u.id}, '${escHtml(u.nome).replace(/'/g, "\\'")}' )" title="Excluir">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                <line x1="10" y1="11" x2="10" y2="17"/>
                <line x1="14" y1="11" x2="14" y2="17"/>
              </svg>
            </button>
          </div>
        </td>
      </tr>`;
  }).join('');
}

/* --- Filtro client-side --- */
function filterTable() {
  const q = (document.getElementById('searchUsuarios')?.value || '').toLowerCase();
  if (!window._allUsers) return;

  const filtered = window._allUsers.filter(function(u) {
    return u.nome.toLowerCase().includes(q) || u.email.toLowerCase().includes(q);
  });
  renderTable(filtered);
}

/* --- Abrir modal criar/editar --- */
function openModal(id, nome, email) {
  const title  = document.getElementById('modalUsuarioLabel');
  const fNome  = document.getElementById('fieldNome');
  const fEmail = document.getElementById('fieldEmail');
  const btnTxt = document.getElementById('saveBtnText');

  // Reset
  fNome.classList.remove('is-invalid');
  fEmail.classList.remove('is-invalid');

  if (id) {
    editingId = id;
    title.textContent = 'Editar Usuário';
    btnTxt.textContent = 'Salvar Alterações';
    fNome.value  = nome || '';
    fEmail.value = email || '';
  } else {
    editingId = null;
    title.textContent = 'Novo Usuário';
    btnTxt.textContent = 'Criar Usuário';
    fNome.value  = '';
    fEmail.value = '';
  }

  modalUsuario.show();

  setTimeout(function() { fNome.focus(); }, 300);
}

/* --- Editar (GET por ID, depois abre modal) --- */
function editUser(id) {
  $.ajax({
    url: USUARIO_API + '/' + id,
    method: 'GET',
    dataType: 'json',
    success: function(u) {
      openModal(u.id, u.nome, u.email);
    },
    error: function() {
      showToast('Erro ao carregar dados do usuário.', 'error');
    }
  });
}

/* --- Salvar (POST ou PUT) --- */
function saveUser() {
  const fNome  = document.getElementById('fieldNome');
  const fEmail = document.getElementById('fieldEmail');
  const btn    = document.getElementById('saveBtn');
  let valid = true;

  // Validate
  fNome.classList.remove('is-invalid');
  fEmail.classList.remove('is-invalid');

  const nome  = fNome.value.trim();
  const email = fEmail.value.trim();

  if (!nome || nome.length > 50) {
    fNome.classList.add('is-invalid');
    valid = false;
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!email || email.length > 50 || !emailRegex.test(email)) {
    fEmail.classList.add('is-invalid');
    valid = false;
  }

  if (!valid) return;

  // Spinner
  btn.disabled = true;
  btn.querySelector('.spinner-border').classList.remove('d-none');

  const payload = { nome: nome, email: email };
  const method  = editingId ? 'PUT' : 'POST';
  const url     = editingId ? USUARIO_API + '/' + editingId : USUARIO_API;

  if (editingId) payload.id = editingId;

  $.ajax({
    url: url,
    method: method,
    contentType: 'application/json',
    data: JSON.stringify(payload),
    success: function() {
      modalUsuario.hide();
      loadUsuarios();
      loadDashStats();
      showToast(
        editingId ? 'Usuário atualizado com sucesso!' : 'Usuário criado com sucesso!',
        'success'
      );
    },
    error: function(xhr) {
      let msg = 'Erro ao salvar usuário.';
      if (xhr.responseJSON && xhr.responseJSON.errors) {
        msg = Object.values(xhr.responseJSON.errors).flat().join(', ');
      }
      showToast(msg, 'error');
    },
    complete: function() {
      btn.disabled = false;
      btn.querySelector('.spinner-border').classList.add('d-none');
    }
  });
}

/* --- Confirmar exclusão --- */
function confirmDelete(id, nome) {
  window._deleteId = id;
  const nameEl = document.getElementById('deleteUserName');
  if (nameEl) nameEl.textContent = nome;
  modalDelete.show();
}

/* --- Excluir --- */
function deleteUser() {
  const id  = window._deleteId;
  const btn = document.getElementById('deleteBtn');
  if (!id) return;

  btn.disabled = true;
  btn.querySelector('.spinner-border').classList.remove('d-none');

  $.ajax({
    url: USUARIO_API + '/' + id,
    method: 'DELETE',
    success: function() {
      modalDelete.hide();
      loadUsuarios();
      loadDashStats();
      showToast('Usuário excluído com sucesso!', 'success');
    },
    error: function() {
      showToast('Erro ao excluir usuário.', 'error');
    },
    complete: function() {
      btn.disabled = false;
      btn.querySelector('.spinner-border').classList.add('d-none');
      window._deleteId = null;
    }
  });
}
