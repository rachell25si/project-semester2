<?php 
$pageTitle = 'Manajemen Reservasi'; 
$reservasi = $reservasi ?? [];
$stats = $stats ?? [];
?>

<!-- Filters -->
<div style="background:#fff;border-radius:20px;padding:1.25rem 1.5rem;border:1px solid rgba(232,196,196,0.2);box-shadow:0 4px 15px rgba(107,76,59,0.05);margin-bottom:1.5rem;">
    <div style="display:flex;gap:1rem;align-items:center;flex-wrap:wrap;">
        <input type="text" id="searchInput" placeholder="🔍  Cari nama customer, paket..." oninput="filterTable()" style="flex:1;min-width:200px;padding:0.65rem 1rem;border-radius:50px;border:1.5px solid rgba(232,196,196,0.4);background:var(--clr-cream);font-family:var(--font-body);font-size:0.88rem;outline:none;transition:border 0.2s;" onfocus="this.style.borderColor='var(--clr-gold)'" onblur="this.style.borderColor='rgba(232,196,196,0.4)'">
        <select id="filterStatus" onchange="filterTable()" style="padding:0.65rem 1rem;border-radius:50px;border:1.5px solid rgba(232,196,196,0.4);background:var(--clr-cream);font-family:var(--font-body);font-size:0.88rem;outline:none;cursor:pointer;">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="dikonfirmasi">Dikonfirmasi</option>
            <option value="selesai">Selesai</option>
            <option value="batal">Batal</option>
        </select>
        <select id="filterBayar" onchange="filterTable()" style="padding:0.65rem 1rem;border-radius:50px;border:1.5px solid rgba(232,196,196,0.4);background:var(--clr-cream);font-family:var(--font-body);font-size:0.88rem;outline:none;cursor:pointer;">
            <option value="">Semua Pembayaran</option>
            <option value="belum">Belum Bayar</option>
            <option value="dp">DP Dibayar</option>
            <option value="lunas">Lunas</option>
        </select>
        <div style="font-size:0.82rem;color:var(--clr-muted);white-space:nowrap;">
            Total: <strong><?= count($reservasi) ?></strong> data
        </div>
    </div>
</div>

