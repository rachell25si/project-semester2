<?php
require_once __DIR__ . '/../core/Model.php';

class JadwalModel extends Model {
    public $table = 'jadwal';

    /**
     * Get available slots for a given date and optionally paket
     * Returns array of slots with availability status
     */
    public function getAvailableSlotsForDate($tanggal, $paket_id = null, $exclude_reservasi_id = null) {
        // Get studio operating hours
        $setting = $this->db->query("SELECT * FROM pengaturan_jadwal ORDER BY id DESC LIMIT 1")->fetch_assoc();
        if (!$setting) {
            $setting = ['jam_mulai' => '03:00:00', 'jam_selesai' => '23:00:00', 'durasi_slot_menit' => 120];
        }

        // Check if it's a holiday
        $isLibur = $this->db->query("SELECT COUNT(*) as c FROM hari_libur WHERE tanggal = '$tanggal'")->fetch_assoc();
        if ($isLibur['c'] > 0) return ['libur' => true, 'slots' => []];

        // Check if there's a wedding booking on this date (blocks full day)
        $weddingCheck = $this->db->prepare(
            "SELECT r.id FROM reservasi r 
             JOIN paket p ON r.paket_id = p.id 
             WHERE r.tanggal_reservasi = ? AND p.kategori = 'wedding' AND r.status NOT IN ('batal')" .
            ($exclude_reservasi_id ? " AND r.id != $exclude_reservasi_id" : "")
        );
        $weddingCheck->bind_param('s', $tanggal);
        $weddingCheck->execute();
        if ($weddingCheck->get_result()->num_rows > 0) {
            return ['libur' => false, 'full_day_wedding' => true, 'slots' => []];
        }

        // Generate all slots
        $slots = [];
        $start = strtotime($setting['jam_mulai']);
        $end   = strtotime($setting['jam_selesai']);
        $dur   = $setting['durasi_slot_menit'] * 60;

        while ($start + $dur <= $end) {
            $jam_mulai  = date('H:i', $start);
            $jam_selesai = date('H:i', $start + $dur);

            // Check if slot is booked
            $query = "SELECT COUNT(*) as booked FROM reservasi 
                      WHERE tanggal_reservasi = ? AND status NOT IN ('batal')
                      AND ((jam_mulai <= ? AND jam_selesai > ?) OR (jam_mulai < ? AND jam_selesai >= ?) OR (jam_mulai >= ? AND jam_selesai <= ?))";
            if ($exclude_reservasi_id) {
                $query .= " AND id != $exclude_reservasi_id";
            }
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssssss', $tanggal, $jam_mulai, $jam_mulai, $jam_selesai, $jam_selesai, $jam_mulai, $jam_selesai);
            $stmt->execute();
            $booked = $stmt->get_result()->fetch_assoc()['booked'];

            $slots[] = [
                'jam_mulai'   => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'label'       => "$jam_mulai - $jam_selesai",
                'tersedia'    => ($booked == 0),
                'booked'      => (int)$booked
            ];

            $start += $dur;
        }

        return ['libur' => false, 'full_day_wedding' => false, 'slots' => $slots];
    }

