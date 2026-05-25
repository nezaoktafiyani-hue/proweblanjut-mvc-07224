<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Barang — Inventaris</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/form.css">
<style>
  .card-header { justify-content:space-between; }
  .card-header-left { display:flex; align-items:center; gap:10px; }
  .edit-badge { font-size:11px; font-weight:500; letter-spacing:0.1em; text-transform:uppercase; color:var(--accent); background:rgba(88,166,255,0.1); border:1px solid rgba(88,166,255,0.25); padding:3px 10px; border-radius:999px; }
  .id-badge { display:inline-flex; align-items:center; gap:6px; background:var(--surface2); border:1px solid var(--border); border-radius:6px; padding:4px 12px; font-size:12px; color:var(--muted); margin-bottom:32px; }
  .id-badge span { color:var(--accent); }
  .gambar-lama-wrap { display:flex; align-items:center; gap:14px; background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:12px 16px; }
  .gambar-lama-wrap img { width:64px; height:64px; object-fit:cover; border-radius:7px; border:1px solid var(--border); flex-shrink:0; }
  .gambar-lama-wrap .gl-info { font-size:12px; color:var(--muted); }
  .gambar-lama-wrap .gl-info span { color:var(--text); font-weight:500; font-size:13px; display:block; margin-bottom:2px; }
  .danger-zone { margin-top:24px; border:1px solid rgba(248,81,73,0.2); border-radius:10px; overflow:hidden; }
  .danger-header { background:rgba(248,81,73,0.07); padding:12px 20px; font-size:11px; font-weight:600; letter-spacing:0.15em; text-transform:uppercase; color:var(--red); border-bottom:1px solid rgba(248,81,73,0.2); }
  .danger-body { padding:16px 20px; display:flex; align-items:center; justify-content:space-between; gap:16px; }
  .danger-body p { font-size:13px; color:var(--muted); }
  .btn-danger { display:inline-flex; align-items:center; gap:6px; padding:9px 16px; border-radius:7px; border:1px solid rgba(248,81,73,0.35); background:rgba(248,81,73,0.08); color:var(--red); font-size:12px; font-weight:500; text-decoration:none; white-space:nowrap; transition:all 0.2s; }
  .btn-danger:hover { background:rgba(248,81,73,0.18); border-color:var(--red); }
  :root { --accent:#58a6ff; --accent-hover:#79b8ff; }
</style>
</head>
<body>
<div class="container">

  <a href="index.php" class="back-link">Kembali ke Inventaris</a>
  <div class="page-tag">Inventaris Barang</div>
  <h1>Edit Barang</h1>
  <p class="subtitle">Perbarui informasi barang yang sudah tersimpan.</p>
  <div class="id-badge">ID Barang: <span>#<?= str_pad($barang['id'], 3, '0', STR_PAD_LEFT) ?></span></div>

  <div class="card">
    <div class="card-header">
      <div class="card-header-left">
        <span class="card-header-dot"></span>
        <span class="card-header-title"><?= htmlspecialchars($barang['nama_barang']) ?></span>
      </div>
      <span class="edit-badge">Mode Edit</span>
    </div>
    <div class="card-body">

      <?php if (!empty($errors)): ?>
      <div class="alert-error">
        <strong>⚠ Periksa kembali form!</strong>
        <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
      </div>
      <?php endif; ?>

      <form method="POST" action="edit.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $barang['id'] ?>">
        <div style="display:flex;flex-direction:column;gap:20px;">

          <div class="form-group">
            <label for="nama_barang">Nama Barang <span class="req">*</span></label>
            <input type="text" id="nama_barang" name="nama_barang" placeholder="Nama barang"
              class="<?= isset($errors['nama_barang']) ? 'input-error' : '' ?>"
              value="<?= htmlspecialchars($val['nama_barang']) ?>">
            <?php if (isset($errors['nama_barang'])): ?>
              <span class="field-error"><?= htmlspecialchars($errors['nama_barang']) ?></span>
            <?php endif; ?>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="jumlah">Jumlah <span class="req">*</span></label>
              <input type="number" id="jumlah" name="jumlah" placeholder="0" min="1"
                class="<?= isset($errors['jumlah']) ? 'input-error' : '' ?>"
                value="<?= htmlspecialchars($val['jumlah']) ?>">
              <?php if (isset($errors['jumlah'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['jumlah']) ?></span>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="harga">Harga Satuan (Rp) <span class="req">*</span></label>
              <input type="number" id="harga" name="harga" placeholder="0" min="1" step="1"
                class="<?= isset($errors['harga']) ? 'input-error' : '' ?>"
                value="<?= htmlspecialchars($val['harga']) ?>">
              <?php if (isset($errors['harga'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['harga']) ?></span>
              <?php endif; ?>
            </div>
          </div>

          <div class="form-group">
            <label for="tanggal_masuk">Tanggal Masuk <span class="req">*</span></label>
            <input type="date" id="tanggal_masuk" name="tanggal_masuk"
              class="<?= isset($errors['tanggal_masuk']) ? 'input-error' : '' ?>"
              value="<?= htmlspecialchars($val['tanggal_masuk']) ?>">
            <?php if (isset($errors['tanggal_masuk'])): ?>
              <span class="field-error"><?= htmlspecialchars($errors['tanggal_masuk']) ?></span>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label>Foto Barang <span class="opt">(Kosongkan untuk tidak mengubah foto)</span></label>
            <?php $gambarLama = $barang['thumb'] ?? $barang['gambar'] ?? null; ?>
            <?php if ($gambarLama && file_exists(__DIR__ . '/../../' . $gambarLama)): ?>
            <div class="gambar-lama-wrap">
              <img src="../<?= htmlspecialchars($gambarLama) ?>" alt="Foto saat ini">
              <div class="gl-info"><span>Foto saat ini</span>Upload gambar baru di bawah untuk mengganti foto ini.</div>
            </div>
            <?php endif; ?>
            <div class="upload-area <?= isset($errors['gambar']) ? 'error-border' : '' ?>" id="uploadArea" onclick="document.getElementById('gambar').click()">
              <div id="uploadPlaceholder">
                <div class="upload-icon">↑</div>
                <div class="upload-label-text"><strong>Klik untuk ganti gambar</strong></div>
                <div class="upload-hint">JPG, PNG • Maksimal 2MB</div>
              </div>
              <div id="previewContainer">
                <img id="previewImg" src="" alt="Preview baru">
                <span id="previewName"></span>
                <button type="button" id="btnGantiGambar">Pilih gambar lain</button>
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
            <button type="submit" class="btn-submit">✓ Simpan Perubahan</button>
          </div>

        </div>
      </form>
    </div>
  </div>

  <div class="danger-zone">
    <div class="danger-header">⚠ Zona Berbahaya</div>
    <div class="danger-body">
      <p>Hapus barang ini secara permanen dari inventaris. Tindakan ini tidak dapat dibatalkan.</p>
      <a href="hapus.php?id=<?= $barang['id'] ?>" class="btn-danger"
         onclick="return confirm('Yakin ingin menghapus barang ini secara permanen?')">✕ Hapus Barang</a>
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
