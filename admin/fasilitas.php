<?php
session_start();
require_once 'auth_check.php';
require_once 'koneksi.php';

$active_menu = 'fasilitas';
$page_name   = 'Manajemen Fasilitas';
$action      = $_GET['action'] ?? 'list';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM fasilitas WHERE id = $id");
    header("Location: fasilitas.php");
    exit;
}

// Handle Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $kategori       = $_POST['kategori'];
    $deskripsi      = $_POST['deskripsi'];
    
    // Foto upload
    $gambar = $_POST['gambar_lama'] ?? null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar = 'fasilitas_' . time() . '_' . uniqid() . '.' . $ext;
        if (!is_dir('../uploads')) mkdir('../uploads', 0777, true);
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../uploads/' . $gambar);
    }

    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO fasilitas (nama_fasilitas, kategori, deskripsi, gambar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama_fasilitas, $kategori, $deskripsi, $gambar);
        $stmt->execute();
    } elseif ($action === 'edit' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $conn->prepare("UPDATE fasilitas SET nama_fasilitas=?, kategori=?, deskripsi=?, gambar=? WHERE id=?");
        $stmt->bind_param("ssssi", $nama_fasilitas, $kategori, $deskripsi, $gambar, $id);
        $stmt->execute();
    }
    header("Location: fasilitas.php");
    exit;
}

// Fetch single data for edit
$edit_data = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $q_fasilitas = $conn->query("SELECT * FROM fasilitas WHERE id = $id");
    if ($q_fasilitas->num_rows > 0) {
        $edit_data = $q_fasilitas->fetch_assoc();
    } else {
        $action = 'add';
    }
}

