<?php
// Session already started in parent files.
$page_name = $page_name ?? 'Dashboard';
$active_menu = $active_menu ?? 'dashboard';

// Count dynamic data for badges
$q_pending = $conn->query("SELECT COUNT(*) as total FROM aspirasi WHERE status != 'dibalas'");
$aspirasi_pending = $q_pending->fetch_assoc()['total'] ?? 0;
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-logo">S</div>
        <div class="sidebar-brand-text">
            <div class="sidebar-brand-name">SMP PGRI Ciomas</div>
            <div class="sidebar-brand-sub">Panel Admin</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>
        <a href="dashboard.php" class="sidebar-link <?= $active_menu === 'dashboard' ? 'active' : '' ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>

        <div class="nav-section-label" style="margin-top:8px">Konten</div>
        <a href="berita.php" class="sidebar-link <?= $active_menu === 'berita' ? 'active' : '' ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/></svg>
            Berita & Pengumuman
        </a>
        <a href="fasilitas.php" class="sidebar-link <?= $active_menu === 'fasilitas' ? 'active' : '' ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Fasilitas
        </a>
        <a href="aspirasi.php" class="sidebar-link <?= $active_menu === 'aspirasi' ? 'active' : '' ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            Aspirasi
            <?php if ($aspirasi_pending > 0): ?>
            <span class="nav-badge"><?= $aspirasi_pending ?></span>
            <?php endif; ?>
        </a>

        <div class="nav-section-label" style="margin-top:8px">Sistem</div>
        <a href="pengaturan.php" class="sidebar-link <?= $active_menu === 'pengaturan' ? 'active' : '' ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Pengaturan
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">AD</div>
            <div>
                <div class="sidebar-user-name">Admin PGRI</div>
                <div class="sidebar-user-role">Super Administrator</div>
            </div>
            <a href="logout.php" class="sidebar-logout" title="Logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </a>
        </div>
    </div>
</aside>
