<?php
$pageTitle = 'Konfirmasi Booking';
$res = $res ?? [];


$upload_success = $_SESSION['upload_success'] ?? null;
$upload_error   = $_SESSION['upload_error']   ?? null;
unset($_SESSION['upload_success'], $_SESSION['upload_error']);

$hariArr = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulanArr = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$tglObj = !empty($res['tanggal_reservasi']) ? new DateTime($res['tanggal_reservasi']) : null;
$tglFormatted = $tglObj ? $hariArr[$tglObj->format('w')] . ', ' . $tglObj->format('j') . ' ' . $bulanArr[(int)$tglObj->format('n')] . ' ' . $tglObj->format('Y') : '-';

// WhatsApp message template
$wa_admin_num = $wa_admin ?? '6281234567890';
$wa_msg = urlencode(
    "Halo Admin MUA ULVA! 🌸\n\n" .
    "Saya ingin konfirmasi booking:\n" .
    "• Nama: " . ($res['customer_nama'] ?? $_SESSION['nama'] ?? 'Customer') . "\n" .
    "• Paket: " . ($res['nama_paket'] ?? '-') . "\n" .
    "• Tanggal: " . $tglFormatted . "\n" .
    "• Waktu: " . (!empty($res['is_full_day']) ? 'Full Day (Wedding)' : (($res['jam_mulai'] ?? '') . ' - ' . ($res['jam_selesai'] ?? ''))) . " WIB\n" .
    "• Lokasi: " . ((($res['jenis_lokasi'] ?? '') === 'studio') ? 'Di Studio' : 'Home Visit') . "\n" .
    "• ID Booking: #" . ($res['id'] ?? '') . "\n\n" .
    "Total DP: Rp " . number_format((float)($res['total_dp'] ?? 0), 0, ',', '.') . "\n\n" .
    "Mohon konfirmasi dan info rekening untuk pembayaran DP. Terima kasih! 🙏"
);
$wa_link = "https://wa.me/{$wa_admin_num}?text={$wa_msg}";
?>

