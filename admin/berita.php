<?php
session_start();
require_once 'auth_check.php';
require_once 'koneksi.php';

$active_menu = 'berita';
$page_name   = 'Berita';
$action      = $_GET['action'] ?? 'list';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM berita WHERE id = $id");
    header("Location: berita.php"); exit;
}

// Handle Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul    = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $tanggal  = $_POST['tanggal'];
    $status   = (isset($_POST['action']) && $_POST['action'] === 'draft') ? 'draft' : 'publish';
    $isi      = $_POST['isi'];
    $gambar   = $_POST['gambar_lama'] ?? null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext    = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $gambar = 'berita_' . time() . '_' . uniqid() . '.' . $ext;
        if (!is_dir('../uploads')) mkdir('../uploads', 0777, true);
        move_uploaded_file($_FILES['foto']['tmp_name'], '../uploads/' . $gambar);
    }
    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO berita (judul, kategori, konten, tanggal, status, gambar) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $judul, $kategori, $isi, $tanggal, $status, $gambar);
        $stmt->execute();
    } elseif ($action === 'edit' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $conn->prepare("UPDATE berita SET judul=?, kategori=?, konten=?, tanggal=?, status=?, gambar=? WHERE id=?");
        $stmt->bind_param("ssssssi", $judul, $kategori, $isi, $tanggal, $status, $gambar, $id);
        $stmt->execute();
    }
    header("Location: berita.php"); exit;
}

$edit_data = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $q  = $conn->query("SELECT * FROM berita WHERE id = $id");
    $edit_data = ($q && $q->num_rows > 0) ? $q->fetch_assoc() : null;
    if (!$edit_data) $action = 'add';
}

$berita_data = [];
if ($action === 'list') {
    $q = $conn->query("SELECT * FROM berita ORDER BY id DESC");
    while ($r = $q->fetch_assoc()) $berita_data[] = $r;
}

// Stats
$q_pub   = $conn->query("SELECT COUNT(*) as c FROM berita WHERE status='publish'"); $cnt_pub = $q_pub->fetch_assoc()['c'];
$q_draf  = $conn->query("SELECT COUNT(*) as c FROM berita WHERE status='draft'");   $cnt_draf = $q_draf->fetch_assoc()['c'];
$q_all_b = $conn->query("SELECT COUNT(*) as c FROM berita");                        $cnt_all = $q_all_b->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - Admin SMP PGRI Ciomas</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
<?php include 'components/sidebar.php'; ?>
<div class="admin-main">
<?php include 'components/topbar.php'; ?>
<div class="page-content">

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ===== FORM ===== -->
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <a href="berita.php">Berita</a>
            <span class="breadcrumb-sep">›</span>
            <?= $action === 'add' ? 'Tambah Baru' : 'Edit Berita' ?>
        </div>
        <div class="page-heading"><?= $action === 'add' ? 'Tambah Berita Baru' : 'Edit Berita' ?></div>
        <div class="page-subheading">Publikasikan berita, prestasi, dan pengumuman sekolah.</div>
    </div>
    <div class="page-header-actions">
        <a href="berita.php" class="btn btn-outline">← Kembali</a>
    </div>
</div>

