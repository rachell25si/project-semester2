<?php
require_once __DIR__ . '/../core/Model.php';

class PengaturanModel extends Model {
    public $table = 'pengaturan_jadwal';

    public function getSetting() {
        $sql = "SELECT * FROM pengaturan_jadwal ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        // Default setting
        return [
            'id' => 0,
            'jam_mulai' => '03:00:00',
            'jam_selesai' => '23:00:00',
            'durasi_slot_menit' => 120
        ];
    }

    public function update($jam_mulai, $jam_selesai, $durasi_slot_menit) {
        $existing = $this->getSetting();
        if ($existing['id'] > 0) {
            $sql = "UPDATE pengaturan_jadwal SET jam_mulai=?, jam_selesai=?, durasi_slot_menit=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('ssii', $jam_mulai, $jam_selesai, $durasi_slot_menit, $existing['id']);
        } else {
            $sql = "INSERT INTO pengaturan_jadwal (jam_mulai, jam_selesai, durasi_slot_menit) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('ssi', $jam_mulai, $jam_selesai, $durasi_slot_menit);
        }
        return $stmt->execute();
    }

    public function generateSlots($jam_mulai, $jam_selesai, $durasi_menit) {
        $slots = [];
        $start = strtotime($jam_mulai);
        $end   = strtotime($jam_selesai);
        $dur   = $durasi_menit * 60;

        while ($start + $dur <= $end) {
            $slot_start = date('H:i', $start);
            $slot_end   = date('H:i', $start + $dur);
            $slots[] = ['jam_mulai' => $slot_start, 'jam_selesai' => $slot_end];
            $start += $dur;
        }
        return $slots;
    }
}
?>
