<?php
$module = $_GET['module'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Digite SaaS — Gestão de Usuários</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="assets/css/app.css" rel="stylesheet"/>
</head>
<body>

<?php include 'menu.php'; ?>

<div id="mainContent">

  <!-- ══════════════════════════════════════════
       TOPBAR
  ══════════════════════════════════════════ -->
  <header class="topbar">
    <div class="topbar-left">

      <button class="btn-menu-toggle" onclick="toggleSidebar()" aria-label="Menu">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
          <line x1="3" y1="6"  x2="21" y2="6"/>
          <line x1="3" y1="12" x2="21" y2="12"/>
          <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>

      <div class="topbar-titles">
        <div class="page-title" id="pageTitle">Dashboard</div>
        <div class="breadcrumb-bar">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
          </svg>
          <span id="breadcrumbText">Início</span>
        </div>
      </div>
    </div>

    <div class="topbar-right">
      <span class="topbar-badge">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
        <?= date('d/m/Y') ?>
      </span>
    </div>
  </header>

  <!-- ══════════════════════════════════════════
       PAGE BODY
  ══════════════════════════════════════════ -->
  <main class="page-body">

    <!-- ─── VIEW: DASHBOARD ─── -->
    <section id="viewDashboard">

      <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-4">
          <div class="stat-card">
            <div class="stat-icon blue">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
            </div>
            <div>
              <div class="stat-value" id="dashTotalUsers">—</div>
              <div class="stat-label">Total de Usuários</div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-4">
          <div class="stat-card">
            <div class="stat-icon green">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
              </svg>
            </div>
            <div>
              <div class="stat-value">Online</div>
              <div class="stat-label">Status da API</div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-4">
          <div class="stat-card">
            <div class="stat-icon orange">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <rect x="2" y="3" width="20" height="14" rx="2"/>
                <line x1="8"  y1="21" x2="16" y2="21"/>
                <line x1="12" y1="17" x2="12" y2="21"/>
              </svg>
            </div>
            <div>
              <div class="stat-value">v1.0</div>
              <div class="stat-label">Versão da Plataforma</div>
            </div>
          </div>
        </div>

      </div><!-- /row -->

      <div class="card p-4">
        <div class="welcome-block">
          <div class="welcome-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
          </div>
          <div>
            <div class="welcome-title">Bem-vindo ao Digite SaaS</div>
            <div class="welcome-sub">Plataforma de gestão integrada via API REST</div>
          </div>
        </div>
        <p class="welcome-text">
          Utilize o menu lateral para navegar pelos módulos do sistema. Acesse
          <strong>Usuários</strong> para realizar o cadastro completo com operações de
          criação, edição, visualização e exclusão via API REST.
        </p>
        <div class="mt-3">
          <button class="btn-primary-custom" onclick="showModule('usuarios')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
            </svg>
            Gerenciar Usuários
          </button>
        </div>
      </div>

    </section><!-- /viewDashboard -->

    <!-- ─── VIEW: USUÁRIOS ─── -->
    <section id="viewUsuarios" style="display:none;">

      <div class="card">

        <div class="card-header-custom">
          <div class="card-title">
            <span class="title-icon">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
            </span>
            Usuários Cadastrados
          </div>

          <div class="card-actions">
            <div class="search-wrap">
              <span class="search-icon">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                  <circle cx="11" cy="11" r="8"/>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
              </span>
              <input type="text" id="searchInput" placeholder="Buscar por nome ou e-mail…" oninput="filterTable()"/>
            </div>
            <button class="btn-secondary-custom" onclick="loadUsuarios()">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <polyline points="23 4 23 10 17 10"/>
                <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
              </svg>
              Atualizar
            </button>
            <button class="btn-primary-custom" onclick="openModal()">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5"  x2="12" y2="19"/>
                <line x1="5"  y1="12" x2="19" y2="12"/>
              </svg>
              Novo Usuário
            </button>
          </div>
        </div>

        <div class="table-wrap">
          <table class="data-table">
            <thead>
              <tr>
                <th style="width:60px">ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th style="width:100px">Ações</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              <tr class="loading-row">
                <td colspan="4">
                  <div class="spinner"></div>
                  <div class="loading-text">Carregando…</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div><!-- /card -->

    </section><!-- /viewUsuarios -->

  </main><!-- /page-body -->

</div><!-- /mainContent -->

<!-- ══════════════════════════════════════════
     TOAST CONTAINER
══════════════════════════════════════════ -->
<div id="toastContainer"></div>

<!-- ══════════════════════════════════════════
     MODAL — CRIAR / EDITAR USUÁRIO
══════════════════════════════════════════ -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <div class="modal-title" id="modalTitle">
          <span id="modalIconWrap" class="modal-title-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="12" y1="5"  x2="12" y2="19"/>
              <line x1="5"  y1="12" x2="19" y2="12"/>
            </svg>
          </span>
          <span id="modalTitleText">Novo Usuário</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="userId"/>

        <div class="mb-3">
          <label class="form-label" for="userName">
            Nome completo <span class="required">*</span>
          </label>
          <input type="text" class="form-control" id="userName"
                 placeholder="Ex: João Silva" maxlength="50" autocomplete="off"/>
        </div>

        <div class="mb-1">
          <label class="form-label" for="userEmail">
            E-mail <span class="required">*</span>
          </label>
          <input type="email" class="form-control" id="userEmail"
                 placeholder="Ex: joao@email.com" maxlength="50" autocomplete="off"/>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn-secondary-custom" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn-primary-custom" id="btnSave" onclick="saveUser()">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          Salvar
        </button>
      </div>

    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════
     MODAL — CONFIRMAR EXCLUSÃO
══════════════════════════════════════════ -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">

      <div class="modal-body text-center py-4 px-4">
        <div class="confirm-icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <polyline points="3 6 5 6 21 6"/>
            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
            <path d="M10 11v6"/><path d="M14 11v6"/>
            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
          </svg>
        </div>
        <div class="confirm-title">Excluir usuário?</div>
        <div class="confirm-text">Esta ação não pode ser desfeita.</div>
      </div>

      <div class="modal-footer justify-content-center border-0 pb-4 pt-0">
        <button class="btn-secondary-custom" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn-primary-custom btn-danger-custom" id="btnConfirmDelete">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="3 6 5 6 21 6"/>
            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
          </svg>
          Confirmar
        </button>
      </div>

    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Módulo PHP → JS -->
<script>window.INITIAL_MODULE = '<?= htmlspecialchars($module, ENT_QUOTES) ?>';</script>

<!-- Módulo de Usuários (deve vir antes do app.js) -->
<script src="assets/js/usuario.js"></script>

<!-- Core da Aplicação -->
<script src="assets/js/app.js"></script>

</body>
</html>
