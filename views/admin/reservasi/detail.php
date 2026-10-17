<?php 
$pageTitle = 'Detail Reservasi'; 
$res = $res ?? [];
?>

<?php
$hariArr  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulanArr = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$tgl_str  = !empty($res['tanggal_reservasi']) && $res['tanggal_reservasi'] !== '0000-00-00' ? $res['tanggal_reservasi'] : null;
$tglObj   = $tgl_str ? new DateTime($tgl_str) : null;
$tglFormatted = $tglObj ? $hariArr[$tglObj->format('w')] . ', ' . $tglObj->format('j') . ' ' . $bulanArr[(int)$tglObj->format('n')] . ' ' . $tglObj->format('Y') : '-';
$wa_msg = urlencode("Halo " . ($res['customer_nama']??'Customer') . "! Booking #" . ($res['id'] ?? '') . " Anda sudah kami konfirmasi. Terima kasih telah memilih MUA ULVA! 🌸");
$wa_link = "https://wa.me/" . preg_replace('/\D/','',$res['no_hp']??'') . "?text=" . $wa_msg;

$status = $res['status'] ?? 'pending';
$statusBayar = $res['status_pembayaran'] ?? 'belum';
?>

<div style="max-width:860px;margin:0 auto;">
    <a href="index.php?page=admin/reservasi" style="display:inline-flex;align-items:center;gap:0.5rem;color:var(--clr-muted);font-size:0.85rem;text-decoration:none;margin-bottom:1.5rem;transition:color 0.2s;" onmouseover="this.style.color='var(--clr-gold)'" onmouseout="this.style.color='var(--clr-muted)'">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Reservasi
    </a>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
        <!-- Customer Info -->
        <div style="background:#fff;border-radius:20px;padding:1.5rem;border:1px solid rgba(232,196,196,0.2);box-shadow:0 4px 15px rgba(107,76,59,0.05);">
            <h3 style="font-family:var(--font-display);font-size:1.2rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem;">
                <i class="fas fa-user" style="color:var(--clr-gold);font-size:0.9rem;"></i> Info Customer
            </h3>
            <?php
            $ci = [
                ['Nama',   $res['customer_nama'] ?? '-'],
                ['No. HP', $res['no_hp']   ?? '-'],
                ['Email',  $res['email'] ?? '-'],
            ];
            foreach ($ci as $c): ?>
            <div style="display:flex;justify-content:space-between;padding:0.65rem 0;border-bottom:1px dashed rgba(232,196,196,0.3);font-size:0.88rem;">
                <span style="color:var(--clr-muted);font-weight:600;"><?= $c[0] ?></span>
                <span style="font-weight:600;"><?= htmlspecialchars($c[1]) ?></span>
            </div>
            <?php endforeach; ?>
            <a href="<?= $wa_link ?>" target="_blank" style="display:inline-flex;align-items:center;gap:0.5rem;margin-top:1rem;background:#25D366;color:#fff;padding:0.55rem 1.25rem;border-radius:50px;font-size:0.82rem;font-weight:600;text-decoration:none;">
                <i class="fab fa-whatsapp"></i> WhatsApp Customer
            </a>
        </div>

        <!-- Booking Info -->
        <div style="background:#fff;border-radius:20px;padding:1.5rem;border:1px solid rgba(232,196,196,0.2);box-shadow:0 4px 15px rgba(107,76,59,0.05);">
            <h3 style="font-family:var(--font-display);font-size:1.2rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem;">
                <i class="fas fa-calendar-alt" style="color:var(--clr-gold);font-size:0.9rem;"></i> Detail Booking
            </h3>
            <?php
            $bi = [
                ['ID Booking',  '#' . $res['id']],
                ['Paket',       $res['nama_paket'] ?? '-'],
                ['Tanggal',     $tglFormatted],
                ['Waktu',       !empty($res['is_full_day']) ? 'Full Day (03:00–23:00)' : (($res['jam_mulai']??'-').' – '.($res['jam_selesai']??'-').' WIB')],
                ['Lokasi',      $res['jenis_lokasi'] === 'studio' ? '🏠 Studio MUA ULVA' : '📍 Home Visit'],
            ];
            foreach ($bi as $b): ?>
            <div style="display:flex;justify-content:space-between;padding:0.65rem 0;border-bottom:1px dashed rgba(232,196,196,0.3);font-size:0.88rem;">
                <span style="color:var(--clr-muted);font-weight:600;"><?= $b[0] ?></span>
                <span style="font-weight:600;"><?= htmlspecialchars($b[1]) ?></span>
            </div>
            <?php endforeach; ?>
            <?php if (!empty($res['catatan'])): ?>
            <div style="margin-top:1rem;background:var(--clr-cream);padding:0.75rem;border-radius:12px;font-size:0.82rem;color:var(--clr-brown);">
                <strong>Catatan:</strong> <?= htmlspecialchars($res['catatan']) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Payment + Status -->
    <div style="background:#fff;border-radius:20px;padding:1.5rem;border:1px solid rgba(232,196,196,0.2);box-shadow:0 4px 15px rgba(107,76,59,0.05);margin-bottom:1.5rem;">
        <h3 style="font-family:var(--font-display);font-size:1.2rem;margin-bottom:1.25rem;">Pembayaran & Status</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
            <div>
                <?php
                $pm = [
                    ['Total Harga', 'Rp '.number_format((float)($res['total_harga'] ?? 0),0,',','.')],
                    ['Total DP',    'Rp '.number_format((float)($res['total_dp'] ?? 0),0,',','.')],
                    ['DP Dibayar',  'Rp '.number_format((float)($res['dp_dibayar'] ?? 0),0,',','.')],
                    ['Sisa Bayar',  'Rp '.number_format((float)($res['total_harga'] ?? 0) - (float)($res['dp_dibayar'] ?? 0),0,',','.')],
                ];
                foreach ($pm as $p): ?>
                <div style="display:flex;justify-content:space-between;padding:0.65rem 0;border-bottom:1px dashed rgba(232,196,196,0.3);font-size:0.88rem;">
                    <span style="color:var(--clr-muted);"><?= $p[0] ?></span>
                    <span style="font-weight:600;"><?= $p[1] ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <div>
                <?php if (!empty($res['bukti_pembayaran'])): ?>
                <p style="font-size:0.8rem;font-weight:600;color:var(--clr-muted);margin-bottom:0.75rem;">Bukti Transfer DP:</p>
                <?php $ext = strtolower(pathinfo($res['bukti_pembayaran'], PATHINFO_EXTENSION)); ?>
                <?php if (in_array($ext, ['jpg','jpeg','png','gif','webp'])): ?>
                    <img src="public/uploads/bukti/<?= htmlspecialchars($res['bukti_pembayaran']) ?>" 
                         style="width:100%;max-height:200px;object-fit:cover;border-radius:12px;border:2px solid rgba(201,168,124,0.3);"
                         onclick="window.open(this.src)" style="cursor:zoom-in;">
                <?php else: ?>
                    <a href="public/uploads/bukti/<?= htmlspecialchars($res['bukti_pembayaran']) ?>" target="_blank" style="display:inline-flex;align-items:center;gap:0.5rem;color:var(--clr-gold);font-size:0.85rem;text-decoration:none;">
                        <i class="fas fa-file-pdf"></i> Lihat Bukti PDF
                    </a>
                <?php endif; ?>
                <?php else: ?>
                    <div style="background:rgba(232,112,112,0.06);border:1px solid rgba(232,112,112,0.2);border-radius:12px;padding:1rem;font-size:0.85rem;color:#B03030;text-align:center;">
                        <i class="fas fa-image" style="font-size:1.5rem;opacity:0.4;display:block;margin-bottom:0.5rem;"></i>
                        Bukti pembayaran belum diupload
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Update Status Pengerjaan -->
    <div style="background:#fff;border-radius:20px;padding:1.5rem;border:1px solid rgba(232,196,196,0.2);box-shadow:0 4px 15px rgba(107,76,59,0.05);margin-bottom:1.5rem;">
        <h3 style="font-family:var(--font-display);font-size:1.2rem;margin-bottom:1.25rem;">Update Status Pengerjaan</h3>
        <div style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap;">
            <div style="display:flex;gap:0.5rem;background:var(--clr-cream);padding:5px;border-radius:50px;flex-wrap:wrap;">
                <?php
                $statuses = [
                    ['val'=>'pending',      'label'=>'Pending',       'color'=>'rgba(232,198,110,0.2);color:#7A5C00;'],
                    ['val'=>'dikonfirmasi', 'label'=>'Dikonfirmasi',  'color'=>'rgba(122,179,212,0.2);color:#1A4E6B;'],
                    ['val'=>'selesai',      'label'=>'Selesai',       'color'=>'rgba(109,190,143,0.2);color:#1E6040;'],
                    ['val'=>'batal',        'label'=>'Batal',         'color'=>'rgba(232,112,112,0.15);color:#B03030;'],
                ];
                foreach ($statuses as $s):
                    $isActive = ($status === $s['val']);
                ?>
                <form method="POST" action="index.php?page=admin/reservasi/update" style="display:inline;">
                    <input type="hidden" name="id"     value="<?= $res['id'] ?? '' ?>">
                    <input type="hidden" name="status" value="<?= $s['val'] ?>">
                    <button type="submit" style="padding:0.5rem 1.25rem;border-radius:50px;border:none;cursor:pointer;font-family:var(--font-body);font-size:0.82rem;font-weight:600;transition:all 0.2s;<?= $isActive ? 'background:'.$s['color'].';box-shadow:0 2px 10px rgba(0,0,0,0.1);' : 'background:transparent;color:var(--clr-muted);' ?>">
                        <?= $s['label'] ?>
                    </button>
                </form>
                <?php endforeach; ?>
            </div>
            <div style="font-size:0.8rem;color:var(--clr-muted);">
                Status saat ini: <strong style="color:var(--clr-brown-deep);"><?= ucfirst($status) ?></strong>
            </div>
        </div>
    </div>

    <!-- Update Status Pembayaran -->
    <div style="background:#fff;border-radius:20px;padding:1.5rem;border:1px solid rgba(232,196,196,0.2);box-shadow:0 4px 15px rgba(107,76,59,0.05);">
        <h3 style="font-family:var(--font-display);font-size:1.2rem;margin-bottom:1.25rem;">Update Status Pembayaran</h3>
        <div style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap;">
            <div style="display:flex;gap:0.5rem;background:var(--clr-cream);padding:5px;border-radius:50px;flex-wrap:wrap;">
                <?php
                $payStatuses = [
                    ['val'=>'belum', 'label'=>'Belum Bayar', 'color'=>'rgba(232,112,112,0.15);color:#B03030;'],
                    ['val'=>'dp',    'label'=>'DP',          'color'=>'rgba(232,198,110,0.2);color:#7A5C00;'],
                    ['val'=>'lunas', 'label'=>'Lunas',       'color'=>'rgba(109,190,143,0.2);color:#1E6040;'],
                ];
                foreach ($payStatuses as $s):
                    $isActive = ($statusBayar === $s['val']);
                ?>
                <form method="POST" action="index.php?page=admin/reservasi/update_pembayaran" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $res['id'] ?? '' ?>">
                    <input type="hidden" name="status_pembayaran" value="<?= $s['val'] ?>">
                    <button type="submit" style="padding:0.5rem 1.25rem;border-radius:50px;border:none;cursor:pointer;font-family:var(--font-body);font-size:0.82rem;font-weight:600;transition:all 0.2s;<?= $isActive ? 'background:'.$s['color'].';box-shadow:0 2px 10px rgba(0,0,0,0.1);' : 'background:transparent;color:var(--clr-muted);' ?>">
                        <?= $s['label'] ?>
                    </button>
                </form>
                <?php endforeach; ?>
            </div>
            <div style="font-size:0.8rem;color:var(--clr-muted);">
                Status saat ini: <strong style="color:var(--clr-brown-deep);"><?= ucfirst($statusBayar) ?></strong>
            </div>
        </div>
    </div>
</div>