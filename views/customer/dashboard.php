<?php
$pageTitle = 'Dashboard Customer';
$reservasi = $reservasi ?? [];
$hariArr  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulanArr = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
?>

<div style="margin-bottom:2rem;">
    <h2 style="font-family:var(--font-display);font-size:2rem;font-weight:600;color:var(--clr-brown-deep);">
        Halo, <?= htmlspecialchars($_SESSION['nama']) ?>! 👋
    </h2>
    <p style="color:var(--clr-muted);font-size:0.9rem;">Kelola reservasi dan pembayaran makeup Anda di sini.</p>
</div>

<!-- Quick Actions -->
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;margin-bottom:2rem;">
    <a href="index.php?page=customer/reservasi/create" style="background:linear-gradient(135deg,var(--clr-brown-deep),var(--clr-brown));color:#fff;padding:1.25rem;border-radius:20px;text-decoration:none;display:flex;align-items:center;gap:1rem;transition:all 0.3s;box-shadow:0 8px 25px rgba(61,43,31,0.2);" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="width:46px;height:46px;background:rgba(201,168,124,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--clr-gold);flex-shrink:0;"><i class="fas fa-calendar-plus"></i></div>
        <div><div style="font-weight:700;font-size:0.9rem;">Booking Baru</div><div style="font-size:0.75rem;opacity:0.7;margin-top:2px;">Reservasi makeup baru</div></div>
    </a>
    <a href="index.php?page=customer/reservasi/riwayat" style="background:#fff;color:var(--clr-brown-deep);padding:1.25rem;border-radius:20px;text-decoration:none;display:flex;align-items:center;gap:1rem;transition:all 0.3s;border:1.5px solid rgba(232,196,196,0.3);box-shadow:0 4px 15px rgba(107,76,59,0.06);" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="width:46px;height:46px;background:rgba(201,168,124,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--clr-gold);flex-shrink:0;"><i class="fas fa-history"></i></div>
        <div><div style="font-weight:700;font-size:0.9rem;">Riwayat Booking</div><div style="font-size:0.75rem;color:var(--clr-muted);margin-top:2px;"><?= count($reservasi) ?> total booking</div></div>
    </a>
    <a href="index.php" style="background:#fff;color:var(--clr-brown-deep);padding:1.25rem;border-radius:20px;text-decoration:none;display:flex;align-items:center;gap:1rem;transition:all 0.3s;border:1.5px solid rgba(232,196,196,0.3);box-shadow:0 4px 15px rgba(107,76,59,0.06);" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="width:46px;height:46px;background:rgba(201,168,124,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--clr-gold);flex-shrink:0;"><i class="fas fa-globe"></i></div>
        <div><div style="font-weight:700;font-size:0.9rem;">Halaman Utama</div><div style="font-size:0.75rem;color:var(--clr-muted);margin-top:2px;">Lihat paket & promo</div></div>
    </a>
</div>