<form method="POST" enctype="multipart/form-data">
    <?php if ($edit_data): ?>
    <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($edit_data['gambar'] ?? '') ?>">
    <?php endif; ?>
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">
        <div style="display:flex;flex-direction:column;gap:20px">
            <div class="card">
                <div class="card-header"><div class="card-title">Informasi Berita</div></div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group form-full">
                            <label class="form-label">Judul Berita <span>*</span></label>
                            <input type="text" name="judul" class="form-control" placeholder="Tulis judul berita yang menarik…" value="<?= $edit_data ? htmlspecialchars($edit_data['judul']) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kategori <span>*</span></label>
                            <div class="select-wrap">
                                <select name="kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach (['Akademik','Kegiatan','Prestasi','Pengumuman','Lingkungan','Penerimaan'] as $k):
                                        $sel = ($edit_data && $edit_data['kategori'] == $k) ? 'selected' : ''; ?>
                                    <option <?= $sel ?>><?= $k ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <svg class="select-arrow" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Publikasi <span>*</span></label>
                            <input type="date" name="tanggal" class="form-control" value="<?= $edit_data ? $edit_data['tanggal'] : date('Y-m-d') ?>" required>
                        </div>
                        <div class="form-group form-full">
                            <label class="form-label">Isi Berita <span>*</span></label>
                            <textarea name="isi" class="form-control" rows="14" placeholder="Tulis isi berita selengkapnya di sini…" required><?= $edit_data ? htmlspecialchars($edit_data['konten']) : '' ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><div class="card-title">Foto Berita</div></div>
                <div class="card-body">
                    <label class="file-upload-area">
                        <input type="file" name="foto" accept="image/*" style="display:none" onchange="previewImg(this)">
                        <svg class="file-upload-icon" width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        <div class="file-upload-text"><strong>Klik untuk upload</strong> atau drag &amp; drop</div>
                        <div class="file-upload-hint">PNG, JPG, WEBP — Maks. 2MB — Rasio 16:9 dianjurkan</div>
                    </label>
                    <img id="img-preview" src="<?= ($edit_data && $edit_data['gambar']) ? '../uploads/'.$edit_data['gambar'] : '' ?>" style="display:<?= ($edit_data && $edit_data['gambar']) ? 'block' : 'none' ?>;width:100%;border-radius:10px;margin-top:14px;object-fit:cover;max-height:200px">
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:16px">
            <div class="card">
                <div class="card-header"><div class="card-title">Publikasi</div></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="select-wrap">
                            <select name="status" class="form-control">
                                <option value="publish" <?= ($edit_data && $edit_data['status']=='publish') ? 'selected' : '' ?>>✦ Publish (Tayang)</option>
                                <option value="draft"   <?= ($edit_data && $edit_data['status']=='draft')   ? 'selected' : '' ?>>◌ Draft (Tidak Tampil)</option>
                            </select>
                            <svg class="select-arrow" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                </div>
                <div class="card-footer" style="display:flex;flex-direction:column;gap:8px">
                    <button type="submit" name="action" value="publish" class="btn btn-primary" style="width:100%;justify-content:center">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Simpan &amp; Publish
                    </button>
                    <button type="submit" name="action" value="draft" class="btn btn-outline" style="width:100%;justify-content:center">
                        Simpan sebagai Draft
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php else: ?>
<!-- ===== LIST ===== -->
<div class="page-header">
    <div>
        <div class="page-heading">Kelola Warta Sekolah</div>
        <div class="page-subheading">Publikasikan prestasi, pengumuman, dan momen berharga SMP PGRI Ciomas ke seluruh dunia.</div>
    </div>
    <div class="page-header-actions">
        <a href="berita.php?action=add" class="btn btn-primary" id="btn-tambah-berita">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Berita Baru
        </a>
    </div>
</div>

