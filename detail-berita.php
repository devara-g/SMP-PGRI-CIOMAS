<?php
require_once 'admin/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: berita.php");
    exit;
}

$id   = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM berita WHERE id = ? AND status = 'publish'");
$stmt->bind_param("i", $id);
$stmt->execute();
$berita = $stmt->get_result()->fetch_assoc();

if (!$berita) {
    header("Location: berita.php");
    exit;
}

// Time ago helper
function time_ago(string $date): string {
    $diff = time() - strtotime($date);
    if ($diff < 3600)       return floor($diff/60)  . ' menit lalu';
    if ($diff < 86400)      return floor($diff/3600) . ' jam lalu';
    if ($diff < 604800)     return floor($diff/86400) . ' hari lalu';
    if ($diff < 2592000)    return floor($diff/604800) . ' minggu lalu';
    return floor($diff/2592000) . ' bulan lalu';
}

// Popular posts (3 most recent published, excluding current)
$q_pop = $conn->query("SELECT id, judul, tanggal, gambar FROM berita WHERE status='publish' AND id != $id ORDER BY id DESC LIMIT 3");
$populars = $q_pop ? $q_pop->fetch_all(MYSQLI_ASSOC) : [];

// Berita lainnya (3 latest, different from current)
$q_lain = $conn->query("SELECT id, judul, kategori, tanggal, gambar FROM berita WHERE status='publish' AND id != $id ORDER BY id DESC LIMIT 3");
$lainnya = $q_lain ? $q_lain->fetch_all(MYSQLI_ASSOC) : [];

// Tags (derive from kategori + a few static ones for looks)
$tags = ['#' . $berita['kategori'], '#SMP PGRI Ciomas', '#Pendidikan'];

$current_page = 'berita';

