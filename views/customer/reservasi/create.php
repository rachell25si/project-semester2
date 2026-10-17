<?php 
$pageTitle = 'Booking Makeup'; 
$paket = $paket ?? [];
$hariLibur = $hariLibur ?? [];
$preselect_paket_id = $preselect_paket_id ?? null;
?>

<!-- BOOKING STEPS -->
<div class="booking-steps">
    <div class="step active" id="step-indicator-1">
        <div class="step-num">1</div>
        <div class="step-label">Pilih Paket</div>
    </div>
    <div class="step-line" id="line-1"></div>
    <div class="step" id="step-indicator-2">
        <div class="step-num">2</div>
        <div class="step-label">Pilih Tanggal</div>
    </div>
    <div class="step-line" id="line-2"></div>
    <div class="step" id="step-indicator-3">
        <div class="step-num">3</div>
        <div class="step-label">Pilih Waktu</div>
    </div>
    <div class="step-line" id="line-3"></div>
    <div class="step" id="step-indicator-4">
        <div class="step-num">4</div>
        <div class="step-label">Konfirmasi</div>
    </div>
</div>

<?php
$bookingError = $_SESSION['booking_error'] ?? null;
unset($_SESSION['booking_error']);
?>
<?php if ($bookingError): ?>
<div class="alert alert-danger" style="margin-bottom:1.5rem;">
    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($bookingError) ?>
</div>
<?php endif; ?>

