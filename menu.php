<?php
$currentModule = $_GET['module'] ?? 'dashboard';
?>
<nav id="sidebar">

  <div class="sidebar-header">
    <div class="sidebar-logo">
      <div class="logo-icon">
        <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
          <rect width="13" height="13" rx="3.5" fill="#4A87F5"/>
          <rect x="17" width="13" height="13" rx="3.5" fill="#38C19A"/>
          <rect y="17" width="13" height="13" rx="3.5" fill="#38C19A"/>
          <rect x="17" y="17" width="13" height="13" rx="3.5" fill="#4A87F5" opacity="0.55"/>
        </svg>
      </div>
      <div class="logo-text">
        <span class="logo-brand">Digite</span>
        <span class="logo-sub">SaaS Platform</span>
      </div>
    </div>
  </div>

  <div class="sidebar-section-label">NAVEGAÇÃO</div>

  <ul class="sidebar-nav">

    <li class="nav-item <?= $currentModule === 'dashboard' ? 'active' : '' ?>">
      <a href="index.php" class="nav-link">
        <span class="nav-icon">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"/>
            <rect x="14" y="3" width="7" height="7"/>
            <rect x="14" y="14" width="7" height="7"/>
            <rect x="3" y="14" width="7" height="7"/>
          </svg>
        </span>
        <span class="nav-label">Dashboard</span>
      </a>
    </li>

    <li class="nav-item <?= $currentModule === 'usuarios' ? 'active' : '' ?>">
      <a href="index.php?module=usuarios" class="nav-link">
        <span class="nav-icon">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </span>
        <span class="nav-label">Usuários</span>
      </a>
    </li>

  </ul>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="user-avatar">A</div>
      <div class="user-info">
        <span class="user-name">Admin</span>
        <span class="user-role">Administrador</span>
      </div>
    </div>
  </div>

</nav>

<div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>
