<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/PaketModel.php';
require_once __DIR__ . '/../models/TestimoniModel.php';

class LandingController extends Controller {

    public function index() {
        $paketModel = new PaketModel();
        $paket = $paketModel->getAllWithImages();

        $testimoniModel = new TestimoniModel();
        $testimoni = $testimoniModel->getAll();

        // Portfolio all images
        $portofolio = $paketModel->getPortofolioAll();

        $studio = [
            'nama'            => 'Studio MUA ULVA',
            'pemilik'         => 'Ulva',
            'deskripsi'       => 'Studio MUA ULVA adalah layanan jasa tata rias profesional yang siap menemani momen spesial Anda. Dengan pengalaman bertahun-tahun, kami mengutamakan kepuasan pelanggan melalui sentuhan artistik dan produk berkualitas tinggi.',
            'alamat'          => 'Jl. Kaharuddin Nst, Simpang Tiga, Kecamatan Bukit Raya, Pekanbaru',
            'telepon'         => '+62 812-3456-7890',
            'whatsapp'        => '6281234567890',
            'email'           => 'info@muaulva.com',
            'jam_operasional' => 'Setiap Hari: 03.00 – 23.00 WIB',
            'instagram'       => 'muaulva',
            'tiktok'          => 'muaulva',
            'tahun_berdiri'   => 2019,
        ];

        extract([
            'paket'      => $paket,
            'testimoni'  => $testimoni,
            'portofolio' => $portofolio,
            'studio'     => $studio,
        ]);

        include_once __DIR__ . '/../views/landing/index.php';
    }
}
?>