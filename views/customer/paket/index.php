<h1>Paket Layanan</h1>
<div class="row">
    <?php if (isset($paket) && count($paket) > 0): ?>
        <?php foreach ($paket as $p): ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5><?= $p['nama_paket'] ?></h5>
                    <p><?= $p['deskripsi'] ?></p>
                    <p><strong>Rp <?= number_format($p['harga'], 0, ',', '.') ?></strong></p>
                    <p>Durasi: <?= $p['durasi_jam'] ?> jam</p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Belum ada paket.</p>
    <?php endif; ?>
</div>