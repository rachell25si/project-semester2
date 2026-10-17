<?php
require_once 'config/database.php';

$password = password_hash('admin123', PASSWORD_DEFAULT);
$sql = "UPDATE users SET password = '$password' WHERE username = 'admin'";

if ($conn->query($sql)) {
    echo "✅ Password admin berhasil direset!";
} else {
    echo "❌ Error: " . $conn->error;
}