<form id="bookingForm" method="POST" action="index.php?page=customer/reservasi/store">
    <input type="hidden" name="paket_id"          id="input-paket-id">
    <input type="hidden" name="tanggal_reservasi"  id="input-tanggal">
    <input type="hidden" name="jam_mulai"          id="input-jam-mulai">
    <input type="hidden" name="jam_selesai"        id="input-jam-selesai">

    <div class="booking-grid">

        <!-- ===== STEP 1: PILIH PAKET ===== -->
        <div class="booking-section" id="section-1">
            <div class="booking-section-header">
                <span class="step-badge">1</span>
                <div>
                    <h3 class="booking-section-title">Pilih Paket Makeup</h3>
                    <p class="booking-section-sub">Klik paket yang ingin Anda booking</p>
                </div>
            </div>

            <div class="paket-choices">
                <?php foreach ($paket as $p): ?>
                <div class="paket-choice-card <?= ($preselect_paket_id == ($p['id'] ?? null)) ? 'selected' : '' ?>"
                     data-id="<?= $p['id'] ?? 0 ?>"
                     data-name="<?= htmlspecialchars($p['nama_paket'] ?? 'Paket') ?>"
                     data-price="<?= (float)($p['harga'] ?? 0) ?>"
                     data-dp="<?= $p['dp_persen'] ?? 30 ?>"
                     data-duration="<?= $p['durasi_jam'] ?? 2 ?>"
                     data-kategori="<?= $p['kategori'] ?? 'regular' ?>"
                     onclick="selectPaket(this)">
                    <div class="pcc-img-wrap">
                        <?php if (!empty($p['gambar_utama'])): ?>
                            <img src="<?= htmlspecialchars($p['gambar_utama']) ?>" alt="<?= htmlspecialchars($p['nama_paket'] ?? 'Paket') ?>" class="pcc-img">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?w=300&h=200&fit=crop&q=70" alt="<?= htmlspecialchars($p['nama_paket'] ?? 'Paket') ?>" class="pcc-img">
                        <?php endif; ?>
                        <?php if (($p['kategori'] ?? 'regular') === 'wedding'): ?>
                            <span class="pcc-badge wedding">✦ Full Day</span>
                        <?php endif; ?>
                        <div class="pcc-check"><i class="fas fa-check"></i></div>
                    </div>
                    <div class="pcc-body">
                        <div class="pcc-name"><?= htmlspecialchars($p['nama_paket'] ?? 'Paket') ?></div>
                        <div class="pcc-desc"><?= htmlspecialchars(substr($p['deskripsi'] ?? '', 0, 80)) ?>...</div>
                        <div class="pcc-footer">
                            <div class="pcc-price">Rp <?= number_format((float)($p['harga'] ?? 0), 0, ',', '.') ?></div>
                            <div class="pcc-meta">
                                <span><?= ($p['kategori'] ?? 'regular') === 'wedding' ? '⏱ Full Day' : '⏱ ~' . ($p['durasi_jam'] ?? 2) . ' jam' ?></span>
                                <span>DP <?= $p['dp_persen'] ?? 30 ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- RIGHT PANEL: KALENDER + SLOT + DETAIL -->
        <div class="booking-right-panel" id="booking-right-panel">

            <!-- Step 2: Kalender -->
            <div class="booking-section" id="section-2" style="<?= $preselect_paket_id ? '' : 'opacity:0.4;pointer-events:none;' ?>">
                <div class="booking-section-header">
                    <span class="step-badge">2</span>
                    <div>
                        <h3 class="booking-section-title">Pilih Tanggal</h3>
                        <p class="booking-section-sub">Pilih paket terlebih dahulu</p>
                    </div>
                </div>

                <!-- Calendar -->
                <div class="booking-calendar">
                    <div class="calendar-header">
                        <button type="button" class="calendar-nav-btn" onclick="prevMonth()"><i class="fas fa-chevron-left"></i></button>
                        <div class="calendar-month" id="calendarMonthLabel"></div>
                        <button type="button" class="calendar-nav-btn" onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div class="calendar-grid" id="calendarGrid">
                        <div style="text-align:center;padding:2rem;color:var(--clr-muted);grid-column:1/-1;">
                            <div class="loading-spinner" style="margin:0 auto;"></div>
                        </div>
                    </div>
                    <div class="calendar-legend">
                        <span><span class="legend-dot" style="background:var(--clr-success);"></span>Tersedia</span>
                        <span><span class="legend-dot" style="background:var(--clr-warning);"></span>Sebagian Terisi</span>
                        <span><span class="legend-dot" style="background:var(--clr-danger);opacity:0.6;"></span>Penuh / Libur</span>
                    </div>
                </div>
            </div>

            <!-- Step 3: Slot Waktu -->
            <div class="booking-section" id="section-3" style="opacity:0.4;pointer-events:none;">
                <div class="booking-section-header">
                    <span class="step-badge">3</span>
                    <div>
                        <h3 class="booking-section-title">Pilih Waktu</h3>
                        <p class="booking-section-sub" id="slot-sub">Pilih tanggal terlebih dahulu</p>
                    </div>
                </div>
                <div id="slot-container">
                    <div class="slot-empty"><i class="far fa-clock"></i><p>Pilih tanggal untuk melihat slot tersedia</p></div>
                </div>
            </div>

            <!-- Step 4: Detail & Ringkasan -->
            <div class="booking-section" id="section-4" style="opacity:0.4;pointer-events:none;">
                <div class="booking-section-header">
                    <span class="step-badge">4</span>
                    <div>
                        <h3 class="booking-section-title">Detail & Konfirmasi</h3>
                        <p class="booking-section-sub">Lengkapi detail pemesanan</p>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                    <div class="form-group">
                        <label class="form-label">Lokasi Makeup</label>
                        <select name="jenis_lokasi" id="jenis_lokasi" class="form-control" onchange="toggleAlamat()">
                            <option value="studio">Di Studio MUA ULVA</option>
                            <option value="customer">Di Lokasi Saya (Home Visit)</option>
                        </select>
                    </div>
                    <div class="form-group" id="alamat-group" style="display:none;">
                        <label class="form-label">Alamat Lengkap</label>
                        <input type="text" name="alamat_customer" class="form-control" placeholder="Jl. Nama, No. Rumah, Kota">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan untuk MUA <span style="font-weight:400;color:var(--clr-muted);">(opsional)</span></label>
                    <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: tema makeup natural, ada alergi tertentu..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan Tambahan <span style="font-weight:400;color:var(--clr-muted);">(opsional)</span></label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: butuh touch-up berkala, acara outdoor..."></textarea>
                </div>

                <!-- Summary Box -->
                <div class="summary-box" id="summaryBox" style="margin-top:1.5rem;">
                    <h4 style="font-family:var(--font-display);font-size:1.15rem;margin-bottom:1rem;">Ringkasan Booking</h4>
                    <div class="summary-row"><span>Paket</span><span id="sum-paket" style="font-weight:600;">—</span></div>
                    <div class="summary-row"><span>Tanggal</span><span id="sum-tanggal">—</span></div>
                    <div class="summary-row"><span>Waktu</span><span id="sum-waktu">—</span></div>
                    <div class="summary-row"><span>Lokasi</span><span id="sum-lokasi">Studio</span></div>
                    <div class="summary-row"><span>Total Harga</span><span id="sum-harga" style="font-weight:600;">—</span></div>
                    <div class="summary-row total"><span>DP yang harus dibayar</span><span id="sum-dp">—</span></div>
                    <p style="font-size:0.75rem;color:var(--clr-muted);margin-top:0.75rem;"><i class="fas fa-info-circle" style="color:var(--clr-gold);"></i> DP dibayarkan via transfer bank/e-wallet ke admin. Konfirmasi via WhatsApp setelah booking.</p>
                </div>

                <button type="submit" class="btn-submit-booking" id="btnSubmit" disabled>
                    <i class="fas fa-calendar-check"></i>
                    Konfirmasi Booking
                </button>
            </div>

        </div><!-- /booking-right-panel -->
    </div><!-- /booking-grid -->
