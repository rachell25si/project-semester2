<?php
$pageTitle = 'Dashboard Admin';
$bulanArr = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
?>

<!-- KPI Stats -->
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1.25rem;margin-bottom:2rem;">
    <?php
    $kpis = [
        ['icon'=>'fas fa-calendar-check', 'color'=>'gold',  'val'=>$stats['total_reservasi']??0,  'label'=>'Total Reservasi',  'format'=>'num'],
        ['icon'=>'fas fa-clock',          'color'=>'blue',  'val'=>$stats['pending']??0,           'label'=>'Menunggu Konfirmasi','format'=>'num'],
        ['icon'=>'fas fa-check-double',   'color'=>'green', 'val'=>$stats['selesai']??0,           'label'=>'Selesai',          'format'=>'num'],
        ['icon'=>'fas fa-money-bill-wave','color'=>'rose',  'val'=>$stats['total_pendapatan']??0,  'label'=>'Total Pendapatan',  'format'=>'idr'],
        ['icon'=>'fas fa-wallet',         'color'=>'gold',  'val'=>$stats['total_dp_masuk']??0,    'label'=>'DP Masuk',          'format'=>'idr'],
    ];
    foreach ($kpis as $kpi):
        $val = $kpi['format'] === 'idr' ? 'Rp ' . number_format((float)$kpi['val'], 0, ',', '.') : number_format((int)$kpi['val']);
    ?>
    <div style="background:#fff;border-radius:20px;padding:1.5rem;border:1px solid rgba(232,196,196,0.2);box-shadow:0 4px 20px rgba(107,76,59,0.06);transition:all 0.3s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 35px rgba(107,76,59,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 20px rgba(107,76,59,0.06)'">
        <div style="width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin-bottom:1rem;<?php
            $icolors = [
                'gold'  => 'background:rgba(201,168,124,0.12);color:var(--clr-gold);',
                'blue'  => 'background:rgba(122,179,212,0.12);color:#2A6D8F;',
                'green' => 'background:rgba(109,190,143,0.12);color:#2D7A50;',
                'rose'  => 'background:rgba(168,112,112,0.12);color:#A87070;',
            ];
            echo $icolors[$kpi['color']]; ?>">
            <i class="<?= $kpi['icon'] ?>"></i>
        </div>
        <div style="font-family:var(--font-display);font-size:1.6rem;font-weight:600;color:var(--clr-brown-deep);line-height:1.1;"><?= $val ?></div>
        <div style="font-size:0.78rem;color:var(--clr-muted);margin-top:4px;font-weight:500;"><?= $kpi['label'] ?></div>
    </div>
    <?php endforeach; ?>
</div>


    <!-- Quick Actions -->
    <div style="background:#fff;border-radius:20px;padding:1.5rem;border:1px solid rgba(232,196,196,0.2);box-shadow:0 4px 20px rgba(107,76,59,0.06);">
        <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:600;margin-bottom:1.25rem;">Menu Cepat</h3>
        <?php
        $qas = [
            ['url'=>'admin/reservasi',    'icon'=>'fas fa-calendar-alt', 'label'=>'Kelola Reservasi',  'desc'=>'Lihat & update status'],
            ['url'=>'admin/paket',        'icon'=>'fas fa-box-open',     'label'=>'Kelola Paket',       'desc'=>'Tambah / edit paket'],
            ['url'=>'admin/laporan',      'icon'=>'fas fa-chart-bar',    'label'=>'Laporan Keuangan',   'desc'=>'Pendapatan & transaksi'],
            ['url'=>'admin/hari_libur',   'icon'=>'fas fa-calendar-times','label'=>'Atur Hari Libur',  'desc'=>'Blok tanggal libur'],
        ];
        foreach ($qas as $qa): ?>
        <a href="index.php?page=<?= $qa['url'] ?>" style="display:flex;align-items:center;gap:0.85rem;padding:0.85rem;border-radius:14px;transition:all 0.2s;text-decoration:none;margin-bottom:0.5rem;" onmouseover="this.style.background='rgba(201,168,124,0.08)'" onmouseout="this.style.background=''">
            <div style="width:40px;height:40px;background:rgba(201,168,124,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--clr-gold);font-size:1rem;flex-shrink:0;">
                <i class="<?= $qa['icon'] ?>"></i>
            </div>
            <div>
                <div style="font-weight:600;font-size:0.88rem;color:var(--clr-brown-deep);"><?= $qa['label'] ?></div>
                <div style="font-size:0.75rem;color:var(--clr-muted);"><?= $qa['desc'] ?></div>
            </div>
            <i class="fas fa-chevron-right" style="margin-left:auto;color:rgba(156,126,112,0.4);font-size:0.75rem;"></i>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Recent Reservations Table -->