// No-image helper
function detail_img(?string $gambar, string $alt = '', string $class = ''): string {
    if ($gambar) {
        return '<img src="' . htmlspecialchars('uploads/' . $gambar) . '" alt="' . htmlspecialchars($alt) . '"' . ($class ? ' class="' . $class . '"' : '') . '>';
    }
    return '<div class="d-no-img' . ($class ? ' ' . $class : '') . '">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
            <circle cx="12" cy="13" r="4"/>
        </svg>
        <span>Belum ada foto</span>
    </div>';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($berita['judul']) ?> - SMP PGRI Ciomas</title>
    <meta name="description" content="<?= htmlspecialchars(mb_substr(strip_tags($berita['konten']), 0, 155)) ?>">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/berita.css">
    <link rel="stylesheet" href="assets/css/detail-berita.css">
</head>
<body>

<?php include 'components/navbar.php'; ?>

<!-- ==========================================
     DETAIL ARTICLE HEADER
     ========================================== -->
<div class="db-header container">
    <div class="db-header-meta">
        <a href="berita.php?kategori=<?= urlencode($berita['kategori']) ?>" class="db-kat <?= strtolower($berita['kategori']) ?>">
            <?= htmlspecialchars($berita['kategori']) ?>
        </a>
        <span class="db-header-date">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <?= date('d Oct Y', strtotime($berita['tanggal'])) ?>
        </span>
    </div>
</div>

<!-- ==========================================
     MAIN 2-COLUMN LAYOUT
     ========================================== -->
<div class="db-layout container">

    <!-- ---- LEFT: ARTICLE ---- -->
    <article class="db-article">

        <!-- Title -->
        <h1 class="db-title"><?= htmlspecialchars($berita['judul']) ?></h1>

        <!-- Author row -->
        <div class="db-author-row">
            <div class="db-author-left">
                <div class="db-avatar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <div class="db-author-name">Admin Sekolah</div>
                    <div class="db-author-role">Tim Akademik</div>
                </div>
            </div>
            <div class="db-author-right">
                <button class="db-action-btn" title="Bagikan" onclick="
                    if(navigator.share){navigator.share({title:document.title,url:location.href})}
                    else{navigator.clipboard.writeText(location.href);alert('Link disalin!')}
                ">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                </button>
                <button class="db-action-btn" title="Simpan">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                </button>
            </div>
        </div>

        <!-- Hero image -->
        <div class="db-img-wrap">
            <?= detail_img($berita['gambar'], $berita['judul'], 'db-img') ?>
            <?php if ($berita['gambar']): ?>
            <p class="db-img-caption">Foto terkait artikel <?= htmlspecialchars($berita['judul']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Content -->
        <div class="db-content">
            <?php
            $konten = $berita['konten'] ?? '';
            // Detect blockquote pattern: line starting with "
            $paragraphs = explode("\n", $konten);
            $html = '';
            $buffer = [];
            foreach ($paragraphs as $line) {
                $line = trim($line);
                if ($line === '') {
                    if (!empty($buffer)) {
                        $html .= '<p>' . implode('<br>', array_map('htmlspecialchars', $buffer)) . '</p>';
                        $buffer = [];
                    }
                    continue;
                }
                // Quote line starts with "
                if (mb_substr($line, 0, 1) === '"' || mb_substr($line, 0, 1) === '"') {
                    if (!empty($buffer)) {
                        $html .= '<p>' . implode('<br>', array_map('htmlspecialchars', $buffer)) . '</p>';
                        $buffer = [];
                    }
                    $html .= '<blockquote class="db-quote">' . htmlspecialchars($line) . '</blockquote>';
                } else {
                    $buffer[] = $line;
                }
            }
            if (!empty($buffer)) {
                $html .= '<p>' . implode('<br>', array_map('htmlspecialchars', $buffer)) . '</p>';
            }
            echo $html ?: '<p>' . nl2br(htmlspecialchars($konten)) . '</p>';
            ?>
        </div>

        <!-- Tags + Share -->
        <div class="db-footer-row">
            <div class="db-tags">
                <?php foreach ($tags as $tag): ?>
                <span class="db-tag"><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
            </div>
            <div class="db-share-row">
                <span class="db-share-label">Bagikan</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>"
                   target="_blank" rel="noopener" class="db-share-btn fb" aria-label="Share to Facebook">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($berita['judul']) ?>"
                   target="_blank" rel="noopener" class="db-share-btn tw" aria-label="Share to Twitter">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
                </a>
            </div>
        </div>

    </article>

    <!-- ---- RIGHT: SIDEBAR ---- -->
    <aside class="db-sidebar">

        <!-- Search -->
        <form class="db-sidebar-search" action="berita.php" method="get">
            <input type="text" name="q" placeholder="Cari berita…" class="db-search-input">
            <button type="submit" class="db-search-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
        </form>

        <!-- Popular Posts -->
        <div class="db-sidebar-block">
            <div class="db-sidebar-title">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                Populer
                <a href="berita.php" class="db-sidebar-lihat">Lihat Semua</a>
            </div>
            <div class="db-popular-list">
                <?php foreach ($populars as $i => $p): ?>
                <a href="detail-berita.php?id=<?= $p['id'] ?>" class="db-popular-item">
                    <span class="db-pop-num"><?= str_pad($i+1, 2, '0', STR_PAD_LEFT) ?></span>
                    <div class="db-pop-text">
                        <p class="db-pop-title"><?= htmlspecialchars($p['judul']) ?></p>
                        <span class="db-pop-time"><?= time_ago($p['tanggal']) ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
                <?php if (empty($populars)): ?>
                <p class="db-sidebar-empty">Belum ada artikel lain.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- CTA Card -->
        <div class="db-cta-card">
            <div class="db-cta-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </div>
            <h3 class="db-cta-title">Ingin Bergabung?</h3>
            <p class="db-cta-desc">Pendaftaran Siswa Baru Tahun Ajaran 2024/2025 masih dibuka secara daring.</p>
            <a href="profil.php#daftar" class="db-cta-btn">
                Daftar Sekarang
            </a>
        </div>

    </aside>
</div>

<!-- ==========================================
     BERITA LAINNYA
     ========================================== -->
<?php if (!empty($lainnya)): ?>
<section class="db-lainnya-section">
    <div class="container">
        <div class="db-lainnya-header">
            <span class="db-lainnya-line"></span>
            <h2 class="db-lainnya-title">Berita Lainnya</h2>
        </div>
        <div class="db-lainnya-grid">
            <?php foreach ($lainnya as $l): ?>
            <a href="detail-berita.php?id=<?= $l['id'] ?>" class="db-lainnya-card">
                <div class="db-lainnya-img-wrap">
                    <?= detail_img($l['gambar'], $l['judul']) ?>
                    <span class="db-lainnya-kat <?= strtolower($l['kategori']) ?>"><?= htmlspecialchars($l['kategori']) ?></span>
                </div>
                <div class="db-lainnya-body">
                    <h3 class="db-lainnya-card-title"><?= htmlspecialchars($l['judul']) ?></h3>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include 'components/footer.php'; ?>

</body>
</html>
