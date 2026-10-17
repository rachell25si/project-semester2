<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/PengaturanModel.php';

class PengaturanController extends Controller {

    public function index() {
        $this->requireAdmin();
        $model = new PengaturanModel();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jam_mulai          = $_POST['jam_mulai'] ?? '03:00';
            $jam_selesai        = $_POST['jam_selesai'] ?? '23:00';
            $durasi_slot_menit  = (int)($_POST['durasi_slot_menit'] ?? 120);

            // Format as time H:i:s
            $jam_mulai_formatted = date('H:i:s', strtotime($jam_mulai));
            $jam_selesai_formatted = date('H:i:s', strtotime($jam_selesai));

            if ($model->update($jam_mulai_formatted, $jam_selesai_formatted, $durasi_slot_menit)) {
                $_SESSION['setting_success'] = 'Pengaturan operasional berhasil diperbarui!';
            } else {
                $_SESSION['setting_error'] = 'Gagal memperbarui pengaturan.';
            }
            $this->redirect('admin/pengaturan');
            return;
        }

        $setting = $model->getSetting();
        $this->view('admin/pengaturan/index', ['setting' => $setting]);
    }
}
?>
