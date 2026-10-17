<?php
require_once __DIR__ . '/../core/Model.php';

class TestimoniModel extends Model {
    public $table = 'testimoni';

    public function getAll() {
        $sql = "SELECT * FROM testimoni WHERE is_tampil = 1 ORDER BY created_at DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create($data) {
        $sql = "INSERT INTO testimoni (user_id, nama, paket, isi, rating, is_tampil) VALUES (?, ?, ?, ?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('isssi', $data['user_id'], $data['nama'], $data['paket'], $data['isi'], $data['rating']);
        return $stmt->execute();
    }

    public function getById($id) {
        $sql = "SELECT * FROM testimoni WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>