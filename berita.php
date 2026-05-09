<?php
require_once 'admin/koneksi.php';
$current_page = 'berita';

// Filter category
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$search   = isset($_GET['q']) ? trim($_GET['q']) : '';

$where = "WHERE status = 'publish'";
if ($kategori) {
    $where .= " AND kategori = '" . $conn->real_escape_string($kategori) . "'";
}
if ($search) {
    $where .= " AND (judul LIKE '%" . $conn->real_escape_string($search) . "%' OR isi LIKE '%" . $conn->real_escape_string($search) . "%')";
}

// Fetch headline (most recent published article)
$q_headline = $conn->query("SELECT * FROM berita WHERE status = 'publish' ORDER BY id DESC LIMIT 1");
$headline   = $q_headline ? $q_headline->fetch_assoc() : null;

// Fetch "Kabar Terbaru" - up to 5 articles (skip headline)
$headline_id = $headline ? (int)$headline['id'] : 0;
$q_terbaru   = $conn->query("SELECT * FROM berita WHERE status='publish' AND id != $headline_id ORDER BY id DESC LIMIT 5");

// All articles (for filtered view)
$q_all = $conn->query("SELECT * FROM berita $where ORDER BY id DESC LIMIT 9");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita &amp; Pengumuman - SMP PGRI Ciomas</title>
    <meta name="description" content="Kumpulan berita dan pengumuman terbaru dari SMP PGRI Ciomas.">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/berita.css">
</head>

