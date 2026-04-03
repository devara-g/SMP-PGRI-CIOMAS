<?php
session_start();
require_once 'auth_check.php';
require_once 'koneksi.php';

$active_menu = 'berita';
$page_name   = 'Berita & Pengumuman';
$action      = $_GET['action'] ?? 'list';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM berita WHERE id = $id");
    header("Location: berita.php");
    exit;
}

// Handle Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul      = $_POST['judul'];
    $kategori   = $_POST['kategori'];
    $tanggal    = $_POST['tanggal'];
    $status     = strtolower($_POST['action'] ?? $_POST['status'] ?? 'publish');
    if($status == 'draft') $status = 'draft'; else $status = 'publish';
    $isi        = $_POST['isi'];
    
    // Foto upload
    $gambar = $_POST['gambar_lama'] ?? null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
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
    header("Location: berita.php");
    exit;
}

// Fetch single data for edit
$edit_data = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $q_berita = $conn->query("SELECT * FROM berita WHERE id = $id");
    if ($q_berita->num_rows > 0) {
        $edit_data = $q_berita->fetch_assoc();
    } else {
        $action = 'add';
    }
}

$berita_data = [];
if ($action === 'list') {
    $q_berita = $conn->query("SELECT * FROM berita ORDER BY id DESC");
    while($row = $q_berita->fetch_assoc()) {
        $berita_data[] = $row;
    }
}
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
    <!-- ========= FORM TAMBAH / EDIT ========= -->
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-heading"><?= $action === 'add' ? 'Tambah Berita' : 'Edit Berita' ?></div>
            <div class="page-subheading">Isi semua informasi berita dengan lengkap dan benar</div>
        </div>
        <div class="page-header-actions">
            <a href="berita.php" class="btn btn-outline">← Kembali</a>
        </div>
    </div>

    <form method="POST" enctype="multipart/form-data">
    <?php if ($edit_data): ?>
        <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($edit_data['gambar']) ?>">
    <?php endif; ?>
    <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start">
        <!-- Main form -->
        <div style="display:flex;flex-direction:column;gap:20px">
            <div class="card">
                <div class="card-header"><div class="card-title">Informasi Berita</div></div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group form-full">
                            <label class="form-label">Judul Berita <span>*</span></label>
                            <input type="text" name="judul" class="form-control" placeholder="Masukkan judul berita yang menarik..." value="<?= $edit_data ? htmlspecialchars($edit_data['judul']) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kategori <span>*</span></label>
                            <div class="select-wrap">
                                <select name="kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php 
                                    $kategoris = ['Akademik', 'Kegiatan', 'Prestasi', 'Pengumuman', 'Lingkungan', 'Penerimaan']; 
                                    foreach ($kategoris as $k):
                                        $selected = ($edit_data && $edit_data['kategori'] == $k) ? 'selected' : '';
                                    ?>
                                    <option <?= $selected ?>><?= $k ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <svg class="select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Publikasi <span>*</span></label>
                            <input type="date" name="tanggal" class="form-control" value="<?= $edit_data ? $edit_data['tanggal'] : date('Y-m-d') ?>" required>
                        </div>
                        <div class="form-group form-full">
                            <label class="form-label">Ringkasan / Excerpt</label>
                            <textarea name="ringkasan" class="form-control" rows="3" placeholder="Ringkasan singkat berita (opsional)..."></textarea>
                        </div>
                        <div class="form-group form-full">
                            <label class="form-label">Isi Berita <span>*</span></label>
                            <textarea name="isi" class="form-control" rows="12" placeholder="Tulis isi berita selengkapnya di sini..." required><?= $edit_data ? htmlspecialchars($edit_data['konten']) : '' ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Foto -->
            <div class="card">
                <div class="card-header"><div class="card-title">Foto Berita</div></div>
                <div class="card-body">
                    <label class="file-upload-area">
                        <input type="file" name="foto" accept="image/*" style="display:none" onchange="previewImg(this)">
                        <svg class="file-upload-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <div class="file-upload-text"><strong>Klik untuk upload</strong> atau drag & drop foto</div>
                        <div class="file-upload-hint">PNG, JPG, WEBP — Maks. 2MB — Rasio 16:9 dianjurkan</div>
                    </label>
                    <img id="img-preview" src="<?= ($edit_data && $edit_data['gambar']) ? '../uploads/'.$edit_data['gambar'] : '' ?>" style="display:<?= ($edit_data && $edit_data['gambar']) ? 'block' : 'none' ?>;width:100%;border-radius:10px;margin-top:14px;object-fit:cover;max-height:200px">
                </div>
            </div>
        </div>

        <!-- Sidebar options -->
        <div style="display:flex;flex-direction:column;gap:20px">
            <div class="card">
                <div class="card-header"><div class="card-title">Publikasi</div></div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:16px">
                        <label class="form-label">Status</label>
                        <div class="select-wrap">
                            <select name="status" class="form-control">
                                <option value="publish" <?= ($edit_data && $edit_data['status']=='publish') ? 'selected' : '' ?>>Publish (Ditayangkan)</option>
                                <option value="draft" <?= ($edit_data && $edit_data['status']=='draft') ? 'selected' : '' ?>>Draft (Tidak Tampil)</option>
                            </select>
                            <svg class="select-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                </div>
                <div class="card-footer" style="display:flex;flex-direction:column;gap:8px">
                    <button type="submit" name="action" value="publish" class="btn btn-primary" style="width:100%;justify-content:center">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Simpan & Publish
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
    <!-- ========= LIST BERITA ========= -->
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-heading">Berita & Pengumuman</div>
            <div class="page-subheading">Kelola semua artikel berita dan pengumuman sekolah</div>
        </div>
        <div class="page-header-actions">
            <a href="berita.php?action=add" class="btn btn-primary" id="btn-tambah-berita">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Berita
            </a>
        </div>
    </div>

    <!-- Filter bar -->
    <div class="card" style="margin-bottom:20px">
        <div class="card-body" style="padding:14px 22px">
            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
                <div style="position:relative;flex:1;min-width:200px">
                    <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--gray-400)" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" class="form-control" placeholder="Cari judul berita..." style="padding-left:34px">
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Berita</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($berita_data as $b): 
                        $tanggal = date('d M Y', strtotime($b['tanggal']));    
                    ?>
                    <tr>
                        <td>
                            <div class="td-name" style="max-width:320px"><?= htmlspecialchars($b['judul']) ?></div>
                        </td>
                        <td><span class="badge badge-green"><?= htmlspecialchars($b['kategori']) ?></span></td>
                        <td style="color:var(--gray-600);font-size:.82rem">Admin</td>
                        <td style="color:var(--gray-600);font-size:.82rem;white-space:nowrap"><?= $tanggal ?></td>
                        <td>
                            <?php if ($b['status'] === 'publish'): ?>
                            <span class="badge badge-green"><span class="badge-dot"></span>Tayang</span>
                            <?php else: ?>
                            <span class="badge badge-gray"><span class="badge-dot"></span>Draft</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="td-actions">
                                <a href="berita.php?action=edit&id=<?= $b['id'] ?>" class="btn btn-sm btn-outline btn-icon" title="Edit">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <a href="berita.php?delete=<?= $b['id'] ?>" class="btn btn-sm btn-danger btn-icon" title="Hapus" onclick="return confirm('Hapus berita ini?')">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
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
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