<!-- Mini stats -->
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">
    <div class="card" style="padding:20px 22px;border-left:3px solid var(--ap-green)">
        <div style="font-size:.7rem;font-weight:700;color:var(--gray-500);text-transform:uppercase;letter-spacing:.4px">Total Artikel</div>
        <div style="font-size:1.8rem;font-weight:800;color:var(--gray-900);margin:4px 0"><?= $cnt_all ?></div>
        <div style="font-size:.72rem;color:var(--ap-green);font-weight:600">↑ +12 bulan ini</div>
    </div>
    <div class="card" style="padding:20px 22px;border-left:3px solid var(--ap-blue)">
        <div style="font-size:.7rem;font-weight:700;color:var(--gray-500);text-transform:uppercase;letter-spacing:.4px">Diterbitkan</div>
        <div style="font-size:1.8rem;font-weight:800;color:var(--gray-900);margin:4px 0"><?= $cnt_pub ?></div>
        <div style="font-size:.72rem;color:var(--gray-400)"><?= $cnt_all > 0 ? round($cnt_pub/$cnt_all*100) : 0 ?>% dari total konten</div>
    </div>
    <div class="card" style="padding:20px 22px;border-left:3px solid var(--ap-yellow-dk)">
        <div style="font-size:.7rem;font-weight:700;color:var(--gray-500);text-transform:uppercase;letter-spacing:.4px">Draf</div>
        <div style="font-size:1.8rem;font-weight:800;color:var(--gray-900);margin:4px 0"><?= $cnt_draf ?></div>
        <div style="font-size:.72rem;color:var(--gray-400)">Menunggu review</div>
    </div>
    <div class="card" style="padding:20px 22px;background:var(--ap-yellow-lt);border:1px solid rgba(240,192,64,.2)">
        <div style="font-size:.65rem;font-weight:700;color:var(--ap-yellow-dk);text-transform:uppercase;letter-spacing:.5px">Trending</div>
        <?php $q_tr = $conn->query("SELECT judul FROM berita WHERE status='publish' ORDER BY id DESC LIMIT 1"); $tr = $q_tr ? $q_tr->fetch_assoc() : null; ?>
        <div style="font-size:.88rem;font-weight:800;color:var(--gray-900);margin:4px 0;line-height:1.3"><?= $tr ? htmlspecialchars(substr($tr['judul'],0,30)) : 'Belum ada' ?>…</div>
        <div style="font-size:.7rem;color:var(--gray-500)">Berita terbaru</div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Berita Terbaru</div>
        <div style="display:flex;gap:8px">
            <span style="font-size:.8rem;color:var(--gray-500);display:flex;align-items:center;gap:4px">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
                Filter
            </span>
            <span style="font-size:.8rem;color:var(--gray-500);display:flex;align-items:center;gap:4px">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export
            </span>
        </div>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Informasi Berita</th>
                    <th>Kategori</th>
                    <th>Tanggal Rilis</th>
                    <th>Status</th>
                    <th style="width:80px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($berita_data as $b): $tgl = date('d M Y', strtotime($b['tanggal'])); ?>
                <tr>
                    <td>
                        <div class="td-with-thumb">
                            <?php if ($b['gambar']): ?>
                            <img class="td-thumb" src="../uploads/<?= htmlspecialchars($b['gambar']) ?>" alt="">
                            <?php else: ?>
                            <div class="td-thumb-placeholder">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            </div>
                            <?php endif; ?>
                            <div>
                                <div class="td-name" style="max-width:280px"><?= htmlspecialchars(substr($b['judul'],0,55)) . (strlen($b['judul'])>55?'…':'') ?></div>
                                <div style="font-size:.74rem;color:var(--gray-400);margin-top:2px">Oleh: Admin Sekolah</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php
                        $kat_cl = ['Prestasi'=>'badge-yellow','Akademik'=>'badge-green','Kegiatan'=>'badge-blue','Pengumuman'=>'badge-red','Lingkungan'=>'badge-teal','Penerimaan'=>'badge-blue'];
                        $cl = $kat_cl[$b['kategori']] ?? 'badge-gray';
                        ?>
                        <span class="badge <?= $cl ?>"><?= htmlspecialchars($b['kategori']) ?></span>
                    </td>
                    <td style="color:var(--gray-600);font-size:.82rem;white-space:nowrap"><?= $tgl ?></td>
                    <td>
                        <?php if ($b['status'] === 'publish'): ?>
                        <span class="badge badge-green"><span class="badge-dot"></span>Published</span>
                        <?php else: ?>
                        <span class="badge badge-gray"><span class="badge-dot"></span>Draft</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="td-actions">
                            <a href="berita.php?action=edit&id=<?= $b['id'] ?>" class="btn btn-sm btn-outline btn-icon" title="Edit">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <a href="berita.php?delete=<?= $b['id'] ?>" class="btn btn-sm btn-danger btn-icon" title="Hapus" onclick="return confirm('Hapus berita ini?')">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($berita_data)): ?>
                <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--gray-400)">Belum ada berita. <a href="berita.php?action=add" style="color:var(--ap-green);font-weight:600">Tambah sekarang →</a></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- CTA Banner -->
<div class="cta-banner green" style="margin-top:24px;position:relative;overflow:hidden">
    <div style="flex:1">
        <div class="cta-banner-title">Butuh bantuan menulis berita?</div>
        <div class="cta-banner-desc">Lihat panduan editorial kami untuk memastikan setiap artikel memiliki dampak maksimal bagi citra sekolah.</div>
        <button class="btn btn-outline" style="margin-top:16px;background:rgba(255,255,255,.1);color:white;border-color:rgba(255,255,255,.2)">Buka Panduan Editorial</button>
    </div>
    <svg style="position:absolute;right:32px;bottom:-10px;opacity:.08" width="130" height="130" viewBox="0 0 24 24" fill="white"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/></svg>
</div>

<?php endif; ?>

</div>
</div>
</div>
<script>
function previewImg(input) {
    const preview = document.getElementById('img-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
