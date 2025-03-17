<?php
require_once __DIR__ . "/../../config/database.php";

if (isset($_GET['MaHP'])) {
    $MaHP = $_GET['MaHP'];
    $stmt = $pdo->prepare("SELECT * FROM HocPhan WHERE MaHP = ?");
    $stmt->execute([$MaHP]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    die("Mã học phần không hợp lệ.");
}
?>

<html>
<head><title>Chi Tiết Học Phần</title></head>
<body>
    <h1>Chi Tiết Học Phần</h1>
    <p><strong>Mã HP:</strong> <?= htmlspecialchars($course['MaHP']) ?></p>
    <p><strong>Tên HP:</strong> <?= htmlspecialchars($course['TenHP']) ?></p>
    <p><strong>Số Tín Chỉ:</strong> <?= htmlspecialchars($course['SoTinChi']) ?></p>
    <a href="list.php">Quay lại danh sách</a>
</body>
</html>
