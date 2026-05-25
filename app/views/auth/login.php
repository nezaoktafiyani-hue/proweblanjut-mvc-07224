<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Inventaris</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@300;400;500&display=swap');
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--bg:#eaeff1;--card:#1a1814;--accent:#8ce4c2;--accent-dim:#7a6230;--text:#f0ead8;--text-muted:#7a7060;--border:#2e2b24;--error:#e07070}
    body{background-color:var(--bg);background-image:radial-gradient(ellipse at 20% 50%,rgba(201,168,76,.06) 0%,transparent 60%),radial-gradient(ellipse at 80% 20%,rgba(201,168,76,.04) 0%,transparent 50%);min-height:100vh;display:flex;align-items:center;justify-content:center;font-family:'DM Sans',sans-serif;color:var(--text)}
    .card{background:var(--card);border:1px solid var(--border);border-radius:4px;padding:52px 48px;width:100%;max-width:420px;box-shadow:0 0 0 1px rgba(201,168,76,.05),0 32px 64px rgba(0,0,0,.5);animation:fadeUp .5s ease both}
    @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    .logo-line{display:flex;align-items:center;gap:12px;margin-bottom:36px}
    .logo-dot{width:28px;height:28px;background:var(--accent);border-radius:50%;flex-shrink:0}
    h1{font-family:'Playfair Display',serif;font-size:22px;font-weight:600;color:var(--text);letter-spacing:.01em}
    .divider{height:1px;background:var(--border);margin-bottom:32px}
    .field{margin-bottom:20px}
    label{display:block;font-size:11px;font-weight:500;letter-spacing:.12em;text-transform:uppercase;color:var(--text-muted);margin-bottom:8px}
    input[type="text"],input[type="password"]{width:100%;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:3px;padding:12px 16px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);outline:none;transition:border-color .2s,background .2s}
    input:focus{border-color:var(--accent-dim);background:rgba(201,168,76,.04)}
    input::placeholder{color:var(--text-muted)}
    .error-msg{background:rgba(224,112,112,.1);border:1px solid rgba(224,112,112,.3);border-radius:3px;color:var(--error);font-size:13px;padding:10px 14px;margin-bottom:20px}
    .remember-row{display:flex;align-items:center;gap:10px;margin-bottom:8px;margin-top:-4px}
    .remember-row input[type="checkbox"]{appearance:none;-webkit-appearance:none;width:16px;height:16px;border:1px solid var(--border);border-radius:2px;background:rgba(255,255,255,.03);cursor:pointer;flex-shrink:0;position:relative;transition:border-color .2s,background .2s}
    .remember-row input[type="checkbox"]:checked{background:var(--accent);border-color:var(--accent)}
    .remember-row input[type="checkbox"]:checked::after{content:'';position:absolute;left:4px;top:1px;width:5px;height:9px;border:2px solid #0f0e0c;border-top:none;border-left:none;transform:rotate(45deg)}
    .remember-row label{font-size:12px;letter-spacing:.04em;text-transform:none;color:var(--text-muted);cursor:pointer;margin-bottom:0;user-select:none}
    .btn{width:100%;background:var(--accent);color:#0f0e0c;border:none;border-radius:3px;padding:13px;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;letter-spacing:.08em;text-transform:uppercase;cursor:pointer;margin-top:8px;transition:background .2s,transform .1s}
    .btn:hover{background:#a0edd0}
    .btn:active{transform:scale(.98)}
    .register-link{text-align:center;margin-top:20px;font-size:13px;color:var(--text-muted)}
    .register-link a{color:var(--accent);text-decoration:none}
    .register-link a:hover{text-decoration:underline}
</style>
</head>
<body>
<div class="card">
  <div class="logo-line">
    <div class="logo-dot"></div>
    <h1>Login</h1>
  </div>
  <div class="divider"></div>

  <?php if (!empty($error)): ?>
    <div class="error-msg"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="field">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Masukkan username" required autocomplete="username"
        value="<?= htmlspecialchars(isset($_POST['username']) ? $_POST['username'] : $remembered_username) ?>">
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
    </div>
    <div class="remember-row">
      <input type="checkbox" id="remember" name="remember" <?= !empty($remembered_username) ? 'checked' : '' ?>>
      <label for="remember">Ingat saya selama 30 hari</label>
    </div>
    <button type="submit" class="btn">Masuk</button>
  </form>

  <div class="register-link">
    Belum punya akun? <a href="register.php">Daftar di sini</a>
  </div>
</div>
</body>
</html>
