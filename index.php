<?php
require_once 'admin/koneksi.php';
$current_page = 'index';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - SMP PGRI Ciomas</title>
    <meta name="description" content="SMP PGRI Ciomas - Membangun generasi cerdas, berkarakter, dan siap menghadapi tantangan masa depan dengan landasan iman dan takwa.">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css?v=<?= time() ?>">
</head>
<body>

<?php include 'components/navbar.php'; ?>

<!-- ==========================================
     HERO SECTION
     ========================================== -->
<section class="hero">
    <div class="hero-bg">
            <img class="hero-img-placeholder" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhSavxoGNf6N1QTFR7_jUX94GR-w1ihetT3jJvXARtVl3kGbMLE4gVqGbV3gPgh9H3OoiiLi30PQzePXu7qU0M19-yKBFquDVDUFaQ6KHJgydtY5KzGGDZa1P_GZaYuMrqTBAJ_uFHvNmXmnWyfPDm4YJ2DtwhydAyQCurAjN4PWaGwix2zQdsXxYXF9RIBGfGSzXK6KW3b2n1X3s7DkG4AMtEDwlmgwABFiX7b1qXIwU5w2I2RDx3NPo0Y-1fRSkoDf3tf6UoHeqI"
             alt="">
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content container">
        <div class="hero-text">
            <div class="badge-strip hero-badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Sekolah Terbaik di Ciomas
            </div>
            <h1 class="hero-title">
                Membangun Masa<br>
                Depan Bersama<br>
                <span class="hero-title-highlight">SMP PGRI Ciomas</span>
            </h1>
            <p class="hero-desc">
                Pendidikan berkualitas yang membentuk karakter unggul dan kompetensi global bagi seluruh siswa SMP PGRI Ciomas.
            </p>
            <div class="hero-actions">
                <a href="profil.php#daftar" class="btn btn-primary">
                    Daftar Sekarang
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="profil.php" class="btn btn-outline" style="margin-right: 12px;">
                    Lihat Profil
                </a>
                
                <div class="hero-badge-circle" tabindex="0">
                    B
                    <div class="tooltip-text">Sekolah Terakreditasi B<br>Standar Nasional Pendidikan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-stats-bar">
        <div class="container">
            <div class="hero-stat">
                <span class="hstat-num">500+</span>
                <span class="hstat-label">Siswa Aktif</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <span class="hstat-num">40+</span>
                <span class="hstat-label">Pengajar Profesional</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <span class="hstat-num">25+</span>
                <span class="hstat-label">Prestasi</span>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION: MEMBENTUK GENERASI
     ========================================== -->
<section class="section generasi-section">
    <div class="container generasi-grid">
        <div class="generasi-text">
            <div class="badge-strip" style="margin-bottom:16px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                Tentang Sekolah
            </div>
            <h2 class="section-title" style="text-align:left">
                Membentuk Generasi<br>
                <span style="color:var(--green-main)">Cerdas & Berakhlak</span>
            </h2>
            <p style="color:var(--gray-600); margin-top:16px; font-size:.95rem; line-height:1.8">
                Sejak berdirinya, SMP PGRI Ciomas telah berkomitmen untuk memberikan pendidikan terbaik yang menggabungkan kecerdasan akademis dengan pembentukan karakter yang kuat.
            </p>
            <div class="generasi-stats">
                <div class="generasi-stat">
                    <span class="gstat-num">25+</span>
                    <span class="gstat-label">Tahun Berdiri</span>
                </div>
                <div class="generasi-stat">
                    <span class="gstat-num">98%</span>
                    <span class="gstat-label">Lulusan Diterima SMA Favorit</span>
                </div>
            </div>
            <ul class="generasi-list">
                <li>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Kurikulum berbasis kompetensi dan karakter
                </li>
                <li>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Fasilitas modern dan lengkap
                </li>
                <li>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Tenaga pendidik berpengalaman dan berdedikasi
                </li>
            </ul>
        </div>
        <div class="generasi-image-wrap">
            <img class="generasi-img" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBbtvEycatQkDoKZ-8CeqZEtpCSleFgQIAsP2eQ5MSH-lUcQgitwnbE_EfTlTb15eiy7w_V3ih-mbhcuDjHxWCqSZutYowy4Y93XqVG3FSbfcxDRGsOlvJ6nryT5QfHDrhrzceXE-HVnDtFrMmnYUktOiN92NJgCBCPOk0u6DHZeG44Ua3UDqWayuk9X2DeVCtnVGoxNN5ko4WCzvopT7cLfb3cGG2XzPE2UJMuBBhM1HHuaRkhKujN2dGZJ5hU2NNwoX3ntakRv2KM" alt="Siswa dan Guru">
            <div class="generasi-badge-float">
                <span class="gen-badge-num">25+</span>
                <span class="gen-badge-text">Tahun<br>Melahirkan<br>Prestasi</span>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION: UNGGULAN KAMI
     ========================================== -->
