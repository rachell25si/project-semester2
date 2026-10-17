<?php 
$pageTitle = 'Edit Paket Layanan'; 
$paket = $paket ?? [];
$portofolio = $portofolio ?? [];
?>

<div style="max-width:640px;margin:0 auto;">
    <a href="index.php?page=admin/paket" style="display:inline-flex;align-items:center;gap:0.5rem;color:var(--clr-muted);font-size:0.85rem;text-decoration:none;margin-bottom:1.5rem;transition:color 0.2s;" onmouseover="this.style.color='var(--clr-gold)'" onmouseout="this.style.color='var(--clr-muted)'">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Paket
    </a>

    <div style="background:#fff;border-radius:20px;padding:2rem;border:1px solid rgba(232,196,196,0.25);box-shadow:0 4px 20px rgba(107,76,59,0.06);">
        <h3 style="font-family:var(--font-display);font-size:1.4rem;font-weight:600;color:var(--clr-brown-deep);margin-bottom:1.5rem;">Form Edit Paket</h3>

        <form method="POST" action="index.php?page=admin/paket/edit&id=<?= $paket['id'] ?? '' ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Nama Paket</label>
                <input type="text" name="nama_paket" class="form-control" value="<?= htmlspecialchars($paket['nama_paket'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required><?= htmlspecialchars($paket['deskripsi'] ?? '') ?></textarea>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                <div class="form-group">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control" value="<?= (int)($paket['harga'] ?? 0) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-control" onchange="toggleKategori(this)">
                        <?php $kategori = $paket['kategori'] ?? 'regular'; ?>
                        <option value="regular" <?= $kategori === 'regular' ? 'selected' : '' ?>>Regular (Jam Terbatas)</option>
                        <option value="wedding" <?= $kategori === 'wedding' ? 'selected' : '' ?>>Wedding (Full Day / Block Day)</option>
                    </select>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                <div class="form-group" id="durasiGroup" style="<?= $kategori === 'wedding' ? 'opacity:0.5;' : '' ?>">
                    <label class="form-label">Durasi Layanan (Jam)</label>
                    <input type="number" name="durasi_jam" class="form-control" value="<?= $paket['durasi_jam'] ?? 2 ?>" min="1" max="24">
                </div>
                <div class="form-group">
                    <label class="form-label">Down Payment / DP (%)</label>
                    <input type="number" name="dp_persen" class="form-control" value="<?= $paket['dp_persen'] ?? 30 ?>" min="10" max="100" required>
                </div>
            </div>

            <!-- Existing Images -->
            <div class="form-group" style="margin-top:1.5rem;">
                <label class="form-label">Foto Portofolio Saat Ini</label>
                <?php if (!empty($portofolio)): ?>
                <div style="display:flex;flex-wrap:wrap;gap:1rem;">
                    <?php foreach ($portofolio as $img): ?>
                    <div style="position:relative;width:100px;height:100px;border-radius:12px;overflow:hidden;border:1px solid rgba(232,196,196,0.5);box-shadow:0 2px 10px rgba(0,0,0,0.05);">
                        <img src="<?= htmlspecialchars($img['gambar']) ?>" style="width:100%;height:100%;object-fit:cover;">
                        <button type="button" onclick="deleteImage(<?= $img['id'] ?>)" style="position:absolute;top:5px;right:5px;background:rgba(255,0,0,0.8);color:#fff;border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:0.7rem;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div style="font-size:0.75rem;color:var(--clr-muted);margin-top:0.5rem;">Gambar pertama akan menjadi gambar utama paket.</div>
                <?php else: ?>
                <div style="font-size:0.85rem;color:var(--clr-muted);padding:1rem;background:var(--clr-cream);border-radius:12px;text-align:center;">
                    Belum ada foto portofolio untuk paket ini.
                </div>
                <?php endif; ?>
            </div>

            <!-- Upload New Images -->
            <div class="form-group" style="margin-top:1.5rem;">
                <label class="form-label">Tambah Foto Baru <span style="font-weight:400;color:var(--clr-muted);">(Bisa pilih banyak)</span></label>
                <div class="upload-zone" onclick="document.getElementById('gambarInput').click()" style="border:2px dashed rgba(201,168,124,0.5);border-radius:16px;padding:2rem;text-align:center;cursor:pointer;background:var(--clr-cream);transition:all 0.3s;">
                    <i class="fas fa-images" style="font-size:2rem;color:var(--clr-gold);margin-bottom:0.5rem;"></i>
                    <p style="font-weight:600;color:var(--clr-brown-deep);">Klik untuk memilih foto</p>
                    <p style="font-size:0.75rem;margin-top:0.3rem;color:var(--clr-muted);">Bisa upload beberapa foto sekaligus (JPG, PNG, WebP)</p>
                </div>
                <input type="file" id="gambarInput" name="gambar[]" accept="image/*" multiple style="display:none;" onchange="previewImages(this)">
                <div id="previewContainer" style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-top:1rem;"></div>
            </div>

            <button type="submit" class="btn-submit" style="width:100%;padding:0.95rem;border-radius:50px;background:var(--clr-brown-deep);color:#fff;font-family:var(--font-body);font-size:0.95rem;font-weight:600;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;margin-top:1.5rem;" onmouseover="this.style.background='var(--clr-gold)';this.style.color='var(--clr-brown-deep)'" onmouseout="this.style.background='var(--clr-brown-deep)';this.style.color='#fff'">
                <i class="fas fa-check"></i> Update Paket
            </button>
        </form>
    </div>
</div>

<form id="deleteImageForm" method="POST" action="index.php?page=admin/paket/delete_image" style="display:none;">
    <input type="hidden" name="image_id" id="deleteImageId">
    <input type="hidden" name="paket_id" value="<?= $paket['id'] ?? '' ?>">
</form>

<script>
function toggleKategori(select) {
    const durasiGroup = document.getElementById('durasiGroup');
    const input = durasiGroup.querySelector('input');
    if (select.value === 'wedding') {
        input.value = 12;
        durasiGroup.style.opacity = '0.5';
    } else {
        input.value = 2;
        durasiGroup.style.opacity = '1';
    }
}

function previewImages(input) {
    const container = document.getElementById('previewContainer');
    container.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.style.position = 'relative';
                div.style.width = '70px';
                div.style.height = '70px';
                div.style.borderRadius = '8px';
                div.style.overflow = 'hidden';
                div.style.border = '1px solid rgba(201,168,124,0.3)';
                div.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}

function deleteImage(id) {
    if (confirm('Yakin ingin menghapus gambar ini?')) {
        document.getElementById('deleteImageId').value = id;
        document.getElementById('deleteImageForm').submit();
    }
}
</script>