<?php

declare(strict_types=1);

session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}


require_once 'config.php';
require_once 'skema_functions.php';

$skemaManager = new SkemaManager($conn);
$skema_list = $skemaManager->getAllSkema();
$error = null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    try {
        switch ($_POST['action']) {
            case 'create_skema':
                $result = $skemaManager->createSkemaComplete($_POST);
                if ($result) {
                    header("Location: admin_skema.php?success=Skema berhasil ditambahkan");
                    exit;
                }
                $error = "Gagal menambahkan skema";
                break;

            case 'update_skema':
                $result = $skemaManager->updateSkemaComplete($_POST);
                if ($result) {
                    header("Location: admin_skema.php?success=Skema berhasil diperbarui");
                    exit;
                }
                $error = "Gagal memperbarui skema";
                break;

            case 'delete_skema':
                $result = $skemaManager->deleteSkema($_POST['skema_id']);
                if ($result) {
                    header("Location: admin_skema.php?success=Skema berhasil dihapus");
                    exit;
                }
                $error = "Gagal menghapus skema";
                break;
        }
    } catch (Exception $e) {
        $error = "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Skema - Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css" />
    <link rel="stylesheet" href="css/admin_skema.css" />

</head>

<body>
    <?php require_once 'includes/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <div class="header-content">
                <h1>Manajemen Skema</h1>
            </div>
        </header>

        <?php if (isset($_GET['success'])) : ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <?php if ($error) : ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <section class="form-section">
            <h2>Tambah Skema Baru</h2>
            <button type="button" class="btn" onclick="openModal('addSkemaModal')">Tambah Skema</button>
        </section>

        <section class="schema-section">
            <h2>Daftar Skema</h2>
            <div class="schema-container">
                <?php foreach ($skema_list as $skema) : ?>
                    <div class="schema-card">
                        <?php if (!empty($skema['gambar'])) : ?>
                            <div class="schema-image">
                                <img src="dksassets/img/<?= htmlspecialchars($skema['gambar']); ?>" alt="<?= htmlspecialchars($skema['nama']); ?>">
                            </div>
                        <?php endif; ?>

                        <h3><?= htmlspecialchars($skema['nama']); ?></h3>
                        <div class="schema-info">
                            <strong>Kode:</strong> <?= htmlspecialchars($skema['kode']); ?><br>
                            <strong>Jenis:</strong> <?= htmlspecialchars($skema['jenis']); ?><br>
                            <strong>Harga:</strong> Rp <?= htmlspecialchars($skema['harga']); ?><br>
                            <strong>Unit Kompetensi:</strong> <?= $skema['unit_kompetensi']; ?>
                        </div>
                        <p><?= htmlspecialchars(substr($skema['ringkasan'], 0, 150)) . '...'; ?></p>
                        <div class="card-actions">
                            <button class="btn btn-small" onclick="editSkema(<?= $skema['id']; ?>)">Edit</button>
                            <button class="btn btn-danger btn-small" onclick="deleteSkema(<?= $skema['id']; ?>)">Hapus</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <!-- Add Skema Modal -->
    <div id="addSkemaModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addSkemaModal')">&times;</span>
            <h2>Tambah Skema Baru</h2>
            <form method="POST" id="addSkemaForm" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create_skema">

                <!-- Basic Info -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama">Nama Skema *</label>
                        <input type="text" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="kode">Kode Skema *</label>
                        <input type="text" id="kode" name="kode" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jenis">Jenis *</label>
                        <select id="jenis" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="Klaster">Klaster</option>
                            <option value="Okupasi">Okupasi</option>
                            <option value="Mandiri">Mandiri</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga *</label>
                        <input type="number" id="harga" name="harga" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="unit_kompetensi">Jumlah Unit Kompetensi *</label>
                        <input type="number" id="unit_kompetensi" name="unit_kompetensi" required>
                    </div>
                    <div class="form-group">
                        <label for="masa_berlaku">Masa Berlaku Sertifikat</label>
                        <input type="text" id="masa_berlaku" name="masa_berlaku" value="3 Tahun" placeholder="Contoh: 3 Tahun">
                    </div>
                </div>

                <div class="form-group">
                    <label for="ringkasan">Ringkasan *</label>
                    <textarea id="ringkasan" name="ringkasan" required placeholder="Masukkan ringkasan skema..."></textarea>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Skema</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*">
                    <small class="form-text text-muted">Format: JPG, PNG, maksimal 2MB</small>
                </div>

                <!-- Tab Container -->
                <div class="tab-container">
                    <div class="tab-buttons">
                        <button type="button" class="tab-btn active" onclick="showAddTab('unit')">Unit Kompetensi</button>
                        <button type="button" class="tab-btn" onclick="showAddTab('persyaratan')">Persyaratan</button>
                        <button type="button" class="tab-btn" onclick="showAddTab('dokumen')">Dokumen</button>
                        <button type="button" class="tab-btn" onclick="showAddTab('asesmen')">Metode Asesmen</button>
                        <button type="button" class="tab-btn" onclick="showAddTab('pemeliharaan')">Pemeliharaan</button>
                        <button type="button" class="tab-btn" onclick="showAddTab('metode_pengujian')">Metode Pengujian</button>
                    </div>

                    <!-- Unit Kompetensi Tab -->
                    <div id="add-tab-unit" class="tab-content active">
                        <h4>Unit Kompetensi</h4>
                        <div id="unit-fields">
                            <div class="dynamic-field">
                                <input type="number" name="unit_no[]" placeholder="No" style="flex: 0 0 60px;">
                                <input type="text" name="kode_unit[]" placeholder="Kode Unit" required>
                                <input type="text" name="unit_judul[]" placeholder="Judul Unit" required>
                                <input type="text" name="unit_standar[]" placeholder="Standar Kompetensi">
                                <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addUnitField()">+ Tambah Unit</button>
                    </div>

                    <!-- Persyaratan Tab -->
                    <div id="add-tab-persyaratan" class="tab-content">
                        <h4>Persyaratan</h4>
                        <div id="persyaratan-fields">
                            <div class="dynamic-field">
                                <textarea name="persyaratan[]" placeholder="Deskripsi persyaratan" required style="flex: 1; height: 60px;"></textarea>
                                <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addPersyaratanField()">+ Tambah Persyaratan</button>
                    </div>

                    <!-- Dokumen Tab -->
                    <div id="add-tab-dokumen" class="tab-content">
                        <h4>Dokumen Persyaratan</h4>
                        <div id="dokumen-fields">
                            <div class="dynamic-field">
                                <input type="text" name="dokumen_nama[]" placeholder="Nama Dokumen" required>
                                <div class="checkbox-field">
                                    <input type="checkbox" name="dokumen_wajib[0]" value="1" checked>
                                    <label>Wajib</label>
                                </div>
                                <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addDokumenField()">+ Tambah Dokumen</button>
                    </div>

                    <!-- Metode Asesmen Tab -->
                    <div id="add-tab-asesmen" class="tab-content">
                        <h4>Metode Asesmen</h4>
                        <div id="asesmen-fields">
                            <div class="dynamic-field">
                                <select name="asesmen_jenis[]" required>
                                    <option value="">Pilih Jenis Peserta</option>
                                    <option value="Berpengalaman">Berpengalaman</option>
                                    <option value="Belum Berpengalaman">Belum Berpengalaman</option>
                                </select>
                                <input type="text" name="asesmen_metode[]" placeholder="Metode Asesmen" required>
                                <textarea name="asesmen_deskripsi[]" placeholder="Deskripsi" style="height: 60px;"></textarea>
                                <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addAsesmenField()">+ Tambah Metode</button>
                    </div>

                    <!-- Pemeliharaan Tab -->
                    <div id="add-tab-pemeliharaan" class="tab-content">
                        <h4>Pemeliharaan Sertifikasi</h4>
                        <div class="form-group">
                            <textarea name="pemeliharaan" placeholder="Masukkan deskripsi pemeliharaan sertifikasi..." style="width: 100%; height: 100px;"></textarea>
                        </div>
                    </div>

                    <!-- Metode Pengujian Tab -->
                    <div id="add-tab-metode_pengujian" class="tab-content">
                        <h4>Metode Pengujian Skema</h4>
                        <div id="add-metode-pengujian-fields">
                            <!-- Field dinamis akan ditambahkan di sini oleh JavaScript -->
                            <div class="dynamic-field">
                                <select name="metode_pengujian_skema[]" class="form-control">
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="Sertifikasi Jarak Jauh (SJJ)">Sertifikasi Jarak Jauh (SJJ)</option>
                                    <option value="Metode Paperless (non-kertas)">Metode Paperless (non-kertas)</option>
                                    <option value="Paper-based (berbasis kertas)">Paper-based (berbasis kertas)</option>
                                </select>
                                <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addMetodePengujianField()">+ Tambah Metode</button>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn" style="background-color: #95a5a6; margin-right: 10px;" onclick="closeModal('addSkemaModal')">Batal</button>
                    <button type="submit" class="btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Skema Modal -->
    <div id="editSkemaModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editSkemaModal')">&times;</span>
            <h2>Edit Skema</h2>
            <form method="POST" id="editSkemaForm" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_skema">
                <input type="hidden" name="skema_id" id="edit_skema_id">

                <!-- Same structure as add form but with edit_ prefixes -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_nama">Nama Skema *</label>
                        <input type="text" id="edit_nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_kode">Kode Skema *</label>
                        <input type="text" id="edit_kode" name="kode" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_jenis">Jenis *</label>
                        <select id="edit_jenis" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="Klaster">Klaster</option>
                            <option value="Okupasi">Okupasi</option>
                            <option value="Mandiri">Mandiri</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_harga">Harga *</label>
                        <input type="number" id="edit_harga" name="harga" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_unit_kompetensi">Jumlah Unit Kompetensi *</label>
                        <input type="number" id="edit_unit_kompetensi" name="unit_kompetensi" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_masa_berlaku">Masa Berlaku Sertifikat</label>
                        <input type="text" id="edit_masa_berlaku" name="masa_berlaku" placeholder="Contoh: 3 Tahun">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_ringkasan">Ringkasan *</label>
                    <textarea id="edit_ringkasan" name="ringkasan" required></textarea>
                </div>

                <div class="form-group">
                    <label for="edit_gambar">Gambar Skema</label>
                    <input type="file" id="edit_gambar" name="gambar" accept="image/*">
                    <small class="form-text text-muted">Format: JPG, PNG, maksimal 2MB</small>
                    <input type="hidden" name="existing_gambar" id="edit_existing_gambar">
                    <div id="current-image-preview" style="margin-top: 10px;"></div>
                </div>
                <!-- Tab Container for Edit -->
                <div class="tab-container">
                    <div class="tab-buttons">
                        <button type="button" class="tab-btn active" onclick="showEditTab('unit')">Unit Kompetensi</button>
                        <button type="button" class="tab-btn" onclick="showEditTab('persyaratan')">Persyaratan</button>
                        <button type="button" class="tab-btn" onclick="showEditTab('dokumen')">Dokumen</button>
                        <button type="button" class="tab-btn" onclick="showEditTab('asesmen')">Metode Asesmen</button>
                        <button type="button" class="tab-btn" onclick="showEditTab('pemeliharaan')">Pemeliharaan</button>
                        <button type="button" class="tab-btn" onclick="showEditTab('metode_pengujian')">Metode Pengujian</button>
                    </div>

                    <div id="edit-tab-unit" class="tab-content active">
                        <h4>Unit Kompetensi</h4>
                        <div id="edit-unit-fields"></div>
                        <button type="button" class="add-btn" onclick="addEditUnitField()">+ Tambah Unit</button>
                    </div>

                    <div id="edit-tab-persyaratan" class="tab-content">
                        <h4>Persyaratan</h4>
                        <div id="edit-persyaratan-fields"></div>
                        <button type="button" class="add-btn" onclick="addEditPersyaratanField()">+ Tambah Persyaratan</button>
                    </div>

                    <div id="edit-tab-dokumen" class="tab-content">
                        <h4>Dokumen Persyaratan</h4>
                        <div id="edit-dokumen-fields"></div>
                        <button type="button" class="add-btn" onclick="addEditDokumenField()">+ Tambah Dokumen</button>
                    </div>

                    <div id="edit-tab-asesmen" class="tab-content">
                        <h4>Metode Asesmen</h4>
                        <div id="edit-asesmen-fields"></div>
                        <button type="button" class="add-btn" onclick="addEditAsesmenField()">+ Tambah Metode</button>
                    </div>

                    <!-- Pemeliharaan Tab for Edit -->
                    <div id="edit-tab-pemeliharaan" class="tab-content">
                        <h4>Pemeliharaan Sertifikasi</h4>
                        <div class="form-group">
                            <textarea id="edit_pemeliharaan" name="pemeliharaan" placeholder="Masukkan deskripsi pemeliharaan sertifikasi..." style="width: 100%; height: 100px;"></textarea>
                        </div>
                    </div>

                    <!-- Metode Pengujian Tab for Edit -->
                    <div id="edit-tab-metode_pengujian" class="tab-content">
                        <h4>Metode Pengujian Skema</h4>
                        <div id="edit-metode-pengujian-fields">
                            <!-- Field dinamis akan diisi di sini oleh JavaScript saat edit -->
                        </div>
                        <button type="button" class="add-btn" onclick="addEditMetodePengujianField()">+ Tambah Metode</button>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn" style="background-color: #95a5a6; margin-right: 10px;" onclick="closeModal('editSkemaModal')">Batal</button>
                    <button type="submit" class="btn">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteSkemaModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteSkemaModal')">&times;</span>
            <h2>Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus skema ini? Tindakan ini tidak dapat dibatalkan.</p>
            <form method="POST" id="deleteSkemaForm">
                <input type="hidden" name="action" value="delete_skema">
                <input type="hidden" name="skema_id" id="delete_skema_id">

                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn" style="background-color: #95a5a6; margin-right: 10px;" onclick="closeModal('deleteSkemaModal')">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
    <script src="js/admin_skema.js"></script>

</body>

</html>
