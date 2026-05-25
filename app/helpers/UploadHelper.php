<?php
// =============================================================
// app/helpers/UploadHelper.php
// Helper: menangani upload dan thumbnail gambar
// =============================================================
class UploadHelper
{
    private $uploadDir;
    private $thumbDir;
    private $allowedMime = ['image/jpeg', 'image/jpg', 'image/png'];
    private $allowedExt  = ['jpg', 'jpeg', 'png'];
    private $maxSize     = 2097152; // 2MB

    public function __construct($baseDir)
    {
        $this->uploadDir = $baseDir . '/uploads/original/';
        $this->thumbDir  = $baseDir . '/uploads/thumbs/';
        if (!is_dir($this->uploadDir)) mkdir($this->uploadDir, 0755, true);
        if (!is_dir($this->thumbDir))  mkdir($this->thumbDir,  0755, true);
    }

    // Proses upload file, return array ['gambar'=>path, 'thumb'=>path] atau ['error'=>pesan]
    public function upload($file)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'Terjadi kesalahan saat upload file.'];
        }
        if ($file['size'] > $this->maxSize) {
            return ['error' => 'Ukuran file maksimal 2MB.'];
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($mime, $this->allowedMime) || !in_array($ext, $this->allowedExt)) {
            return ['error' => 'Hanya file JPG dan PNG yang diperbolehkan.'];
        }

        $namaAsli   = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file['name']);
        $namaUnik   = uniqid('img_', true) . '_' . $namaAsli;
        $namaThumb  = 'thumb_' . $namaUnik;
        $targetPath = $this->uploadDir . $namaUnik;
        $thumbPath  = $this->thumbDir  . $namaThumb;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['error' => 'Gagal menyimpan file ke server.'];
        }

        $this->buatThumbnail($targetPath, $thumbPath, $mime);

        return [
            'gambar' => 'uploads/original/' . $namaUnik,
            'thumb'  => 'uploads/thumbs/'   . $namaThumb,
        ];
    }

    // Hapus file gambar lama dari server
    public function hapusGambar($gambar, $thumb, $baseDir)
    {
        if ($gambar && file_exists($baseDir . '/' . $gambar)) unlink($baseDir . '/' . $gambar);
        if ($thumb  && file_exists($baseDir . '/' . $thumb))  unlink($baseDir . '/' . $thumb);
    }

    // Buat thumbnail dengan GD Library
    private function buatThumbnail($source, $destination, $mime, $maxW = 200, $maxH = 200)
    {
        if (!extension_loaded('gd')) {
            copy($source, $destination);
            return;
        }

        list($w, $h) = getimagesize($source);
        $scale = min($maxW / $w, $maxH / $h);
        $newW  = (int)($w * $scale);
        $newH  = (int)($h * $scale);

        $srcImg = ($mime === 'image/png')
            ? imagecreatefrompng($source)
            : imagecreatefromjpeg($source);
        $thumb = imagecreatetruecolor($newW, $newH);

        if ($mime === 'image/png') {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            $transparent = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
            imagefilledrectangle($thumb, 0, 0, $newW, $newH, $transparent);
        }

        imagecopyresampled($thumb, $srcImg, 0, 0, 0, 0, $newW, $newH, $w, $h);

        ($mime === 'image/png')
            ? imagepng($thumb, $destination, 8)
            : imagejpeg($thumb, $destination, 85);

        imagedestroy($srcImg);
        imagedestroy($thumb);
    }
}
