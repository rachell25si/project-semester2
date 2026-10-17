<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/HariLiburModel.php';

class HariLiburController extends Controller {

    public function index() {
        $this->requireAdmin();
        $model     = new HariLiburModel();
        $hariLibur = $model->getAll();
        $this->view('admin/hari_libur/index', ['hariLibur' => $hariLibur]);
    }

    public function store() {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tanggal    = $_POST['tanggal'] ?? '';
            $keterangan = $_POST['keterangan'] ?? 'Libur Studio';
            if ($tanggal) {
                $model = new HariLiburModel();
                $model->create($tanggal, $keterangan);
            }
        }
        $this->redirect('admin/hari_libur');
    }

    public function delete() {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $model = new HariLiburModel();
            $model->delete($id);
        }
        $this->redirect('admin/hari_libur');
    }
}
?>
