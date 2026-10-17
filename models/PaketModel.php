<?php
require_once __DIR__ . '/../core/Model.php';

class PaketModel extends Model {
    public $table = 'paket';

    public function getAll() {
        $sql = "SELECT * FROM paket WHERE is_aktif = 1 ORDER BY harga ASC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getById($id) {
        $sql = "SELECT * FROM paket WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getWithPortofolio() {
        $sql = "SELECT p.*, 
                (SELECT gambar FROM portofolio WHERE paket_id = p.id ORDER BY urutan LIMIT 1) as contoh_gambar
                FROM paket p WHERE p.is_aktif = 1 ORDER BY p.harga ASC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllWithImages() {
        $sql = "SELECT p.*, 
                (SELECT gambar FROM portofolio WHERE paket_id = p.id ORDER BY urutan LIMIT 1) as gambar_utama
                FROM paket p WHERE p.is_aktif = 1 ORDER BY p.kategori DESC, p.harga ASC";
        $result = $this->db->query($sql);
        if (!$result) return [];
        $paket = $result->fetch_all(MYSQLI_ASSOC);
        // Attach all images per paket
        foreach ($paket as &$p) {
            $imgs = $this->db->query("SELECT gambar, caption FROM portofolio WHERE paket_id = {$p['id']} ORDER BY urutan");
            $p['images'] = $imgs ? $imgs->fetch_all(MYSQLI_ASSOC) : [];
        }
        return $paket;
    }

    public function getPortofolioAll() {
        $sql = "SELECT po.*, p.nama_paket FROM portofolio po 
                JOIN paket p ON po.paket_id = p.id 
                ORDER BY po.paket_id, po.urutan";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create($data) {
        $kategori = $data['kategori'] ?? 'regular';
        $dp_persen = $data['dp_persen'] ?? 30;
        $sql = "INSERT INTO paket (nama_paket, deskripsi, harga, durasi_jam, kategori, dp_persen) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ssdiss', $data['nama_paket'], $data['deskripsi'], $data['harga'], $data['durasi_jam'], $kategori, $dp_persen);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $kategori = $data['kategori'] ?? 'regular';
        $dp_persen = $data['dp_persen'] ?? 30;
        $sql = "UPDATE paket SET nama_paket=?, deskripsi=?, harga=?, durasi_jam=?, kategori=?, dp_persen=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ssdissi', $data['nama_paket'], $data['deskripsi'], $data['harga'], $data['durasi_jam'], $kategori, $dp_persen, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "UPDATE paket SET is_aktif = 0 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function addPortofolio($paket_id, $gambar, $caption = '') {
        $sql = "INSERT INTO portofolio (paket_id, gambar, caption) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('iss', $paket_id, $gambar, $caption);
        return $stmt->execute();
    }

    public function getPortofolioByPaketId($paket_id) {
        $sql = "SELECT * FROM portofolio WHERE paket_id = ? ORDER BY urutan, id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $paket_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function deletePortofolio($id) {
        // Find image first to unlink file
        $sql = "SELECT gambar FROM portofolio WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        
        if ($res && !empty($res['gambar']) && file_exists(__DIR__ . '/../' . $res['gambar'])) {
            unlink(__DIR__ . '/../' . $res['gambar']);
        }

        $sql = "DELETE FROM portofolio WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getLastInsertId() {
        return $this->db->insert_id;
    }
}
?>