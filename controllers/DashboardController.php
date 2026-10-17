<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/ReservasiModel.php';

class DashboardController extends Controller {

    public function adminIndex() {
        $this->requireAdmin();
        $reservasiModel = new ReservasiModel();
        $all            = $reservasiModel->getAllWithDetails();
        $stats          = $reservasiModel->getStats();
        $monthly        = $reservasiModel->getMonthlyStats(date('Y'));

        // Format monthly for chart
        $chartLabels  = [];
        $chartData    = [];
        $namabulan    = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyMap   = array_column($monthly, null, 'bulan');
        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $namabulan[$i];
            $chartData[]   = isset($monthlyMap[$i]) ? (int)$monthlyMap[$i]['total'] : 0;
        }

        $this->view('admin/dashboard', [
            'stats'        => $stats,
            'reservasi'    => array_slice($all, 0, 15),
            'chartLabels'  => json_encode($chartLabels),
            'chartData'    => json_encode($chartData),
        ]);
    }

    public function customerIndex() {
        $this->requireCustomer();
        $reservasiModel = new ReservasiModel();
        $reservasi      = $reservasiModel->getByUser($_SESSION['user_id']);
        $this->view('customer/dashboard', ['reservasi' => $reservasi]);
    }

    public function index() {
        $this->requireLogin();
        if ($this->isAdmin()) {
            $this->adminIndex();
        } else {
            $this->customerIndex();
        }
    }
}
?>