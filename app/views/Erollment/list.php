<?php
// File: views/Enrollment/list.php
require_once __DIR__ . "/../../config/database.php";

try {
    $stmt = $pdo->query("SELECT DangKy.MaDK, DangKy.NgayDK, SinhVien.HoTen, HocPhan.TenHP 
                         FROM DangKy 
                         JOIN SinhVien ON DangKy.MaSV = SinhVien.MaSV 
                         JOIN ChiTietDangKy ON DangKy.MaDK = ChiTietDangKy.MaDK 
                         JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP");
    $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div class='alert alert-danger'>Lỗi truy vấn: " . $e->getMessage() . "</div>");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Đăng Ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h1 class="text-center text-primary">📋 Danh Sách Đăng Ký</h1>
    <div class="text-end mb-3">
        <a href="add.php" class="btn btn-success">➕ Đăng Ký Mới</a>
    </div>
    <table class="table table-bordered table-hover shadow">
        <thead class="table-dark">
            <tr>
                <th>Mã ĐK</th>
                <th>📅 Ngày Đăng Ký</th>
                <th>👨‍🎓 Sinh Viên</th>
                <th>📚 Học Phần</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($enrollments)): ?>
                <?php foreach ($enrollments as $enrollment): ?>
                <tr>
                    <td><?= htmlspecialchars($enrollment['MaDK']) ?></td>
                    <td><?= htmlspecialchars($enrollment['NgayDK']) ?></td>
                    <td><?= htmlspecialchars($enrollment['HoTen']) ?></td>
                    <td><?= htmlspecialchars($enrollment['TenHP']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">🚫 Không có đăng ký nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
