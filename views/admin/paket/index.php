<?php $pageTitle = 'Kelola Paket Layanan'; ?>

<div style="background:#fff;border-radius:20px;border:1px solid rgba(232,196,196,0.25);box-shadow:0 4px 20px rgba(107,76,59,0.06);overflow:hidden;max-width:1000px;margin:0 auto;">
    <div style="padding:1.5rem;border-bottom:1px solid rgba(232,196,196,0.2);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <div>
            <h3 style="font-family:var(--font-display);font-size:1.3rem;font-weight:600;color:var(--clr-brown-deep);">Daftar Paket Layanan</h3>
            <p style="font-size:0.82rem;color:var(--clr-muted);margin-top:2px;">Tambah, edit, dan hapus paket kecantikan MUA ULVA</p>
        </div>
        <a href="index.php?page=admin/paket/create" style="background:var(--clr-gold);color:var(--clr-brown-deep);padding:0.6rem 1.5rem;border-radius:50px;font-size:0.85rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;" onmouseover="this.style.background='var(--clr-brown-deep)';this.style.color='var(--clr-gold)'" onmouseout="this.style.background='var(--clr-gold)';this.style.color='var(--clr-brown-deep)'">
            <i class="fas fa-plus"></i> Tambah Paket Baru
        </a>
    </div>

    <?php if (empty($paket)): ?>
    <div style="padding:4rem;text-align:center;color:var(--clr-muted);">
        <i class="fas fa-box-open" style="font-size:3rem;opacity:0.3;margin-bottom:1rem;display:block;"></i>
        Belum ada paket yang dibuat.
    </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table-premium">
            <thead>
                <tr>
                    <th style="padding:0.9rem 1.25rem;">Nama Paket</th>
                    <th style="padding:0.9rem 1.25rem;">Deskripsi</th>
                    <th style="padding:0.9rem 1.25rem;">Kategori</th>
                    <th style="padding:0.9rem 1.25rem;">Durasi</th>
                    <th style="padding:0.9rem 1.25rem;">DP%</th>
                    <th style="padding:0.9rem 1.25rem;text-align:right;">Harga</th>
                    <th style="padding:0.9rem 1.25rem;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paket ?? [] as $p): ?>
                <tr style="border-bottom:1px solid rgba(232,196,196,0.15);transition:background 0.2s;" onmouseover="this.style.background='rgba(253,248,245,0.8)'" onmouseout="this.style.background=''">
                    <td style="padding:0.85rem 1.25rem;font-weight:600;white-space:nowrap;"><?= htmlspecialchars($p['nama_paket']) ?></td>
                    <td style="padding:0.85rem 1.25rem;max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--clr-muted);"><?= htmlspecialchars($p['deskripsi'] ?? '-') ?></td>
                    <td style="padding:0.85rem 1.25rem;white-space:nowrap;">
                        <span style="display:inline-block;padding:2px 10px;border-radius:20px;font-size:0.75rem;font-weight:600;<?= ($p['kategori'] ?? 'regular') === 'wedding' ? 'background:rgba(201,168,124,0.15);color:#8B6914;border:1px solid rgba(201,168,124,0.4);' : 'background:rgba(156,126,112,0.1);color:var(--clr-muted);border:1px solid rgba(156,126,112,0.25);' ?>">
                            <?= ucfirst($p['kategori'] ?? 'regular') ?>
                        </span>
                    </td>
                    <td style="padding:0.85rem 1.25rem;white-space:nowrap;"><?= ($p['kategori'] ?? 'regular') === 'wedding' ? 'Full Day' : ($p['durasi_jam'] ?? 2) . ' jam' ?></td>
                    <td style="padding:0.85rem 1.25rem;white-space:nowrap;"><?= $p['dp_persen'] ?? 30 ?>%</td>
                    <td style="padding:0.85rem 1.25rem;font-weight:600;color:var(--clr-gold);text-align:right;white-space:nowrap;">Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                    <td style="padding:0.85rem 1.25rem;text-align:center;white-space:nowrap;">
                        <a href="index.php?page=admin/paket/edit&id=<?= $p['id'] ?>" style="background:var(--clr-brown-deep);color:#fff;padding:4px 12px;border-radius:20px;font-size:0.72rem;font-weight:600;text-decoration:none;margin-right:4px;">Edit</a>
                        <a href="index.php?page=admin/paket/delete&id=<?= $p['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan paket ini?')" style="background:rgba(232,112,112,0.1);color:#B03030;padding:4px 12px;border-radius:20px;font-size:0.72rem;font-weight:600;text-decoration:none;border:1px solid rgba(232,112,112,0.2);">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>