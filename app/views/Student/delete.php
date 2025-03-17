<?php
require_once __DIR__ . "/../../config/database.php";

if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];

    try {
        // Xóa dữ liệu liên quan trước khi xóa sinh viên
        $pdo->prepare("DELETE FROM ChiTietDangKy WHERE MaDK IN (SELECT MaDK FROM DangKy WHERE MaSV = ?)")->execute([$MaSV]);
        $pdo->prepare("DELETE FROM DangKy WHERE MaSV = ?")->execute([$MaSV]);

        // Xóa sinh viên
        $stmt = $pdo->prepare("DELETE FROM SinhVien WHERE MaSV = ?");
        $stmt->execute([$MaSV]);

        header("Location: list.php");
        exit();
    } catch (PDOException $e) {
        die("Lỗi xóa sinh viên: " . $e->getMessage());
    }
} else {
    die("Mã sinh viên không hợp lệ.");
}
?>
