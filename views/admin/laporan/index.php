<?php 
$pageTitle = 'Laporan Keuangan'; 

$bulanFull = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

$selectedYear    = $selectedYear ?? date('Y');
$yearList        = $yearList ?? [['tahun' => date('Y')]];
$totalBooking    = $totalBooking ?? 0;
$totalTagihan    = $totalTagihan ?? 0;
$totalDpMasuk    = $totalDpMasuk ?? 0;
$totalLunas      = $totalLunas ?? 0;
$topPaket        = $topPaket ?? [];
$monthly         = $monthly ?? [];
$yearlyAll       = $yearlyAll ?? [];
$chartLabels     = $chartLabels ?? '[]';
$chartPendapatan = $chartPendapatan ?? '[]';
$chartBooking    = $chartBooking ?? '[]';
?>
<style>
/* ── Laporan Keuangan Page Styles ────────────────────────────── */
.lap-summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px,1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}
.lap-kpi {
    background: #fff;
    border-radius: 20px;
    padding: 1.4rem 1.5rem;
    border: 1px solid rgba(232,196,196,0.2);
    box-shadow: 0 4px 20px rgba(107,76,59,0.06);
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
    transition: transform 0.25s, box-shadow 0.25s;
}
.lap-kpi:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(107,76,59,0.1); }
.lap-kpi-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; margin-bottom: 0.5rem;
}
.lap-kpi-val {
    font-family: var(--font-display);
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--clr-brown-deep);
    line-height: 1.1;
}
.lap-kpi-label { font-size: 0.75rem; color: var(--clr-muted); font-weight: 500; }

