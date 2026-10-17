<?php
require_once __DIR__ . '/../core/Model.php';

class UserModel extends Model {
    public $table = 'users';

    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $sql = "INSERT INTO users (username, password, nama, email, no_hp, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ssssss', $data['username'], $data['password'], $data['nama'], $data['email'], $data['no_hp'], $data['role']);
        try {
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }
}
?>