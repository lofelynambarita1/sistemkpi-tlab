/**
 * Sidebar Component — Sistem KPI
 * (init_project.sh replaces "Sistem KPI" with the actual project title)
 *
 * USAGE:
 *   1. Add <div id="topbar-container"></div> and <div id="sidebar-container"></div> in body
 *   2. Include <script src="[path-to]/sidebar-component.js"></script>
 *   3. Call initSidebar('page-id') — must match the 'page' key in SIDEBAR_ITEMS
 *
 * To add a new module/page:
 *   1. Add an entry to SIDEBAR_ITEMS below
 *   2. Add icon SVG to ICONS if the icon name is new
 *   3. Create the HTML file and call initSidebar('your-page-id')
 */

// ─── Session & Auth ───────────────────────────────────────────────────────

function getCurrentUser() {
  try {
    const session = localStorage.getItem('kpi_session');
    return session ? JSON.parse(session) : null;
  } catch (e) {
    return null;
  }
}

function isLoggedIn() {
  return !!getCurrentUser();
}

function checkSession() {
  // Skip check for login page itself
  const path = window.location.pathname;
  if (path.includes('/auth/login') || path.includes('login.html')) {
    return true;
  }
  const user = getCurrentUser();
  if (!user) {
    window.location.href = resolvePath('pages/auth/login.html');
    return false;
  }
  return true;
}

function resolvePath(href) {
  // Gunakan resolveHref yang sudah teruji untuk navigasi antar halaman
  return resolveHref(href, getCurrentPathFromRoot());
}

function logout() {
  if (confirm('Apakah Anda yakin ingin logout?')) {
    localStorage.removeItem('kpi_session');
    window.location.href = resolvePath('pages/auth/login.html');
  }
}

// ─── Navigation Items ──────────────────────────────────────────────────────
// Edit this array to add modules. Each item needs: label, href, icon, page.
// 'href' is always relative to the mockup root (e.g. 'pages/module/list.html').
// 'page' must match the string passed to initSidebar() on that page.
// resolveHref() automatically adjusts paths for any page depth.

const ALL_SIDEBAR_ITEMS = [
  {
    group: null,
    items: [
      { label: 'Dashboard', href: 'index.html', icon: 'dashboard', page: 'index', roles: ['all'] },
    ]
  },
  { group: 'PENILAIAN KPI', items: [
    { label: 'Form KPI', href: 'pages/kpi/form.html', icon: 'document', page: 'kpi-form', roles: ['Associate', 'Intermediate', 'Senior', 'Principle', 'Lead', 'Lead HR'] },
    { label: 'History KPI', href: 'pages/history/list.html', icon: 'chart', page: 'history', roles: ['Associate', 'Intermediate', 'Senior', 'Principle', 'Lead', 'Lead HR', 'Manager'] },
  ]},
  { group: 'REVIEW & APPROVAL', items: [
    { label: 'Review Lead', href: 'pages/review/lead.html', icon: 'eye', page: 'review-lead', roles: ['Lead'] },
    { label: 'Review Lead HR', href: 'pages/review/lead-hr.html', icon: 'eye', page: 'review-lead-hr', roles: ['Lead HR'] },
    { label: 'Review Manager', href: 'pages/review/manager.html', icon: 'eye', page: 'review-manager', roles: ['Manager'] },
  ]},
  { group: 'ADMINISTRASI', items: [
    { label: 'Manajemen User', href: 'pages/users/list.html', icon: 'users', page: 'users-list', roles: ['Admin'] },
  ]},
  { group: 'AKUN', items: [
    { label: 'Profil Saya', href: 'pages/profile/profile.html', icon: 'user', page: 'profile', roles: ['all'] },
  ]},
  { group: null, items: [
    { label: 'Panduan', href: 'pages/panduan/panduan.html', icon: 'document', page: 'panduan', roles: ['all'] },
  ]},
];

function getSidebarItemsForRole(role) {
  if (!role) return ALL_SIDEBAR_ITEMS;
  return ALL_SIDEBAR_ITEMS.map(group => ({
    group: group.group,
    items: group.items.filter(item =>
      item.roles.includes('all') || item.roles.includes(role)
    )
  })).filter(group => group.items.length > 0);
}