    /**
     * Get booked dates info for calendar display (next 6 months)
     * Returns array: date => 'libur' | 'penuh' | 'sebagian' | 'tersedia'
     */
    public function getCalendarStatus($tahun, $bulan) {
        $result = [];
        $firstDay = "$tahun-" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "-01";
        $lastDay  = date('Y-m-t', strtotime($firstDay));
        $today    = date('Y-m-d');

        // Get all holiday dates in month
        $liburs = $this->db->query("SELECT tanggal FROM hari_libur WHERE tanggal >= '$firstDay' AND tanggal <= '$lastDay'")->fetch_all(MYSQLI_ASSOC);
        $liburDates = array_column($liburs, 'tanggal');

        // Get setting
        $setting = $this->db->query("SELECT * FROM pengaturan_jadwal ORDER BY id DESC LIMIT 1")->fetch_assoc();
        if (!$setting) $setting = ['jam_mulai' => '03:00:00', 'jam_selesai' => '23:00:00', 'durasi_slot_menit' => 120];

        $totalSlots = floor((strtotime($setting['jam_selesai']) - strtotime($setting['jam_mulai'])) / ($setting['durasi_slot_menit'] * 60));

        // Iterate each day of month
        $current = strtotime($firstDay);
        $last    = strtotime($lastDay);
        while ($current <= $last) {
            $dateStr = date('Y-m-d', $current);

            if ($dateStr < $today) {
                $result[$dateStr] = 'lewat';
            } elseif (in_array($dateStr, $liburDates)) {
                $result[$dateStr] = 'libur';
            } else {
                // Check wedding block
                $wed = $this->db->query("SELECT COUNT(*) as c FROM reservasi r JOIN paket p ON r.paket_id = p.id WHERE r.tanggal_reservasi = '$dateStr' AND p.kategori = 'wedding' AND r.status NOT IN ('batal')")->fetch_assoc();
                if ($wed['c'] > 0) {
                    $result[$dateStr] = 'penuh';
                } else {
                    // Count booked slots
                    $booked = $this->db->query("SELECT COUNT(*) as c FROM reservasi WHERE tanggal_reservasi = '$dateStr' AND status NOT IN ('batal')")->fetch_assoc();
                    $bookedCount = (int)$booked['c'];
                    if ($bookedCount == 0) {
                        $result[$dateStr] = 'tersedia';
                    } elseif ($bookedCount >= $totalSlots) {
                        $result[$dateStr] = 'penuh';
                    } else {
                        $result[$dateStr] = 'sebagian';
                    }
                }
            }
            $current = strtotime('+1 day', $current);
        }

        return $result;
    }

    /**
     * Check if a specific slot is available
     */
    public function isSlotAvailable($tanggal, $jam_mulai, $jam_selesai, $exclude_id = null) {
        // Check holiday
        $isLibur = $this->db->query("SELECT COUNT(*) as c FROM hari_libur WHERE tanggal = '$tanggal'")->fetch_assoc();
        if ($isLibur['c'] > 0) return false;

        // Check wedding block
        $wed = $this->db->query("SELECT COUNT(*) as c FROM reservasi r JOIN paket p ON r.paket_id = p.id WHERE r.tanggal_reservasi = '$tanggal' AND p.kategori = 'wedding' AND r.status NOT IN ('batal')" . ($exclude_id ? " AND r.id != $exclude_id" : ""))->fetch_assoc();
        if ($wed['c'] > 0) return false;

        // Check time conflict
        $query = "SELECT COUNT(*) as c FROM reservasi 
                  WHERE tanggal_reservasi = ? AND status NOT IN ('batal')
                  AND ((jam_mulai <= ? AND jam_selesai > ?) OR (jam_mulai < ? AND jam_selesai >= ?) OR (jam_mulai >= ? AND jam_selesai <= ?))";
        if ($exclude_id) $query .= " AND id != $exclude_id";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssssss', $tanggal, $jam_mulai, $jam_mulai, $jam_selesai, $jam_selesai, $jam_mulai, $jam_selesai);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['c'] == 0;
    }

    // Legacy methods kept for compatibility
    public function getAvailableSlots($tanggal = null) {
        if (!$tanggal) $tanggal = date('Y-m-d');
        $result = $this->getAvailableSlotsForDate($tanggal);
        return $result['slots'] ?? [];
    }

    public function create($data) {
        $sql = "INSERT INTO jadwal (tanggal, jam_mulai, jam_selesai, kuota) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sssi', $data['tanggal'], $data['jam_mulai'], $data['jam_selesai'], $data['kuota']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE jadwal SET tanggal=?, jam_mulai=?, jam_selesai=?, kuota=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sssii', $data['tanggal'], $data['jam_mulai'], $data['jam_selesai'], $data['kuota'], $id);
        return $stmt->execute();
    }
}
?>