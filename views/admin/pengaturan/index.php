<?php $pageTitle = 'Pengaturan Operasional Studio'; ?>

<?php
$success = $_SESSION['setting_success'] ?? null;
$error   = $_SESSION['setting_error']   ?? null;
unset($_SESSION['setting_success'], $_SESSION['setting_error']);
?>

<div style="max-width:540px;margin:0 auto;">
    
    <?php if ($success): ?>
    <div class="alert alert-success" style="margin-bottom:1rem;"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
    <div class="alert alert-danger" style="margin-bottom:1rem;"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div style="background:#fff;border-radius:20px;padding:2rem;border:1px solid rgba(232,196,196,0.25);box-shadow:0 4px 20px rgba(107,76,59,0.06);">
        <h3 style="font-family:var(--font-display);font-size:1.35rem;font-weight:600;color:var(--clr-brown-deep);margin-bottom:0.5rem;display:flex;align-items:center;gap:0.5rem;">
            <i class="fas fa-cog" style="color:var(--clr-gold);font-size:1rem;"></i> Jam Operasional & Durasi Slot
        </h3>
        <p style="font-size:0.83rem;color:var(--clr-muted);margin-bottom:1.5rem;">
            Konfigurasi ini akan mengubah rentang waktu dan durasi pembagian slot booking (dari jam 03.00 s/d 23.00 WIB) yang ditawarkan kepada customer.
        </p>

        <form method="POST" action="index.php?page=admin/pengaturan">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                <div class="form-group">
                    <label class="form-label">Jam Buka Studio</label>
                    <input type="time" name="jam_mulai" class="form-control" value="<?= date('H:i', strtotime($setting['jam_mulai'] ?? '03:00')) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Tutup Studio</label>
                    <input type="time" name="jam_selesai" class="form-control" value="<?= date('H:i', strtotime($setting['jam_selesai'] ?? '23:00')) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Durasi per Slot Booking (Menit)</label>
                <select name="durasi_slot_menit" class="form-control" required>
                    <?php $durasi = $setting['durasi_slot_menit'] ?? 120; ?>
                    <option value="60" <?= $durasi == 60 ? 'selected' : '' ?>>1 Jam (60 menit)</option>
                    <option value="90" <?= $durasi == 90 ? 'selected' : '' ?>>1.5 Jam (90 menit)</option>
                    <option value="120" <?= $durasi == 120 ? 'selected' : '' ?>>2 Jam (120 menit) — Default</option>
                    <option value="180" <?= $durasi == 180 ? 'selected' : '' ?>>3 Jam (180 menit)</option>
                    <option value="240" <?= $durasi == 240 ? 'selected' : '' ?>>4 Jam (240 menit)</option>
                </select>
            </div>

            <div style="background:rgba(201,168,124,0.08);border:1.5px solid rgba(201,168,124,0.3);border-radius:12px;padding:1rem;font-size:0.8rem;color:var(--clr-brown);margin-bottom:1.5rem;line-height:1.6;display:flex;gap:0.5rem;align-items:flex-start;">
                <i class="fas fa-info-circle" style="color:var(--clr-gold);margin-top:2px;"></i>
                <div>
                    <strong>Informasi:</strong><br>
                    Perubahan pengaturan slot booking ini tidak akan mengganggu booking yang sudah sah/sudah dipesan sebelumnya di database.
                </div>
            </div>

            <button type="submit" style="width:100%;padding:0.9rem;border-radius:50px;background:var(--clr-brown-deep);color:#fff;font-family:var(--font-body);font-size:0.92rem;font-weight:600;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;" onmouseover="this.style.background='var(--clr-gold)';this.style.color='var(--clr-brown-deep)'" onmouseout="this.style.background='var(--clr-brown-deep)';this.style.color='#fff'">
                <i class="fas fa-check"></i> Simpan Pengaturan
            </button>
        </form>
    </div>
</div>
