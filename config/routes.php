<?php
$routes = [
    ''                                  => ['controller' => 'LandingController',  'action' => 'index'],
    'home'                              => ['controller' => 'LandingController',  'action' => 'index'],
    'login'                             => ['controller' => 'AuthController',     'action' => 'login'],
    'logout'                            => ['controller' => 'AuthController',     'action' => 'logout'],
    'register'                          => ['controller' => 'AuthController',     'action' => 'register'],
    'dashboard'                         => ['controller' => 'DashboardController','action' => 'index'],

    // Admin
    'admin/dashboard'                   => ['controller' => 'DashboardController','action' => 'adminIndex'],
    'admin/paket'                       => ['controller' => 'PaketController',    'action' => 'index'],
    'admin/paket/create'                => ['controller' => 'PaketController',    'action' => 'create'],
    'admin/paket/edit'                  => ['controller' => 'PaketController',    'action' => 'edit'],
    'admin/paket/delete'                => ['controller' => 'PaketController',    'action' => 'delete'],
    'admin/paket/delete_image'          => ['controller' => 'PaketController',    'action' => 'deleteImage'],
    'admin/reservasi'                   => ['controller' => 'ReservasiController','action' => 'indexAdmin'],
    'admin/reservasi/detail'            => ['controller' => 'ReservasiController','action' => 'detailAdmin'],
    'admin/reservasi/update'            => ['controller' => 'ReservasiController','action' => 'updateStatus'],
    'admin/reservasi/update_pembayaran' => ['controller' => 'ReservasiController','action' => 'updatePembayaran'],
    'admin/hari_libur'                  => ['controller' => 'HariLiburController','action' => 'index'],
    'admin/hari_libur/store'            => ['controller' => 'HariLiburController','action' => 'store'],
    'admin/hari_libur/delete'           => ['controller' => 'HariLiburController','action' => 'delete'],
    'admin/pengaturan'                  => ['controller' => 'PengaturanController','action' => 'index'],
    'admin/laporan'                     => ['controller' => 'LaporanController',   'action' => 'index'],

    // Customer
    'customer/dashboard'                => ['controller' => 'DashboardController','action' => 'customerIndex'],
    'customer/reservasi/create'         => ['controller' => 'ReservasiController','action' => 'create'],
    'customer/reservasi/store'          => ['controller' => 'ReservasiController','action' => 'store'],
    'customer/reservasi/konfirmasi'     => ['controller' => 'ReservasiController','action' => 'konfirmasi'],
    'customer/reservasi/riwayat'        => ['controller' => 'ReservasiController','action' => 'riwayat'],
    'customer/pembayaran/upload'        => ['controller' => 'ReservasiController','action' => 'uploadBukti'],
    'customer/reservasi/struk'          => ['controller' => 'ReservasiController','action' => 'struk'],

    // AJAX endpoints
    'api/slots'                         => ['controller' => 'ReservasiController','action' => 'getSlots'],
    'api/calendar'                      => ['controller' => 'ReservasiController','action' => 'getCalendar'],
];
?>