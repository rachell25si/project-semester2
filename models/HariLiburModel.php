<?php
require_once __DIR__ . '/../core/Model.php';

class HariLiburModel extends Model {
    public $table = 'hari_libur';

    public function getAll() {
        $sql = "SELECT * FROM hari_libur ORDER BY tanggal ASC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getUpcoming() {
        $today = date('Y-m-d');
        $sql = "SELECT * FROM hari_libur WHERE tanggal >= ? ORDER BY tanggal ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $today);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function isLibur($tanggal) {
        $sql = "SELECT COUNT(*) as total FROM hari_libur WHERE tanggal = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $tanggal);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total'] > 0;
    }

    public function getLiburDates() {
        $today = date('Y-m-d');
        $future = date('Y-m-d', strtotime('+6 months'));
        $sql = "SELECT tanggal FROM hari_libur WHERE tanggal >= ? AND tanggal <= ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ss', $today, $future);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return array_column($rows, 'tanggal');
    }

    public function create($tanggal, $keterangan = 'Libur Studio') {
        $sql = "INSERT IGNORE INTO hari_libur (tanggal, keterangan) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ss', $tanggal, $keterangan);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM hari_libur WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function deleteByDate($tanggal) {
        $sql = "DELETE FROM hari_libur WHERE tanggal = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $tanggal);
        return $stmt->execute();
    }
}
?>
