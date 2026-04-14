<?php $page_name = $page_name ?? 'Dashboard'; ?>
<header class="topbar">
    <button class="topbar-menu-btn" id="sidebar-toggle" aria-label="Menu">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>

    <div class="topbar-search">
        <svg class="topbar-search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Search data, students, or reports…" id="topbar-search-input">
    </div>

    <div class="topbar-actions">
        <button class="topbar-btn" title="Notifikasi" id="notif-btn">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="topbar-notif-dot"></span>
        </button>
        <a href="../index.php" target="_blank" class="topbar-btn" title="Lihat Website">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        </a>
        <div class="topbar-user">
            <div class="topbar-avatar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="topbar-user-info">
                <div class="topbar-user-name"><?= htmlspecialchars($admin_nama ?? 'Admin Utama') ?></div>
                <div class="topbar-user-role">SMP PGRI Ciomas</div>
            </div>
        </div>
    </div>
</header>

<script>
(function() {
    const toggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', () => sidebar.classList.toggle('open'));
    }
    // Show hamburger on mobile
    function checkWidth() {
        if (toggle) toggle.style.display = window.innerWidth <= 768 ? 'flex' : 'none';
    }
    checkWidth();
    window.addEventListener('resize', checkWidth);
})();
</script>