.lap-filter-bar {
    background: #fff;
    border-radius: 18px;
    padding: 1rem 1.5rem;
    border: 1px solid rgba(232,196,196,0.2);
    box-shadow: 0 4px 20px rgba(107,76,59,0.06);
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.lap-filter-bar label { font-size: 0.85rem; font-weight: 600; color: var(--clr-muted); white-space: nowrap; }
.lap-filter-bar select {
    font-family: var(--font-body);
    font-size: 0.88rem;
    padding: 0.5rem 1.2rem;
    border-radius: 50px;
    border: 1.5px solid rgba(201,168,124,0.4);
    background: var(--clr-cream);
    color: var(--clr-brown-deep);
    cursor: pointer;
    outline: none;
    font-weight: 600;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239C7E70' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    padding-right: 2.5rem;
}
.lap-filter-bar select:focus { border-color: var(--clr-gold); }
.lap-filter-bar button {
    background: var(--clr-brown-deep);
    color: #fff;
    font-family: var(--font-body);
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.5rem 1.4rem;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
    display: inline-flex; align-items: center; gap: 0.4rem;
}
.lap-filter-bar button:hover { background: var(--clr-gold); color: var(--clr-brown-deep); transform: translateY(-1px); }

.lap-section {
    background: #fff;
    border-radius: 20px;
    border: 1px solid rgba(232,196,196,0.2);
    box-shadow: 0 4px 20px rgba(107,76,59,0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.lap-section-header {
    padding: 1.1rem 1.5rem;
    border-bottom: 1px solid rgba(232,196,196,0.2);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.lap-section-header h3 {
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 600;
    display: flex; align-items: center; gap: 0.5rem;
    color: var(--clr-brown-deep);
}
.lap-section-header h3 i { color: var(--clr-gold); font-size: 0.9rem; }

.lap-chart-wrap { padding: 1.25rem 1.5rem; }

.lap-table-wrap { overflow-x: auto; }
.lap-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
}
.lap-table thead tr { background: var(--clr-cream-2); }
.lap-table th {
    padding: 0.8rem 1.2rem;
    text-align: left;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--clr-muted);
    letter-spacing: 0.5px;
    text-transform: uppercase;
    white-space: nowrap;
}
.lap-table td {
    padding: 0.8rem 1.2rem;
    border-bottom: 1px solid rgba(232,196,196,0.12);
    white-space: nowrap;
}
.lap-table tbody tr:last-child td { border-bottom: none; }
.lap-table tbody tr:hover td { background: rgba(253,248,245,0.8); }
.lap-table .td-month { font-weight: 600; color: var(--clr-brown-deep); }
.lap-table .td-num { font-weight: 500; color: var(--clr-brown); text-align: right; }
.lap-table .td-money { font-weight: 700; color: var(--clr-gold); text-align: right; }
.lap-table .td-green { font-weight: 700; color: #1E6040; text-align: right; }
.lap-table .td-center { text-align: center; }
.lap-table tfoot tr td { font-weight: 700; background: rgba(201,168,124,0.07); }
.lap-table tfoot .td-total-label { color: var(--clr-brown-deep); font-family: var(--font-display); font-size: 0.95rem; }

.lap-two-col { display: grid; grid-template-columns: 1fr 300px; gap: 1.5rem; margin-bottom: 1.5rem; }
.lap-full { margin-bottom: 1.5rem; }

.lap-paket-bar {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.7rem 0;
    border-bottom: 1px dashed rgba(232,196,196,0.25);
}
.lap-paket-bar:last-child { border-bottom: none; }
.lap-paket-rank {
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(201,168,124,0.12);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; font-weight: 700;
    color: var(--clr-gold); flex-shrink: 0;
}
.lap-paket-info { flex: 1; min-width: 0; }
.lap-paket-name { font-size: 0.85rem; font-weight: 600; color: var(--clr-brown-deep); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.lap-paket-count { font-size: 0.72rem; color: var(--clr-muted); }
.lap-paket-amount { font-size: 0.85rem; font-weight: 700; color: var(--clr-gold); flex-shrink: 0; }

.badge-bulan { display: inline-flex; align-items: center; padding: 2px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; }
.badge-bulan.has-data { background: rgba(109,190,143,0.1); color: #1E6040; }
.badge-bulan.no-data { background: rgba(232,196,196,0.2); color: var(--clr-muted); }

@media (max-width: 768px) {
    .lap-two-col { grid-template-columns: 1fr; }
}
</style>

<!-- Page Title -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.75rem;flex-wrap:wrap;gap:1rem;">
    <div>
        <h2 style="font-family:var(--font-display);font-size:1.6rem;font-weight:600;color:var(--clr-brown-deep);line-height:1.1;">
            <i class="fas fa-chart-bar" style="color:var(--clr-gold);font-size:1.2rem;"></i>
            Laporan Keuangan
        </h2>
        <p style="font-size:0.82rem;color:var(--clr-muted);margin-top:4px;">Ringkasan pendapatan & transaksi pembayaran</p>
    </div>
    <a href="index.php?page=admin/laporan&export=1&year=<?= $selectedYear ?>"
       style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(201,168,124,0.1);border:1px solid rgba(201,168,124,0.35);color:var(--clr-brown);padding:0.55rem 1.3rem;border-radius:50px;font-size:0.83rem;font-weight:600;text-decoration:none;transition:all 0.2s;"
       onmouseover="this.style.background='rgba(201,168,124,0.2)'" onmouseout="this.style.background='rgba(201,168,124,0.1)'">
        <i class="fas fa-download"></i> Ekspor CSV
    </a>
</div>

<!-- Filter Bar -->
<form method="GET" action="" class="lap-filter-bar">
    <input type="hidden" name="page" value="admin/laporan">
    <label><i class="fas fa-filter" style="margin-right:4px;"></i> Filter Tahun:</label>
    <select name="year" id="yearSelect">
        <?php foreach ($yearList as $y): ?>
        <option value="<?= $y['tahun'] ?>" <?= $y['tahun'] == $selectedYear ? 'selected' : '' ?>>
            <?= $y['tahun'] ?>
        </option>
        <?php endforeach; ?>
    </select>
    <button type="submit"><i class="fas fa-search"></i> Tampilkan</button>
</form>

<!-- KPI Summary -->
<div class="lap-summary-grid">
    <?php
    $kpis = [
        ['icon' => 'fas fa-calendar-check', 'bg' => 'rgba(122,179,212,0.12)', 'color' => '#2A6D8F',
         'val' => number_format((int)$totalBooking),
         'label' => 'Total Booking ' . $selectedYear, 'prefix' => ''],
        ['icon' => 'fas fa-money-bill-wave', 'bg' => 'rgba(201,168,124,0.12)', 'color' => 'var(--clr-gold)',
         'val' => 'Rp ' . number_format((float)$totalTagihan, 0, ',', '.'),
         'label' => 'Total Tagihan', 'prefix' => ''],
        ['icon' => 'fas fa-wallet', 'bg' => 'rgba(232,198,110,0.12)', 'color' => '#7A5C00',
         'val' => 'Rp ' . number_format((float)$totalDpMasuk, 0, ',', '.'),
         'label' => 'DP Masuk', 'prefix' => ''],
        ['icon' => 'fas fa-check-circle', 'bg' => 'rgba(109,190,143,0.12)', 'color' => '#1E6040',
         'val' => 'Rp ' . number_format((float)$totalLunas, 0, ',', '.'),
         'label' => 'Pendapatan Lunas', 'prefix' => ''],
    ];
    foreach ($kpis as $kpi):
    ?>
    <div class="lap-kpi">
        <div class="lap-kpi-icon" style="background:<?= $kpi['bg'] ?>;color:<?= $kpi['color'] ?>;">
            <i class="<?= $kpi['icon'] ?>"></i>
        </div>
        <div class="lap-kpi-val"><?= $kpi['val'] ?></div>
        <div class="lap-kpi-label"><?= $kpi['label'] ?></div>
    </div>
    <?php endforeach; ?>
</div>


    <!-- Top Paket -->
    <div class="lap-section">
        <div class="lap-section-header">
            <h3><i class="fas fa-trophy"></i> Paket Terlaris</h3>
        </div>
        <div style="padding:1rem 1.5rem;">
            <?php if (empty($topPaket)): ?>
            <div style="text-align:center;padding:2rem;color:var(--clr-muted);font-size:0.85rem;">
                <i class="fas fa-box-open" style="font-size:2rem;opacity:0.3;display:block;margin-bottom:0.5rem;"></i>
                Belum ada data
            </div>
            <?php else: ?>
            <?php foreach ($topPaket as $idx => $pk): ?>
            <div class="lap-paket-bar">
                <div class="lap-paket-rank"><?= $idx + 1 ?></div>
                <div class="lap-paket-info">
                    <div class="lap-paket-name"><?= htmlspecialchars($pk['nama_paket']) ?></div>
                    <div class="lap-paket-count"><?= $pk['jumlah'] ?> booking</div>
                </div>
                <div class="lap-paket-amount">Rp <?= number_format((float)($pk['total'] ?? 0), 0, ',', '.') ?></div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Monthly Detail Table -->
<div class="lap-section lap-full">
    <div class="lap-section-header">
        <h3><i class="fas fa-table"></i> Rincian Pendapatan Bulanan <?= $selectedYear ?></h3>
    </div>
    <div class="lap-table-wrap">
        <table class="lap-table">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th style="text-align:right;">Booking</th>
                    <th style="text-align:right;">Total Tagihan</th>
                    <th style="text-align:right;">DP Masuk</th>
                    <th style="text-align:right;">Pendapatan Lunas</th>
                    <th style="text-align:center;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monthly as $m => $row): ?>
                <tr>
                    <td class="td-month"><?= $bulanFull[$m] ?></td>
                    <td class="td-num"><?= number_format((int)$row['jumlah_booking']) ?></td>
                    <td class="td-money">Rp <?= number_format((float)$row['total_tagihan'], 0, ',', '.') ?></td>
                    <td class="td-num" style="text-align:right;">Rp <?= number_format((float)$row['total_dp_masuk'], 0, ',', '.') ?></td>
                    <td class="td-green">Rp <?= number_format((float)$row['pendapatan_lunas'], 0, ',', '.') ?></td>
                    <td class="td-center">
                        <?php if ($row['jumlah_booking'] > 0): ?>
                        <span class="badge-bulan has-data"><i class="fas fa-check" style="margin-right:4px;"></i><?= $row['jumlah_booking'] ?> booking</span>
                        <?php else: ?>
                        <span class="badge-bulan no-data">Kosong</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td class="td-total-label" colspan="1">TOTAL <?= $selectedYear ?></td>
                    <td class="td-num" style="font-weight:700;"><?= number_format((int)$totalBooking) ?></td>
                    <td class="td-money">Rp <?= number_format((float)$totalTagihan, 0, ',', '.') ?></td>
                    <td class="td-num" style="font-weight:700;text-align:right;">Rp <?= number_format((float)$totalDpMasuk, 0, ',', '.') ?></td>
                    <td class="td-green">Rp <?= number_format((float)$totalLunas, 0, ',', '.') ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Yearly Summary Table -->
<?php if (!empty($yearlyAll)): ?>
<div class="lap-section lap-full">
    <div class="lap-section-header">
        <h3><i class="fas fa-history"></i> Rekapitulasi Per Tahun</h3>
    </div>
    <div class="lap-table-wrap">
        <table class="lap-table">
            <thead>
                <tr>
                    <th>Tahun</th>
                    <th style="text-align:right;">Total Booking</th>
                    <th style="text-align:right;">Total Tagihan</th>
                    <th style="text-align:right;">DP Masuk</th>
                    <th style="text-align:right;">Pendapatan Lunas</th>
                    <th style="text-align:right;">Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($yearlyAll as $yr): ?>
                <tr>
                    <td class="td-month">
                        <a href="?page=admin/laporan&year=<?= $yr['tahun'] ?>"
                           style="color:var(--clr-gold);font-weight:700;text-decoration:none;">
                            <?= $yr['tahun'] ?> <i class="fas fa-external-link-alt" style="font-size:0.6rem;"></i>
                        </a>
                    </td>
                    <td class="td-num"><?= number_format((int)$yr['jumlah_booking']) ?></td>
                    <td class="td-money">Rp <?= number_format((float)$yr['total_tagihan'], 0, ',', '.') ?></td>
                    <td class="td-num" style="text-align:right;">Rp <?= number_format((float)$yr['total_dp_masuk'], 0, ',', '.') ?></td>
                    <td class="td-green">Rp <?= number_format((float)$yr['pendapatan_lunas'], 0, ',', '.') ?></td>
                    <td class="td-num"><?= number_format((int)$yr['jumlah_selesai']) ?> sesi</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<script>
(function() {
    const labels = <?= $chartLabels ?>;
    const pendapatanData = <?= $chartPendapatan ?>;
    const bookingData    = <?= $chartBooking ?>;

    const ctx = document.getElementById('incomeChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pendapatan Lunas (Rp)',
                    data: pendapatanData,
                    backgroundColor: 'rgba(201,168,124,0.55)',
                    borderColor: 'rgba(201,168,124,1)',
                    borderWidth: 2,
                    borderRadius: 7,
                    borderSkipped: false,
                    yAxisID: 'y',
                    order: 2,
                },
                {
                    label: 'Jumlah Booking',
                    data: bookingData,
                    type: 'line',
                    borderColor: 'rgba(109,190,143,1)',
                    backgroundColor: 'rgba(109,190,143,0.1)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgba(109,190,143,1)',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    tension: 0.4,
                    fill: false,
                    yAxisID: 'y2',
                    order: 1,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: { font: { family: 'Jost', size: 11 }, usePointStyle: true, boxWidth: 8, color: '#9C7E70' }
                },
                tooltip: {
                    backgroundColor: 'rgba(61,43,31,0.92)',
                    padding: 12, cornerRadius: 10,
                    titleFont: { family: 'Jost', size: 12 },
                    bodyFont: { family: 'Jost', size: 13 },
                    callbacks: {
                        label: ctx => {
                            if (ctx.datasetIndex === 0) {
                                return ' Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                            }
                            return ' ' + ctx.parsed.y + ' booking';
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { family: 'Jost', size: 11 }, color: '#9C7E70' } },
                y: {
                    position: 'left',
                    grid: { color: 'rgba(232,196,196,0.2)', drawBorder: false },
                    ticks: {
                        font: { family: 'Jost', size: 11 }, color: '#9C7E70',
                        callback: v => 'Rp ' + (v >= 1000000 ? (v/1000000).toFixed(1) + 'jt' : v.toLocaleString('id-ID'))
                    },
                    beginAtZero: true
                },
                y2: {
                    position: 'right',
                    grid: { display: false },
                    ticks: { font: { family: 'Jost', size: 11 }, color: '#6DBE8F', stepSize: 1 },
                    beginAtZero: true,
                    max: Math.max(...bookingData) + 2
                }
            }
        }
    });
})();
</script>
