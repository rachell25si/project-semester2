<h1>Jadwal Tersedia</h1>
<table class="table table-bordered">
    <thead><tr><th>Tanggal</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Kuota</th><th>Status</th></tr></thead>
    <tbody>
        <?php if (isset($jadwal) && count($jadwal) > 0): ?>
            <?php foreach ($jadwal as $j): ?>
            <tr>
                <td><?= $j['tanggal'] ?></td>
                <td><?= $j['jam_mulai'] ?></td>
                <td><?= $j['jam_selesai'] ?></td>
                <td><?= $j['kuota'] ?></td>
                <td>
                    <?php if ($j['status'] == 'Tersedia'): ?>
                        <span class="badge bg-success">Tersedia</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Penuh</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Tidak ada jadwal tersedia.</td></tr>
        <?php endif; ?>
    </tbody>
</table>