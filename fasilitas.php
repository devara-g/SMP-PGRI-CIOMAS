<?php
require_once 'admin/koneksi.php';
$current_page = 'fasilitas';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas - SMP PGRI Ciomas</title>
    <meta name="description" content="Fasilitas modern SMP PGRI Ciomas - ruang kelas ber-AC, perpustakaan digital, lab komputer, laboratorium IPA, musholla, kantin, dan sarana olahraga.">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/fasilitas.css">
</head>
<body>

<?php include 'components/navbar.php'; ?>

<!-- ==========================================
     HERO - FASILITAS
     ========================================== -->
<section class="fasilitas-hero">
    <div class="fasilitas-hero-wrap">
        <div class="fasilitas-hero-text-col">
            <div class="badge-strip" style="margin-bottom:16px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                ENVIRONMENT FOR EXCELLENCE
            </div>
            <h1 class="fasilitas-hero-title">
                Fasilitas<br>
                <span>Sekolah</span>
            </h1>
            <p class="fasilitas-hero-desc">
                Kami berkomitmen menyediakan infrastruktur premium yang mendukung potensi setiap Siswa dalam lingkungan yang nyaman, modern, dan inspiratif.
            </p>
        </div>
        <div class="fasilitas-hero-img-col">
            <img class="fasilitas-hero-img" src="img/sekolah.jpeg" alt="Gedung Sekolah">
            <div class="fasilitas-akred-badge">
                <div class="akred-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"/></svg>
                </div>
                <div>
                    <strong>Akreditasi B</strong>
                    <p>Sekolah kami telah memperoleh<br>akreditasi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     FASILITAS GRID
     ========================================== -->
<section class="section fasilitas-main-section">
    <div class="container">
        <div class="section-header">
            <div class="section-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                Pusat Belajar & Kreativitas
            </div>
            <h2 class="section-title">Pusat Belajar & Kreativitas</h2>
            <p class="section-subtitle">Integrasi Teknologi dan Kenyamanan Fisik untuk melahirkan generasi cerdas dan berkarakter.</p>
        </div>

        <div class="fasilitas-mosaic">
            <?php 
            $icons = [
                '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>',
                '<circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>',
                '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
                '<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>'
            ];
            $sizes = ['big-left', 'big-right', 'small', 'small', 'small', 'small-wide', 'big-musholla'];
            $q_fas = $conn->query("SELECT * FROM fasilitas ORDER BY id DESC");
            $i = 0;
            while ($f = $q_fas->fetch_assoc()): 
                $icon = $icons[$i % count($icons)];
                $size = $sizes[$i % count($sizes)];
                $i++;
            ?>
            <div class="fasilitas-item fasilitas-<?= $size ?>">
                <img class="fasilitas-item-img" src="<?= htmlspecialchars($f['gambar'] ? 'uploads/'.$f['gambar'] : 'img/fasilitas1.jpeg') ?>" alt="<?= htmlspecialchars($f['nama_fasilitas']) ?>">
                <div class="fasilitas-item-overlay">
                    <div class="fasilitas-item-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?= $icon ?></svg>
                    </div>
                    <h3><?= htmlspecialchars($f['nama_fasilitas']) ?></h3>
                    <p><?= htmlspecialchars($f['deskripsi']) ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- ==========================================
     CTA - KUNJUNGAN
     ========================================== -->
<section class="section kunjungan-section">
    <div class="container">
        <div class="kunjungan-box">
            <h2>Siap Melihat Lebih Dekat?</h2>
            <p>Kami mengundang Bapak/Ibu yang berkunjung langsung dan melihat bagaimana lingkungan kami dapat menjadi rumah kedua bagi putra-putri Anda.</p>
            <div class="kunjungan-actions">
                <a href="#" class="btn btn-primary">
                    Jadwalkan Kunjungan
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </a>
                <a href="#hubungi" class="btn btn-outline">Hubungi Kami</a>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
