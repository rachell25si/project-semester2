<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Studio MUA ULVA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,400&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
:root {
    --clr-cream: #FDF8F5; --clr-cream-2: #F9F1EC;
    --clr-gold: #C9A87C; --clr-gold-light: #E8D5B5;
    --clr-brown: #6B4C3B; --clr-brown-deep: #3D2B1F;
    --clr-muted: #9C7E70; --clr-white: #fff;
    --font-display: 'Cormorant Garamond', Georgia, serif;
    --font-body: 'Jost', system-ui, sans-serif;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--font-body); background: var(--clr-cream); min-height: 100vh; display: flex; overflow-x: hidden; }

.auth-left {
    width: 45%;
    background: linear-gradient(160deg, #3D2B1F 0%, #6B4C3B 100%);
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 3rem;
    overflow: hidden;
}
.auth-left::before {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,124,0.18) 0%, transparent 70%);
}
.auth-left::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -80px;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(232,196,196,0.1) 0%, transparent 70%);
}
.auth-left-content { position: relative; z-index: 1; text-align: center; }
.auth-brand { font-family: var(--font-display); font-size: 2.5rem; color: var(--clr-gold-light); font-weight: 300; margin-bottom: 0.5rem; }
.auth-brand i { color: var(--clr-gold); margin-right: 0.5rem; }
.auth-tagline { color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-bottom: 2.5rem; }
.auth-left-img {
    width: 320px; height: 380px;
    object-fit: cover;
    border-radius: 60% 40% 60% 40% / 50% 60% 40% 50%;
    box-shadow: 0 30px 60px rgba(0,0,0,0.3);
    margin-bottom: 2rem;
}
.auth-quote { color: rgba(255,255,255,0.6); font-family: var(--font-display); font-size: 1.2rem; font-style: italic; line-height: 1.6; max-width: 320px; }
.auth-quote span { color: var(--clr-gold); }

.auth-right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 2rem;
}
.auth-box {
    width: 100%;
    max-width: 420px;
}
.auth-back { display: inline-flex; align-items: center; gap: 0.5rem; color: var(--clr-muted); font-size: 0.85rem; margin-bottom: 2rem; text-decoration: none; transition: color 0.2s; }
.auth-back:hover { color: var(--clr-gold); }
.auth-title { font-family: var(--font-display); font-size: 2.2rem; font-weight: 600; color: var(--clr-brown-deep); margin-bottom: 0.4rem; }
.auth-sub { color: var(--clr-muted); font-size: 0.88rem; margin-bottom: 2rem; }
.form-group { margin-bottom: 1.25rem; }
.form-label { display: block; font-size: 0.82rem; font-weight: 600; color: var(--clr-brown); margin-bottom: 0.4rem; }
.input-wrap { position: relative; }
.input-icon { position: absolute; left: 1.1rem; top: 50%; transform: translateY(-50%); color: var(--clr-muted); font-size: 0.9rem; }
.form-input {
    width: 100%; padding: 0.85rem 1rem 0.85rem 2.8rem;
    border-radius: 50px;
    border: 1.5px solid rgba(232,196,196,0.5);
    background: #fff;
    font-family: var(--font-body);
    font-size: 0.92rem;
    color: var(--clr-brown-deep);
    outline: none;
    transition: all 0.3s;
}
.form-input:focus { border-color: var(--clr-gold); box-shadow: 0 0 0 4px rgba(201,168,124,0.1); }
.btn-auth {
    width: 100%; padding: 0.95rem;
    border-radius: 50px;
    background: var(--clr-brown-deep);
    color: #fff;
    font-family: var(--font-body);
    font-size: 0.95rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
}
.btn-auth:hover { background: var(--clr-gold); color: var(--clr-brown-deep); transform: translateY(-2px); box-shadow: 0 10px 25px rgba(201,168,124,0.35); }
.auth-switch { text-align: center; margin-top: 1.5rem; font-size: 0.88rem; color: var(--clr-muted); }
.auth-switch a { color: var(--clr-gold); font-weight: 600; text-decoration: none; }
.auth-switch a:hover { text-decoration: underline; }
.alert-error { background: rgba(232,112,112,0.08); border: 1px solid rgba(232,112,112,0.25); color: #7A2020; padding: 0.85rem 1.25rem; border-radius: 16px; font-size: 0.88rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.6rem; }
.divider { display: flex; align-items: center; gap: 1rem; color: var(--clr-muted); font-size: 0.8rem; margin: 1.25rem 0; }
.divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: rgba(232,196,196,0.4); }

@media (max-width: 768px) {
    .auth-left { display: none; }
    .auth-right { padding: 2rem 1.5rem; }
}
    </style>
</head>
<body>

<div class="auth-right">
    <div class="auth-box">
        <a href="index.php" class="auth-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
        <h1 class="auth-title">Selamat Datang</h1>
        <p class="auth-sub">Masuk ke akun Anda untuk melanjutkan booking</p>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['booking_error'])): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($_SESSION['booking_error']) ?>
            </div>
            <?php unset($_SESSION['booking_error']); ?>
        <?php endif; ?>

        <form method="POST" action="index.php?page=login<?= !empty($paket_id) ? '&paket_id=' . urlencode($paket_id) : '' ?>">
            <input type="hidden" name="redirect"  value="<?= htmlspecialchars($redirect ?? '') ?>">
            <input type="hidden" name="paket_id" value="<?= htmlspecialchars($paket_id ?? '') ?>">

            <div class="form-group">
                <label class="form-label">Username</label>
                <div class="input-wrap">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="username" class="form-input" placeholder="Masukkan username" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="passwordInput" class="form-input" placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit" class="btn-auth">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
        </form>

        <div class="divider">atau</div>

        <div class="auth-switch">
            Belum punya akun?
            <a href="index.php?page=register<?= !empty($paket_id) ? '&paket_id=' . urlencode($paket_id) : '' ?>">
                Daftar Sekarang
            </a>
        </div>
    </div>
</div>

</body>
</html>