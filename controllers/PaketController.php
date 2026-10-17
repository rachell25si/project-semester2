<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/PaketModel.php';

class PaketController extends Controller {

    public function index() {
        $this->requireAdmin();
        $model = new PaketModel();
        $paket = $model->getAll();
        $this->view('admin/paket/index', ['paket' => $paket]);
    }

    public function create() {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new PaketModel();
            $data = [
                'nama_paket' => $_POST['nama_paket'] ?? '',
                'deskripsi'  => $_POST['deskripsi']  ?? '',
                'harga'      => (float)($_POST['harga'] ?? 0),
                'durasi_jam' => (int)($_POST['durasi_jam'] ?? 2),
                'kategori'   => $_POST['kategori']   ?? 'regular',
                'dp_persen'  => (int)($_POST['dp_persen'] ?? 30),
            ];
            if ($model->create($data)) {
                $paket_id = $model->getLastInsertId();
                // Handle image upload
                if (!empty($_FILES['gambar']['name'][0])) {
                    $upload_dir = __DIR__ . '/../public/uploads/paket/';
                    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                    foreach ($_FILES['gambar']['name'] as $i => $name) {
                        if (!empty($name)) {
                            $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                            $filename = 'paket_' . $paket_id . '_' . time() . '_' . $i . '.' . $ext;
                            if (move_uploaded_file($_FILES['gambar']['tmp_name'][$i], $upload_dir . $filename)) {
                                $model->addPortofolio($paket_id, 'public/uploads/paket/' . $filename, '');
                            }
                        }
                    }
                }
                $this->redirect('admin/paket');
            } else {
                $error = "Gagal menambah paket.";
                $this->view('admin/paket/create', ['error' => $error]);
            }
        } else {
            $this->view('admin/paket/create', []);
        }
    }

    public function edit() {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $model = new PaketModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_paket' => $_POST['nama_paket'] ?? '',
                'deskripsi'  => $_POST['deskripsi']  ?? '',
                'harga'      => (float)($_POST['harga'] ?? 0),
                'durasi_jam' => (int)($_POST['durasi_jam'] ?? 2),
                'kategori'   => $_POST['kategori']   ?? 'regular',
                'dp_persen'  => (int)($_POST['dp_persen'] ?? 30),
            ];
            $model->update($id, $data);

            // Handle new image uploads
            if (!empty($_FILES['gambar']['name'][0])) {
                $upload_dir = __DIR__ . '/../public/uploads/paket/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                foreach ($_FILES['gambar']['name'] as $i => $name) {
                    if (!empty($name)) {
                        $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                        $filename = 'paket_' . $id . '_' . time() . '_' . $i . '.' . $ext;
                        if (move_uploaded_file($_FILES['gambar']['tmp_name'][$i], $upload_dir . $filename)) {
                            $model->addPortofolio($id, 'public/uploads/paket/' . $filename, '');
                        }
                    }
                }
            }

            $this->redirect('admin/paket');
        } else {
            $paket = $model->getById($id);
            $portofolio = $model->getPortofolioByPaketId($id);
            $this->view('admin/paket/edit', ['paket' => $paket, 'portofolio' => $portofolio]);
        }
    }

    public function deleteImage() {
        $this->requireAdmin();
        $id = (int)($_POST['image_id'] ?? 0);
        $paket_id = (int)($_POST['paket_id'] ?? 0);
        
        if ($id) {
            $model = new PaketModel();
            $model->deletePortofolio($id);
        }
        
        $this->redirect("admin/paket/edit?id=$paket_id");
    }

    public function delete() {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $model = new PaketModel();
            $model->delete($id);
        }
        $this->redirect('admin/paket');
    }
}
?>