</form>

<style>
.booking-grid { display: grid; grid-template-columns: 380px 1fr; gap: 2rem; align-items: start; }
.booking-section { background: #fff; border-radius: 20px; padding: 1.5rem; border: 1px solid rgba(232,196,196,0.25); box-shadow: 0 4px 20px rgba(107,76,59,0.06); margin-bottom: 1.25rem; transition: opacity 0.3s; }
.booking-section:last-child { margin-bottom: 0; }
.booking-section-header { display: flex; align-items: flex-start; gap: 0.85rem; margin-bottom: 1.25rem; }
.step-badge { width: 32px; height: 32px; border-radius: 50%; background: var(--clr-gold); color: var(--clr-brown-deep); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; flex-shrink: 0; font-family: var(--font-display); }
.booking-section-title { font-family: var(--font-display); font-size: 1.15rem; font-weight: 600; color: var(--clr-brown-deep); line-height: 1.2; }
.booking-section-sub { font-size: 0.78rem; color: var(--clr-muted); margin-top: 2px; }

.paket-choices { display: flex; flex-direction: column; gap: 0.85rem; }
.paket-choice-card { background: #fff; border-radius: 16px; border: 2px solid rgba(232,196,196,0.25); overflow: hidden; cursor: pointer; transition: all 0.3s; display: flex; }
.paket-choice-card:hover { border-color: rgba(201,168,124,0.5); box-shadow: 0 8px 25px rgba(107,76,59,0.1); }
.paket-choice-card.selected { border-color: var(--clr-gold); box-shadow: 0 0 0 3px rgba(201,168,124,0.15); }
.pcc-img-wrap { position: relative; width: 90px; flex-shrink: 0; }
.pcc-img { width: 90px; height: 100%; object-fit: cover; }
.pcc-badge { position: absolute; top: 5px; left: 5px; background: var(--clr-gold); color: var(--clr-brown-deep); font-size: 0.6rem; font-weight: 700; padding: 2px 7px; border-radius: 20px; }
.pcc-check { position: absolute; top: 5px; right: 5px; width: 22px; height: 22px; background: var(--clr-gold); border-radius: 50%; display: none; align-items: center; justify-content: center; color: var(--clr-brown-deep); font-size: 0.65rem; font-weight: 700; }
.paket-choice-card.selected .pcc-check { display: flex; }
.pcc-body { padding: 0.85rem; flex: 1; display: flex; flex-direction: column; }
.pcc-name { font-family: var(--font-display); font-size: 1rem; font-weight: 600; color: var(--clr-brown-deep); margin-bottom: 0.25rem; }
.pcc-desc { font-size: 0.75rem; color: var(--clr-muted); line-height: 1.5; flex: 1; }
.pcc-footer { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 0.5rem; }
.pcc-price { font-family: var(--font-display); font-size: 1.1rem; font-weight: 600; color: var(--clr-gold); }
.pcc-meta { font-size: 0.7rem; color: var(--clr-muted); text-align: right; }
.pcc-meta span { display: block; }

.booking-right-panel { display: flex; flex-direction: column; }

.slot-empty { text-align: center; padding: 2rem; color: var(--clr-muted); }
.slot-empty i { font-size: 2rem; opacity: 0.4; margin-bottom: 0.75rem; }
.slot-empty p { font-size: 0.85rem; }

.btn-submit-booking {
    width: 100%; padding: 1rem; border-radius: 50px;
    background: var(--clr-brown-deep); color: #fff;
    font-family: var(--font-body); font-size: 1rem; font-weight: 600;
    border: none; cursor: pointer; transition: all 0.3s;
    display: flex; align-items: center; justify-content: center; gap: 0.6rem;
    margin-top: 1.25rem;
}
.btn-submit-booking:hover:not(:disabled) { background: var(--clr-gold); color: var(--clr-brown-deep); transform: translateY(-2px); box-shadow: 0 12px 30px rgba(201,168,124,0.4); }
.btn-submit-booking:disabled { opacity: 0.5; cursor: not-allowed; }

.wedding-notice {
    background: rgba(201,168,124,0.08);
    border: 1.5px solid rgba(201,168,124,0.3);
    border-radius: 16px;
    padding: 1rem 1.25rem;
    font-size: 0.85rem;
    color: var(--clr-brown);
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}
.wedding-notice i { color: var(--clr-gold); margin-top: 2px; flex-shrink: 0; }

@media (max-width: 900px) {
    .booking-grid { grid-template-columns: 1fr; }
    .paket-choices { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
    .paket-choice-card { flex-direction: column; }
    .pcc-img-wrap { width: 100%; height: 120px; }
    .pcc-img { width: 100%; height: 120px; }
}
@media (max-width: 600px) {
    .paket-choices { grid-template-columns: 1fr; }
}
</style>

<script>
const HARI_LIBUR = <?= json_encode($hariLibur ?? []) ?>;
const TODAY = '<?= date('Y-m-d') ?>';
let currentYear = <?= date('Y') ?>;
let currentMonth = <?= date('n') ?>;
let selectedPaket = null;
let selectedDate  = null;
let selectedSlot  = null;
let calendarStatus = {};
let isWedding = false;

const BULAN = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

// ===== PAKET SELECTION =====
function selectPaket(el) {
    document.querySelectorAll('.paket-choice-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');

    selectedPaket = {
        id:       el.dataset.id,
        name:     el.dataset.name,
        price:    parseFloat(el.dataset.price),
        dp:       parseInt(el.dataset.dp),
        duration: el.dataset.duration,
        kategori: el.dataset.kategori
    };
    isWedding = selectedPaket.kategori === 'wedding';

    document.getElementById('input-paket-id').value = selectedPaket.id;
    document.getElementById('sum-paket').textContent = selectedPaket.name;
    document.getElementById('sum-harga').textContent = 'Rp ' + parseInt(selectedPaket.price).toLocaleString('id-ID');
    document.getElementById('sum-dp').textContent = 'Rp ' + Math.round(selectedPaket.price * selectedPaket.dp / 100).toLocaleString('id-ID');

    // Enable section 2
    const sec2 = document.getElementById('section-2');
    sec2.style.opacity = '1';
    sec2.style.pointerEvents = 'auto';

    // Update step indicator
    setStepDone(1);
    setStepActive(2);

    // Reset date and slot
    selectedDate = null; selectedSlot = null;
    resetSlots();

    // Disable sections 3,4
    disableSection(3); disableSection(4);

    // Load calendar for current month
    loadCalendar(currentYear, currentMonth);
}

// ===== CALENDAR =====
function loadCalendar(year, month) {
    document.getElementById('calendarMonthLabel').textContent = `${BULAN[month]} ${year}`;
    document.getElementById('calendarGrid').innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:1.5rem;color:var(--clr-muted)"><div class="loading-spinner" style="margin:0 auto;"></div></div>`;

    fetch(`index.php?page=api/calendar&tahun=${year}&bulan=${month}`)
        .then(r => r.json())
        .then(data => { calendarStatus = data; renderCalendar(year, month); })
        .catch(() => { calendarStatus = {}; renderCalendar(year, month); });
}

function renderCalendar(year, month) {
    const grid = document.getElementById('calendarGrid');
    const dayNames = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
    let html = dayNames.map(d => `<div class="calendar-day-header">${d}</div>`).join('');

    const firstDay = new Date(year, month - 1, 1).getDay();
    const daysInMonth = new Date(year, month, 0).getDate();

    for (let i = 0; i < firstDay; i++) html += `<div class="calendar-day empty"></div>`;

    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${year}-${String(month).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
        let status = calendarStatus[dateStr] || (dateStr < TODAY ? 'lewat' : 'tersedia');
        let classes = `calendar-day ${status}`;
        if (dateStr === TODAY) classes += ' today';
        if (dateStr === selectedDate) classes += ' selected';
        const clickable = (status === 'tersedia' || status === 'sebagian') && dateStr >= TODAY;
        html += `<div class="${classes}"${clickable ? ` onclick="selectDate('${dateStr}')"` : ''} title="${dateStr}">${day}</div>`;
    }

    grid.innerHTML = html;
}

function prevMonth() {
    currentMonth--;
    if (currentMonth < 1) { currentMonth = 12; currentYear--; }
    if (!selectedPaket) return;
    loadCalendar(currentYear, currentMonth);
}
function nextMonth() {
    currentMonth++;
    if (currentMonth > 12) { currentMonth = 1; currentYear++; }
    if (!selectedPaket) return;
    loadCalendar(currentYear, currentMonth);
}

// ===== DATE SELECTION =====
function selectDate(dateStr) {
    selectedDate = dateStr;
    document.getElementById('input-tanggal').value = dateStr;

    // Update calendar highlight
    renderCalendar(currentYear, currentMonth);

    // Enable section 3
    enableSection(3);
    setStepDone(2);
    setStepActive(3);

    // Reset slot
    selectedSlot = null;
    document.getElementById('input-jam-mulai').value = '';
    document.getElementById('input-jam-selesai').value = '';
    disableSection(4);

    // Format display date
    const d = new Date(dateStr + 'T00:00:00');
    const hariArr = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    document.getElementById('sum-tanggal').textContent = `${hariArr[d.getDay()]}, ${d.getDate()} ${BULAN[d.getMonth()+1]} ${d.getFullYear()}`;

    // Load slots
    loadSlots(dateStr);
}

function loadSlots(dateStr) {
    const container = document.getElementById('slot-container');
    container.innerHTML = `<div class="slot-empty"><div class="loading-spinner" style="margin:0 auto;"></div><p style="margin-top:0.75rem;">Memuat slot waktu...</p></div>`;

    fetch(`index.php?page=api/slots&tanggal=${dateStr}&paket_id=${selectedPaket.id}`)
        .then(r => r.json())
        .then(data => {
            if (data.libur) {
                container.innerHTML = `<div class="wedding-notice"><i class="fas fa-moon"></i><div><strong>Studio Libur</strong><br>Tanggal ini adalah hari libur studio. Silakan pilih tanggal lain.</div></div>`;
                return;
            }
            if (data.full_day_wedding) {
                container.innerHTML = `<div class="wedding-notice"><i class="fas fa-ring"></i><div><strong>Tanggal Ini Sudah Dibooking Wedding</strong><br>Paket wedding memblok penuh satu hari. Silakan pilih tanggal lain.</div></div>`;
                return;
            }
            if (isWedding) {
                if (data.wedding_available) {
                    container.innerHTML = `<div class="wedding-notice" style="border-color:rgba(109,190,143,0.4);background:rgba(109,190,143,0.05);">
                        <i class="fas fa-check-circle" style="color:var(--clr-success);"></i>
                        <div><strong>Tanggal tersedia untuk Paket Wedding!</strong><br>Paket wedding akan memblok seluruh hari (03:00 – 23:00). MUA akan mendampingi dari awal hingga akhir acara.</div>
                    </div>
                    <button type="button" onclick="selectWeddingSlot()" class="btn-submit-booking" style="margin-top:1rem;background:var(--clr-gold);color:var(--clr-brown-deep);">
                        <i class="fas fa-ring"></i> Pilih Tanggal Ini untuk Wedding
                    </button>`;
                } else {
                    container.innerHTML = `<div class="wedding-notice"><i class="fas fa-times-circle" style="color:var(--clr-danger);"></i><div><strong>Tidak Tersedia</strong><br>Sudah ada booking di tanggal ini. Silakan pilih tanggal lain.</div></div>`;
                }
                return;
            }

            const slots = data.slots || [];
            if (slots.length === 0) {
                container.innerHTML = `<div class="slot-empty"><i class="fas fa-calendar-times"></i><p>Tidak ada slot tersedia di tanggal ini.</p></div>`;
                return;
            }

            let html = `<div style="font-size:0.78rem;color:var(--clr-muted);margin-bottom:0.75rem;"><i class="fas fa-info-circle" style="color:var(--clr-gold);"></i> Klik slot waktu yang tersedia</div><div class="slot-grid">`;
            slots.forEach(slot => {
                const cls = slot.tersedia ? 'slot-chip' : 'slot-chip booked';
                const onclick = slot.tersedia ? `onclick="selectSlot('${slot.jam_mulai}','${slot.jam_selesai}',this)"` : '';
                html += `<div class="${cls}" ${onclick}>${slot.jam_mulai}<br><small>${slot.jam_selesai}</small></div>`;
            });
            html += `</div>`;
            container.innerHTML = html;
        })
        .catch(err => {
            container.innerHTML = `<div class="slot-empty"><i class="fas fa-exclamation-triangle"></i><p>Gagal memuat slot. Coba lagi.</p></div>`;
        });
}

function selectSlot(start, end, el) {
    document.querySelectorAll('.slot-chip').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedSlot = { start, end };
    document.getElementById('input-jam-mulai').value = start;
    document.getElementById('input-jam-selesai').value = end;
    document.getElementById('sum-waktu').textContent = `${start} – ${end} WIB`;
    enableSection(4);
    setStepDone(3);
    setStepActive(4);
    enableSubmit();
    document.getElementById('section-4').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function selectWeddingSlot() {
    document.getElementById('input-jam-mulai').value = '03:00';
    document.getElementById('input-jam-selesai').value = '23:00';
    document.getElementById('sum-waktu').textContent = 'Full Day (03:00 – 23:00) WIB';
    enableSection(4);
    setStepDone(3);
    setStepActive(4);
    enableSubmit();
    document.getElementById('section-4').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function resetSlots() {
    document.getElementById('slot-container').innerHTML = `<div class="slot-empty"><i class="far fa-clock"></i><p>Pilih tanggal untuk melihat slot tersedia</p></div>`;
    document.getElementById('sum-waktu').textContent = '—';
    document.getElementById('slot-sub').textContent = 'Pilih tanggal terlebih dahulu';
}

// ===== LOKASI =====
function toggleAlamat() {
    const jenis = document.getElementById('jenis_lokasi').value;
    const alamat = document.getElementById('alamat-group');
    alamat.style.display = jenis === 'customer' ? 'block' : 'none';
    document.getElementById('sum-lokasi').textContent = jenis === 'studio' ? 'Di Studio MUA ULVA' : 'Home Visit (Lokasi Saya)';
}

// ===== HELPERS =====
function enableSection(num) {
    const sec = document.getElementById('section-' + num);
    sec.style.opacity = '1';
    sec.style.pointerEvents = 'auto';
}
function disableSection(num) {
    const sec = document.getElementById('section-' + num);
    sec.style.opacity = '0.4';
    sec.style.pointerEvents = 'none';
}
function setStepDone(num) {
    const step = document.getElementById('step-indicator-' + num);
    step.classList.remove('active');
    step.classList.add('done');
    if (num < 4) document.getElementById('line-' + num).classList.add('done');
}
function setStepActive(num) {
    const step = document.getElementById('step-indicator-' + num);
    step.classList.add('active');
}
function enableSubmit() {
    document.getElementById('btnSubmit').disabled = false;
}

// ===== FORM VALIDATION =====
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    const paket = document.getElementById('input-paket-id').value;
    const tanggal = document.getElementById('input-tanggal').value;
    const jam_mulai = document.getElementById('input-jam-mulai').value;
    const jam_selesai = document.getElementById('input-jam-selesai').value;
    if (!paket || !tanggal || !jam_mulai || !jam_selesai) {
        e.preventDefault();
        alert('Lengkapi semua pilihan: paket, tanggal, dan waktu.');
        return false;
    }
});

// ===== INIT =====
window.addEventListener('DOMContentLoaded', () => {
    // Init calendar
    loadCalendar(currentYear, currentMonth);

    // If paket pre-selected from landing
    const preselect = <?= json_encode($preselect_paket_id) ?>;
    if (preselect) {
        const el = document.querySelector(`.paket-choice-card[data-id="${preselect}"]`);
        if (el) selectPaket(el);
    }
});
</script>