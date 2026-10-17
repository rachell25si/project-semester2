<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController extends Controller {

    public function login() {
        $redirect  = $_GET['redirect']  ?? $_POST['redirect']  ?? '';
        $paket_id  = $_GET['paket_id']  ?? $_POST['paket_id']  ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username  = trim($_POST['username'] ?? '');
            $password  = $_POST['password'] ?? '';
            $userModel = new UserModel();
            $user      = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];
                $_SESSION['nama']     = $user['nama'];
                $_SESSION['no_hp']    = $user['no_hp'];

                if (!empty($redirect)) {
                    header("Location: index.php?page=$redirect" . ($paket_id ? "&paket_id=$paket_id" : ''));
                    exit;
                } elseif ($user['role'] === 'admin') {
                    $this->redirect('admin/dashboard');
                } else {
                    // Customer: go to booking if paket_id provided
                    if ($paket_id) {
                        header("Location: index.php?page=customer/reservasi/create&paket_id=$paket_id");
                        exit;
                    }
                    $this->redirect('customer/dashboard');
                }
            } else {
                $error = "Username atau password salah!";
                $this->view('auth/login', ['error' => $error, 'redirect' => $redirect, 'paket_id' => $paket_id], false);
            }
        } else {
            $this->view('auth/login', ['redirect' => $redirect, 'paket_id' => $paket_id], false);
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit;
    }

    public function register() {
        $redirect = $_GET['redirect'] ?? $_POST['redirect'] ?? '';
        $paket_id = $_GET['paket_id'] ?? $_POST['paket_id'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new UserModel();
            $username  = trim($_POST['username'] ?? '');
            
            // Check username exists
            $existing = $userModel->findByUsername($username);
            if ($existing) {
                $error = "Username sudah digunakan. Pilih username lain.";
                $this->view('auth/register', ['error' => $error, 'redirect' => $redirect, 'paket_id' => $paket_id], false);
                return;
            }

            // Check email exists
            $email = $_POST['email'] ?? '';
            if ($email) {
                $existingEmail = $userModel->findByEmail($email);
                if ($existingEmail) {
                    $error = "Email sudah terdaftar. Silakan gunakan email lain atau login.";
                    $this->view('auth/register', ['error' => $error, 'redirect' => $redirect, 'paket_id' => $paket_id], false);
                    return;
                }
            }

            $data = [
                'username' => $username,
                'password' => password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT),
                'nama'     => $_POST['nama'] ?? '',
                'email'    => $_POST['email'] ?? '',
                'no_hp'    => $_POST['no_hp'] ?? '',
                'role'     => 'customer'
            ];
            if ($userModel->create($data)) {
                // Auto login after register
                $user = $userModel->findByUsername($username);
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];
                $_SESSION['nama']     = $user['nama'];
                $_SESSION['no_hp']    = $user['no_hp'];

                if ($paket_id) {
                    header("Location: index.php?page=customer/reservasi/create&paket_id=$paket_id");
                    exit;
                }
                $this->redirect('customer/dashboard');
            } else {
                $error = "Registrasi gagal, coba lagi.";
                $this->view('auth/register', ['error' => $error, 'redirect' => $redirect, 'paket_id' => $paket_id], false);
            }
        } else {
            $this->view('auth/register', ['redirect' => $redirect, 'paket_id' => $paket_id], false);
        }
    }
}
?>