$fasilitas_list = [];
if ($action === 'list') {
    $q_fas = $conn->query("SELECT * FROM fasilitas ORDER BY id ASC");
    while($row = $q_fas->fetch_assoc()) {
        $fasilitas_list[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas - Admin SMP PGRI Ciomas</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        .facility-card-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .facility-item-card {
            background: white;
            border-radius: var(--radius-md);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: box-shadow var(--transition), transform var(--transition);
        }
        .facility-item-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        .facility-img-wrap {
            position: relative;
            aspect-ratio: 16/9;
            overflow: hidden;
            background: var(--green-light);
        }
        .facility-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover; object-position: center;
            transition: transform .3s ease;
        }
        .facility-item-card:hover .facility-img-wrap img {
            transform: scale(1.04);
        }
        .facility-img-actions {
            position: absolute; inset: 0;
            background: rgba(0,0,0,.5);
            display: flex; align-items: center; justify-content: center; gap: 8px;
            opacity: 0; transition: opacity var(--transition);
        }
        .facility-item-card:hover .facility-img-actions { opacity: 1; }
        .facility-item-body { padding: 16px; }
        .facility-item-name {
            font-size: .92rem; font-weight: 700; color: var(--gray-900); margin-bottom: 4px;
        }
        .facility-item-desc {
            font-size: .78rem; color: var(--gray-600); line-height: 1.5;
        }
        .facility-item-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 16px;
            border-top: 1px solid var(--gray-100);
        }
        @media (max-width: 900px) { .facility-card-grid { grid-template-columns: repeat(2,1fr); } }
        @media (max-width: 600px) { .facility-card-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="admin-layout">
<?php include 'components/sidebar.php'; ?>
<div class="admin-main">
<?php include 'components/topbar.php'; ?>
<div class="page-content">

    <?php if ($action === 'add' || $action === 'edit'): ?>
    <!-- ============ FORM ============ -->
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-heading"><?= $action === 'add' ? 'Tambah Fasilitas' : 'Edit Fasilitas' ?></div>
            <div class="page-subheading">Lengkapi informasi fasilitas sekolah</div>
        </div>
        <a href="fasilitas.php" class="btn btn-outline">← Kembali</a>
    </div>

    <form method="POST" enctype="multipart/form-data">
    <?php if ($edit_data): ?>
        <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($edit_data['gambar'] ?? '') ?>">
    <?php endif; ?>
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">
        <div class="card">
            <div class="card-header"><div class="card-title">Informasi Fasilitas</div></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group form-full">
                        <label class="form-label">Nama Fasilitas <span>*</span></label>
                        <input type="text" class="form-control" name="nama_fasilitas" placeholder="Contoh: Ruang Kelas Ber-AC" value="<?= $edit_data ? htmlspecialchars($edit_data['nama_fasilitas']) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <div class="select-wrap">
                            <select class="form-control" name="kategori">
                                <?php 
                                $kats = ['Ruang Belajar', 'Laboratorium', 'Olahraga', 'Ibadah', 'Umum'];
                                foreach ($kats as $k):
                                    $sel = ($edit_data && $edit_data['kategori'] == $k) ? 'selected' : '';
                                ?>
                                <option <?= $sel ?>><?= $k ?></option>
                                <?php endforeach; ?>
                            </select>
                            <svg class="select-arrow" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    <div class="form-group form-full">
                        <label class="form-label">Deskripsi <span>*</span></label>
                        <textarea class="form-control" name="deskripsi" rows="4" placeholder="Deskripsi singkat fasilitas ini..." required><?= $edit_data ? htmlspecialchars($edit_data['deskripsi'] ?? '') : '' ?></textarea>
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
                        <svg class="file-upload-icon" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <div class="file-upload-text"><strong>Upload Foto</strong></div>
                        <div class="file-upload-hint">JPG, PNG — Maks. 2MB</div>
                    </label>
                    <img id="img-preview" src="<?= ($edit_data && $edit_data['gambar']) ? '../uploads/'.$edit_data['gambar'] : '' ?>" style="display:<?= ($edit_data && $edit_data['gambar']) ? 'block' : 'none' ?>;width:100%;border-radius:10px;margin-top:14px;object-fit:cover;max-height:200px">
                </div>
            </div>
            <div class="card">
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Simpan Fasilitas</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <?php else: ?>
    <!-- ============ LIST ============ -->
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-heading">Manajemen Fasilitas</div>
            <div class="page-subheading">Kelola data fasilitas & sarana prasarana sekolah</div>
        </div>
        <a href="fasilitas.php?action=add" class="btn btn-primary" id="btn-tambah-fasilitas">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Fasilitas
        </a>
    </div>

    <div class="facility-card-grid">
        <?php foreach ($fasilitas_list as $f): 
            $img = $f['gambar'] ? '../uploads/' . $f['gambar'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCEElR7Y7-kCYFW3ZsfYClcatBUlzOq2tkxNt4PGDeK1fSBSHkY7LuFfh45uOWfDmatcszWZoi0UrpRienFQqFZWljVHKH-RG2bZBL-ADaqUp96e53guwqaIE5rs-hqaPnT7S5yfYehoJ66FV_iYuXzqmNONCZ3uOVkraseURAAxA8aE0clVaf6FBAzPjGUvF-1Nf4dGTTgw_5CXhVDq4YtshRtJpuLiz8ItxfjD1WjMU5uMyfU9jQAi6dK0dI7tiGUDhyptfe-P_iI';    
        ?>
        <div class="facility-item-card">
            <div class="facility-img-wrap">
                <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($f['nama_fasilitas']) ?>">
                <div class="facility-img-actions">
                    <a href="fasilitas.php?action=edit&id=<?= $f['id'] ?>" class="btn btn-sm" style="background:white;color:var(--gray-800)">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Foto
                    </a>
                </div>
                <span style="position:absolute;top:10px;right:10px" class="badge badge-green"><?= htmlspecialchars($f['kategori']) ?></span>
            </div>
            <div class="facility-item-body">
                <div class="facility-item-name"><?= htmlspecialchars($f['nama_fasilitas']) ?></div>
                <div class="facility-item-desc"><?= htmlspecialchars($f['deskripsi'] ?? 'Deskripsi belum tersedia.') ?></div>
            </div>
            <div class="facility-item-footer">
                <span style="font-size:.73rem;color:var(--gray-400)">ID: <?= $f['id'] ?></span>
                <div style="display:flex;gap:6px">
                    <a href="fasilitas.php?action=edit&id=<?= $f['id'] ?>" class="btn btn-sm btn-outline btn-icon" title="Edit">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </a>
                    <a href="fasilitas.php?delete=<?= $f['id'] ?>" class="btn btn-sm btn-danger btn-icon" title="Hapus" onclick="return confirm('Hapus fasilitas ini?')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
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