<body>

    <?php include 'components/navbar.php'; ?>

    <?php if (!$kategori && !$search && $headline): ?>
        <!-- ==========================================
     HERO - FEATURED ARTICLE
     ========================================== -->
        <section class="b-hero">
            <div class="b-hero-inner container">
                <!-- Left: Text -->
                <div class="b-hero-text">
                    <span class="b-hero-badge">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10" />
                        </svg>
                        Berita Utama
                    </span>
                    <h1 class="b-hero-title"><?= htmlspecialchars($headline['judul']) ?></h1>
                    <p class="b-hero-desc">
                        <?= htmlspecialchars(mb_substr(strip_tags($headline['konten']), 0, 160)) ?>…
                    </p>
                    <div class="b-hero-meta">
                        <span class="b-hero-meta-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            <?= date('d F Y', strtotime($headline['tanggal'])) ?>
                        </span>
                        <span class="b-hero-meta-sep">•</span>
                        <span class="b-hero-meta-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Oleh Admin Sekolah
                        </span>
                    </div>
                    <a href="detail-berita.php?id=<?= $headline['id'] ?>" class="b-hero-cta">
                        Baca Selengkapnya
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                </div>
                <!-- Right: Image -->
                <div class="b-hero-img-wrap">
                    <img
                        src="<?= htmlspecialchars($headline['gambar'] ? 'uploads/' . $headline['gambar'] : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&q=80') ?>"
                        alt="<?= htmlspecialchars($headline['judul']) ?>"
                        class="b-hero-img">
                    <a href="detail-berita.php?id=<?= $headline['id'] ?>" class="b-hero-play-btn" aria-label="Baca berita">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <polygon points="5 3 19 12 5 21 5 3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ==========================================
     FILTER & SEARCH BAR
     ========================================== -->
    <section class="b-filter-section">
        <div class="container b-filter-inner">
            <div class="b-kategori-tabs">
                <?php
                $kats = ['Semua' => '', 'Akademik' => 'Akademik', 'Prestasi' => 'Prestasi', 'Kegiatan' => 'Kegiatan', 'Pengumuman' => 'Pengumuman'];
                foreach ($kats as $label => $val):
                    $isActive = ($val === $kategori && !$search) || ($label === 'Semua' && !$kategori && !$search);
                ?>
                    <a href="berita.php<?= $val ? '?kategori=' . urlencode($val) : '' ?>" class="b-tab <?= $isActive ? 'active' : '' ?>">
                        <?= $label ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <form class="b-search-form" action="berita.php" method="get">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="text" name="q" class="b-search-input" placeholder="Cari berita atau artikel…" value="<?= htmlspecialchars($search) ?>">
            </form>
        </div>
    </section>

    <?php if ($kategori || $search): ?>
        <!-- ==========================================
     FILTERED / SEARCH RESULTS
     ========================================== -->
        <section class="section b-results-section">
            <div class="container">
                <div class="b-section-header">
                    <h2 class="b-section-title">
                        <?= $search ? 'Hasil Pencarian: <em>"' . htmlspecialchars($search) . '"</em>' : 'Kategori: ' . htmlspecialchars($kategori) ?>
                    </h2>
                </div>
                <div class="b-grid-3">
                    <?php if ($q_all && $q_all->num_rows > 0): ?>
                        <?php while ($b = $q_all->fetch_assoc()): ?>
                            <a href="detail-berita.php?id=<?= $b['id'] ?>" class="b-card">
                                <div class="b-card-img-wrap">
                                    <img src="<?= htmlspecialchars($b['gambar'] ? 'uploads/' . $b['gambar'] : 'https://images.unsplash.com/photo-1585829365234-781fefc47e02?w=600&q=80') ?>" alt="<?= htmlspecialchars($b['judul']) ?>">
                                    <span class="b-card-kat <?= strtolower($b['kategori']) ?>"><?= htmlspecialchars($b['kategori']) ?></span>
                                </div>
                                <div class="b-card-body">
                                    <p class="b-card-date">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        <?= date('d M Y', strtotime($b['tanggal'])) ?>
                                    </p>
                                    <h3 class="b-card-title"><?= htmlspecialchars($b['judul']) ?></h3>
                                    <p class="b-card-snippet"><?= htmlspecialchars(mb_substr(strip_tags($b['konten']), 0, 100)) ?>…</p>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="b-empty">Belum ada berita untuk pencarian ini.</div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

    <?php else: ?>
        <!-- ==========================================
     KABAR TERBARU - MAIN LAYOUT
     ========================================== -->
        <section class="section b-terbaru-section">
            <div class="container">
                <div class="b-section-header">
                    <h2 class="b-section-title">Kabar Terbaru</h2>
                    <a href="berita.php?p=all" class="b-lihat-semua">
                        Lihat Semua
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                </div>

                <?php
                // Collect all "terbaru" articles
                $terbaru_list = [];
                while ($t = $q_terbaru->fetch_assoc()) {
                    $terbaru_list[] = $t;
                }
                $top3    = array_slice($terbaru_list, 0, 3);
                $bottom2 = array_slice($terbaru_list, 3, 2);
                ?>

                <!-- Top row: 3 small cards -->
                <?php if (!empty($top3)): ?>
                    <div class="b-grid-3 b-grid-top">
                        <?php foreach ($top3 as $b): ?>
                            <a href="detail-berita.php?id=<?= $b['id'] ?>" class="b-card">
                                <div class="b-card-img-wrap">
                                    <img src="<?= htmlspecialchars($b['gambar'] ? 'uploads/' . $b['gambar'] : 'https://images.unsplash.com/photo-1585829365234-781fefc47e02?w=600&q=80') ?>" alt="<?= htmlspecialchars($b['judul']) ?>">
                                    <span class="b-card-kat <?= strtolower($b['kategori']) ?>"><?= htmlspecialchars($b['kategori']) ?></span>
                                </div>
                                <div class="b-card-body">
                                    <p class="b-card-date">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        <?= date('d M Y', strtotime($b['tanggal'])) ?>
                                    </p>
                                    <h3 class="b-card-title"><?= htmlspecialchars($b['judul']) ?></h3>
                                    <p class="b-card-snippet"><?= htmlspecialchars(mb_substr(strip_tags($b['konten']), 0, 90)) ?>…</p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Bottom row: 1 featured big card + 1 side card -->
                <?php if (!empty($bottom2)): ?>
                    <div class="b-grid-featured">
                        <!-- Featured (big) -->
                        <?php $feat = $bottom2[0]; ?>
                        <div class="b-featured-card">
                            <span class="b-featured-kat <?= strtolower($feat['kategori']) ?>"><?= htmlspecialchars($feat['kategori']) ?></span>
                            <h2 class="b-featured-title"><?= htmlspecialchars($feat['judul']) ?></h2>
                            <p class="b-featured-desc"><?= htmlspecialchars(mb_substr(strip_tags($feat['konten']), 0, 150)) ?>…</p>
                            <a href="detail-berita.php?id=<?= $feat['id'] ?>" class="b-featured-cta">
                                Baca Selengkapnya
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                    <polyline points="12 5 19 12 12 19" />
                                </svg>
                            </a>
                        </div>

                        <!-- Side card -->
                        <?php if (isset($bottom2[1])): $side = $bottom2[1]; ?>
                            <a href="detail-berita.php?id=<?= $side['id'] ?>" class="b-side-card">
                                <div class="b-side-img-wrap">
                                    <img src="<?= htmlspecialchars($side['gambar'] ? 'uploads/' . $side['gambar'] : 'https://images.unsplash.com/photo-1585829365234-781fefc47e02?w=600&q=80') ?>" alt="<?= htmlspecialchars($side['judul']) ?>">
                                    <span class="b-card-kat <?= strtolower($side['kategori']) ?>"><?= htmlspecialchars($side['kategori']) ?></span>
                                </div>
                                <div class="b-card-body">
                                    <p class="b-card-date">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        <?= date('d M Y', strtotime($side['tanggal'])) ?>
                                    </p>
                                    <h3 class="b-card-title"><?= htmlspecialchars($side['judul']) ?></h3>
                                    <p class="b-card-snippet"><?= htmlspecialchars(mb_substr(strip_tags($side['konten']), 0, 100)) ?>…</p>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($terbaru_list)): ?>
                    <div class="b-empty">Belum ada berita terbaru lainnya.</div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ==========================================
     NEWSLETTER CTA
     ========================================== -->
        <section class="b-newsletter-section">
            <div class="container">
                <div class="b-newsletter-box">
                    <div class="b-newsletter-text">
                        <h2>Jangan Lewatkan Kabar<br>Pendidikan Kami</h2>
                        <p>Dapatkan update berita, prestasi, dan pengumuman sekolah langsung di email Anda setiap minggu.</p>
                    </div>
                    <form class="b-newsletter-form" onsubmit="return false;">
                        <input type="email" placeholder="Alamat email Anda" class="b-newsletter-input">
                        <button type="submit" class="b-newsletter-btn">Langganan</button>
                    </form>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php include 'components/footer.php'; ?>

</body>

</html>