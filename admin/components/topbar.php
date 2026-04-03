<?php
$page_name = $page_name ?? 'Dashboard';
?>
<header class="topbar">
    <button class="topbar-btn" id="sidebar-toggle" style="display:none">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
    <div class="topbar-title"><?= htmlspecialchars($page_name) ?></div>

    <div class="topbar-search">
        <svg class="topbar-search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Cari...">
    </div>

    <div class="topbar-actions">
        <button class="topbar-btn" title="Notifikasi">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="topbar-notif-dot"></span>
        </button>
        <button class="topbar-btn" title="Lihat Website">
            <a href="../index.php" target="_blank" style="display:flex;align-items:center;color:inherit">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
        </button>
        <div class="topbar-user">
            <div class="topbar-avatar">AD</div>
            <span class="topbar-user-name">Admin</span>
        </div>
    </div>
</header>

<script>
const toggle = document.getElementById('sidebar-toggle');
if (toggle) {
    toggle.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('open');
    });
    // Show hamburger on mobile
    if (window.innerWidth <= 768) toggle.style.display = 'flex';
}
window.addEventListener('resize', () => {
    if (toggle) toggle.style.display = window.innerWidth <= 768 ? 'flex' : 'none';
});
</script>
