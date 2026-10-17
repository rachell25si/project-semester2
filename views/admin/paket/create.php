<?php $pageTitle = 'Tambah Paket Baru'; ?>

<div style="max-width:640px;margin:0 auto;">
    <a href="index.php?page=admin/paket" style="display:inline-flex;align-items:center;gap:0.5rem;color:var(--clr-muted);font-size:0.85rem;text-decoration:none;margin-bottom:1.5rem;transition:color 0.2s;" onmouseover="this.style.color='var(--clr-gold)'" onmouseout="this.style.color='var(--clr-muted)'">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Paket
    </a>

    <div style="background:#fff;border-radius:20px;padding:2rem;border:1px solid rgba(232,196,196,0.25);box-shadow:0 4px 20px rgba(107,76,59,0.06);">
        <h3 style="font-family:var(--font-display);font-size:1.4rem;font-weight:600;color:var(--clr-brown-deep);margin-bottom:1.5rem;">Form Tambah Paket</h3>

        <?php if (!empty($error)): ?>
        <div class="alert alert-danger" style="margin-bottom:1rem;"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=admin/paket/create" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Nama Paket</label>
                <input type="text" name="nama_paket" class="form-control" placeholder="Contoh: Paket Makeup Wisuda Soft Glam" required>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan detail apa saja yang didapat customer pada paket ini..." required></textarea>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                <div class="form-group">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control" placeholder="Contoh: 350000" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-control" onchange="toggleKategori(this)">
                        <option value="regular">Regular (Jam Terbatas)</option>
                        <option value="wedding">Wedding (Full Day / Block Day)</option>
                    </select>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                <div class="form-group" id="durasiGroup">
                    <label class="form-label">Durasi Layanan (Jam)</label>
                    <input type="number" name="durasi_jam" class="form-control" value="2" min="1" max="24">
                </div>
                <div class="form-group">
                    <label class="form-label">Down Payment / DP (%)</label>
                    <input type="number" name="dp_persen" class="form-control" value="30" min="10" max="100" required>
                </div>
            </div>

            <!-- Upload Portfolio Images -->
            <div class="form-group">
                <label class="form-label">Foto Portofolio Paket <span style="font-weight:400;color:var(--clr-muted);">(Bisa pilih banyak)</span></label>
                <div class="upload-zone" onclick="document.getElementById('gambarInput').click()">
                    <i class="fas fa-images"></i>
                    <p><strong>Klik untuk memilih foto</strong></p>
                    <p style="font-size:0.75rem;margin-top:0.3rem;">Bisa upload beberapa foto sekaligus (JPG, PNG, WebP)</p>
                </div>
                <input type="file" id="gambarInput" name="gambar[]" accept="image/*" multiple style="display:none;" onchange="previewImages(this)">
                <div id="previewContainer" style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-top:1rem;"></div>
            </div>

            <button type="submit" class="btn-submit" style="width:100%;padding:0.95rem;border-radius:50px;background:var(--clr-brown-deep);color:#fff;font-family:var(--font-body);font-size:0.95rem;font-weight:600;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;margin-top:1.5rem;" onmouseover="this.style.background='var(--clr-gold)';this.style.color='var(--clr-brown-deep)'" onmouseout="this.style.background='var(--clr-brown-deep)';this.style.color='#fff'">
                <i class="fas fa-check"></i> Simpan Paket
            </button>
        </form>
    </div>
</div>

<script>
function toggleKategori(select) {
    const durasiGroup = document.getElementById('durasiGroup');
    const input = durasiGroup.querySelector('input');
    if (select.value === 'wedding') {
        input.value = 12; // default block size for wedding representation
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
</script>