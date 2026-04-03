<?php
require_once 'admin/koneksi.php';
$current_page = 'profil';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Sekolah - SMP PGRI Ciomas</title>
    <meta name="description" content="Profil lengkap SMP PGRI Ciomas - sejarah, visi misi, struktur organisasi, dan tenaga pendidik.">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/profil.css">
</head>
<body>

<?php include 'components/navbar.php'; ?>

<!-- ==========================================
     HERO - PROFIL
     ========================================== -->
<section class="profil-hero">
    <img class="profil-hero-bg" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhSavxoGNf6N1QTFR7_jUX94GR-w1ihetT3jJvXARtVl3kGbMLE4gVqGbV3gPgh9H3OoiiLi30PQzePXu7qU0M19-yKBFquDVDUFaQ6KHJgydtY5KzGGDZa1P_GZaYuMrqTBAJ_uFHvNmXmnWyfPDm4YJ2DtwhydAyQCurAjN4PWaGwix2zQdsXxYXF9RIBGfGSzXK6KW3b2n1X3s7DkG4AMtEDwlmgwABFiX7b1qXIwU5w2I2RDx3NPo0Y-1fRSkoDf3tf6UoHeqI" alt="Gedung SMP PGRI Ciomas">
    <div class="profil-hero-overlay"></div>
    <div class="profil-hero-content container">
        <div class="badge-strip" style="background:rgba(255,255,255,.15);color:white;margin-bottom:14px">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            SMP PGRI Ciomas
        </div>
        <h1 class="profil-hero-title">Profil Sekolah</h1>
        <p class="profil-hero-desc">
            Kenali kami lebih dekat; sejarah panjang perjalanan pendidikan kami, dan nilai-nilai luhur yang selalu kami jaga dan lestarikan.
        </p>
    </div>
</section>

<!-- ==========================================
     SEJARAH SEKOLAH
     ========================================== -->
<section class="section sejarah-section">
    <div class="container">
        <div class="sejarah-header">
            <div class="badge-strip" style="margin-bottom:14px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Warisan Pendidikan
            </div>
            <h2 class="section-title" style="text-align:left">Warisan Pendidikan : Sejarah Sekolah</h2>
        </div>

        <div class="sejarah-grid">
            <div class="sejarah-text">
                <p>
                    Berdiri pada tahun yang penuh semangat, SMP PGRI Ciomas hadir untuk menjawab kebutuhan pendidikan masyarakat sekitar. Sejak awal berdirinya, sekolah ini telah berkomitmen untuk memberikan pendidikan yang berkualitas dan terjangkau bagi seluruh lapisan masyarakat.
                </p>
                <p style="margin-top:14px">
                    Melewati berbagai tantangan dan perkembangan zaman, SMP PGRI Ciomas terus bertransformasi untuk menjadi institusi pendidikan yang semakin relevan dan kompetitif. Kini, kami hadir sebagai sekolah yang tidak hanya mengedepankan prestasi akademik, tetapi juga pembentukan karakter dan kepribadian siswa.
                </p>
                <blockquote class="sejarah-quote">
                    <p>"Kami tidak hanya mencetak siswa yang pintar secara akademis, tetapi juga insan yang berkarakter dan bermanfaat bagi bangsa."</p>
                    <cite>— Kepala Sekolah</cite>
                </blockquote>
            </div>
            <div class="sejarah-image-wrap">
                <img class="sejarah-img" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaxgOvtactjrARqi6h63bzeZEUDDt4-UJrLz600ywV4aUNxrWikzvQV9ywe2SJRlI77z723OWdg32sIgJKlOfh_JQMB-dZc00W5Q0PoUvig-rtP8M5y3w1NWvmO07hQHp5-0Nx1T9AggdAEYFYnHeUcYbaZcH_iAYOAEb9oLuexUyi0RUYdvUkLX8uMi8qW6K4xIht9WYKCppW5RTcuQto-_CLPYWV5MLpP5oG0RuuCV1NfL8PyDClQKfecaslD9WpvX-o3dlIGvQl" alt="Foto Sekolah">
                <div class="sejarah-badge">
                    <span class="sejarah-badge-num">25+</span>
                    <span class="sejarah-badge-label">Tahun Pengabdian</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     VISI & MISI
     ========================================== -->
