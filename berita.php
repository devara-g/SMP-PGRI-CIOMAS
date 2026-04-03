<?php
require_once 'admin/koneksi.php';
$current_page = 'berita';

// Pagination parameters
$limit = 9;
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($page - 1) * $limit;

// Filter category
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$where = "WHERE status = 'publish'";
if ($kategori) {
    $where .= " AND kategori = '" . $conn->real_escape_string($kategori) . "'";
}

// Get total for pagination
$q_total = $conn->query("SELECT COUNT(*) as total FROM berita $where");
$total_data = $q_total->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// Fetch data
$q_berita = $conn->query("SELECT * FROM berita $where ORDER BY id DESC LIMIT $limit OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita & Pengumuman - SMP PGRI Ciomas</title>
    <meta name="description" content="Kumpulan berita dan pengumuman terbaru dari SMP PGRI Ciomas.">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/berita.css">
</head>
<body>

<?php include 'components/navbar.php'; ?>

<!-- ==========================================
     HERO - BERITA
     ========================================== -->
<section class="berita-hero">
    <div class="berita-hero-inner container">
        <h1 class="berita-hero-title">Berita & <span>Pengumuman</span></h1>
        <p class="berita-hero-desc">Ikuti informasi pendidikan, kegiatan siswa, serta pengumuman terbaru di lingkungan sekolah kami.</p>
        
        <div class="kategori-filter">
            <a href="berita.php" class="kategori-btn <?= empty($kategori) ? 'active' : '' ?>">Semua</a>
            <?php 
            $kats = ['Akademik', 'Kegiatan', 'Prestasi', 'Pengumuman', 'Lingkungan', 'Penerimaan']; 
            foreach ($kats as $k):
            ?>
            <a href="berita.php?kategori=<?= urlencode($k) ?>" class="kategori-btn <?= $kategori == $k ? 'active' : '' ?>"><?= $k ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==========================================
     BERITA LIST
     ========================================== -->
<section class="section berita-list-section">
    <div class="container">
        <div class="berita-grid">
            <?php if ($q_berita->num_rows > 0): ?>
                <?php while ($b = $q_berita->fetch_assoc()): ?>
                <div class="berita-card card">
                    <img class="berita-img" src="<?= htmlspecialchars($b['gambar'] ? 'uploads/'.$b['gambar'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCEElR7Y7-kCYFW3ZsfYClcatBUlzOq2tkxNt4PGDeK1fSBSHkY7LuFfh45uOWfDmatcszWZoi0UrpRienFQqFZWljVHKH-RG2bZBL-ADaqUp96e53guwqaIE5rs-hqaPnT7S5yfYehoJ66FV_iYuXzqmNONCZ3uOVkraseURAAxA8aE0clVaf6FBAzPjGUvF-1Nf4dGTTgw_5CXhVDq4YtshRtJpuLiz8ItxfjD1WjMU5uMyfU9jQAi6dK0dI7tiGUDhyptfe-P_iI') ?>" alt="Foto Berita">
                    <div class="berita-card-body">
                        <span class="berita-kategori"><?= htmlspecialchars($b['kategori']) ?></span>
                        <a href="detail-berita.php?id=<?= $b['id'] ?>" class="berita-title-link">
                            <h3 class="berita-title"><?= htmlspecialchars($b['judul']) ?></h3>
                        </a>
                        <p class="berita-date">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <?= date('d M Y', strtotime($b['tanggal'])) ?>
                        </p>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--gray-600)">
                    Belum ada berita untuk kategori ini.
                </div>
            <?php endif; ?>
        </div>

        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="berita.php?p=<?= $i ?><?= $kategori ? '&kategori='.urlencode($kategori) : '' ?>" class="page-btn <?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
