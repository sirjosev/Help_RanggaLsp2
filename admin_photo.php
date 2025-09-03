<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Foto Halaman Depan</title>
  <link rel="stylesheet" href="css/admin.css" />
  <style>
  :root {
    --card-width: 250px;
    --card-height: 150px;
  }

  .upload-page {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .upload-page header {
    background: #ffffffff;
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
  }

  .upload-page header h1 {
    margin: 0;
    font-size: 1.5rem;
  }

  .upload-page .upload-section {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    max-width: 500px;
  }

  .upload-page .upload-section label {
    font-weight: bold;
    font-size: 1rem;
    color: #444;
  }

  .upload-page .upload-section input[type="file"] {
    display: block;
    margin-top: 10px;
    padding: 10px;
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    width: 100%;
    background: #f9fafb;
    cursor: pointer;
    transition: 0.3s ease;
  }

  .upload-page .upload-section input[type="file"]:hover {
    border-color: #4f46e5;
    background: #eef2ff;
  }

  .button-group {
    display: flex;
    gap: 10px;
    margin-top: 20px;
  }

  .btn-upload {
    background: #5185ff;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: bold;
    transition: background 0.3s ease;
  }

  .btn-upload:hover {
    background: #3730a3;
  }

  .btn-draft {
    background: #c40707ff;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: bold;
    transition: background 0.3s ease;
  }

  .btn-draft:hover {
    background: #4b5563;
  }

  .upload-page .preview {
    margin-top: 20px;
    text-align: center;
  }

  .upload-page .preview img {
    max-width: 100%;
    border-radius: 10px;
    margin-top: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }

  .uploaded-section {
    margin-top: 40px;
  }

  .uploaded-section h2 {
    font-size: 1.3rem;
    margin-bottom: 20px;
    color: #333;
  }

  .uploaded-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(var(--card-width), 1fr));
    gap: 25px;
  }

  .uploaded-gallery .card {
    position: relative;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.12);
    overflow: hidden;
    text-align: center;
    padding: 15px;
    transition: transform 0.2s ease;

    /* tambahan biar semua card seragam */
    min-height: 280px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .uploaded-gallery .card:hover {
    transform: translateY(-5px);
  }

  .uploaded-gallery .card img {
    width: 100%;
    height: var(--card-height);
    object-fit: cover;
    border-radius: 10px;
    display: block;
  }

  .preview-link {
    margin-top: 10px;
    font-size: 1rem;
    font-weight: 600;
    color: #4f46e5;
    cursor: pointer;
    transition: color 0.3s ease;
  }

  .preview-link:hover {
    color: #3730a3;
    text-decoration: underline;
  }

  .btn-upload-small {
    background: #4f46e5;
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9rem;
    margin-top: 8px;
    transition: background 0.3s ease;
  }

  .btn-upload-small:hover {
    background: #3730a3;
  }

  .btn-delete {
    position: absolute;
    top: 8px;
    right: 8px;
    background: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background: rgba(0,0,0,0.8);
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    max-width: 90%;
    max-height: 90%;
    border-radius: 12px;
    object-fit: contain;
  }

  .close {
    position: absolute;
    top: 20px;
    right: 30px;
    color: white;
    font-size: 2rem;
    cursor: pointer;
  }

  /* Confirm Modal */
  .confirm-modal {
    display: none;
    position: fixed;
    z-index: 2000;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
  }

  .confirm-box {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 300px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
  }

  .confirm-box p {
    font-size: 1rem;
    margin-bottom: 20px;
  }

  .confirm-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
  }

  .confirm-btn {
    padding: 8px 15px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
  }

  .confirm-yes {
    background: #e11d48;
    color: white;
  }

  .confirm-no {
    background: #4b5563;
    color: white;
  }
</style>

</head>
<body>
  <?php require_once 'includes/sidebar.php'; ?>

  <div class="main-content upload-page">
    <header>
      <h1>Upload Foto Halaman Depan</h1>
    </header>

    <section class="upload-section">
      <form action="proses_upload.php" method="post" enctype="multipart/form-data">
        <label for="foto">Pilih Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/*" required>

        <div class="button-group">
          <button type="submit" class="btn-upload">Upload</button>
          <button type="button" class="btn-draft">Draft</button>
        </div>

        <div class="preview" id="preview"></div>
      </form>
    </section>

    <!-- Draft Section -->
    <section class="uploaded-section">
      <h2>Foto Draft</h2>
      <div class="uploaded-gallery">
        <div class="card">
          <button class="btn-delete" onclick="deleteCard(this)">×</button>
          <img src="https://via.placeholder.com/400x250.png?text=Draft+1" alt="Draft 1">
          <p class="preview-link" onclick="openPreview('https://via.placeholder.com/400x250.png?text=Draft+1')">Preview</p>
          <button class="btn-upload-small" onclick="uploadDraft(this)">Upload</button>
        </div>
        <div class="card">
          <button class="btn-delete" onclick="deleteCard(this)">×</button>
          <img src="https://via.placeholder.com/400x250.png?text=Draft+2" alt="Draft 2">
          <p class="preview-link" onclick="openPreview('https://via.placeholder.com/400x250.png?text=Draft+2')">Preview</p>
          <button class="btn-upload-small" onclick="uploadDraft(this)">Upload</button>
        </div>
      </div>
    </section>

    <!-- Upload Section -->
    <section class="uploaded-section">
      <h2>Foto yang Sudah Diupload</h2>
      <div class="uploaded-gallery">
        <div class="card">
          <button class="btn-delete" onclick="deleteCard(this)">×</button>
          <img src="https://via.placeholder.com/400x250.png?text=Foto+1" alt="Foto 1">
          <p class="preview-link" onclick="openPreview('https://via.placeholder.com/400x250.png?text=Foto+1')">Preview</p>
        </div>
        <div class="card">
          <button class="btn-delete" onclick="deleteCard(this)">×</button>
          <img src="https://via.placeholder.com/400x250.png?text=Foto+2" alt="Foto 2">
          <p class="preview-link" onclick="openPreview('https://via.placeholder.com/400x250.png?text=Foto+2')">Preview</p>
        </div>
        <div class="card">
          <button class="btn-delete" onclick="deleteCard(this)">×</button>
          <img src="https://via.placeholder.com/400x250.png?text=Foto+3" alt="Foto 3">
          <p class="preview-link" onclick="openPreview('https://via.placeholder.com/400x250.png?text=Foto+3')">Preview</p>
        </div>
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
    const input = document.getElementById('foto');
    const preview = document.getElementById('preview');

    input.addEventListener('change', function() {
      preview.innerHTML = '';
      const file = this.files[0];
      if (file) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        preview.appendChild(img);
      }
    });

    const modal = document.getElementById('previewModal');
    const modalImg = document.getElementById('modalImage');

    function openPreview(src) {
      modal.style.display = "flex";
      modalImg.src = src;
    }

    function closePreview() {
      modal.style.display = "none";
    }

    // ===== KONFIRMASI MODAL =====
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

    // ===== ACTION =====
    function deleteCard(btn) {
      askConfirm("Yakin mau hapus foto ini?", function() {
        btn.parentElement.remove();
      });
    }

    function uploadDraft(btn) {
      askConfirm("Yakin mau upload foto ini?", function() {
        alert("Foto berhasil diupload (contoh, nanti sambung ke backend)");
      });
    }
  </script>
</body>
</html>
