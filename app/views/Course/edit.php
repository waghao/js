<?php
require_once __DIR__ . "/../../config/database.php";

if (isset($_GET['MaHP'])) {
    $MaHP = $_GET['MaHP'];
    $stmt = $pdo->prepare("SELECT * FROM HocPhan WHERE MaHP = ?");
    $stmt->execute([$MaHP]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaHP = $_POST['MaHP'];
    $TenHP = $_POST['TenHP'];
    $SoTinChi = $_POST['SoTinChi'];

    $stmt = $pdo->prepare("UPDATE HocPhan SET TenHP = ?, SoTinChi = ? WHERE MaHP = ?");
    $stmt->execute([$TenHP, $SoTinChi, $MaHP]);
    header("Location: list.php");
    exit();
}
?>

<html>
<head><title>Chỉnh Sửa Học Phần</title></head>
<body>
    <h1>Chỉnh Sửa Học Phần</h1>
    <form method="post">
        <input type="hidden" name="MaHP" value="<?= $course['MaHP'] ?>">
        <label>Tên HP: <input type="text" name="TenHP" value="<?= $course['TenHP'] ?>" required></label><br>
        <label>Số Tín Chỉ: <input type="number" name="SoTinChi" value="<?= $course['SoTinChi'] ?>" required></label><br>
        <button type="submit">Lưu</button>
    </form>
</body>
</html>
