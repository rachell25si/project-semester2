<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/ReservasiModel.php';

class LaporanController extends Controller {

    public function index() {
        $this->requireAdmin();

        $reservasiModel = new ReservasiModel();

        $selectedYear = (int)($_GET['year'] ?? date('Y'));
        $yearList     = $reservasiModel->getYearList();

        // If no data at all, still include current year as option
        $hasCurrentYear = false;
        foreach ($yearList as $y) {
            if ((int)$y['tahun'] === (int)date('Y')) { $hasCurrentYear = true; break; }
        }
        if (!$hasCurrentYear) {
            array_unshift($yearList, ['tahun' => date('Y')]);
        }

        $monthlyRaw  = $reservasiModel->getMonthlyIncome($selectedYear);
        $yearlyAll   = $reservasiModel->getYearlyIncome();
        $topPaket    = $reservasiModel->getTopPaketByYear($selectedYear);

        // Build full 12-month array
        $bulanNames = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
        $monthlyMap = array_column($monthlyRaw, null, 'bulan');
        $monthly    = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthly[$i] = $monthlyMap[$i] ?? [
                'bulan'           => $i,
                'jumlah_booking'  => 0,
                'total_tagihan'   => 0,
                'total_dp_masuk'  => 0,
                'pendapatan_lunas'=> 0,
                'jumlah_selesai'  => 0,
            ];
        }

        // Summary for selected year
        $totalBooking    = array_sum(array_column($monthly, 'jumlah_booking'));
        $totalTagihan    = array_sum(array_column($monthly, 'total_tagihan'));
        $totalDpMasuk    = array_sum(array_column($monthly, 'total_dp_masuk'));
        $totalLunas      = array_sum(array_column($monthly, 'pendapatan_lunas'));

        // Chart data
        $chartLabels   = json_encode(array_values(array_slice($bulanNames, 1)));
        $chartPendapatan = json_encode(array_map(fn($m) => (float)($m['pendapatan_lunas'] ?? 0), array_values($monthly)));
        $chartBooking    = json_encode(array_map(fn($m) => (int)($m['jumlah_booking'] ?? 0), array_values($monthly)));

        $this->view('admin/laporan/index', [
            'selectedYear'  => $selectedYear,
            'yearList'      => $yearList,
            'monthly'       => $monthly,
            'yearlyAll'     => $yearlyAll,
            'topPaket'      => $topPaket,
            'totalBooking'  => $totalBooking,
            'totalTagihan'  => $totalTagihan,
            'totalDpMasuk'  => $totalDpMasuk,
            'totalLunas'    => $totalLunas,
            'bulanNames'    => $bulanNames,
            'chartLabels'   => $chartLabels,
            'chartPendapatan'=> $chartPendapatan,
            'chartBooking'  => $chartBooking,
        ]);
    }
}
?>
