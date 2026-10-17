<?php $pageTitle = 'Atur Hari Libur Studio'; ?>

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;max-width:1000px;margin:0 auto;">
    
    <!-- Hari Libur List -->
    <div style="background:#fff;border-radius:20px;border:1px solid rgba(232,196,196,0.25);box-shadow:0 4px 20px rgba(107,76,59,0.06);overflow:hidden;">
        <div style="padding:1.5rem;border-bottom:1px solid rgba(232,196,196,0.2);">
            <h3 style="font-family:var(--font-display);font-size:1.25rem;font-weight:600;color:var(--clr-brown-deep);">Daftar Hari Libur Studio</h3>
            <p style="font-size:0.82rem;color:var(--clr-muted);margin-top:2px;">Tanggal-tanggal di mana studio tutup dan tidak menerima reservasi</p>
        </div>

        <?php if (empty($hariLibur)): ?>
        <div style="padding:4rem 2rem;text-align:center;color:var(--clr-muted);">
            <i class="fas fa-calendar-check" style="font-size:3rem;opacity:0.3;margin-bottom:1rem;display:block;"></i>
            Belum ada hari libur/cuti yang dijadwalkan.
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th style="padding:0.9rem 1.25rem;">Tanggal</th>
                        <th style="padding:0.9rem 1.25rem;">Keterangan</th>
                        <th style="padding:0.9rem 1.25rem;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $hariArr  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                    $bulanArr = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                    foreach ($hariLibur as $libur): 
                        $tgl_str = !empty($libur['tanggal']) && $libur['tanggal'] !== '0000-00-00' ? $libur['tanggal'] : null;
                        $tgl = $tgl_str ? new DateTime($tgl_str) : new DateTime();
                        $tglStr = $hariArr[$tgl->format('w')] . ', ' . $tgl->format('d') . ' ' . $bulanArr[(int)$tgl->format('n')] . ' ' . $tgl->format('Y');
                    ?>
                    <tr style="border-bottom:1px solid rgba(232,196,196,0.15);transition:background 0.2s;" onmouseover="this.style.background='rgba(253,248,245,0.8)'" onmouseout="this.style.background=''">
                        <td style="padding:0.85rem 1.25rem;font-weight:600;white-space:nowrap;color:var(--clr-danger);"><?= $tglStr ?></td>
                        <td style="padding:0.85rem 1.25rem;color:var(--clr-brown);"><?= htmlspecialchars($libur['keterangan'] ?? '-') ?></td>
                        <td style="padding:0.85rem 1.25rem;text-align:center;">
                            <a href="index.php?page=admin/hari_libur/delete&id=<?= $libur['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus libur ini?')" style="background:rgba(232,112,112,0.1);color:#B03030;padding:4px 12px;border-radius:20px;font-size:0.72rem;font-weight:600;text-decoration:none;border:1px solid rgba(232,112,112,0.2);">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- Add Hari Libur Form -->
    <div style="background:#fff;border-radius:20px;padding:1.5rem;border:1px solid rgba(232,196,196,0.25);box-shadow:0 4px 20px rgba(107,76,59,0.06);">
        <h3 style="font-family:var(--font-display);font-size:1.15rem;font-weight:600;color:var(--clr-brown-deep);margin-bottom:1rem;">Tambah Hari Libur</h3>
        
        <form method="POST" action="index.php?page=admin/hari_libur/store">
            <div class="form-group">
                <label class="form-label">Pilih Tanggal</label>
                <input type="date" name="tanggal" class="form-control" min="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Keterangan / Alasan</label>
                <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Cuti Bersama, Libur Lebaran..." required>
            </div>
            <button type="submit" style="width:100%;padding:0.8rem;border-radius:50px;background:var(--clr-brown-deep);color:#fff;font-family:var(--font-body);font-size:0.9rem;font-weight:600;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.4rem;" onmouseover="this.style.background='var(--clr-gold)';this.style.color='var(--clr-brown-deep)'" onmouseout="this.style.background='var(--clr-brown-deep)';this.style.color='#fff'">
                <i class="fas fa-plus"></i> Tambah Libur
            </button>
        </form>
    </div>

</div>
