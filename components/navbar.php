<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<nav class="navbar">
    <div class="nav-container">
        <a href="index.php" class="nav-brand">
            <div class="brand-logo">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <rect width="32" height="32" rx="6" fill="#1a6b4a"/>
                    <text x="50%" y="58%" dominant-baseline="middle" text-anchor="middle" fill="white" font-size="14" font-weight="bold" font-family="Georgia">S</text>
                </svg>
            </div>
            <span class="brand-name">SMP PGRI Ciomas</span>
        </a>
        <ul class="nav-links">
            <li><a href="index.php" class="<?= $current_page === 'index' ? 'active' : '' ?>">Beranda</a></li>
            <li><a href="profil.php" class="<?= $current_page === 'profil' ? 'active' : '' ?>">Profil Sekolah</a></li>
            <li><a href="berita.php" class="<?= $current_page === 'berita' || $current_page === 'detail-berita' ? 'active' : '' ?>">Berita</a></li>
            <li><a href="fasilitas.php" class="<?= $current_page === 'fasilitas' ? 'active' : '' ?>">Fasilitas</a></li>
            <li><a href="aspirasi.php" class="<?= $current_page === 'aspirasi' ? 'active' : '' ?>">Aspirasi</a></li>
            <li><a href="#hubungi" class="<?= $current_page === 'hubungi' ? 'active' : '' ?>">Hubungi Kami</a></li>
        </ul>
        <a href="profil.php#daftar" class="btn-daftar">Daftar Sekarang</a>
        <button class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>
