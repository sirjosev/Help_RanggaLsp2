<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_super_admin']) || !$_SESSION['is_super_admin']) {
    header("Location: login");
    exit();
}
require_once '../config/config.php';

try {
    // Check if the 'photos' table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'photos'");
    if ($stmt->rowCount() == 0) {
        // If not, create it with the user's schema + status column
        $conn->exec("CREATE TABLE `photos` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) DEFAULT NULL,
            `file_path` VARCHAR(255) NOT NULL,
            `alt_text` VARCHAR(255) DEFAULT NULL,
            `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
            `uploaded_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    } else {
        // If the table exists, check for the 'status' column
        $stmt = $conn->query("SHOW COLUMNS FROM `photos` LIKE 'status'");
        if ($stmt->rowCount() == 0) {
            // If the 'status' column doesn't exist, add it
            $conn->exec("ALTER TABLE `photos` ADD COLUMN `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft';");
        }
    }

    // Ambil semua foto dari database
    $stmt = $conn->query("SELECT * FROM photos ORDER BY uploaded_at DESC");
    $photos = $stmt->fetchAll();

    // Pisahkan foto berdasarkan status
    $draft_photos = array_filter($photos, fn($p) => $p['status'] === 'draft');
    $published_photos = array_filter($photos, fn($p) => $p['status'] === 'published');

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Foto Halaman Depan</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin.css" />
  <style>
  :root {
    --card-width: 250px;
    --card-height: 150px;
  }
  .upload-page { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
  .upload-page .upload-section input[type="file"] { display: block; margin-top: 10px; padding: 10px; border: 2px dashed #cbd5e1; border-radius: 10px; width: 100%; background: #f9fafb; cursor: pointer; transition: 0.3s ease; }
  .upload-page .upload-section input[type="file"]:hover { border-color: #4f46e5; background: #eef2ff; }
  .button-group { display: flex; gap: 10px; margin-top: 20px; }
  .btn-upload { background: #5185ff; color: white; padding: 12px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; font-weight: bold; transition: background 0.3s ease; }
  .btn-upload:hover { background: #3730a3; }
  .btn-draft { background: #c40707ff; color: white; padding: 12px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; font-weight: bold; transition: background 0.3s ease; }
  .btn-draft:hover { background: #4b5563; }
  .upload-page .preview { margin-top: 20px; text-align: center; }
  .upload-page .preview img { max-width: 100%; border-radius: 10px; margin-top: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
  .uploaded-section { margin-top: 40px; }
  .uploaded-section h2 { font-size: 1.3rem; margin-bottom: 20px; color: #333; }
  .uploaded-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(var(--card-width), 1fr)); gap: 25px; }
  .uploaded-gallery .card { position: relative; background: #fff; border-radius: 14px; box-shadow: 0 6px 15px rgba(0,0,0,0.12); overflow: hidden; text-align: center; padding: 15px; transition: transform 0.2s ease; min-height: 280px; display: flex; flex-direction: column; justify-content: space-between; }
  .uploaded-gallery .card:hover { transform: translateY(-5px); }
  .uploaded-gallery .card img { width: 100%; height: var(--card-height); object-fit: cover; border-radius: 10px; display: block; }
  .preview-link { margin-top: 10px; font-size: 1rem; font-weight: 600; color: #4f46e5; cursor: pointer; transition: color 0.3s ease; }
  .preview-link:hover { color: #3730a3; text-decoration: underline; }
  .btn-upload-small { background: #4f46e5; color: #fff; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; margin-top: 8px; transition: background 0.3s ease; }
  .btn-upload-small:hover { background: #3730a3; }
  .btn-delete { position: absolute; top: 8px; right: 8px; background: red; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
  .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background: rgba(0,0,0,0.8); justify-content: center; align-items: center; }
  .modal-content { max-width: 90%; max-height: 90%; border-radius: 12px; object-fit: contain; }
  .close { position: absolute; top: 20px; right: 30px; color: white; font-size: 2rem; cursor: pointer; }
  .confirm-modal { display: none; position: fixed; z-index: 2000; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); justify-content: center; align-items: center; }
  .confirm-box { background: #fff; padding: 20px; border-radius: 10px; text-align: center; width: 300px; box-shadow: 0 6px 15px rgba(0,0,0,0.2); }
  .confirm-box p { font-size: 1rem; margin-bottom: 20px; }
  .confirm-actions { display: flex; justify-content: center; gap: 10px; }
  .confirm-btn { padding: 8px 15px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
  .confirm-yes { background: #e11d48; color: white; }
  .confirm-no { background: #4b5563; color: white; }
  </style>
</head>
<body>
  <?php require_once __DIR__ . '/../src/View/partials/sidebar.php'; ?>

  <div class="main-content upload-page">
    <header>
      <h1>Upload Foto Halaman Depan</h1>
    </header>

    <section class="upload-section">
      <form id="upload-form" action="proses_upload.php" method="post" enctype="multipart/form-data">
        <label for="foto">Pilih Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/*" required>
        <div class="button-group">
          <button type="submit" class="btn-upload">Upload</button>
          <button type="button" class="btn-draft" id="draft-btn">Draft</button>
        </div>
        <div class="preview" id="preview"></div>
      </form>
    </section>

    <!-- Draft Section -->
    <section class="uploaded-section">
      <h2>Foto Draft</h2>
      <div class="uploaded-gallery" id="draft-gallery">
        <?php foreach ($draft_photos as $photo): ?>
          <div class="card" data-id="<?= $photo['id'] ?>">
            <button class="btn-delete" onclick="deletePhoto(this)">×</button>
            <img src="<?= htmlspecialchars($photo['file_path']) ?>" alt="<?= htmlspecialchars($photo['alt_text']) ?>">
            <p class="preview-link" onclick="openPreview('<?= htmlspecialchars($photo['file_path']) ?>')">Preview</p>
            <button class="btn-upload-small" onclick="publishDraft(this)">Upload</button>
          </div>
        <?php endforeach; ?>
        <?php if (empty($draft_photos)): ?>
          <p>Tidak ada foto draft.</p>
        <?php endif; ?>
      </div>
    </section>

    <!-- Upload Section -->
    <section class="uploaded-section">
      <h2>Foto yang Sudah Diupload</h2>
      <div class="uploaded-gallery" id="published-gallery">
        <?php foreach ($published_photos as $photo): ?>
          <div class="card" data-id="<?= $photo['id'] ?>">
            <button class="btn-delete" onclick="deletePhoto(this)">×</button>
            <img src="<?= htmlspecialchars($photo['file_path']) ?>" alt="<?= htmlspecialchars($photo['alt_text']) ?>">
            <p class="preview-link" onclick="openPreview('<?= htmlspecialchars($photo['file_path']) ?>')">Preview</p>
          </div>
        <?php endforeach; ?>
         <?php if (empty($published_photos)): ?>
          <p>Tidak ada foto yang diupload.</p>
        <?php endif; ?>
      </div>
    </section>
  </div>

  <!-- Modal Preview -->
  <div id="previewModal" class="modal">
    <span class="close" onclick="closePreview()">&times;</span>
    <img class="modal-content" id="modalImage">
  </div>

  <!-- Modal Konfirmasi -->
  <div id="confirmModal" class="confirm-modal">
    <div class="confirm-box">
      <p id="confirmMessage">Yakin?</p>
      <div class="confirm-actions">
        <button class="confirm-btn confirm-yes" onclick="confirmAction()">Ya</button>
        <button class="confirm-btn confirm-no" onclick="closeConfirm()">Batal</button>
      </div>
    </div>
  </div>

  <script>
    const fileInput = document.getElementById('foto');
    const preview = document.getElementById('preview');
    const draftBtn = document.getElementById('draft-btn');

    fileInput.addEventListener('change', function() {
      preview.innerHTML = '';
      const file = this.files[0];
      if (file) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        preview.appendChild(img);
      }
    });

    // Modal Preview
    const modal = document.getElementById('previewModal');
    const modalImg = document.getElementById('modalImage');
    function openPreview(src) {
      modal.style.display = "flex";
      modalImg.src = src;
    }
    function closePreview() {
      modal.style.display = "none";
    }

    // Modal Konfirmasi
    let pendingAction = null;
    function askConfirm(message, action) {
      document.getElementById("confirmMessage").innerText = message;
      document.getElementById("confirmModal").style.display = "flex";
      pendingAction = action;
    }
    function confirmAction() {
      if (pendingAction) pendingAction();
      closeConfirm();
    }
    function closeConfirm() {
      document.getElementById("confirmModal").style.display = "none";
      pendingAction = null;
    }

    // --- AJAX Functions ---

    // 1. Save as Draft
    draftBtn.addEventListener('click', function() {
      const file = fileInput.files[0];
      if (!file) {
        alert("Pilih file terlebih dahulu!");
        return;
      }

      const formData = new FormData();
      formData.append('foto', file);

      fetch('proses_draft.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          addCardToGallery(data.photo, 'draft');
          fileInput.value = ''; // Reset input file
          preview.innerHTML = ''; // Clear preview
        } else {
          alert('Gagal menyimpan draft: ' + data.message);
        }
      })
      .catch(error => console.error('Error:', error));
    });

    // 2. Delete Photo
    function deletePhoto(btn) {
      const card = btn.closest('.card');
      const photoId = card.dataset.id;

      askConfirm("Yakin mau hapus foto ini?", function() {
        const formData = new FormData();
        formData.append('id', photoId);

        fetch('proses_delete_photo.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            card.remove();
          } else {
            alert('Gagal menghapus foto: ' + data.message);
          }
        })
        .catch(error => console.error('Error:', error));
      });
    }

    // 3. Publish a Draft
    function publishDraft(btn) {
      const card = btn.closest('.card');
      const photoId = card.dataset.id;

      askConfirm("Yakin mau upload foto ini?", function() {
        const formData = new FormData();
        formData.append('id', photoId);

        fetch('proses_publish_draft.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Pindahkan card ke galeri published
            const publishedGallery = document.getElementById('published-gallery');
            btn.remove(); // Hapus tombol upload dari card
            publishedGallery.prepend(card);
          } else {
            alert('Gagal mempublish foto: ' + data.message);
          }
        })
        .catch(error => console.error('Error:', error));
      });
    }

    // Helper untuk menambah card baru ke galeri
    function addCardToGallery(photo, type) {
        const galleryId = type === 'draft' ? 'draft-gallery' : 'published-gallery';
        const gallery = document.getElementById(galleryId);

        const card = document.createElement('div');
        card.className = 'card';
        card.dataset.id = photo.id;

        let buttons = `<button class="btn-upload-small" onclick="publishDraft(this)">Upload</button>`;
        if (type === 'published') {
            buttons = '';
        }

        card.innerHTML = `
            <button class="btn-delete" onclick="deletePhoto(this)">×</button>
            <img src="${photo.file_path}" alt="${photo.title}">
            <p class="preview-link" onclick="openPreview('${photo.file_path}')">Preview</p>
            ${buttons}
        `;

        // Remove placeholder if it exists
        const placeholder = gallery.querySelector('p');
        if (placeholder && placeholder.innerText.startsWith('Tidak ada foto')) {
            placeholder.remove();
        }

        gallery.prepend(card);
    }
  </script>
</body>
</html>
