<?php
require_once __DIR__ . '/../config/database.php';

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function query($sql) {
        return $this->db->query($sql);
    }

    public function escape($str) {
        return $this->db->real_escape_string($str);
    }
}
?>