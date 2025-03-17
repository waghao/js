<?php
require_once __DIR__ . "/../../config/database.php";

if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];
    $stmt = $pdo->prepare("SELECT * FROM SinhVien WHERE MaSV = ?");
    $stmt->execute([$MaSV]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    die("Mã sinh viên không hợp lệ.");
}
?>

<html>
<head><title>Chi Tiết Sinh Viên</title></head>
<body>
    <h1>Chi Tiết Sinh Viên</h1>
    <p><strong>Mã SV:</strong> <?= htmlspecialchars($student['MaSV']) ?></p>
    <p><strong>Họ Tên:</strong> <?= htmlspecialchars($student['HoTen']) ?></p>
    <p><strong>Giới Tính:</strong> <?= htmlspecialchars($student['GioiTinh']) ?></p>
    <p><strong>Ngày Sinh:</strong> <?= htmlspecialchars($student['NgaySinh']) ?></p>
    <p><strong>Mã Ngành:</strong> <?= htmlspecialchars($student['MaNganh']) ?></p>
    <p><strong>Hình:</strong><br>
        <?php if (!empty($student['Hinh']) && file_exists(__DIR__ . "/../../public/uploads/" . $student['Hinh'])): ?>
            <img src="/public/uploads/<?= htmlspecialchars($student['Hinh']) ?>" width="150">
        <?php else: ?>
            Không có ảnh
        <?php endif; ?>
    </p>
    <a href="list.php">Quay lại danh sách</a>
</body>
</html>