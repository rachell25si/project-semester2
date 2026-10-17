<?php
class Controller {
    protected $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    protected function view($view, $data = [], $useLayout = true) {
        extract($data);
        if ($useLayout) {
            include_once __DIR__ . '/../views/layout/header.php';
        }
        include_once __DIR__ . '/../views/' . $view . '.php';
        if ($useLayout) {
            include_once __DIR__ . '/../views/layout/footer.php';
        }
    }

    protected function redirect($url) {
        if (strpos($url, '?') !== false) {
            // Convert first '?' to '&' if 'page=' is prepended
            $url = str_replace('?', '&', $url);
            header("Location: index.php?page=" . $url);
        } else {
            header("Location: index.php?page=" . $url);
        }
        exit;
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    protected function isCustomer() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'customer';
    }

    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('login');
        }
    }

    protected function requireAdmin() {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            $this->redirect('customer/dashboard');
        }
    }

    protected function requireCustomer() {
        $this->requireLogin();
        if (!$this->isCustomer()) {
            $this->redirect('admin/dashboard');
        }
    }
}
?>