<div style="background:#fff;border-radius:20px;border:1px solid rgba(232,196,196,0.2);box-shadow:0 4px 20px rgba(107,76,59,0.06);overflow:hidden;">
    <div style="padding:1.25rem 1.5rem;border-bottom:1px solid rgba(232,196,196,0.2);display:flex;justify-content:space-between;align-items:center;">
        <h3 style="font-family:var(--font-display);font-size:1.15rem;font-weight:600;">Reservasi Terbaru</h3>
        <a href="index.php?page=admin/reservasi" style="font-size:0.82rem;color:var(--clr-gold);font-weight:600;text-decoration:none;">Lihat Semua →</a>
    </div>
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:0.88rem;">
            <thead>
                <tr style="background:var(--clr-cream-2);">
                    <th style="padding:0.85rem 1.25rem;text-align:left;font-size:0.75rem;font-weight:600;color:var(--clr-muted);letter-spacing:0.5px;text-transform:uppercase;white-space:nowrap;">#</th>
                    <th style="padding:0.85rem 1.25rem;text-align:left;font-size:0.75rem;font-weight:600;color:var(--clr-muted);letter-spacing:0.5px;text-transform:uppercase;white-space:nowrap;">Customer</th>
                    <th style="padding:0.85rem 1.25rem;text-align:left;font-size:0.75rem;font-weight:600;color:var(--clr-muted);letter-spacing:0.5px;text-transform:uppercase;white-space:nowrap;">Paket</th>
                    <th style="padding:0.85rem 1.25rem;text-align:left;font-size:0.75rem;font-weight:600;color:var(--clr-muted);letter-spacing:0.5px;text-transform:uppercase;white-space:nowrap;">Tanggal</th>
                    <th style="padding:0.85rem 1.25rem;text-align:left;font-size:0.75rem;font-weight:600;color:var(--clr-muted);letter-spacing:0.5px;text-transform:uppercase;white-space:nowrap;">Status</th>
                    <th style="padding:0.85rem 1.25rem;text-align:left;font-size:0.75rem;font-weight:600;color:var(--clr-muted);letter-spacing:0.5px;text-transform:uppercase;white-space:nowrap;">Pembayaran</th>
                    <th style="padding:0.85rem 1.25rem;text-align:left;font-size:0.75rem;font-weight:600;color:var(--clr-muted);letter-spacing:0.5px;text-transform:uppercase;white-space:nowrap;">Total</th>
                    <th style="padding:0.85rem 1.25rem;text-align:left;font-size:0.75rem;font-weight:600;color:var(--clr-muted);letter-spacing:0.5px;text-transform:uppercase;white-space:nowrap;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reservasi)): ?>
                <tr><td colspan="8" style="padding:3rem;text-align:center;color:var(--clr-muted);">Belum ada reservasi</td></tr>
                <?php else: ?>
                <?php foreach ($reservasi as $res):
                    $tgl_str = !empty($res['tanggal_reservasi']) && $res['tanggal_reservasi'] !== '0000-00-00' ? $res['tanggal_reservasi'] : null;
                    $tgl = $tgl_str ? new DateTime($tgl_str) : null;
                    
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
                    
                    $bLabel_map = ['belum'=>'Belum','dp'=>'DP Bayar','lunas'=>'Lunas'];
                    $bLabel = $bLabel_map[$statusBayar] ?? '-';
                    
                    $sLabel_map = ['pending'=>'Pending','dikonfirmasi'=>'Dikonfirmasi','selesai'=>'Selesai','batal'=>'Batal'];
                    $sLabel = $sLabel_map[$status] ?? '-';
                ?>
                <tr style="border-bottom:1px solid rgba(232,196,196,0.15);transition:background 0.2s;" onmouseover="this.style.background='rgba(253,248,245,0.8)'" onmouseout="this.style.background=''">
                    <td style="padding:0.85rem 1.25rem;color:var(--clr-muted);font-size:0.8rem;">#<?= $res['id'] ?></td>
                    <td style="padding:0.85rem 1.25rem;font-weight:600;white-space:nowrap;"><?= htmlspecialchars($res['customer_nama'] ?? '-') ?></td>
                    <td style="padding:0.85rem 1.25rem;white-space:nowrap;"><?= htmlspecialchars($res['nama_paket'] ?? '-') ?></td>
                    <td style="padding:0.85rem 1.25rem;white-space:nowrap;color:var(--clr-brown);"><?= $tgl ? $tgl->format('d M Y') : '-' ?></td>
                    <td style="padding:0.85rem 1.25rem;">
                        <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:600;<?= $sc ?>"><?= $sLabel ?></span>
                    </td>
                    <td style="padding:0.85rem 1.25rem;">
                        <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:600;<?= $bc ?>"><?= $bLabel ?></span>
                    </td>
                    <td style="padding:0.85rem 1.25rem;font-weight:600;color:var(--clr-gold);white-space:nowrap;">Rp <?= number_format((float)($res['total_harga'] ?? 0),0,',','.') ?></td>
                    <td style="padding:0.85rem 1.25rem;">
                        <a href="index.php?page=admin/reservasi/detail&id=<?= $res['id'] ?>" style="background:var(--clr-brown-deep);color:#fff;padding:4px 14px;border-radius:20px;font-size:0.75rem;font-weight:600;text-decoration:none;white-space:nowrap;">Detail</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

