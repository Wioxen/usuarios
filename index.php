<?php
$module = isset($_GET['module']) ? $_GET['module'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digite SaaS — Gestão de Usuários</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/app.css" rel="stylesheet">
</head>
<body>

<div class="app-layout">
  <!-- Sidebar -->
  <?php include 'menu.php'; ?>

  <!-- Main Content -->
  <div class="main-content">

    <!-- Topbar -->
    <header class="topbar">
      <div class="topbar-left">
        <button class="hamburger" onclick="toggleSidebar()">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
        </button>
        <div>
          <h1 id="topbarTitle">Dashboard</h1>
          <div class="breadcrumb-trail">
            <span>Digite</span>
            <span class="sep">›</span>
            <span id="breadcrumbModule">Dashboard</span>
          </div>
        </div>
      </div>
      <div class="topbar-right">
        <div class="topbar-search">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
          <input type="text" placeholder="Buscar qualquer coisa...">
        </div>
        <button class="topbar-icon-btn" title="Notificações">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
          </svg>
          <span class="badge-dot"></span>
        </button>
        <div class="topbar-user">
          <div class="avatar-sm">AD</div>
          <div class="user-label">
            <div class="name">Admin</div>
            <div class="role">admin</div>
          </div>
        </div>
      </div>
    </header>

    <!-- Page Body -->
    <div class="page-body">

      <!-- ==============================
           VIEW: Dashboard
           ============================== -->
      <section id="view-dashboard" class="view-section">
        <div class="stats-row">
          <!-- Total Users -->
          <div class="stat-card">
            <div class="stat-icon blue">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
            </div>
            <div class="stat-info">
              <div class="stat-label">Total de Usuários</div>
              <div class="stat-value" id="statTotalUsers">...</div>
              <div class="stat-change up">Atualizado agora</div>
            </div>
          </div>

          <!-- API Status -->
          <div class="stat-card">
            <div class="stat-icon green">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
              </svg>
            </div>
            <div class="stat-info">
              <div class="stat-label">Status da API</div>
              <div class="stat-value" style="color:var(--accent)">Online</div>
              <div class="stat-change up">api-usuario.digite.com.br</div>
            </div>
          </div>

          <!-- Version -->
          <div class="stat-card">
            <div class="stat-icon orange">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
              </svg>
            </div>
            <div class="stat-info">
              <div class="stat-label">Versão</div>
              <div class="stat-value">1.0</div>
              <div class="stat-change">Estável</div>
            </div>
          </div>

          <!-- Uptime -->
          <div class="stat-card">
            <div class="stat-icon red">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
              </svg>
            </div>
            <div class="stat-info">
              <div class="stat-label">Uptime</div>
              <div class="stat-value">99.9%</div>
              <div class="stat-change up">Últimos 30 dias</div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
          <div class="quick-action-card" onclick="showModule('usuarios')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <line x1="19" y1="8" x2="19" y2="14"></line>
              <line x1="22" y1="11" x2="16" y2="11"></line>
            </svg>
            <h4>Gerenciar Usuários</h4>
            <p>Criar, editar e excluir registros</p>
          </div>
          <div class="quick-action-card" onclick="showToast('Relatórios em breve!', 'info')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
              <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <h4>Relatórios</h4>
            <p>Exportar dados e análises</p>
          </div>
          <div class="quick-action-card" onclick="showToast('Configurações em breve!', 'info')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="3"></circle>
              <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
            <h4>Configurações</h4>
            <p>Preferências do sistema</p>
          </div>
        </div>
      </section>

      <!-- ==============================
           VIEW: Usuários
           ============================== -->
      <section id="view-usuarios" class="view-section">
        <div class="stats-row" style="margin-bottom: 24px;">
          <div class="stat-card">
            <div class="stat-icon blue">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="stat-info">
              <div class="stat-label">Total cadastrados</div>
              <div class="stat-value" id="statTotalUsers2">...</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon green">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
              </svg>
            </div>
            <div class="stat-info">
              <div class="stat-label">Ativos</div>
              <div class="stat-value" style="color:var(--accent)" id="statActiveUsers">...</div>
            </div>
          </div>
        </div>

        <div class="content-card">
          <div class="content-card-header">
            <div class="header-actions" style="flex:1; gap: 14px;">
              <div class="search-bar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" id="searchUsuarios" placeholder="Buscar por nome ou e-mail...">
              </div>
              <div style="margin-left:auto; display:flex; gap:10px; align-items:center;">
                <button class="btn btn-outline btn-sm" onclick="loadUsuarios()">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                  </svg>
                  Atualizar
                </button>
                <button class="btn btn-primary btn-sm" onclick="openModal()">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg>
                  Novo Usuário
                </button>
              </div>
            </div>
          </div>

          <!-- Table Wrapper -->
          <div id="usuariosTableWrapper">
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
            </table>
          </div>
        </div>
      </section>

    </div>
  </div>
</div>

<!-- ==============================
     MODAL: Criar / Editar Usuário
     ============================== -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUsuarioLabel">Novo Usuário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nome <span class="required">*</span></label>
          <input type="text" class="form-control" id="fieldNome" placeholder="Nome completo" maxlength="50">
          <div class="invalid-feedback">Informe um nome válido (até 50 caracteres).</div>
        </div>
        <div class="form-group mb-0">
          <label>E-mail <span class="required">*</span></label>
          <input type="email" class="form-control" id="fieldEmail" placeholder="email@exemplo.com" maxlength="50">
          <div class="invalid-feedback">Informe um e-mail válido (até 50 caracteres).</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="saveBtn" onclick="saveUser()">
          <span class="spinner-border spinner-border-sm d-none" role="status"></span>
          <span id="saveBtnText">Criar Usuário</span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ==============================
     MODAL: Confirmar Exclusão
     ============================== -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="delete-modal-body">
          <div class="icon-circle">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              <line x1="10" y1="11" x2="10" y2="17"></line>
              <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
          </div>
          <h4>Excluir Usuário?</h4>
          <p>Tem certeza que deseja excluir <span class="user-name" id="deleteUserName"></span>? Esta ação não poderá ser desfeita.</p>
        </div>
      </div>
      <div class="modal-footer" style="justify-content:center">
        <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="deleteBtn" onclick="deleteUser()">
          <span class="spinner-border spinner-border-sm d-none" role="status"></span>
          Excluir
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="toast-container"></div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>window.INITIAL_MODULE = '<?= htmlspecialchars($module, ENT_QUOTES) ?>';</script>
<script src="assets/js/usuario.js"></script>
<script src="assets/js/app.js"></script>

<script>
// Also update usuario stats on the usuarios view
var _origLoadUsuarios = loadUsuarios;
loadUsuarios = function() {
  _origLoadUsuarios();
  $.ajax({
    url: USUARIO_API,
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      var count = Array.isArray(data) ? data.length : 0;
      var el2 = document.getElementById('statTotalUsers2');
      var elA = document.getElementById('statActiveUsers');
      if (el2) el2.textContent = count;
      if (elA) elA.textContent = count;
    }
  });
};
</script>

</body>
</html>
