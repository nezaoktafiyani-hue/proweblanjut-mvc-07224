<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventaris Barang</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">

  <div class="topbar">
    <div class="brand">
      <div class="brand-icon">📦</div>
      <div class="brand-text">
        <h1>Inventaris Barang</h1>
        <p>Sistem Manajemen Stok & Gudang</p>
      </div>
    </div>
    <div class="topbar-right">
      <div class="welcome-text">Selamat datang, <span><?= htmlspecialchars($_SESSION['username']) ?></span></div>
      <a href="tambah.php" class="btn-add">+ Tambah Barang</a>
      <a href="logout.php" class="btn-logout">Logout</a>
    </div>
  </div>

  <div class="stats">
    <div class="stat">
      <div class="stat-label">Jenis Barang</div>
      <div class="stat-value"><?= $stats['total_barang'] ?></div>
      <div class="stat-sub">item terdaftar</div>
    </div>
    <div class="stat">
      <div class="stat-label">Total Stok</div>
      <div class="stat-value"><?= number_format($stats['total_stok'], 0, ',', '.') ?></div>
      <div class="stat-sub">unit tersedia</div>
    </div>
    <div class="stat">
      <div class="stat-label">Total Nilai</div>
      <div class="stat-value">Rp <?= number_format($stats['total_nilai'], 0, ',', '.') ?></div>
      <div class="stat-sub">nilai inventaris</div>
    </div>
  </div>

  <div class="card">
    <div class="card-head">
      <div class="card-title"><span class="dot"></span> Daftar Inventaris</div>
      <span class="badge"><?= $stats['total_barang'] ?> data</span>
    </div>

    <?php if (empty($data)): ?>
      <div class="empty">📭 Belum ada data barang</div>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID</th><th>Foto</th><th>Nama Barang</th>
            <th>Jumlah</th><th>Harga</th><th>Tanggal</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $row): ?>
          <tr>
            <td>#<?= $row['id'] ?></td>
            <td>
              <?php $foto = $row['thumb'] ?? $row['gambar'] ?? null; ?>
              <?php if (!empty($foto) && file_exists(__DIR__ . '/../../' . $foto)): ?>
                <img src="../<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($row['nama_barang']) ?>" class="foto-thumb">
              <?php else: ?>
                <div class="foto-placeholder">📦</div>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
            <td><?= number_format($row['jumlah']) ?></td>
            <td>Rp <?= number_format($row['harga']) ?></td>
            <td><?= date('d M Y', strtotime($row['tanggal_masuk'])) ?></td>
            <td>
              <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
              <a href="hapus.php?id=<?= $row['id'] ?>" class="btn-del"
                 onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <div class="footer"></div>
</div>
</body>
</html>
