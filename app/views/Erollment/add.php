<?php
// File: views/Enrollment/add.php
require_once __DIR__ . "/../../config/database.php";

try {
    $students = $pdo->query("SELECT * FROM SinhVien")->fetchAll(PDO::FETCH_ASSOC);
    $courses = $pdo->query("SELECT * FROM HocPhan")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $MaHP = $_POST['MaHP'];
    $NgayDK = date('Y-m-d');
    
    $stmt = $pdo->prepare("INSERT INTO DangKy (NgayDK, MaSV) VALUES (?, ?)");
    $stmt->execute([$NgayDK, $MaSV]);
    $MaDK = $pdo->lastInsertId();
    
    $stmt = $pdo->prepare("INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)");
    $stmt->execute([$MaDK, $MaHP]);
    
    header("Location: list.php");
    exit();
}
?>

<html>
<head><title>Đăng Ký Học Phần</title></head>
<body>
    <h1>Đăng Ký Học Phần</h1>
    <form method="post">
        <label>Sinh Viên:
            <select name="MaSV" required>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['MaSV'] ?>"> <?= $student['HoTen'] ?> </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Học Phần:
            <select name="MaHP" required>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course['MaHP'] ?>"> <?= $course['TenHP'] ?> </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <button type="submit">Đăng Ký</button>
    </form>
</body>
</html>