<section class="section visi-section" id="visi">
    <div class="container">
        <div class="section-header">
            <div class="section-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                Arah dan Tujuan
            </div>
            <h2 class="section-title">Visi & Misi Kami</h2>
            <p class="section-subtitle">Landasan filosofis yang menentukan langkah dan arah perjalanan kami</p>
        </div>

        <!-- Visi Card -->
        <div class="visi-card">
            <div class="visi-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <div class="visi-label">Visi Utama</div>
            <blockquote class="visi-text">
                "Mewujudkan insan yang beriman, berkarakter, berprestasi, bertaqwa, dan berakhlak mulia serta berwawasan teknologi masa depan."
            </blockquote>
        </div>

        <!-- Misi cards -->
        <div class="misi-grid">
            <?php
            $misi = [
                ['icon' => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>', 'judul' => 'Akademis', 'isi' => 'Menyelenggarakan proses pembelajaran yang efektif, inovatif, dan menyenangkan untuk meningkatkan prestasi akademik siswa secara optimal.'],
                ['icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>', 'judul' => 'Karakter', 'isi' => 'Membentuk karakter siswa yang berakhlak mulia, disiplin, jujur, bertanggung jawab, dan mampu berkolaborasi dengan sesama.'],
                ['icon' => '<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>', 'judul' => 'Kreativitas', 'isi' => 'Mengembangkan kreativitas dan inovasi siswa melalui berbagai program ekstrakurikuler dan kegiatan seni budaya yang beragam.'],
            ];
            foreach ($misi as $m): ?>
            <div class="misi-card">
                <div class="misi-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?= $m['icon'] ?></svg>
                </div>
                <h3><?= $m['judul'] ?></h3>
                <p><?= $m['isi'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==========================================
     STRUKTUR ORGANISASI
     ========================================== -->
<section class="section struktur-section">
    <div class="container">
        <div class="struktur-header">
            <div>
                <div class="section-label" style="justify-content:flex-start">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="5" r="3"/><path d="M12 8v7"/><path d="M7 15v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2"/><circle cx="5" cy="17" r="3"/><circle cx="19" cy="17" r="3"/></svg>
                    Kepemimpinan
                </div>
                <h2 class="section-title" style="text-align:left">Struktur Organisasi</h2>
                <p class="section-subtitle" style="text-align:left">Tim kepemimpinan yang berdedikasi dan berpengalaman</p>
            </div>
            <a href="#" class="btn btn-outline-green" style="white-space:nowrap">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Lihat Semua Anggota
            </a>
        </div>

        <!-- Org Chart -->
        <div class="org-chart">
            <!-- Kepala Sekolah -->
            <div class="org-level org-top">
                <div class="org-box org-box-main">
                    <img class="org-avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBbtvEycatQkDoKZ-8CeqZEtpCSleFgQIAsP2eQ5MSH-lUcQgitwnbE_EfTlTb15eiy7w_V3ih-mbhcuDjHxWCqSZutYowy4Y93XqVG3FSbfcxDRGsOlvJ6nryT5QfHDrhrzceXE-HVnDtFrMmnYUktOiN92NJgCBCPOk0u6DHZeG44Ua3UDqWayuk9X2DeVCtnVGoxNN5ko4WCzvopT7cLfb3cGG2XzPE2UJMuBBhM1HHuaRkhKujN2dGZJ5hU2NNwoX3ntakRv2KM" alt="Kepala Sekolah">
                    <?php 
                    $q_kepsek = $conn->query("SELECT kepala_sekolah FROM pengaturan LIMIT 1");
                    $kepsek = $q_kepsek->fetch_assoc()['kepala_sekolah'] ?? 'H. Ahmad Reza, M.Pd';
                    ?>
                    <div class="org-name"><?= htmlspecialchars($kepsek) ?></div>
                    <div class="org-role">Kepala Sekolah</div>
                </div>
            </div>
            <!-- Connector -->
            <div class="org-connector-v"></div>
            <!-- Row 2 -->
            <div class="org-level org-level-3">
                <?php
                $row2 = [
                    ['nama' => 'Dra. Siti Aminah', 'peran' => 'Waka Kurikulum'],
                    ['nama' => 'Bpk. Hendra S., M.Pd', 'peran' => 'Waka Kesiswaan'],
                    ['nama' => 'Ibu. Ratna W., S.T', 'peran' => 'Waka Sarana'],
                ];
                foreach ($row2 as $r): ?>
                <div class="org-box org-box-secondary">
                    <img class="org-avatar-sm" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCEElR7Y7-kCYFW3ZsfYClcatBUlzOq2tkxNt4PGDeK1fSBSHkY7LuFfh45uOWfDmatcszWZoi0UrpRienFQqFZWljVHKH-RG2bZBL-ADaqUp96e53guwqaIE5rs-hqaPnT7S5yfYehoJ66FV_iYuXzqmNONCZ3uOVkraseURAAxA8aE0clVaf6FBAzPjGUvF-1Nf4dGTTgw_5CXhVDq4YtshRtJpuLiz8ItxfjD1WjMU5uMyfU9jQAi6dK0dI7tiGUDhyptfe-P_iI" alt="Staff">
                    <div class="org-name" style="font-size:.82rem"><?= $r['nama'] ?></div>
                    <div class="org-role" style="font-size:.75rem"><?= $r['peran'] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     TENAGA PENDIDIK & KEPENDIDIKAN
     ========================================== -->
<section class="section tenaga-section" id="akademik">
    <div class="container">
        <div class="section-header">
            <div class="section-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Tim Pengajar
            </div>
            <h2 class="section-title">Tenaga Pendidik & Kependidikan</h2>
            <p class="section-subtitle">30 orang guru dan staf yang berdedikasi mendampingi siswa kami</p>
        </div>

        <div class="tenaga-grid">
            <?php
            $guru = [
                ['nama' => 'Bpk. Agus Salim', 'mapel' => 'Matematika'],
                ['nama' => 'Ibu. Dewi Sartika', 'mapel' => 'Bahasa Indonesia'],
                ['nama' => 'Bpk. Eko Prasetyo', 'mapel' => 'IPA'],
                ['nama' => 'Ibu. Fajar Indah', 'mapel' => 'Bahasa Inggris'],
                ['nama' => 'Bpk. Gunawan', 'mapel' => 'PJOK'],
            ];
            foreach ($guru as $g): ?>
            <div class="tenaga-card card">
                <img class="tenaga-img" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaxgOvtactjrARqi6h63bzeZEUDDt4-UJrLz600ywV4aUNxrWikzvQV9ywe2SJRlI77z723OWdg32sIgJKlOfh_JQMB-dZc00W5Q0PoUvig-rtP8M5y3w1NWvmO07hQHp5-0Nx1T9AggdAEYFYnHeUcYbaZcH_iAYOAEb9oLuexUyi0RUYdvUkLX8uMi8qW6K4xIht9WYKCppW5RTcuQto-_CLPYWV5MLpP5oG0RuuCV1NfL8PyDClQKfecaslD9WpvX-o3dlIGvQl" alt="Foto Guru">
                <div class="tenaga-info">
                    <div class="tenaga-nama"><?= $g['nama'] ?></div>
                    <div class="tenaga-mapel"><?= $g['mapel'] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==========================================
     FASILITAS MODERN
     ========================================== -->
<section class="section fasilitas-mini-section">
    <div class="container">
        <div class="section-header">
            <div class="section-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/></svg>
                Infrastruktur
            </div>
            <h2 class="section-title">Fasilitas Modern</h2>
            <p class="section-subtitle">Sarana prasarana terbaik untuk mendukung proses pembelajaran</p>
        </div>
        <div class="fasilitas-mini-grid">
            <?php
            $q_fas = $conn->query("SELECT * FROM fasilitas ORDER BY id DESC LIMIT 4");
            while ($f = $q_fas->fetch_assoc()): ?>
            <div class="fasilitas-mini-card card">
                <img class="fasilitas-mini-img" src="<?= htmlspecialchars($f['gambar'] ? 'uploads/'.$f['gambar'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCEElR7Y7-kCYFW3ZsfYClcatBUlzOq2tkxNt4PGDeK1fSBSHkY7LuFfh45uOWfDmatcszWZoi0UrpRienFQqFZWljVHKH-RG2bZBL-ADaqUp96e53guwqaIE5rs-hqaPnT7S5yfYehoJ66FV_iYuXzqmNONCZ3uOVkraseURAAxA8aE0clVaf6FBAzPjGUvF-1Nf4dGTTgw_5CXhVDq4YtshRtJpuLiz8ItxfjD1WjMU5uMyfU9jQAi6dK0dI7tiGUDhyptfe-P_iI') ?>" alt="<?= htmlspecialchars($f['nama_fasilitas']) ?>">
                <div class="fasilitas-mini-name"><?= htmlspecialchars($f['nama_fasilitas']) ?></div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- ==========================================
     CTA - BERGABUNG
     ========================================== -->
<section class="section bergabung-section">
    <div class="container">
        <div class="bergabung-box">
            <h2>Bergabung Bersama Kami</h2>
            <p>Mari wujudkan pendidikan putra-putri Anda di lingkungan yang hangat, aman, dan selalu mendorong untuk menjadi yang terbaik di SMP PGRI Ciomas.</p>
            <div class="bergabung-actions" id="daftar">
                <a href="#" class="btn btn-green">
                    Daftar Siswa Sekarang
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="#" class="btn btn-outline">Unduh Brosur (PDF)</a>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