<!-- Recent Bookings -->
<div style="background:#fff;border-radius:20px;border:1px solid rgba(232,196,196,0.25);box-shadow:0 4px 20px rgba(107,76,59,0.06);overflow:hidden;">
    <div style="padding:1.5rem;border-bottom:1px solid rgba(232,196,196,0.2);display:flex;justify-content:space-between;align-items:center;">
        <h3 style="font-family:var(--font-display);font-size:1.25rem;font-weight:600;">Reservasi Saya</h3>
        <a href="index.php?page=customer/reservasi/create" style="background:var(--clr-gold);color:var(--clr-brown-deep);padding:0.5rem 1.25rem;border-radius:50px;font-size:0.82rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> Booking Baru
        </a>
    </div>

    <?php if (empty($reservasi)): ?>
    <div style="padding:4rem;text-align:center;color:var(--clr-muted);">
        <i class="fas fa-calendar-times" style="font-size:3rem;opacity:0.3;"></i>
        <p style="margin-top:1rem;font-size:0.95rem;">Belum ada reservasi.</p>
        <a href="index.php?page=customer/reservasi/create" style="display:inline-block;margin-top:1rem;background:var(--clr-gold);color:var(--clr-brown-deep);padding:0.7rem 1.75rem;border-radius:50px;font-weight:600;font-size:0.88rem;text-decoration:none;">
            Mulai Booking Sekarang
        </a>
    </div>
    <?php else: ?>
    <div style="padding:0.5rem;">
        <?php foreach (array_slice($reservasi, 0, 10) as $res):
            $tgl = $res['tanggal_reservasi'] ? new DateTime($res['tanggal_reservasi']) : null;
            $tglStr = $tgl ? $tgl->format('d') . ' ' . $bulanArr[(int)$tgl->format('n')] . ' ' . $tgl->format('Y') : '-';
            $statusColors = [
                'pending'     => ['bg'=>'rgba(232,198,110,0.12)','c'=>'#7A5C00','label'=>'Menunggu Konfirmasi'],
                'dikonfirmasi'=> ['bg'=>'rgba(122,179,212,0.12)','c'=>'#1A4E6B','label'=>'Dikonfirmasi'],
                'selesai'     => ['bg'=>'rgba(109,190,143,0.12)','c'=>'#1E6040','label'=>'Selesai'],
                'batal'       => ['bg'=>'rgba(232,112,112,0.1)','c'=>'#B03030','label'=>'Dibatalkan'],
            ];
            $sc = $statusColors[$res['status']] ?? $statusColors['pending'];
            $bayarColors = [
                'belum' => ['bg'=>'rgba(232,112,112,0.1)','c'=>'#B03030','label'=>'Belum Bayar'],
                'dp'    => ['bg'=>'rgba(232,198,110,0.12)','c'=>'#7A5C00','label'=>'DP Dibayar'],
                'lunas' => ['bg'=>'rgba(109,190,143,0.12)','c'=>'#1E6040','label'=>'Lunas'],
            ];
            $bc = $bayarColors[$res['status_pembayaran']] ?? $bayarColors['belum'];
        ?>
        <div style="padding:1.25rem;border-bottom:1px solid rgba(232,196,196,0.15);display:flex;gap:1rem;align-items:center;transition:background 0.2s;" onmouseover="this.style.background='rgba(253,248,245,0.8)'" onmouseout="this.style.background=''">
            <!-- Date Box -->
            <div style="width:52px;height:56px;background:rgba(201,168,124,0.1);border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(201,168,124,0.25);">
                <div style="font-family:var(--font-display);font-size:1.3rem;font-weight:700;color:var(--clr-brown-deep);line-height:1;"><?= $tgl ? $tgl->format('d') : '-' ?></div>
                <div style="font-size:0.65rem;font-weight:600;color:var(--clr-gold);text-transform:uppercase;"><?= $tgl ? $bulanArr[(int)$tgl->format('n')] : '-' ?></div>
            </div>
            <!-- Info -->
            <div style="flex:1;min-width:0;">
                <div style="font-weight:600;font-size:0.9rem;color:var(--clr-brown-deep);margin-bottom:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    <?= htmlspecialchars($res['nama_paket'] ?? 'Paket Dihapus') ?>
                </div>
                <div style="font-size:0.77rem;color:var(--clr-muted);">
                    <?= $res['is_full_day'] ? 'Full Day' : (($res['jam_mulai'] ?? '-') . ' – ' . ($res['jam_selesai'] ?? '-') . ' WIB') ?>
                    &nbsp;·&nbsp;
                    <?= $res['jenis_lokasi'] === 'studio' ? 'Studio' : 'Home Visit' ?>
                </div>
                <div style="margin-top:6px;display:flex;gap:6px;flex-wrap:wrap;">
                    <span style="display:inline-block;padding:2px 10px;border-radius:20px;font-size:0.72rem;font-weight:600;background:<?= $sc['bg'] ?>;color:<?= $sc['c'] ?>;"><?= $sc['label'] ?></span>
                    <span style="display:inline-block;padding:2px 10px;border-radius:20px;font-size:0.72rem;font-weight:600;background:<?= $bc['bg'] ?>;color:<?= $bc['c'] ?>;"><?= $bc['label'] ?></span>
                </div>
            </div>
            <!-- Price + Action -->
            <div style="text-align:right;flex-shrink:0;">
                <div style="font-family:var(--font-display);font-size:1rem;font-weight:600;color:var(--clr-gold);">Rp <?= number_format((float)($res['total_harga'] ?? 0), 0, ',', '.') ?></div>
                <div style="font-size:0.72rem;color:var(--clr-muted);">DP: Rp <?= number_format((float)($res['total_dp'] ?? 0), 0, ',', '.') ?></div>
                <a href="index.php?page=customer/reservasi/konfirmasi&id=<?= $res['id'] ?>" style="display:inline-block;margin-top:6px;background:var(--clr-brown-deep);color:#fff;padding:4px 14px;border-radius:20px;font-size:0.72rem;font-weight:600;text-decoration:none;">
                    Detail
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if (count($reservasi) > 10): ?>
    <div style="padding:1rem;text-align:center;">
        <a href="index.php?page=customer/reservasi/riwayat" style="color:var(--clr-gold);font-size:0.85rem;font-weight:600;text-decoration:none;">
            Lihat semua <?= count($reservasi) ?> reservasi →
        </a>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>