<div style="max-width:720px;margin:0 auto;">

    <!-- Success Icon -->
    <div style="text-align:center;margin-bottom:2rem;">
        <div class="confirm-icon">
            <i class="fas fa-check"></i>
        </div>
        <h1 style="font-family:var(--font-display);font-size:2.2rem;font-weight:600;color:var(--clr-brown-deep);margin-bottom:0.5rem;">Booking Berhasil!</h1>
        <p style="color:var(--clr-muted);font-size:0.95rem;">ID Booking: <strong style="color:var(--clr-gold);">#<?= $res['id'] ?? '-' ?></strong></p>
    </div>

    <?php if ($upload_success): ?>
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($upload_success) ?></div>
    <?php endif; ?>
    <?php if ($upload_error): ?>
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($upload_error) ?></div>
    <?php endif; ?>

    <!-- Detail Card -->
    <div class="card" style="margin-bottom:1.5rem;">
        <div style="padding:1.5rem;">
            <h3 style="font-family:var(--font-display);font-size:1.3rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem;">
                <i class="fas fa-clipboard-list" style="color:var(--clr-gold);font-size:1rem;"></i> Detail Reservasi
            </h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <?php
                $details = [
                    ['icon'=>'fas fa-spa',          'label'=>'Paket',     'val'=> $res['nama_paket'] ?? '-'],
                    ['icon'=>'fas fa-calendar-alt', 'label'=>'Tanggal',   'val'=> $tglFormatted],
                    ['icon'=>'fas fa-clock',        'label'=>'Waktu',     'val'=> !empty($res['is_full_day']) ? 'Full Day (Wedding)' : (($res['jam_mulai'] ?? '-') . ' – ' . ($res['jam_selesai'] ?? '-') . ' WIB')],
                    ['icon'=>'fas fa-map-marker-alt','label'=>'Lokasi',   'val'=> ($res['jenis_lokasi'] ?? '') === 'studio' ? 'Di Studio MUA ULVA' : 'Home Visit (Lokasi Saya)'],
                ];
                foreach ($details as $d): ?>
                <div style="display:flex;align-items:flex-start;gap:0.75rem;padding:0.75rem;background:var(--clr-cream);border-radius:12px;">
                    <div style="width:34px;height:34px;background:rgba(201,168,124,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--clr-gold);font-size:0.9rem;flex-shrink:0;">
                        <i class="<?= $d['icon'] ?>"></i>
                    </div>
                    <div>
                        <div style="font-size:0.72rem;font-weight:600;color:var(--clr-muted);text-transform:uppercase;letter-spacing:0.5px;"><?= $d['label'] ?></div>
                        <div style="font-size:0.9rem;font-weight:600;color:var(--clr-brown-deep);margin-top:2px;"><?= htmlspecialchars($d['val']) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (!empty($res['catatan'])): ?>
            <div style="margin-top:1rem;padding:0.85rem 1rem;background:var(--clr-cream);border-radius:12px;font-size:0.85rem;color:var(--clr-brown);">
                <strong>Catatan:</strong> <?= htmlspecialchars($res['catatan']) ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Payment Summary -->
        <div style="border-top:1px solid rgba(232,196,196,0.3);padding:1.5rem;">
            <h4 style="font-family:var(--font-display);font-size:1.1rem;margin-bottom:1rem;">Ringkasan Pembayaran</h4>
            <div class="summary-box">
                <div class="summary-row"><span>Total Harga</span><span>Rp <?= number_format((float)($res['total_harga'] ?? 0), 0, ',', '.') ?></span></div>
                <div class="summary-row"><span>DP yang Harus Dibayar</span><span style="color:var(--clr-gold);font-weight:700;">Rp <?= number_format((float)($res['total_dp'] ?? 0), 0, ',', '.') ?></span></div>
                <div class="summary-row"><span>Sisa Pembayaran</span><span>Rp <?= number_format((float)($res['total_harga'] ?? 0) - (float)($res['total_dp'] ?? 0), 0, ',', '.') ?></span></div>
                <div class="summary-row total">
                    <span>Status Pembayaran</span>
                    <span>
                        <?php if (($res['status_pembayaran'] ?? '') === 'lunas'): ?>
                            <span class="badge badge-success"><i class="fas fa-check"></i> Lunas</span>
                        <?php elseif (($res['status_pembayaran'] ?? '') === 'dp'): ?>
                            <span class="badge badge-warning">DP Dibayar</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Belum Bayar</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bank Account Info -->
    <div class="card" style="margin-bottom:1.5rem;background:#fff;border-left:4px solid var(--clr-gold);">
        <div style="padding:1.5rem;">
            <h4 style="font-family:var(--font-display);font-size:1.1rem;margin-bottom:1rem;color:var(--clr-brown-deep);">
                <i class="fas fa-university" style="color:var(--clr-gold);"></i> Rekening Pembayaran
            </h4>
            <p style="font-size:0.85rem;color:var(--clr-muted);margin-bottom:1rem;">Silakan lakukan transfer ke salah satu rekening berikut sejumlah yang tertera pada ringkasan pembayaran:</p>
            <div style="display:flex;flex-direction:column;gap:1rem;">
                <div style="display:flex;align-items:center;gap:1rem;background:var(--clr-cream);padding:1rem;border-radius:12px;">
                    <div style="font-weight:bold;font-size:1.1rem;color:#005E6A;width:60px;">BCA</div>
                    <div>
                        <div style="font-size:1.1rem;font-weight:600;letter-spacing:1px;color:var(--clr-brown-deep);">8271 234 567</div>
                        <div style="font-size:0.8rem;color:var(--clr-muted);">a.n. Ulva Makeup</div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:1rem;background:var(--clr-cream);padding:1rem;border-radius:12px;">
                    <div style="font-weight:bold;font-size:1.1rem;color:#FF6600;width:60px;">BNI</div>
                    <div>
                        <div style="font-size:1.1rem;font-weight:600;letter-spacing:1px;color:var(--clr-brown-deep);">0987 654 321</div>
                        <div style="font-size:0.8rem;color:var(--clr-muted);">a.n. Ulva Makeup</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Bukti DP -->
    <?php if (($res['status_pembayaran'] ?? '') === 'belum' || ($res['status_pembayaran'] ?? '') === 'dp'): ?>
    <div class="card" style="margin-bottom:1.5rem;">
        <div style="padding:1.5rem;">
            <h3 style="font-family:var(--font-display);font-size:1.2rem;margin-bottom:0.4rem;display:flex;align-items:center;gap:0.5rem;">
                <i class="fas fa-upload" style="color:var(--clr-gold);font-size:1rem;"></i> Upload Bukti Transfer
            </h3>
            <p style="font-size:0.83rem;color:var(--clr-muted);margin-bottom:1.25rem;">
                Upload foto/screenshot bukti transfer untuk mempercepat konfirmasi booking Anda.
            </p>

            <?php if (!empty($res['bukti_pembayaran'])): ?>
            <div style="background:rgba(109,190,143,0.08);border:1px solid rgba(109,190,143,0.25);border-radius:12px;padding:1rem;display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                <i class="fas fa-file-image" style="color:var(--clr-success);font-size:1.2rem;"></i>
                <div style="font-size:0.85rem;color:var(--clr-brown);">
                    Bukti telah diupload: <strong><?= htmlspecialchars($res['bukti_pembayaran']) ?></strong>
                </div>
            </div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=customer/pembayaran/upload" enctype="multipart/form-data">
                <input type="hidden" name="reservasi_id" value="<?= $res['id'] ?? '' ?>">
                <div class="upload-zone" onclick="document.getElementById('buktiFile').click()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p><strong>Klik untuk pilih file</strong> atau drag & drop</p>
                    <p style="font-size:0.75rem;margin-top:0.3rem;">JPG, PNG, PDF - Max 5MB</p>
                </div>
                <input type="file" id="buktiFile" name="bukti" accept="image/*,.pdf" style="display:none;" onchange="previewBukti(this)" required>
                <div id="previewContainer" style="display:none;margin-top:0.75rem;"></div>
                <button type="submit" class="btn btn-gold w-100" style="margin-top:1rem;justify-content:center;border:none;cursor:pointer;">
                    <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                </button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- WhatsApp Confirm -->
    <div class="card" style="margin-bottom:1.5rem;background:linear-gradient(135deg,#3D2B1F,#6B4C3B);border:none;">
        <div style="padding:1.75rem;text-align:center;">
            <div style="width:60px;height:60px;background:rgba(37,211,102,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;border:2px solid rgba(37,211,102,0.3);">
                <i class="fab fa-whatsapp" style="font-size:1.75rem;color:#25D366;"></i>
            </div>
            <h3 style="font-family:var(--font-display);font-size:1.4rem;color:var(--clr-gold-light);margin-bottom:0.5rem;">Konfirmasi via WhatsApp</h3>
            <p style="color:rgba(255,255,255,0.6);font-size:0.88rem;margin-bottom:1.5rem;line-height:1.7;">
                Hubungi admin kami via WhatsApp untuk:<br>
                konfirmasi booking, info rekening transfer DP,<br>
                dan diskusi detail pelaksanaan makeup Anda.
            </p>
            <a href="<?= $wa_link ?>" target="_blank" class="btn btn-wa btn-lg" style="display:inline-flex;gap:0.6rem;align-items:center;text-decoration:none;">
                <i class="fab fa-whatsapp"></i> Chat Admin Sekarang
            </a>
        </div>
    </div>

    <!-- Steps Info -->
    <div class="card" style="margin-bottom:1.5rem;">
        <div style="padding:1.5rem;">
            <h4 style="font-family:var(--font-display);font-size:1.1rem;margin-bottom:1.25rem;">Langkah Selanjutnya</h4>
            <?php
            $steps = [
                ['num'=>'1', 'title'=>'Upload Bukti DP', 'desc'=>'Upload foto bukti transfer DP di atas, atau kirim ke WhatsApp admin.', 'done' => ($res['status_pembayaran'] ?? '') !== 'belum'],
                ['num'=>'2', 'title'=>'Konfirmasi Admin', 'desc'=>'Admin akan mengkonfirmasi booking dan memberikan detail pelaksanaan.', 'done' => ($res['status'] ?? '') === 'dikonfirmasi' || ($res['status'] ?? '') === 'selesai'],
                ['num'=>'3', 'title'=>'Persiapan Hari H', 'desc'=>'Admin akan menghubungi Anda untuk koordinasi lokasi, waktu, dan kebutuhan khusus.', 'done' => false],
                ['num'=>'4', 'title'=>'Selamat Tampil Cantik!', 'desc'=>'MUA kami siap membuatmu bersinar di hari istimewa!', 'done' => ($res['status'] ?? '') === 'selesai'],
            ];
            foreach ($steps as $s): ?>
            <div style="display:flex;gap:1rem;margin-bottom:1rem;">
                <div style="width:32px;height:32px;border-radius:50%;background:<?= $s['done'] ? 'var(--clr-success)' : 'rgba(201,168,124,0.15)' ?>;border:2px solid <?= $s['done'] ? 'var(--clr-success)' : 'rgba(201,168,124,0.3)' ?>;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;color:<?= $s['done'] ? '#fff' : 'var(--clr-gold)' ?>;flex-shrink:0;">
                    <?= $s['done'] ? '&check;' : $s['num'] ?>
                </div>
                <div>
                    <div style="font-weight:600;font-size:0.88rem;color:var(--clr-brown-deep);"><?= $s['title'] ?></div>
                    <div style="font-size:0.8rem;color:var(--clr-muted);"><?= $s['desc'] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Actions -->
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
        <a href="index.php?page=customer/reservasi/riwayat" class="btn btn-outline">
            <i class="fas fa-history"></i> Lihat Riwayat Booking
        </a>
        <a href="index.php?page=customer/reservasi/create" class="btn btn-gold">
            <i class="fas fa-plus"></i> Booking Lagi
        </a>
    </div>
