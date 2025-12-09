<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Model/SkemaManager.php';

use App\Model\SkemaManager;

$skemaManager = new SkemaManager($conn);
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'create_skema':
                    $skemaManager->createSkemaComplete($_POST);
                    header("Location: admin_skema.php?success=Skema berhasil ditambahkan");
                    exit();
                    break;
                
                case 'update_skema':
                    $skemaManager->updateSkemaComplete($_POST);
                    header("Location: admin_skema.php?success=Skema berhasil diperbarui");
                    exit();
                    break;

                case 'delete_skema':
                    if (isset($_POST['skema_id'])) {
                        $skemaManager->deleteSkema($_POST['skema_id']);
                        header("Location: admin_skema.php?success=Skema berhasil dihapus");
                        exit();
                    }
                    break;
            }
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$skema_list = $skemaManager->getAllSkema();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Skema - Admin DKS</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin.css">
    <style>
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .form-row { display: flex; gap: 20px; }
        .form-row .form-group { flex: 1; }
        .btn { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn-danger { background-color: #f44336; }
        .btn-small { padding: 5px 10px; font-size: 12px; }
        .card-actions { margin-top: 15px; display: flex; gap: 10px; }
        
        /* Tab Styles */
        .tab-container { margin-top: 20px; border: 1px solid #ddd; border-radius: 4px; padding: 15px; }
        .tab-buttons { display: flex; border-bottom: 1px solid #ddd; margin-bottom: 15px; overflow-x: auto; }
        .tab-btn { padding: 10px 20px; background: none; border: none; cursor: pointer; border-bottom: 2px solid transparent; white-space: nowrap; }
        .tab-btn.active { border-bottom-color: #4CAF50; color: #4CAF50; font-weight: bold; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        /* Dynamic Fields */
        .dynamic-field { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; }
        .dynamic-field input, .dynamic-field select { flex: 1; }
        .remove-btn { background: #ff4444; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
        .add-btn { background: #4CAF50; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 12px; margin-top: 5px; }
        .checkbox-field { display: flex; align-items: center; gap: 5px; }
        .checkbox-field input { width: auto; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../src/View/partials/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <div class="header-content">
                <h1>Manajemen Skema</h1>
            </div>
        </header>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <section class="form-section">
            <h2>Tambah Skema Baru</h2>
            <button type="button" class="btn" onclick="openModal('addSkemaModal')">Tambah Skema</button>
        </section>

        <section class="schema-section">
            <h2>Daftar Skema</h2>
            <div class="schema-container">
                <?php foreach ($skema_list as $skema): ?>
                    <div class="schema-card">
                        <?php if (!empty($skema['gambar'])): ?>
                            <div class="schema-image">
                                <img src="dksassets/img/<?php echo htmlspecialchars($skema['gambar']); ?>" 
                                     alt="<?php echo htmlspecialchars($skema['nama']); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <h3><?php echo htmlspecialchars($skema['nama']); ?></h3>
                        <div class="schema-info">
                            <strong>Kode:</strong> <?php echo htmlspecialchars($skema['kode']); ?><br>
                            <strong>Jenis:</strong> <?php echo htmlspecialchars($skema['jenis']); ?><br>
                            <strong>Harga:</strong> Rp <?php echo htmlspecialchars($skema['harga']); ?><br>
                            <strong>Unit Kompetensi:</strong> <?php echo $skema['unit_kompetensi']; ?>
                        </div>
                        <p><?php echo htmlspecialchars(substr($skema['ringkasan'], 0, 150)) . '...'; ?></p>
                        <div class="card-actions">
                            <button class="btn btn-small" onclick="editSkema(<?php echo $skema['id']; ?>)">Edit</button>
                            <button class="btn btn-danger btn-small" onclick="deleteSkema(<?php echo $skema['id']; ?>)">Hapus</button>
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
            <h2 id="modalTitle">Tambah Skema Baru</h2>
            <form method="POST" id="addSkemaForm" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create_skema">
                <input type="hidden" name="skema_id" id="skema_id">
                <input type="hidden" name="existing_gambar" id="existing_gambar">
                
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
                    <div id="current-image-preview"></div>
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
                            <textarea name="pemeliharaan" id="pemeliharaan" placeholder="Masukkan deskripsi pemeliharaan sertifikasi..." style="width: 100%; height: 100px;"></textarea>
                        </div>
                    </div>

                    <!-- Metode Pengujian Tab -->
                    <div id="add-tab-metode_pengujian" class="tab-content">
                        <h4>Metode Pengujian Skema</h4>
                        <div id="add-metode-pengujian-fields">
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

                <div class="card-actions" style="margin-top: 20px;">
                    <button type="submit" class="btn">Simpan Skema</button>
                    <button type="button" class="btn btn-danger" onclick="closeModal('addSkemaModal')">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
            if (modalId === 'addSkemaModal') {
                document.getElementById('modalTitle').innerText = 'Tambah Skema Baru';
                document.getElementById('addSkemaForm').reset();
                document.querySelector('input[name="action"]').value = 'create_skema';
                document.getElementById('skema_id').value = '';
                document.getElementById('existing_gambar').value = '';
                document.getElementById('current-image-preview').innerHTML = '';
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }

        function showAddTab(tabName) {
            // Hide all tabs
            var tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(function(tab) {
                tab.classList.remove('active');
            });
            
            // Deactivate all buttons
            var buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(function(btn) {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById('add-tab-' + tabName).classList.add('active');
            
            // Activate button
            event.currentTarget.classList.add('active');
        }

        function removeField(btn) {
            btn.closest('.dynamic-field').remove();
        }

        function addUnitField() {
            var container = document.getElementById('unit-fields');
            var div = document.createElement('div');
            div.className = 'dynamic-field';
            div.innerHTML = `
                <input type="number" name="unit_no[]" placeholder="No" style="flex: 0 0 60px;">
                <input type="text" name="kode_unit[]" placeholder="Kode Unit" required>
                <input type="text" name="unit_judul[]" placeholder="Judul Unit" required>
                <input type="text" name="unit_standar[]" placeholder="Standar Kompetensi">
                <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
            `;
            container.appendChild(div);
        }

        function addPersyaratanField() {
            var container = document.getElementById('persyaratan-fields');
            var div = document.createElement('div');
            div.className = 'dynamic-field';
            div.innerHTML = `
                <textarea name="persyaratan[]" placeholder="Deskripsi persyaratan" required style="flex: 1; height: 60px;"></textarea>
                <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
            `;
            container.appendChild(div);
        }

        function addDokumenField() {
            var container = document.getElementById('dokumen-fields');
            var index = container.children.length;
            var div = document.createElement('div');
            div.className = 'dynamic-field';
            div.innerHTML = `
                <input type="text" name="dokumen_nama[]" placeholder="Nama Dokumen" required>
                <div class="checkbox-field">
                    <input type="checkbox" name="dokumen_wajib[${index}]" value="1" checked>
                    <label>Wajib</label>
                </div>
                <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
            `;
            container.appendChild(div);
        }

        function addAsesmenField() {
            var container = document.getElementById('asesmen-fields');
            var div = document.createElement('div');
            div.className = 'dynamic-field';
            div.innerHTML = `
                <select name="asesmen_jenis[]" required>
                    <option value="">Pilih Jenis Peserta</option>
                    <option value="Berpengalaman">Berpengalaman</option>
                    <option value="Belum Berpengalaman">Belum Berpengalaman</option>
                </select>
                <input type="text" name="asesmen_metode[]" placeholder="Metode Asesmen" required>
                <textarea name="asesmen_deskripsi[]" placeholder="Deskripsi" style="height: 60px;"></textarea>
                <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
            `;
            container.appendChild(div);
        }

        function addMetodePengujianField() {
            var container = document.getElementById('add-metode-pengujian-fields');
            var div = document.createElement('div');
            div.className = 'dynamic-field';
            div.innerHTML = `
                <select name="metode_pengujian_skema[]" class="form-control">
                    <option value="">-- Pilih Metode --</option>
                    <option value="Sertifikasi Jarak Jauh (SJJ)">Sertifikasi Jarak Jauh (SJJ)</option>
                    <option value="Metode Paperless (non-kertas)">Metode Paperless (non-kertas)</option>
                    <option value="Paper-based (berbasis kertas)">Paper-based (berbasis kertas)</option>
                </select>
                <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
            `;
            container.appendChild(div);
        }

        function deleteSkema(id) {
            if (confirm('Apakah Anda yakin ingin menghapus skema ini?')) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_skema">
                    <input type="hidden" name="skema_id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        async function editSkema(id) {
            try {
                const response = await fetch(`get_skema.php?id=${id}`);
                const data = await response.json();
                
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Populate form
                document.getElementById('modalTitle').innerText = 'Edit Skema';
                document.querySelector('input[name="action"]').value = 'update_skema';
                document.getElementById('skema_id').value = data.skema.id;
                document.getElementById('nama').value = data.skema.nama;
                document.getElementById('kode').value = data.skema.kode;
                document.getElementById('jenis').value = data.skema.jenis;
                document.getElementById('harga').value = data.skema.harga;
                document.getElementById('unit_kompetensi').value = data.skema.unit_kompetensi;
                document.getElementById('masa_berlaku').value = data.skema.masa_berlaku;
                document.getElementById('ringkasan').value = data.skema.ringkasan;
                document.getElementById('existing_gambar').value = data.skema.gambar || '';

                if (data.skema.gambar) {
                    document.getElementById('current-image-preview').innerHTML = 
                        `<p>Gambar saat ini: ${data.skema.gambar}</p>`;
                }

                // Populate Unit Kompetensi
                const unitContainer = document.getElementById('unit-fields');
                unitContainer.innerHTML = '';
                if (data.unit_kompetensi && data.unit_kompetensi.length > 0) {
                    data.unit_kompetensi.forEach(unit => {
                        const div = document.createElement('div');
                        div.className = 'dynamic-field';
                        div.innerHTML = `
                            <input type="number" name="unit_no[]" value="${unit.no_urut}" placeholder="No" style="flex: 0 0 60px;">
                            <input type="text" name="kode_unit[]" value="${unit.kode_unit}" placeholder="Kode Unit" required>
                            <input type="text" name="unit_judul[]" value="${unit.judul_unit}" placeholder="Judul Unit" required>
                            <input type="text" name="unit_standar[]" value="${unit.standar_kompetensi || ''}" placeholder="Standar Kompetensi">
                            <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
                        `;
                        unitContainer.appendChild(div);
                    });
                } else {
                    addUnitField();
                }

                // Populate Persyaratan
                const persContainer = document.getElementById('persyaratan-fields');
                persContainer.innerHTML = '';
                if (data.persyaratan && data.persyaratan.length > 0) {
                    data.persyaratan.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'dynamic-field';
                        div.innerHTML = `
                            <textarea name="persyaratan[]" placeholder="Deskripsi persyaratan" required style="flex: 1; height: 60px;">${item.deskripsi}</textarea>
                            <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
                        `;
                        persContainer.appendChild(div);
                    });
                } else {
                    addPersyaratanField();
                }

                // Populate Dokumen
                const docContainer = document.getElementById('dokumen-fields');
                docContainer.innerHTML = '';
                if (data.dokumen && data.dokumen.length > 0) {
                    data.dokumen.forEach((item, index) => {
                        const div = document.createElement('div');
                        div.className = 'dynamic-field';
                        div.innerHTML = `
                            <input type="text" name="dokumen_nama[]" value="${item.nama_dokumen}" placeholder="Nama Dokumen" required>
                            <div class="checkbox-field">
                                <input type="checkbox" name="dokumen_wajib[${index}]" value="1" ${item.wajib == 1 ? 'checked' : ''}>
                                <label>Wajib</label>
                            </div>
                            <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
                        `;
                        docContainer.appendChild(div);
                    });
                } else {
                    addDokumenField();
                }

                // Populate Asesmen
                const asesmenContainer = document.getElementById('asesmen-fields');
                asesmenContainer.innerHTML = '';
                if (data.metode_asesmen && data.metode_asesmen.length > 0) {
                    data.metode_asesmen.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'dynamic-field';
                        div.innerHTML = `
                            <select name="asesmen_jenis[]" required>
                                <option value="">Pilih Jenis Peserta</option>
                                <option value="Berpengalaman" ${item.jenis_peserta === 'Berpengalaman' ? 'selected' : ''}>Berpengalaman</option>
                                <option value="Belum Berpengalaman" ${item.jenis_peserta === 'Belum Berpengalaman' ? 'selected' : ''}>Belum Berpengalaman</option>
                            </select>
                            <input type="text" name="asesmen_metode[]" value="${item.metode}" placeholder="Metode Asesmen" required>
                            <textarea name="asesmen_deskripsi[]" placeholder="Deskripsi" style="height: 60px;">${item.deskripsi || ''}</textarea>
                            <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
                        `;
                        asesmenContainer.appendChild(div);
                    });
                } else {
                    addAsesmenField();
                }

                // Populate Pemeliharaan
                if (data.pemeliharaan && data.pemeliharaan.length > 0) {
                    document.getElementById('pemeliharaan').value = data.pemeliharaan[0].deskripsi;
                } else {
                    document.getElementById('pemeliharaan').value = '';
                }

                // Populate Metode Pengujian
                const pengujianContainer = document.getElementById('add-metode-pengujian-fields');
                pengujianContainer.innerHTML = '';
                if (data.metode_pengujian_skema && data.metode_pengujian_skema.length > 0) {
                    data.metode_pengujian_skema.forEach(metode => {
                        const div = document.createElement('div');
                        div.className = 'dynamic-field';
                        div.innerHTML = `
                            <select name="metode_pengujian_skema[]" class="form-control">
                                <option value="">-- Pilih Metode --</option>
                                <option value="Sertifikasi Jarak Jauh (SJJ)" ${metode === 'Sertifikasi Jarak Jauh (SJJ)' ? 'selected' : ''}>Sertifikasi Jarak Jauh (SJJ)</option>
                                <option value="Metode Paperless (non-kertas)" ${metode === 'Metode Paperless (non-kertas)' ? 'selected' : ''}>Metode Paperless (non-kertas)</option>
                                <option value="Paper-based (berbasis kertas)" ${metode === 'Paper-based (berbasis kertas)' ? 'selected' : ''}>Paper-based (berbasis kertas)</option>
                            </select>
                            <button type="button" class="remove-btn" onclick="removeField(this)">×</button>
                        `;
                        pengujianContainer.appendChild(div);
                    });
                } else {
                    addMetodePengujianField();
                }

                openModal('addSkemaModal');
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal mengambil data skema');
            }
        }
    </script>
</body>
</html>