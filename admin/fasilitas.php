<?php
session_start();
require_once 'auth_check.php';
require_once 'koneksi.php';
$active_menu = 'fasilitas';
$page_name   = 'Fasilitas';
$action      = $_GET['action'] ?? 'list';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM fasilitas WHERE id = $id");
    header("Location: fasilitas.php"); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = $_POST['nama_fasilitas'];
    $kategori  = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $gambar    = $_POST['gambar_lama'] ?? null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ext    = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar = 'fasilitas_' . time() . '_' . uniqid() . '.' . $ext;
        if (!is_dir('../uploads')) mkdir('../uploads', 0777, true);
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../uploads/' . $gambar);
    }
    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO fasilitas (nama_fasilitas, kategori, deskripsi, gambar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $kategori, $deskripsi, $gambar);
        $stmt->execute();
    } elseif ($action === 'edit' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $conn->prepare("UPDATE fasilitas SET nama_fasilitas=?, kategori=?, deskripsi=?, gambar=? WHERE id=?");
        $stmt->bind_param("ssssi", $nama, $kategori, $deskripsi, $gambar, $id);
        $stmt->execute();
    }
    header("Location: fasilitas.php"); exit;
}

$edit_data = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $q  = $conn->query("SELECT * FROM fasilitas WHERE id = $id");
    $edit_data = ($q && $q->num_rows > 0) ? $q->fetch_assoc() : null;
    if (!$edit_data) $action = 'add';
}

