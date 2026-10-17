<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/ReservasiModel.php';
require_once __DIR__ . '/../models/PaketModel.php';
require_once __DIR__ . '/../models/JadwalModel.php';
require_once __DIR__ . '/../models/HariLiburModel.php';

class ReservasiController extends Controller {

    /**
     * One-page booking form for customers
     */
    public function create() {
        $this->requireCustomer();

        $paketModel = new PaketModel();
        $paket      = $paketModel->getAllWithImages();

        $hariLiburModel = new HariLiburModel();
        $hariLibur      = $hariLiburModel->getLiburDates();

        // Pre-selected paket from landing page
        $preselect_paket_id = $_GET['paket_id'] ?? null;

        $this->view('customer/reservasi/create', [
            'paket'              => $paket,
            'hariLibur'          => $hariLibur,
            'preselect_paket_id' => $preselect_paket_id,
        ]);
    }

    /**
     * AJAX: Return available slots for a given date + paket
     */
    public function getSlots() {
        $this->requireCustomer();
        header('Content-Type: application/json');

        $tanggal  = $_GET['tanggal']  ?? '';
        $paket_id = $_GET['paket_id'] ?? 0;

        if (!$tanggal) {
            echo json_encode(['error' => 'Tanggal diperlukan']);
            exit;
        }

        $jadwalModel = new JadwalModel();
        $paketModel  = new PaketModel();

        $paket = $paketModel->getById($paket_id);
        $isWedding = $paket && $paket['kategori'] === 'wedding';

        $result = $jadwalModel->getAvailableSlotsForDate($tanggal, $paket_id);
        $result['is_wedding'] = $isWedding;

        if ($isWedding) {
            // For wedding: entire day is one slot
            if (!$result['libur'] && !($result['full_day_wedding'] ?? false)) {
                // Check if any booking exists on this day
                $anyBooking = $this->db->query("SELECT COUNT(*) as c FROM reservasi WHERE tanggal_reservasi = '$tanggal' AND status NOT IN ('batal')")->fetch_assoc();
                $result['wedding_available'] = $anyBooking['c'] == 0;
            } else {
                $result['wedding_available'] = false;
            }
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Get calendar status for a month (AJAX)
     */
    public function getCalendar() {
        $this->requireCustomer();
        header('Content-Type: application/json');

        $tahun = (int)($_GET['tahun'] ?? date('Y'));
        $bulan = (int)($_GET['bulan'] ?? date('m'));

        $jadwalModel = new JadwalModel();
        $status = $jadwalModel->getCalendarStatus($tahun, $bulan);

        echo json_encode($status);
        exit;
    }

    /**
     * Store new reservation
     */
    public function store() {
        $this->requireCustomer();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('customer/reservasi/create');
            return;
        }

        $paket_id           = (int)($_POST['paket_id'] ?? 0);
        $tanggal_reservasi  = $_POST['tanggal_reservasi'] ?? '';
        $jam_mulai          = $_POST['jam_mulai'] ?? '';
        $jam_selesai        = $_POST['jam_selesai'] ?? '';
        $jenis_lokasi       = $_POST['jenis_lokasi'] ?? 'studio';
        $alamat_customer    = $_POST['alamat_customer'] ?? '';
        $catatan            = $_POST['catatan'] ?? '';
        $keterangan         = $_POST['keterangan'] ?? '';

        $paketModel = new PaketModel();
        $paket      = $paketModel->getById($paket_id);

        if (!$paket || !$tanggal_reservasi) {
            $this->redirectWithError('Paket atau tanggal tidak valid.');
            return;
        }

        $isWedding  = $paket['kategori'] === 'wedding';
        $is_full_day = $isWedding ? 1 : 0;

        if ($isWedding) {
            $jam_mulai   = '03:00';
            $jam_selesai = '23:00';
        }

        // Validate required fields
        if (!$jam_mulai || !$jam_selesai) {
            $this->redirectWithError('Pilih slot waktu terlebih dahulu.');
            return;
        }

        // Anti-double booking check
        $jadwalModel = new JadwalModel();
        if (!$jadwalModel->isSlotAvailable($tanggal_reservasi, $jam_mulai, $jam_selesai)) {
            $this->redirectWithError('Maaf, jadwal tersebut sudah dipesan. Silakan pilih waktu lain.');
            return;
        }

        $total_harga = $paket['harga'];
        $dp_persen   = $paket['dp_persen'] ?? 30;
        $total_dp    = $total_harga * ($dp_persen / 100);

        $data = [
            'user_id'          => $_SESSION['user_id'],
            'paket_id'         => $paket_id,
            'tanggal_reservasi'=> $tanggal_reservasi,
            'jam_mulai'        => $jam_mulai,
            'jam_selesai'      => $jam_selesai,
            'is_full_day'      => $is_full_day,
            'status'           => 'pending',
            'status_pembayaran'=> 'belum',
            'total_harga'      => $total_harga,
            'dp_dibayar'       => 0,
            'total_dp'         => $total_dp,
            'bukti_pembayaran' => null,
            'jenis_lokasi'     => $jenis_lokasi,
            'alamat_customer'  => $alamat_customer,
            'catatan'          => $catatan,
            'keterangan'       => $keterangan,
        ];

        $reservasiModel = new ReservasiModel();
        $id = $reservasiModel->create($data);

        if ($id) {
            $this->redirect("customer/reservasi/konfirmasi?id=$id");
        } else {
            $this->redirectWithError('Gagal membuat reservasi. Silakan coba lagi.');
        }
    }

    private function redirectWithError($msg) {
        $_SESSION['booking_error'] = $msg;
        $this->redirect('customer/reservasi/create');
    }

    /**
     * Konfirmasi / success page
     */
    public function konfirmasi() {
        $this->requireCustomer();
        $id = (int)($_GET['id'] ?? 0);

        $reservasiModel = new ReservasiModel();
        $res = $reservasiModel->getById($id);

        if (!$res || $res['user_id'] != $_SESSION['user_id']) {
            $this->redirect('customer/dashboard');
            return;
        }

        // Admin WA number for contact
        $wa_admin = '6281234567890';

        $this->view('customer/reservasi/konfirmasi', [
            'res'      => $res,
            'wa_admin' => $wa_admin,
        ]);
    }

    /**
     * Upload bukti pembayaran DP
     */
    public function uploadBukti() {
        $this->requireCustomer();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bukti'])) {
            $id   = (int)($_POST['reservasi_id'] ?? 0);
            $file = $_FILES['bukti'];

            $target_dir = __DIR__ . '/../public/uploads/bukti/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

            $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed  = ['jpg','jpeg','png','gif','webp','pdf'];
            if (!in_array($ext, $allowed)) {
                $_SESSION['upload_error'] = 'Format file tidak diizinkan.';
                $this->redirect("customer/reservasi/konfirmasi?id=$id");
                return;
            }

            $filename    = 'dp_' . $id . '_' . time() . '.' . $ext;
            $target_file = $target_dir . $filename;

            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                $reservasiModel = new ReservasiModel();
                $reservasiModel->updateBukti($id, $filename);
                $reservasiModel->updatePaymentStatus($id, 'dp');

                // Update dp_dibayar
                $res = $reservasiModel->getById($id);
                if ($res) {
                    $reservasiModel->updateDpDibayar($id, $res['total_dp']);
                }

                $_SESSION['upload_success'] = 'Bukti DP berhasil diupload!';
                $this->redirect("customer/reservasi/struk?id=$id");
            } else {
                $_SESSION['upload_error'] = 'Gagal upload file.';
                $this->redirect("customer/reservasi/konfirmasi?id=$id");
            }
        } else {
            $this->redirect('customer/dashboard');
        }
    }

    /**
     * Struk / receipt page after payment upload
     */
    public function struk() {
        $this->requireCustomer();
        $id = (int)($_GET['id'] ?? 0);

        $reservasiModel = new ReservasiModel();
        $res = $reservasiModel->getById($id);

        if (!$res || $res['user_id'] != $_SESSION['user_id']) {
            $this->redirect('customer/dashboard');
            return;
        }

        $this->view('customer/reservasi/struk', ['res' => $res]);
    }

    /**
     * Riwayat reservasi customer
     */
    public function riwayat() {
        $this->requireCustomer();
        $reservasiModel = new ReservasiModel();
        $reservasi      = $reservasiModel->getByUser($_SESSION['user_id']);
        $this->view('customer/reservasi/riwayat', ['reservasi' => $reservasi]);
    }

    // ==================== ADMIN ====================

    public function indexAdmin() {
        $this->requireAdmin();
        $reservasiModel = new ReservasiModel();
        $reservasi      = $reservasiModel->getAllWithDetails();
        $stats          = $reservasiModel->getStats();
        $this->view('admin/reservasi/index', [
            'reservasi' => $reservasi,
            'stats'     => $stats,
        ]);
    }

    public function detailAdmin() {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $reservasiModel = new ReservasiModel();
        $res = $reservasiModel->getById($id);
        if (!$res) {
            $this->redirect('admin/reservasi');
            return;
        }
        $this->view('admin/reservasi/detail', ['res' => $res]);
    }

    public function updateStatus() {
        $this->requireAdmin();
        $id     = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if ($id && $status) {
            $reservasiModel = new ReservasiModel();
            $reservasiModel->updateStatus($id, $status);
        }
        $this->redirect("admin/reservasi/detail?id=$id");
    }

    public function updatePembayaran() {
        $this->requireAdmin();
        $id     = (int)($_POST['id'] ?? 0);
        $status = $_POST['status_pembayaran'] ?? '';

        if ($id && $status) {
            $reservasiModel = new ReservasiModel();
            $reservasiModel->updatePaymentStatus($id, $status);
            
            if ($status === 'lunas') {
                $res = $reservasiModel->getById($id);
                if ($res) {
                    $reservasiModel->updateDpDibayar($id, $res['total_harga']);
                }
            } else if ($status === 'dp') {
                $res = $reservasiModel->getById($id);
                if ($res) {
                    $reservasiModel->updateDpDibayar($id, $res['total_dp']);
                }
            } else if ($status === 'belum') {
                $reservasiModel->updateDpDibayar($id, 0);
                // Also reset status_pembayaran back to belum because updateDpDibayar might have set it to 'dp'
                $reservasiModel->updatePaymentStatus($id, 'belum');
            }
        }
        $this->redirect("admin/reservasi/detail?id=$id");
    }
}
?>