<section class="section unggulan-section">
    <div class="container">
        <div class="section-header">
            <div class="section-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Unggulan Kami
            </div>
            <h2 class="section-title">Unggulan Kami</h2>
            <p class="section-subtitle">Keistimewaan yang menjadikan SMP PGRI Ciomas pilihan terbaik untuk putra-putri Anda</p>
        </div>

        <div class="unggulan-grid">
            <!-- Big card: Prestasi -->
            <div class="unggulan-big card">
                <img class="unggulan-img"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaxgOvtactjrARqi6h63bzeZEUDDt4-UJrLz600ywV4aUNxrWikzvQV9ywe2SJRlI77z723OWdg32sIgJKlOfh_JQMB-dZc00W5Q0PoUvig-rtP8M5y3w1NWvmO07hQHp5-0Nx1T9AggdAEYFYnHeUcYbaZcH_iAYOAEb9oLuexUyi0RUYdvUkLX8uMi8qW6K4xIht9WYKCppW5RTcuQto-_CLPYWV5MLpP5oG0RuuCV1NfL8PyDClQKfecaslD9WpvX-o3dlIGvQl"
                 alt="">
                <div class="unggulan-big-content">
                    <a href="#" class="badge-strip" style="margin-bottom:10px">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"/></svg>
                        Prestasi Terbaru
                    </a>
                    <h3>Juara Umum Kompetisi Akademik & Non-Akademik</h3>
                    <p style="color:var(--gray-600); font-size:.88rem; margin-top:8px">SMP PGRI Ciomas berhasil meraih juara umum pada berbagai kompetisi tingkat kabupaten dan provinsi tahun ini.</p>
                    <a href="#" class="unggulan-link">Selengkapnya →</a>
                </div>
            </div>

            <!-- Right column -->
            <div class="unggulan-right">
                <!-- Fasilitas card -->
                <div class="unggulan-card card">
                    <img class="placeholder-img unggulan-small-img"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCEElR7Y7-kCYFW3ZsfYClcatBUlzOq2tkxNt4PGDeK1fSBSHkY7LuFfh45uOWfDmatcszWZoi0UrpRienFQqFZWljVHKH-RG2bZBL-ADaqUp96e53guwqaIE5rs-hqaPnT7S5yfYehoJ66FV_iYuXzqmNONCZ3uOVkraseURAAxA8aE0clVaf6FBAzPjGUvF-1Nf4dGTTgw_5CXhVDq4YtshRtJpuLiz8ItxfjD1WjMU5uMyfU9jQAi6dK0dI7tiGUDhyptfe-P_iI"
                    alt="">
                    <div class="unggulan-card-content">
                        <div class="unggulan-icon-wrap green">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        </div>
                        <h4>Fasilitas Modern</h4>
                        <p>Lab komputer, perpustakaan digital, dan ruang kelas ber-AC mendukung proses belajar yang optimal.</p>
                    </div>
                </div>
                <!-- Ekstrakurikuler -->
                <div class="unggulan-ekstra card">
                    <div class="unggulan-ekstra-header">
                        <div>
                            <div class="unggulan-icon-wrap yellow">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            </div>
                            <h4 style="margin-top:8px">Ragam Ekstrakurikuler</h4>
                            <p style="font-size:.83rem; color:var(--gray-600); margin-top:4px">Pilihan ekstra yang mengembangkan bakat dan minat siswa</p>
                        </div>
                        <a href="#" class="btn btn-green" style="padding:8px 16px; font-size:.82rem;">Selengkapnya →</a>
                    </div>
                    <div class="ekstra-icons">
                        <div class="ekstra-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                            <span>Seni</span>
                        </div>
                        <div class="ekstra-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/></svg>
                            <span>Olahraga</span>
                        </div>
                        <div class="ekstra-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/></svg>
                            <span>IT / Coding</span>
                        </div>
                        <div class="ekstra-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                            <span>PMR</span>
                        </div>
                        <div class="ekstra-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            <span>Pramuka</span>
                        </div>
                        <div class="ekstra-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                            <span>Tari</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION: BERITA & PENGUMUMAN
     ========================================== -->