<!-- Table -->
<div style="background:#fff;border-radius:20px;border:1px solid rgba(232,196,196,0.2);box-shadow:0 4px 20px rgba(107,76,59,0.06);overflow:hidden;">
    <div style="overflow-x:auto;">
        <table id="reservasiTable" style="width:100%;border-collapse:collapse;font-size:0.88rem;">
            <thead>
                <tr style="background:var(--clr-cream-2);">
                    <?php foreach (['#','Customer','Telp','Paket','Tanggal','Waktu','Lokasi','Status','Pembayaran','Total Harga','DP','Aksi'] as $h): ?>
                    <th style="padding:0.9rem 1rem;text-align:left;font-size:0.72rem;font-weight:600;color:var(--clr-muted);letter-spacing:0.5px;text-transform:uppercase;white-space:nowrap;"><?= $h ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody id="reservasiBody">
                <?php foreach ($reservasi as $res):
                    $tgl_str = !empty($res['tanggal_reservasi']) && $res['tanggal_reservasi'] !== '0000-00-00' ? $res['tanggal_reservasi'] : null;
                    $tgl = $tgl_str ? new DateTime($tgl_str) : null;
                    
                    $status = $res['status'] ?? 'pending';
                    $statusBayar = $res['status_pembayaran'] ?? 'belum';
                    
                    $sc_map = [
                        'pending'     => 'rgba(232,198,110,0.12);color:#7A5C00;',
                        'dikonfirmasi'=> 'rgba(122,179,212,0.12);color:#1A4E6B;',
                        'selesai'     => 'rgba(109,190,143,0.12);color:#1E6040;',
                        'batal'       => 'rgba(232,112,112,0.1);color:#B03030;',
                    ];
                    $sc = $sc_map[$status] ?? $sc_map['pending'];
                    
                    $bc_map = [
                        'belum' => 'rgba(232,112,112,0.1);color:#B03030;',
                        'dp'    => 'rgba(232,198,110,0.12);color:#7A5C00;',
                        'lunas' => 'rgba(109,190,143,0.12);color:#1E6040;',
                    ];
                    $bc = $bc_map[$statusBayar] ?? $bc_map['belum'];
                    
                    $bLabel_map = ['belum'=>'Belum','dp'=>'DP','lunas'=>'Lunas'];
                    $bLabel = $bLabel_map[$statusBayar] ?? '-';
                    
                    $sLabel_map = ['pending'=>'Pending','dikonfirmasi'=>'Dikonfirmasi','selesai'=>'Selesai','batal'=>'Batal'];
                    $sLabel = $sLabel_map[$status] ?? '-';
                    
                    $hp = $res['no_hp'] ?? $res['customer_hp'] ?? '-';
                ?>
                <tr class="res-row" 
                    data-status="<?= $status ?>" 
                    data-bayar="<?= $statusBayar ?>"
                    data-search="<?= strtolower(($res['customer_nama']??'').' '.($res['nama_paket']??'').' '.($hp)) ?>"
                    style="border-bottom:1px solid rgba(232,196,196,0.12);transition:background 0.2s;" 
                    onmouseover="this.style.background='rgba(253,248,245,0.8)'" 
                    onmouseout="this.style.background=''">
                    <td style="padding:0.85rem 1rem;color:var(--clr-muted);font-size:0.78rem;">#<?= $res['id'] ?? 0 ?></td>
                    <td style="padding:0.85rem 1rem;font-weight:600;white-space:nowrap;"><?= htmlspecialchars($res['customer_nama'] ?? '-') ?></td>
                    <td style="padding:0.85rem 1rem;font-size:0.8rem;color:var(--clr-muted);"><?= htmlspecialchars($hp) ?></td>
                    <td style="padding:0.85rem 1rem;white-space:nowrap;"><?= htmlspecialchars($res['nama_paket'] ?? '-') ?></td>
                    <td style="padding:0.85rem 1rem;white-space:nowrap;"><?= $tgl ? $tgl->format('d M Y') : '-' ?></td>
                    <td style="padding:0.85rem 1rem;white-space:nowrap;"><?= !empty($res['is_full_day']) ? '<span style="color:var(--clr-gold);font-weight:600;">Full Day</span>' : (($res['jam_mulai']??'-') . ' – ' . ($res['jam_selesai']??'-')) ?></td>
                    <td style="padding:0.85rem 1rem;"><?= $res['jenis_lokasi'] === 'studio' ? 'Studio' : 'Home Visit' ?></td>
                    <td style="padding:0.85rem 1rem;">
                        <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:600;background:<?= $sc ?>"><?= $sLabel ?></span>
                    </td>
                    <td style="padding:0.85rem 1rem;">
                        <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:600;background:<?= $bc ?>"><?= $bLabel ?></span>
                    </td>
                    <td style="padding:0.85rem 1rem;font-weight:600;color:var(--clr-gold);white-space:nowrap;">Rp <?= number_format((float)($res['total_harga'] ?? 0),0,',','.') ?></td>
                    <td style="padding:0.85rem 1rem;font-size:0.82rem;white-space:nowrap;">Rp <?= number_format((float)($res['total_dp'] ?? 0),0,',','.') ?></td>
                    <td style="padding:0.85rem 1rem;white-space:nowrap;">
                        <a href="index.php?page=admin/reservasi/detail&id=<?= $res['id'] ?>" style="background:var(--clr-brown-deep);color:#fff;padding:4px 14px;border-radius:20px;font-size:0.75rem;font-weight:600;text-decoration:none;white-space:nowrap;">Detail</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('filterStatus').value;
    const bayar  = document.getElementById('filterBayar').value;
    document.querySelectorAll('.res-row').forEach(row => {
        const matchSearch = !search || row.dataset.search.includes(search);
        const matchStatus = !status || row.dataset.status === status;
        const matchBayar  = !bayar  || row.dataset.bayar  === bayar;
        row.style.display = (matchSearch && matchStatus && matchBayar) ? '' : 'none';
    });
}
</script>