// ─── Icon Library ──────────────────────────────────────────────────────────

const ICONS = {
  dashboard: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>`,
  list:      `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>`,
  building:  `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>`,
  document:  `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>`,
  users:     `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>`,
  shield:    `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>`,
  chart:     `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>`,
  cog:       `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`,
  eye:       `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`,
  inbox:     `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>`,
  map:       `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>`,
  user:      `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>`,
  lock:      `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>`,
  moon:      `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>`,
  sun:       `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>`,
  logout:    `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>`,
};

// ─── Path Resolution ────────────────────────────────────────────────────────

function resolveHref(href, currentPathFromRoot) {
  const pathParts = currentPathFromRoot.split('/');
  const depth = pathParts.length - 1;

  if (depth === 0) return href;

  const currentModule = pathParts[1];

  if (href.startsWith('pages/')) {
    const hrefParts = href.split('/');
    const targetModule = hrefParts[1];
    const targetFile = hrefParts[hrefParts.length - 1];

    if (hrefParts.length === 2) return '../' + targetFile;
    if (targetModule === currentModule) return targetFile;
    return '../' + targetModule + '/' + targetFile;
  }

  return '../'.repeat(depth) + href;
}

function getCurrentPathFromRoot() {
  const currentPath = window.location.pathname;
  // Hapus trailing slash untuk konsistensi
  const cleanPath = currentPath.replace(/\/$/, '');
  const pathParts = cleanPath.split('/').filter(p => p !== '');

  const mockupIndex = pathParts.findIndex(p => p.endsWith('_mockup'));
  if (mockupIndex !== -1 && mockupIndex < pathParts.length - 1) {
    return pathParts.slice(mockupIndex + 1).join('/');
  }

  const pagesIndex = pathParts.indexOf('pages');
  if (pagesIndex !== -1 && pagesIndex < pathParts.length - 1) {
    return pathParts.slice(pagesIndex - 1).join('/');
  }

  // Jika tidak ada file di akhir (root), default ke index.html
  const last = pathParts[pathParts.length - 1];
  if (!last || !last.includes('.')) {
    return 'index.html';
  }

  return last;
}

// ─── Dark Mode ───────────────────────────────────────────────────────────

function isDarkMode() {
  return localStorage.getItem('kpi_dark_mode') === 'true';
}

function toggleDarkMode() {
  const dark = !isDarkMode();
  localStorage.setItem('kpi_dark_mode', dark ? 'true' : 'false');
  applyDarkMode(dark);
}

function applyDarkMode(dark) {
  if (dark) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
  // Update toggle icon
  const btn = document.getElementById('dark-mode-toggle');
  if (btn) {
    btn.innerHTML = dark ? ICONS.sun : ICONS.moon;
    btn.title = dark ? 'Mode Terang' : 'Mode Gelap';
  }
}

// ─── Render Functions ───────────────────────────────────────────────────────

function renderTopbar() {
  const depth = getCurrentPathFromRoot().split('/').length - 1;
  const prefix = depth === 0 ? '' : '../'.repeat(depth);
  const logoPath = prefix + 'assets/images/logo.png';

  const user = getCurrentUser();
  const initials = user ? user.initials : 'A';
  const name = user ? user.name : 'Admin';
  const role = user ? user.role : 'Admin';
  const dark = isDarkMode();

  return `
    <header class="fixed top-0 left-0 right-0 h-16 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 z-50 flex items-center px-4">
      <div class="flex items-center gap-3">
        <button id="sidebar-toggle" class="lg:hidden p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
          <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
        <img src="${logoPath}" alt="Logo" class="h-8 w-auto" onerror="this.style.display='none'">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white">Sistem KPI</h1>
      </div>
      <div class="ml-auto flex items-center gap-3">
        <!-- Dark Mode Toggle -->
        <button id="dark-mode-toggle" onclick="toggleDarkMode()" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300" title="${dark ? 'Mode Terang' : 'Mode Gelap'}">
          ${dark ? ICONS.sun : ICONS.moon}
        </button>
        <!-- User Dropdown -->
        <div class="relative">
          <button id="user-dropdown-btn" onclick="toggleUserDropdown()" class="flex items-center gap-2 p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            <div class="w-8 h-8 bg-red-700 rounded-full flex items-center justify-center text-white text-sm font-bold">${initials}</div>
            <div class="hidden md:block text-left">
              <p class="text-sm font-medium text-gray-800 dark:text-white leading-tight">${name}</p>
              <p class="text-xs text-gray-500 dark:text-gray-400 leading-tight">${role}</p>
            </div>
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
            <div class="p-3 border-b border-gray-200 dark:border-gray-700">
              <p class="text-sm font-medium text-gray-800 dark:text-white">${name}</p>
              <p class="text-xs text-gray-500 dark:text-gray-400">${user ? user.email : 'admin@company.com'}</p>
              <span class="inline-block mt-1 px-2 py-0.5 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 text-xs rounded">${role}</span>
            </div>
            <div class="p-1">
              <a href="${prefix}pages/profile/profile.html" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                ${ICONS.user} Profil Saya
              </a>
              <a href="${prefix}pages/profile/profile.html" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                ${ICONS.lock} Ubah Password
              </a>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 p-1">
              <button onclick="logout()" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded text-left">
                ${ICONS.logout} Logout
              </button>
            </div>
          </div>
        </div>
      </div>
    </header>`;
}

function renderSidebar(activePage) {
  const currentPathFromRoot = getCurrentPathFromRoot();
  const user = getCurrentUser();
  const role = user ? user.role : null;
  const sidebarItems = getSidebarItemsForRole(role);

  let html = `
    <aside id="sidebar" class="fixed top-16 left-0 bottom-0 w-64 bg-sip-sidebar overflow-y-auto z-40 shadow-lg">
      <nav class="p-4 space-y-1">`;

  sidebarItems.forEach(group => {
    if (group.group) {
      html += `
        <div class="pt-3 pb-1">
          <span class="text-gray-500 text-xs font-semibold tracking-widest uppercase px-3">${group.group}</span>
        </div>`;
    }

    group.items.forEach(item => {
      const isActive = item.page === activePage;
      const resolvedHref = resolveHref(item.href, currentPathFromRoot);
      const activeClass = isActive
        ? 'bg-sip-sidebar-act text-white font-semibold'
        : 'text-gray-400 hover:bg-sip-sidebar-sec hover:text-white';

      html += `
        <a href="${resolvedHref}" class="flex items-center gap-3 px-3 py-2.5 ${activeClass} rounded-md text-sm transition-colors">
          ${ICONS[item.icon] || ''}
          <span>${item.label}</span>
        </a>`;
    });
  });

  html += `
      </nav>
    </aside>`;

  return html;
}

// ─── Dropdown Toggle ───────────────────────────────────────────────────────

function toggleUserDropdown() {
  const menu = document.getElementById('user-dropdown-menu');
  if (menu) {
    menu.classList.toggle('hidden');
  }
}

// Close dropdown when clicking outside
window.addEventListener('click', function(e) {
  const btn = document.getElementById('user-dropdown-btn');
  const menu = document.getElementById('user-dropdown-menu');
  if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
    menu.classList.add('hidden');
  }
});

// ─── Init ───────────────────────────────────────────────────────────────────

function initSidebar(activePage) {
  // Apply dark mode immediately
  applyDarkMode(isDarkMode());

  const topbarContainer = document.getElementById('topbar-container');
  if (topbarContainer) topbarContainer.innerHTML = renderTopbar();

  const sidebarContainer = document.getElementById('sidebar-container');
  if (sidebarContainer) sidebarContainer.innerHTML = renderSidebar(activePage);

  // Ensure main content clears the fixed topbar
  const main = document.querySelector('main');
  if (main && !main.classList.contains('mt-16')) main.classList.add('mt-16');

  // Mobile sidebar toggle
  const toggle = document.getElementById('sidebar-toggle');
  const sidebar = document.getElementById('sidebar');
  if (toggle && sidebar) {
    toggle.addEventListener('click', () => sidebar.classList.toggle('hidden'));
  }
}
