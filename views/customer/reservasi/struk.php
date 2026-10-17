<?php
$pageTitle = 'Struk Pembayaran DP';
$res = $res ?? [];


$upload_success = $_SESSION['upload_success'] ?? null;
unset($_SESSION['upload_success']);

$hariArr = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulanArr = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$tglObj = !empty($res['tanggal_reservasi']) ? new DateTime($res['tanggal_reservasi']) : null;
$tglFormatted = $tglObj ? $hariArr[$tglObj->format('w')] . ', ' . $tglObj->format('j') . ' ' . $bulanArr[(int)$tglObj->format('n')] . ' ' . $tglObj->format('Y') : '-';
?>

<div style="max-width:600px;margin:0 auto;">
    
    <?php if ($upload_success): ?>
    <div class="alert alert-success" style="margin-bottom:1.5rem;text-align:center;">
        <i class="fas fa-check-circle" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;"></i> 
        <?= htmlspecialchars($upload_success) ?>
    </div>
    <?php endif; ?>

    <div class="card" id="printableArea" style="background:#fff;border-radius:20px;padding:2rem;box-shadow:0 10px 30px rgba(107,76,59,0.08);border:1px solid rgba(232,196,196,0.3);position:relative;overflow:hidden;">
        <!-- Decorative Header -->
        <div style="position:absolute;top:0;left:0;right:0;height:8px;background:linear-gradient(90deg, var(--clr-gold), var(--clr-brown-deep));"></div>
        
        <div style="text-align:center;margin-bottom:2rem;margin-top:1rem;">
            <h2 style="font-family:var(--font-display);font-size:1.8rem;font-weight:700;color:var(--clr-brown-deep);letter-spacing:1px;margin-bottom:0.25rem;">
                <i class="fas fa-spa" style="color:var(--clr-gold);font-size:1.4rem;"></i> MUA ULVA
            </h2>
            <p style="font-size:0.85rem;color:var(--clr-muted);text-transform:uppercase;letter-spacing:2px;">Tanda Terima Pembayaran DP</p>
        </div>

        <div style="display:flex;justify-content:space-between;align-items:flex-end;border-bottom:2px dashed rgba(232,196,196,0.5);padding-bottom:1rem;margin-bottom:1.5rem;">
            <div>
                <div style="font-size:0.75rem;color:var(--clr-muted);text-transform:uppercase;letter-spacing:1px;">ID Booking</div>
                <div style="font-size:1.2rem;font-weight:700;color:var(--clr-brown-deep);">#<?= $res['id'] ?? '-' ?></div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:0.75rem;color:var(--clr-muted);text-transform:uppercase;letter-spacing:1px;">Tanggal Cetak</div>
                <div style="font-size:0.9rem;font-weight:600;color:var(--clr-brown);"><?= date('d/m/Y H:i') ?></div>
            </div>
        </div>

        <div style="margin-bottom:1.5rem;">
            <h4 style="font-size:0.9rem;color:var(--clr-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:1rem;">Detail Pemesan & Layanan</h4>
            <div style="display:grid;grid-template-columns:100px 1fr;gap:0.5rem;font-size:0.9rem;margin-bottom:0.5rem;">
                <div style="color:var(--clr-muted);">Nama</div>
                <div style="font-weight:600;color:var(--clr-brown-deep);"><?= htmlspecialchars($res['customer_nama'] ?? $_SESSION['nama'] ?? 'Customer') ?></div>
                
                <div style="color:var(--clr-muted);">Paket</div>
                <div style="font-weight:600;color:var(--clr-brown-deep);"><?= htmlspecialchars($res['nama_paket'] ?? '-') ?></div>
                
                <div style="color:var(--clr-muted);">Jadwal</div>
                <div style="font-weight:600;color:var(--clr-brown-deep);"><?= $tglFormatted ?> <br> <span style="font-size:0.8rem;color:var(--clr-gold);">(<?= !empty($res['is_full_day']) ? 'Full Day / Wedding' : (($res['jam_mulai'] ?? '') . ' - ' . ($res['jam_selesai'] ?? '') . ' WIB') ?>)</span></div>
                
                <div style="color:var(--clr-muted);">Lokasi</div>
                <div style="font-weight:600;color:var(--clr-brown-deep);"><?= (($res['jenis_lokasi'] ?? '') === 'studio') ? 'Studio MUA ULVA' : 'Home Visit (Lokasi Customer)' ?></div>
            </div>
        </div>

        <div style="background:var(--clr-cream);border-radius:12px;padding:1.5rem;margin-bottom:2rem;">
            <div style="display:flex;justify-content:space-between;margin-bottom:0.75rem;font-size:0.9rem;">
                <span style="color:var(--clr-muted);">Total Harga Paket</span>
                <span style="font-weight:600;color:var(--clr-brown-deep);">Rp <?= number_format((float)($res['total_harga'] ?? 0), 0, ',', '.') ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:0.75rem;font-size:0.9rem;border-bottom:1px solid rgba(232,196,196,0.5);padding-bottom:0.75rem;">
                <span style="color:var(--clr-muted);">DP yang harus dibayar</span>
                <span style="font-weight:600;color:var(--clr-brown-deep);">Rp <?= number_format((float)($res['total_dp'] ?? 0), 0, ',', '.') ?></span>
            </div>
            
            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1rem;">
                <span style="font-size:1rem;font-weight:600;color:var(--clr-brown-deep);">Total DP Dibayar</span>
                <span style="font-size:1.4rem;font-family:var(--font-display);font-weight:700;color:var(--clr-gold);">
                    Rp <?= number_format((float)($res['dp_dibayar'] ?? 0), 0, ',', '.') ?>
                </span>
            </div>
            <div style="display:flex;justify-content:space-between;margin-top:0.5rem;font-size:0.85rem;">
                <span style="color:var(--clr-muted);">Sisa Pembayaran (Pelunasan)</span>
                <span style="font-weight:600;color:var(--clr-danger);">
                    Rp <?= number_format((float)($res['total_harga'] ?? 0) - (float)($res['dp_dibayar'] ?? 0), 0, ',', '.') ?>
                </span>
            </div>
        </div>

        <div style="text-align:center;font-size:0.85rem;color:var(--clr-muted);line-height:1.5;">
            <p>Bukti DP Anda sedang diverifikasi oleh Admin. <br>Status booking Anda akan segera diupdate menjadi <strong>"Dikonfirmasi"</strong> setelah pengecekan selesai.</p>
            <p style="margin-top:1rem;font-weight:600;color:var(--clr-brown-deep);">Terima kasih atas kepercayaan Anda kepada MUA ULVA! 🌸</p>
        </div>
    </div>

    <!-- Actions -->
    <div style="display:flex;gap:1rem;justify-content:center;margin-top:1.5rem;flex-wrap:wrap;">
        <button onclick="window.print()" class="btn btn-outline">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
        <a href="index.php?page=customer/reservasi/riwayat" class="btn btn-gold">
            <i class="fas fa-history"></i> Ke Riwayat Booking
        </a>
    </div>

</div>

<style>
.btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.75rem; border-radius: 50px; font-family: var(--font-body); font-size: 0.9rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s; text-decoration: none; }
.btn-outline { background: #fff; color: var(--clr-brown-deep); border: 1.5px solid rgba(61,43,31,0.3); }
.btn-outline:hover { background: var(--clr-brown-deep); color: #fff; transform: translateY(-2px); }
.btn-gold { background: var(--clr-gold); color: var(--clr-brown-deep); box-shadow: 0 6px 20px rgba(201,168,124,0.35); }
.btn-gold:hover { background: var(--clr-brown-deep); color: var(--clr-gold); transform: translateY(-2px); }

@media print {
    body * { visibility: hidden; }
    #printableArea, #printableArea * { visibility: visible; }
    #printableArea { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none !important; border: none !important; padding: 0 !important; }
}
</style>