<section class="section berita-section">
    <div class="container">
        <div class="berita-header">
            <div>
                <div class="section-label">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/></svg>
                    Informasi Terkini
                </div>
                <h2 class="section-title" style="text-align:left">Berita & Pengumuman</h2>
                <p class="section-subtitle" style="text-align:left">Ikuti perkembangan yang ada di SMP PGRI Ciomas</p>
            </div>
            <a href="berita.php" class="btn btn-outline-green">Semua Berita →</a>
        </div>

        <div class="berita-grid">
            <?php
            $q_berita = $conn->query("SELECT * FROM berita WHERE status = 'publish' ORDER BY id DESC LIMIT 3");
            while ($b = $q_berita->fetch_assoc()): ?>
            <div class="berita-card card">
                <img class="berita-img" src="<?= htmlspecialchars($b['gambar'] ? 'uploads/'.$b['gambar'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCEElR7Y7-kCYFW3ZsfYClcatBUlzOq2tkxNt4PGDeK1fSBSHkY7LuFfh45uOWfDmatcszWZoi0UrpRienFQqFZWljVHKH-RG2bZBL-ADaqUp96e53guwqaIE5rs-hqaPnT7S5yfYehoJ66FV_iYuXzqmNONCZ3uOVkraseURAAxA8aE0clVaf6FBAzPjGUvF-1Nf4dGTTgw_5CXhVDq4YtshRtJpuLiz8ItxfjD1WjMU5uMyfU9jQAi6dK0dI7tiGUDhyptfe-P_iI') ?>" alt="Foto Berita">
                <div class="berita-card-body">
                    <span class="berita-kategori"><?= htmlspecialchars($b['kategori']) ?></span>
                    <a href="detail-berita.php?id=<?= $b['id'] ?>" class="berita-title-link" style="text-decoration:none">
                        <h3 class="berita-title"><?= htmlspecialchars($b['judul']) ?></h3>
                    </a>
                    <p class="berita-date">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <?= date('d M Y', strtotime($b['tanggal'])) ?>
                    </p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION: TESTIMONI
     ========================================== -->
<section class="section testimoni-section">
    <div class="container">
        <div class="section-header">
            <div class="section-label">Kata Alumni & Orang Tua</div>
            <h2 class="section-title">Kata Alumni & Orang Tua</h2>
            <p class="section-subtitle">Apa yang mereka katakan tentang SMP PGRI Ciomas</p>
        </div>
        <div class="testimoni-grid">
            <?php
            $testimoni = [
                ['nama' => 'Ridwan Kusuma', 'peran' => 'Alumni 2022', 'isi' => 'SMP PGRI Ciomas memberikan saya fondasi yang kuat. Guru-gurunya yang berdedikasi dan fasilitas lengkap membuat saya siap menghadapi jenjang berikutnya.'],
                ['nama' => 'Sri Wahyuni', 'peran' => 'Orang Tua Siswa', 'isi' => 'Sangat puas dengan perkembangan anak saya sejak bersekolah di sini. Tidak hanya pintar akademis, karakternya pun terbentuk dengan baik. Terima kasih PGRI!'],
            ];
            foreach ($testimoni as $t): ?>
            <div class="testimoni-card card">
                <div class="testimoni-quote">"</div>
                <p class="testimoni-isi"><?= htmlspecialchars($t['isi']) ?></p>
                <div class="testimoni-author">
                    <img class="testimoni-avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaxgOvtactjrARqi6h63bzeZEUDDt4-UJrLz600ywV4aUNxrWikzvQV9ywe2SJRlI77z723OWdg32sIgJKlOfh_JQMB-dZc00W5Q0PoUvig-rtP8M5y3w1NWvmO07hQHp5-0Nx1T9AggdAEYFYnHeUcYbaZcH_iAYOAEb9oLuexUyi0RUYdvUkLX8uMi8qW6K4xIht9WYKCppW5RTcuQto-_CLPYWV5MLpP5oG0RuuCV1NfL8PyDClQKfecaslD9WpvX-o3dlIGvQl" alt="Avatar">
                    <div>
                        <div class="testimoni-nama"><?= htmlspecialchars($t['nama']) ?></div>
                        <div class="testimoni-peran"><?= htmlspecialchars($t['peran']) ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION: CTA
     ========================================== -->
<section class="cta-section">
    <div class="container">
        <div class="cta-box">
            <div class="cta-text">
                <h2>Siap Bergabung dengan Kami?</h2>
                <p>Mari jadikan pendidikan putra-putri Anda sebagai investasi terbaik yang tidak akan pernah Anda sesali.</p>
            </div>
            <div class="cta-actions">
                <a href="profil.php#daftar" class="btn btn-primary">
                    Daftar Siswa Sekarang
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="#hubungi" class="btn btn-outline">Hubungi Panitia</a>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>