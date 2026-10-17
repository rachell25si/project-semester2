<?php
$pageTitle = 'Riwayat Booking Saya';
$reservasi = $reservasi ?? [];
$hariArr  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulanArr = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
?>

<div style="background:#fff;border-radius:20px;border:1px solid rgba(232,196,196,0.25);box-shadow:0 4px 20px rgba(107,76,59,0.06);overflow:hidden;max-width:960px;margin:0 auto;">
    <div style="padding:1.5rem;border-bottom:1px solid rgba(232,196,196,0.2);display:flex;justify-content:between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <div>
            <h3 style="font-family:var(--font-display);font-size:1.3rem;font-weight:600;color:var(--clr-brown-deep);">Riwayat Booking</h3>
            <p style="font-size:0.82rem;color:var(--clr-muted);margin-top:2px;">Daftar lengkap seluruh pemesanan makeup Anda di Studio MUA ULVA</p>
        </div>
        <a href="index.php?page=customer/reservasi/create" class="btn btn-gold btn-sm" style="display:inline-flex;align-items:center;gap:0.4rem;text-decoration:none;">
            <i class="fas fa-plus"></i> Booking Baru
        </a>
    </div>

    <?php if (empty($reservasi)): ?>
    <div style="padding:5rem 2rem;text-align:center;color:var(--clr-muted);">
        <i class="fas fa-calendar-times" style="font-size:3.5rem;opacity:0.3;margin-bottom:1rem;display:block;"></i>
        <p style="font-size:1rem;font-weight:500;">Belum ada riwayat booking.</p>
        <p style="font-size:0.83rem;margin-top:4px;">Pesan riasan pertama Anda sekarang!</p>
        <a href="index.php?page=customer/reservasi/create" class="btn btn-primary" style="margin-top:1.5rem;text-decoration:none;">
            Mulai Reservasi
        </a>
    </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table-premium">
            <thead>
                <tr>
                    <th style="padding:0.9rem 1.25rem;">ID Booking</th>
                    <th style="padding:0.9rem 1.25rem;">Paket</th>
                    <th style="padding:0.9rem 1.25rem;">Tanggal</th>
                    <th style="padding:0.9rem 1.25rem;">Waktu</th>
                    <th style="padding:0.9rem 1.25rem;">Lokasi</th>
                    <th style="padding:0.9rem 1.25rem;">Status</th>
                    <th style="padding:0.9rem 1.25rem;">Pembayaran</th>
                    <th style="padding:0.9rem 1.25rem;text-align:right;">Total Harga</th>
                    <th style="padding:0.9rem 1.25rem;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservasi as $res):
                    $tgl_str = !empty($res['tanggal_reservasi']) && $res['tanggal_reservasi'] !== '0000-00-00' ? $res['tanggal_reservasi'] : null;
                    $tgl = $tgl_str ? new DateTime($tgl_str) : null;
                    $tglStr = $tgl ? $tgl->format('d') . ' ' . substr($bulanArr[(int)$tgl->format('n')], 0, 3) . ' ' . $tgl->format('Y') : '-';
                    
                    $status = $res['status'] ?? 'pending';
                    $statusBayar = $res['status_pembayaran'] ?? 'belum';
                    
                    $sc_map = [
                        'pending'     => 'background:rgba(232,198,110,0.12);color:#7A5C00;',
                        'dikonfirmasi'=> 'background:rgba(122,179,212,0.12);color:#1A4E6B;',
                        'selesai'     => 'background:rgba(109,190,143,0.12);color:#1E6040;',
                        'batal'       => 'background:rgba(232,112,112,0.1);color:#B03030;',
                    ];
                    $sc = $sc_map[$status] ?? $sc_map['pending'];
                    
                    $bc_map = [
                        'belum' => 'background:rgba(232,112,112,0.1);color:#B03030;',
                        'dp'    => 'background:rgba(232,198,110,0.12);color:#7A5C00;',
                        'lunas' => 'background:rgba(109,190,143,0.12);color:#1E6040;',
                    ];
                    $bc = $bc_map[$statusBayar] ?? $bc_map['belum'];
                    
                    $bLabel_map = ['belum'=>'Belum','dp'=>'DP','lunas'=>'Lunas'];
                    $bLabel = $bLabel_map[$statusBayar] ?? '-';
                    
                    $sLabel_map = ['pending'=>'Pending','dikonfirmasi'=>'Dikonfirmasi','selesai'=>'Selesai','batal'=>'Batal'];
                    $sLabel = $sLabel_map[$status] ?? '-';
                ?>
                <tr style="border-bottom:1px solid rgba(232,196,196,0.15);transition:background 0.2s;" onmouseover="this.style.background='rgba(253,248,245,0.8)'" onmouseout="this.style.background=''">
                    <td style="padding:0.85rem 1.25rem;color:var(--clr-muted);font-size:0.8rem;">#<?= $res['id'] ?></td>
                    <td style="padding:0.85rem 1.25rem;font-weight:600;white-space:nowrap;"><?= htmlspecialchars($res['nama_paket'] ?? 'Paket Dihapus') ?></td>
                    <td style="padding:0.85rem 1.25rem;white-space:nowrap;color:var(--clr-brown);"><?= $tglStr ?></td>
                    <td style="padding:0.85rem 1.25rem;white-space:nowrap;"><?= !empty($res['is_full_day']) ? '<span style="color:var(--clr-gold);font-weight:600;">Full Day</span>' : (($res['jam_mulai']??'-') . ' - ' . ($res['jam_selesai']??'-')) ?></td>
                    <td style="padding:0.85rem 1.25rem;white-space:nowrap;"><?= $res['jenis_lokasi'] === 'studio' ? '🏠 Studio' : '📍 Home Visit' ?></td>
                    <td style="padding:0.85rem 1.25rem;">
                        <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:600;<?= $sc ?>"><?= $sLabel ?></span>
                    </td>
                    <td style="padding:0.85rem 1.25rem;">
                        <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:600;<?= $bc ?>"><?= $bLabel ?></span>
                    </td>
                    <td style="padding:0.85rem 1.25rem;font-weight:600;color:var(--clr-gold);text-align:right;white-space:nowrap;">Rp <?= number_format((float)($res['total_harga'] ?? 0), 0, ',', '.') ?></td>
                    <td style="padding:0.85rem 1.25rem;text-align:center;">
                        <a href="index.php?page=customer/reservasi/konfirmasi&id=<?= $res['id'] ?>" class="btn btn-primary btn-sm" style="padding:4px 14px;font-size:0.72rem;font-weight:600;border-radius:20px;text-decoration:none;">
                            Detail
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<style>
.btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.6rem 1.5rem; border-radius: 50px; font-family: var(--font-body); font-size: 0.85rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s; }
.btn-primary { background: var(--clr-brown-deep); color: #fff; }
.btn-primary:hover { background: var(--clr-gold); color: var(--clr-brown-deep); }
.btn-gold { background: var(--clr-gold); color: var(--clr-brown-deep); }
.btn-gold:hover { background: var(--clr-brown-deep); color: var(--clr-gold); }
.btn-sm { padding: 0.45rem 1.2rem; font-size: 0.8rem; }
</style>