<?php
// Determine layout mode: 'admin', 'customer', or 'landing'
// This header is only used for admin & customer pages
$role       = $_SESSION['role'] ?? 'guest';
$nama       = $_SESSION['nama'] ?? 'User';
$avatar     = strtoupper(substr($nama, 0, 1));
$isAdmin    = $role === 'admin';
$currentPage = $_GET['page'] ?? '';

$adminLinks = [
    ['url' => 'admin/dashboard',   'icon' => 'fas fa-chart-line',    'label' => 'Dashboard'],
    ['url' => 'admin/reservasi',   'icon' => 'fas fa-calendar-check', 'label' => 'Reservasi'],
    ['url' => 'admin/paket',       'icon' => 'fas fa-box-open',       'label' => 'Paket Layanan'],
    ['url' => 'admin/hari_libur',  'icon' => 'fas fa-calendar-times', 'label' => 'Hari Libur'],
    ['url' => 'admin/laporan',     'icon' => 'fas fa-chart-bar',      'label' => 'Laporan Keuangan'],
    ['url' => 'admin/pengaturan',  'icon' => 'fas fa-cog',            'label' => 'Pengaturan'],
];
$customerLinks = [
    ['url' => 'customer/dashboard',          'icon' => 'fas fa-home',         'label' => 'Dashboard'],
    ['url' => 'customer/reservasi/create',   'icon' => 'fas fa-calendar-plus', 'label' => 'Booking Baru'],
    ['url' => 'customer/reservasi/riwayat',  'icon' => 'fas fa-history',       'label' => 'Riwayat Booking'],
];
$links = $isAdmin ? $adminLinks : $customerLinks;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio MUA ULVA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,400&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-name">
            <i class="fas fa-spa"></i>
            MUA ULVA
        </div>
        <div class="sidebar-role-badge">
            <?= $isAdmin ? '✦ Admin Panel' : '✦ Customer Area' ?>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-nav-label">Menu Utama</div>
        <div class="sidebar-nav-section">
            <?php foreach ($links as $link): ?>
            <a href="index.php?page=<?= $link['url'] ?>" 
               class="sidebar-nav-link <?= ($currentPage === $link['url']) ? 'active' : '' ?>">
                <i class="<?= $link['icon'] ?>"></i>
                <?= $link['label'] ?>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="sidebar-nav-label" style="margin-top:1rem;">Umum</div>
        <div class="sidebar-nav-section">
            <a href="index.php" class="sidebar-nav-link">
                <i class="fas fa-globe"></i>
                Landing Page
            </a>
            <a href="index.php?page=logout" class="sidebar-nav-link" style="color: rgba(232,112,112,0.75);">
                <i class="fas fa-sign-out-alt"></i>
                Keluar
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar"><?= $avatar ?></div>
            <div>
                <div class="sidebar-user-name"><?= htmlspecialchars($nama) ?></div>
                <div class="sidebar-user-role"><?= $isAdmin ? 'Administrator' : 'Customer' ?></div>
            </div>
        </div>
    </div>
</aside>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <!-- Topbar -->
    <div class="topbar">
        <div class="d-flex align-center gap-sm">
            <button class="hamburger" onclick="toggleSidebar()">
                <span></span><span></span><span></span>
            </button>
            <div class="topbar-title" id="topbarTitle">Dashboard</div>
        </div>
        <div class="topbar-actions">
            <div style="font-size:0.85rem; color:var(--clr-muted);">
                <i class="far fa-user me-1"></i> <?= htmlspecialchars($nama) ?>
            </div>
            <a href="index.php?page=logout" class="btn btn-sm btn-outline-gold">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
    </div>

    <div class="page-content">