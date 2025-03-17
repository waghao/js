<?php
require_once __DIR__ . "/../../config/database.php";

try {
    $stmt = $pdo->query("SELECT SinhVien.*, NganhHoc.TenNganh FROM SinhVien JOIN NganhHoc ON SinhVien.MaNganh = NganhHoc.MaNganh");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div class='alert alert-danger'>Lỗi truy vấn: " . $e->getMessage() . "</div>");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Danh Sách Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1 class="text-center mb-4">📋 Danh Sách Sinh Viên</h1>
    <a href="add.php" class="btn btn-primary mb-3">➕ Thêm Sinh Viên</a>
    <table class="table table-striped table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Mã SV</th>
                <th>Họ Tên</th>
                <th>Giới Tính</th>
                <th>Ngày Sinh</th>
                <th>Hình</th>
                <th>Ngành</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['MaSV']) ?></td>
                    <td><?= htmlspecialchars($student['HoTen']) ?></td>
                    <td><?= htmlspecialchars($student['GioiTinh']) ?></td>
                    <td><?= htmlspecialchars($student['NgaySinh']) ?></td>
                    <td>
                        <?php if (!empty($student['Hinh']) && file_exists(__DIR__ . "/../../public/uploads/" . $student['Hinh'])): ?>
                            <img src="/public/uploads/<?= htmlspecialchars($student['Hinh']) ?>" width="50" class="rounded-circle">
                        <?php else: ?>
                            <span class="text-muted">Không có ảnh</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($student['TenNganh']) ?></td>
                    <td>
                        <a href="detail.php?MaSV=<?= urlencode($student['MaSV']) ?>" class="btn btn-info btn-sm">👁️ Xem</a>
                        <a href="edit.php?MaSV=<?= urlencode($student['MaSV']) ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
                        <a href="delete.php?MaSV=<?= urlencode($student['MaSV']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">🗑️ Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted">Không có sinh viên nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
