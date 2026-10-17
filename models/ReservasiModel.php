<?php
require_once __DIR__ . '/../core/Model.php';

class ReservasiModel extends Model {
    public $table = 'reservasi';

    public function create($data) {
        $sql = "INSERT INTO reservasi 
                (user_id, paket_id, tanggal_reservasi, jam_mulai, jam_selesai, is_full_day,
                 status, status_pembayaran, total_harga, dp_dibayar, total_dp, 
                 bukti_pembayaran, jenis_lokasi, alamat_customer, catatan, keterangan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            'iisssissdddsssss',
            $data['user_id'],
            $data['paket_id'],
            $data['tanggal_reservasi'],
            $data['jam_mulai'],
            $data['jam_selesai'],
            $data['is_full_day'],
            $data['status'],
            $data['status_pembayaran'],
            $data['total_harga'],
            $data['dp_dibayar'],
            $data['total_dp'],
            $data['bukti_pembayaran'],
            $data['jenis_lokasi'],
            $data['alamat_customer'],
            $data['catatan'],
            $data['keterangan']
        );
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function getById($id) {
        $sql = "SELECT r.*, u.nama AS customer_nama, u.username, u.email, u.no_hp, 
                p.nama_paket, p.harga, p.kategori, p.dp_persen,
                (SELECT gambar FROM portofolio WHERE paket_id = p.id ORDER BY urutan LIMIT 1) as paket_gambar
                FROM reservasi r
                JOIN users u ON r.user_id = u.id
                JOIN paket p ON r.paket_id = p.id
                WHERE r.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getByUser($user_id) {
        $sql = "SELECT r.*, p.nama_paket, p.kategori,
                (SELECT gambar FROM portofolio WHERE paket_id = p.id ORDER BY urutan LIMIT 1) as paket_gambar
                FROM reservasi r
                JOIN paket p ON r.paket_id = p.id
                WHERE r.user_id = ?
                ORDER BY r.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllWithDetails() {
        $sql = "SELECT r.*, u.nama AS customer_nama, u.username, u.email, u.no_hp, 
                p.nama_paket, p.kategori
                FROM reservasi r
                JOIN users u ON r.user_id = u.id
                JOIN paket p ON r.paket_id = p.id
                ORDER BY r.created_at DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getStats() {
        $stats = [];
        $result = $this->db->query("SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'dikonfirmasi' THEN 1 ELSE 0 END) as dikonfirmasi,
            SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai,
            SUM(CASE WHEN status = 'batal' THEN 1 ELSE 0 END) as batal,
            SUM(CASE WHEN status_pembayaran = 'lunas' THEN total_harga ELSE 0 END) as total_lunas,
            SUM(CASE WHEN status_pembayaran = 'dp' THEN dp_dibayar ELSE 0 END) as total_dp_masuk,
            SUM(CASE WHEN status_pembayaran = 'dp' THEN 1 ELSE 0 END) as jumlah_dp,
            SUM(CASE WHEN status_pembayaran = 'lunas' THEN 1 ELSE 0 END) as jumlah_lunas,
            SUM(CASE WHEN status_pembayaran = 'belum' THEN 1 ELSE 0 END) as jumlah_belum
            FROM reservasi WHERE status != 'batal'");
        return $result ? $result->fetch_assoc() : [];
    }

    public function getMonthlyStats($year = null) {
        if (!$year) $year = date('Y');
        $sql = "SELECT 
            MONTH(tanggal_reservasi) as bulan,
            COUNT(*) as total,
            SUM(CASE WHEN status_pembayaran = 'lunas' THEN total_harga ELSE 0 END) as pendapatan
            FROM reservasi 
            WHERE YEAR(tanggal_reservasi) = ? AND status != 'batal'
            GROUP BY MONTH(tanggal_reservasi)
            ORDER BY bulan";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $year);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE reservasi SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('si', $status, $id);
        return $stmt->execute();
    }

    public function updateBukti($id, $filename) {
        $sql = "UPDATE reservasi SET bukti_pembayaran = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('si', $filename, $id);
        return $stmt->execute();
    }

    public function updatePaymentStatus($id, $status) {
        $sql = "UPDATE reservasi SET status_pembayaran = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('si', $status, $id);
        return $stmt->execute();
    }

    public function updateDpDibayar($id, $amount) {
        $sql = "UPDATE reservasi SET dp_dibayar = ?, status_pembayaran = 'dp' WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('di', $amount, $id);
        return $stmt->execute();
    }

    public function markWASent($id) {
        $sql = "UPDATE reservasi SET whatsapp_sent = 1 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getMonthlyIncome($year) {
        $sql = "SELECT 
            MONTH(tanggal_reservasi) as bulan,
            COUNT(*) as jumlah_booking,
            SUM(total_harga) as total_tagihan,
            SUM(dp_dibayar) as total_dp_masuk,
            SUM(CASE WHEN status_pembayaran = 'lunas' THEN total_harga ELSE 0 END) as pendapatan_lunas,
            SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as jumlah_selesai
            FROM reservasi 
            WHERE YEAR(tanggal_reservasi) = ? AND status != 'batal'
            GROUP BY MONTH(tanggal_reservasi)
            ORDER BY bulan";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $year);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getYearlyIncome() {
        $sql = "SELECT 
            YEAR(tanggal_reservasi) as tahun,
            COUNT(*) as jumlah_booking,
            SUM(total_harga) as total_tagihan,
            SUM(dp_dibayar) as total_dp_masuk,
            SUM(CASE WHEN status_pembayaran = 'lunas' THEN total_harga ELSE 0 END) as pendapatan_lunas,
            SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as jumlah_selesai
            FROM reservasi 
            WHERE status != 'batal' AND tanggal_reservasi IS NOT NULL
            GROUP BY YEAR(tanggal_reservasi)
            ORDER BY tahun DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getYearList() {
        $sql = "SELECT DISTINCT YEAR(tanggal_reservasi) as tahun 
                FROM reservasi 
                WHERE tanggal_reservasi IS NOT NULL AND status != 'batal'
                ORDER BY tahun DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getTopPaketByYear($year) {
        $sql = "SELECT p.nama_paket, COUNT(r.id) as jumlah, SUM(r.total_harga) as total
                FROM reservasi r
                JOIN paket p ON r.paket_id = p.id
                WHERE YEAR(r.tanggal_reservasi) = ? AND r.status != 'batal'
                GROUP BY r.paket_id, p.nama_paket
                ORDER BY jumlah DESC
                LIMIT 5";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $year);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>