</div>

<style>
.btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.75rem; border-radius: 50px; font-family: var(--font-body); font-size: 0.9rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s; text-decoration: none; }
.btn-outline { background: transparent; color: var(--clr-brown-deep); border: 1.5px solid rgba(61,43,31,0.3); }
.btn-outline:hover { background: var(--clr-brown-deep); color: #fff; transform: translateY(-2px); }
.btn-gold { background: var(--clr-gold); color: var(--clr-brown-deep); box-shadow: 0 6px 20px rgba(201,168,124,0.35); }
.btn-gold:hover { background: var(--clr-brown-deep); color: var(--clr-gold); transform: translateY(-2px); }
.btn-wa { background: #25D366; color: #fff; }
.btn-wa:hover { background: #1da855; transform: translateY(-2px); }
.btn-lg { padding: 1rem 2.25rem; font-size: 1rem; }
.w-100 { width: 100%; justify-content: center; }
.confirm-icon { width: 80px; height: 80px; border-radius: 50%; background: rgba(109,190,143,0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; border: 3px solid rgba(109,190,143,0.3); animation: pulse 2s ease-in-out infinite; }
.confirm-icon i { font-size: 2rem; color: var(--clr-success,#6DBE8F); }
@keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.05)} }
</style>

<script>
function previewBukti(input) {
    const file = input.files[0];
    if (!file) return;
    const container = document.getElementById('previewContainer');
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            container.style.display = 'block';
            container.innerHTML = `<img src="${e.target.result}" style="max-height:200px;border-radius:12px;border:2px solid rgba(201,168,124,0.3);">`;
        };
        reader.readAsDataURL(file);
    } else {
        container.style.display = 'block';
        container.innerHTML = `<div style="background:var(--clr-cream);padding:0.75rem 1rem;border-radius:12px;font-size:0.85rem;color:var(--clr-brown);"><i class="fas fa-file-pdf" style="color:var(--clr-danger);"></i> ${file.name}</div>`;
    }
}
// Drag and drop
const uploadZone = document.querySelector('.upload-zone');
if (uploadZone) {
    uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
    uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
    uploadZone.addEventListener('drop', e => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) {
            const input = document.getElementById('buktiFile');
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            previewBukti(input);
        }
    });
}
</script>