<?php
require_once __DIR__ . "/../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaHP = $_POST['MaHP'];
    $TenHP = $_POST['TenHP'];
    $SoTinChi = $_POST['SoTinChi'];

    $stmt = $pdo->prepare("INSERT INTO HocPhan (MaHP, TenHP, SoTinChi) VALUES (?, ?, ?)");
    $stmt->execute([$MaHP, $TenHP, $SoTinChi]);
    header("Location: list.php");
    exit();
}
?>

<html>
<head><title>Thêm Học Phần</title></head>
<body>
    <h1>Thêm Học Phần</h1>
    <form method="post">
        <label>Mã HP: <input type="text" name="MaHP" required></label><br>
        <label>Tên HP: <input type="text" name="TenHP" required></label><br>
        <label>Số Tín Chỉ: <input type="number" name="SoTinChi" required></label><br>
        <button type="submit">Thêm</button>
    </form>
</body>
</html>