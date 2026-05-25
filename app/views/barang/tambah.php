<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Barang — Inventaris</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/form.css">
</head>
<body>
<div class="container">

  <a href="index.php" class="back-link">Kembali ke Inventaris</a>
  <div class="page-tag">Inventaris Barang</div>
  <h1>Tambah Barang</h1>
  <p class="subtitle">Isi form di bawah untuk menambahkan barang baru ke inventaris.</p>

  <div class="card">
    <div class="card-header">
      <span class="card-header-dot"></span>
      <span class="card-header-title">Form Input Barang</span>
    </div>
    <div class="card-body">

      <?php if (!empty($errors)): ?>
      <div class="alert-error">
        <strong>⚠ Periksa kembali form!</strong>
        <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
      </div>
      <?php endif; ?>

      <form method="POST" action="tambah.php" enctype="multipart/form-data">
        <div style="display:flex;flex-direction:column;gap:20px;">

          <div class="form-group">
            <label for="nama_barang">Nama Barang <span class="req">*</span></label>
            <input type="text" id="nama_barang" name="nama_barang"
              placeholder="Contoh: Laptop Asus VivoBook"
              class="<?= isset($errors['nama_barang']) ? 'input-error' : '' ?>"
              value="<?= htmlspecialchars($old['nama_barang']) ?>">
            <?php if (isset($errors['nama_barang'])): ?>
              <span class="field-error"><?= htmlspecialchars($errors['nama_barang']) ?></span>
            <?php endif; ?>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="jumlah">Jumlah <span class="req">*</span></label>
              <input type="number" id="jumlah" name="jumlah" placeholder="0" min="1"
                class="<?= isset($errors['jumlah']) ? 'input-error' : '' ?>"
                value="<?= htmlspecialchars($old['jumlah']) ?>">
              <?php if (isset($errors['jumlah'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['jumlah']) ?></span>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="harga">Harga Satuan (Rp) <span class="req">*</span></label>
              <input type="number" id="harga" name="harga" placeholder="0" min="1" step="1"
                class="<?= isset($errors['harga']) ? 'input-error' : '' ?>"
                value="<?= htmlspecialchars($old['harga']) ?>">
              <?php if (isset($errors['harga'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['harga']) ?></span>
              <?php endif; ?>
            </div>
          </div>

          <div class="form-group">
            <label for="tanggal_masuk">Tanggal Masuk <span class="req">*</span></label>
            <input type="date" id="tanggal_masuk" name="tanggal_masuk"
              class="<?= isset($errors['tanggal_masuk']) ? 'input-error' : '' ?>"
              value="<?= htmlspecialchars($old['tanggal_masuk']) ?>">
            <?php if (isset($errors['tanggal_masuk'])): ?>
              <span class="field-error"><?= htmlspecialchars($errors['tanggal_masuk']) ?></span>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label>Foto Barang <span class="opt">(Opsional — JPG/PNG, maks. 2MB)</span></label>
            <div class="upload-area <?= isset($errors['gambar']) ? 'error-border' : '' ?>" id="uploadArea" onclick="document.getElementById('gambar').click()">
              <div id="uploadPlaceholder">
                <div class="upload-icon">☁</div>
                <div class="upload-label-text"><strong>Klik untuk pilih gambar</strong></div>
                <div class="upload-hint">JPG, PNG • Maksimal 2MB</div>
              </div>
              <div id="previewContainer">
                <img id="previewImg" src="" alt="Preview">
                <span id="previewName"></span>
                <button type="button" id="btnGantiGambar">Ganti gambar</button>
              </div>
            </div>
            <input type="file" id="gambar" name="gambar" accept=".jpg,.jpeg,.png" style="display:none" onchange="handleFileChange(this)">
            <?php if (isset($errors['gambar'])): ?>
              <span class="field-error"><?= htmlspecialchars($errors['gambar']) ?></span>
            <?php endif; ?>
          </div>

          <hr class="divider">

          <div class="form-actions">
            <a href="index.php" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">+ Simpan Barang</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>
<script>
function handleFileChange(input) {
  const file = input.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function(e) {
    document.getElementById('uploadPlaceholder').style.display = 'none';
    document.getElementById('previewContainer').style.display  = 'flex';
    document.getElementById('previewImg').src = e.target.result;
    document.getElementById('previewName').textContent = file.name + ' (' + (file.size/1024).toFixed(1) + ' KB)';
    document.getElementById('uploadArea').classList.add('has-file');
  };
  reader.readAsDataURL(file);
}
document.getElementById('btnGantiGambar').addEventListener('click', function(e) {
  e.stopPropagation();
  document.getElementById('gambar').click();
});
</script>
</body>
</html>
