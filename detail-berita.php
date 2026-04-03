<?php
require_once 'admin/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: berita.php");
    exit;
}

$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM berita WHERE id = ? AND status = 'publish'");
$stmt->bind_param("i", $id);
$stmt->execute();
$berita = $stmt->get_result()->fetch_assoc();

if (!$berita) {
    header("Location: berita.php");
    exit;
}

$current_page = 'detail-berita';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($berita['judul']) ?> - SMP PGRI Ciomas</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/berita.css">
    <style>
        .detail-hero {
            padding: 80px 0 40px;
            background: linear-gradient(to bottom, var(--green-light), white);
            text-align: center;
        }
        .detail-kategori {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            background: rgba(26, 107, 74, 0.1);
            color: var(--green-main);
            font-size: .8rem;
            font-weight: 700;
            border-radius: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }
        .detail-title {
            font-size: 2.8rem;
            color: var(--gray-900);
            max-width: 900px;
            margin: 0 auto 24px;
            font-family: var(--font-heading, 'Poppins', sans-serif);
            line-height: 1.3;
        }
        .detail-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            color: var(--gray-500);
            font-size: .95rem;
        }
        .detail-meta span { display: flex; align-items: center; gap: 8px; }
        .detail-image-wrap {
            max-width: 900px;
            margin: 0 auto 40px;
            border-radius: var(--radius-lg, 16px);
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .detail-image-wrap img {
            width: 100%;
            height: auto;
            aspect-ratio: 16/9;
            object-fit: cover;
            display: block;
        }
        .detail-content {
            max-width: 800px;
            margin: 0 auto 60px;
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--gray-800);
        }
        .detail-content p { margin-bottom: 24px; }
        .detail-content h2, .detail-content h3 {
            margin: 40px 0 20px;
            color: var(--gray-900);
            font-family: var(--font-heading, "Poppins", sans-serif);
        }
        @media (max-width: 768px) {
            .detail-title { font-size: 2rem; }
        }
    </style>
</head>
<body>

<?php include 'components/navbar.php'; ?>

<article>
    <section class="detail-hero">
        <div class="container">
            <a href="berita.php?kategori=<?= urlencode($berita['kategori']) ?>" class="detail-kategori">
                <?= htmlspecialchars($berita['kategori']) ?>
            </a>
            <h1 class="detail-title"><?= htmlspecialchars($berita['judul']) ?></h1>
            <div class="detail-meta">
                <span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <?= date('d M Y', strtotime($berita['tanggal'])) ?>
                </span>
                <span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Admin PGRI
                </span>
            </div>
        </div>
    </section>

    <div class="container" style="padding-top:20px">
        <div class="detail-image-wrap">
            <img src="<?= htmlspecialchars($berita['gambar'] ? 'uploads/'.$berita['gambar'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCEElR7Y7-kCYFW3ZsfYClcatBUlzOq2tkxNt4PGDeK1fSBSHkY7LuFfh45uOWfDmatcszWZoi0UrpRienFQqFZWljVHKH-RG2bZBL-ADaqUp96e53guwqaIE5rs-hqaPnT7S5yfYehoJ66FV_iYuXzqmNONCZ3uOVkraseURAAxA8aE0clVaf6FBAzPjGUvF-1Nf4dGTTgw_5CXhVDq4YtshRtJpuLiz8ItxfjD1WjMU5uMyfU9jQAi6dK0dI7tiGUDhyptfe-P_iI') ?>" alt="<?= htmlspecialchars($berita['judul']) ?>">
        </div>
        
        <div class="detail-content">
            <!-- nl2br to format newlines correctly as it is a standard textarea text -->
            <?= nl2br(htmlspecialchars($berita['konten'])) ?>
        </div>

        <!-- Back to berita button -->
        <div style="text-align:center;margin-bottom:80px">
            <a href="berita.php" class="btn btn-outline" style="border-radius:40px;padding:12px 30px">
                ← Kembali ke Daftar Berita
            </a>
        </div>
    </div>
</article>

<?php include 'components/footer.php'; ?>

</body>
</html>