$fasilitas_list = [];
if ($action === 'list') {
    $q = $conn->query("SELECT * FROM fasilitas ORDER BY id ASC");
    while ($r = $q->fetch_assoc()) $fasilitas_list[] = $r;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas - Admin SMP PGRI Ciomas</title>
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
        <div class="breadcrumb"><a href="fasilitas.php">Fasilitas</a><span class="breadcrumb-sep">›</span><?= $action==='add'?'Tambah Baru':'Edit Fasilitas' ?></div>
        <div class="page-heading"><?= $action==='add'?'Tambah Fasilitas':'Edit Fasilitas' ?></div>
        <div class="page-subheading">Lengkapi informasi sarana dan prasarana sekolah.</div>
    </div>
    <a href="fasilitas.php" class="btn btn-outline">← Kembali</a>
</div>
<form method="POST" enctype="multipart/form-data">
    <?php if ($edit_data): ?><input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($edit_data['gambar'] ?? '') ?>"><?php endif; ?>
    <div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start">
        <div class="card">
            <div class="card-header"><div class="card-title">Informasi Fasilitas</div></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group form-full">
                        <label class="form-label">Nama Fasilitas <span>*</span></label>
                        <input type="text" class="form-control" name="nama_fasilitas" placeholder="Contoh: Lab Komputer Lantai 2" value="<?= $edit_data ? htmlspecialchars($edit_data['nama_fasilitas']) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <div class="select-wrap">
                            <select class="form-control" name="kategori">
                                <?php foreach (['Ruang Belajar','Laboratorium','Olahraga','Ibadah','Umum'] as $k):
                                    $sel = ($edit_data && $edit_data['kategori']==$k) ? 'selected' : ''; ?>
                                <option <?= $sel ?>><?= $k ?></option>
                                <?php endforeach; ?>
                            </select>
                            <svg class="select-arrow" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="form-group form-full">
                        <label class="form-label">Deskripsi <span>*</span></label>
                        <textarea class="form-control" name="deskripsi" rows="4" placeholder="Deskripsi singkat fasilitas…" required><?= $edit_data ? htmlspecialchars($edit_data['deskripsi'] ?? '') : '' ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:16px">
            <div class="card">
                <div class="card-header"><div class="card-title">Foto Fasilitas</div></div>
                <div class="card-body">
                    <label class="file-upload-area">
                        <input type="file" name="gambar" accept="image/*" style="display:none" onchange="previewImg(this)">
                        <svg class="file-upload-icon" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        <div class="file-upload-text"><strong>Upload Foto</strong></div>
                        <div class="file-upload-hint">JPG, PNG — Maks. 2MB</div>
                    </label>
                    <img id="img-preview" src="<?= ($edit_data&&$edit_data['gambar']) ? '../uploads/'.$edit_data['gambar'] : '' ?>" style="display:<?= ($edit_data&&$edit_data['gambar'])?'block':'none'?>;width:100%;border-radius:10px;margin-top:14px;object-fit:cover;max-height:180px">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Simpan Fasilitas</button>
        </div>
    </div>
</form>

<?php else: ?>
<!-- ===== LIST ===== -->
<div class="page-header">
    <div>
        <div class="page-heading">Manajemen Fasilitas</div>
        <div class="page-subheading">Kelola sarana dan prasarana pendidikan untuk mendukung kegiatan belajar mengajar di SMP PGRI Ciomas.</div>
    </div>
    <a href="fasilitas.php?action=add" class="btn btn-primary" id="btn-tambah-fasilitas">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Fasilitas
    </a>
</div>

<div class="facility-card-grid">
    <?php foreach ($fasilitas_list as $f): ?>
    <div class="facility-item-card">
        <div class="facility-img-wrap">
            <?php if ($f['gambar']): ?>
            <img src="../uploads/<?= htmlspecialchars($f['gambar']) ?>" alt="<?= htmlspecialchars($f['nama_fasilitas']) ?>">
            <?php else: ?>
            <div class="facility-no-img">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                <span>Belum ada foto</span>
            </div>
            <?php endif; ?>
            <div class="facility-img-actions">
                <a href="fasilitas.php?action=edit&id=<?= $f['id'] ?>" class="btn btn-sm" style="background:white;color:var(--gray-800)">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit Foto
                </a>
            </div>
            <span style="position:absolute;top:10px;left:10px" class="badge badge-green"><span class="badge-dot"></span>Tersedia</span>
        </div>
        <div class="facility-item-body">
            <div class="facility-item-name"><?= htmlspecialchars($f['nama_fasilitas']) ?></div>
            <div class="facility-item-desc"><?= htmlspecialchars($f['deskripsi'] ?? 'Deskripsi belum tersedia.') ?></div>
        </div>
        <div class="facility-item-footer">
            <span class="badge badge-gray" style="font-size:.68rem"><?= htmlspecialchars($f['kategori']) ?></span>
            <div style="display:flex;gap:6px">
                <a href="fasilitas.php?action=edit&id=<?= $f['id'] ?>" class="btn btn-sm btn-outline">Edit</a>
                <a href="fasilitas.php?delete=<?= $f['id'] ?>" onclick="return confirm('Hapus fasilitas ini?')" class="btn btn-sm btn-danger" style="color:var(--ap-red)">Hapus</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Add card -->
    <a href="fasilitas.php?action=add" class="facility-add-card">
        <div class="facility-add-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </div>
        <div style="font-size:.9rem;font-weight:700;color:var(--ap-green)">Tambah Fasilitas Baru</div>
        <div style="font-size:.75rem;color:var(--gray-400);text-align:center;padding:0 20px">Klik untuk menambahkan sarana sekolah ke dalam sistem</div>
    </a>
</div>

<!-- CTA Banner -->
<div class="cta-banner yellow" style="margin-top:24px">
    <div style="width:52px;height:52px;background:var(--ap-yellow);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--gray-900)" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
    </div>
    <div style="flex:1">
        <div class="cta-banner-title" style="color:var(--gray-900)">Pembaruan Fasilitas Terakhir</div>
        <div class="cta-banner-desc">Pastikan semua jadwal praktikum sudah diperbarui di dashboard setelah menambahkan fasilitas baru.</div>
    </div>
    <button class="btn btn-green" style="padding:11px 22px">Lihat Log Perubahan</button>
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
