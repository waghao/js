<?php
require_once __DIR__ . "/../../config/database.php";

// Lấy danh sách học phần
try {
    $stmt = $pdo->query("SELECT * FROM HocPhan");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}

// Xử lý đăng ký học phần
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['MaHP'])) {
    $MaSV = 1; // Giả sử sinh viên có mã 1 (cần thay bằng session user)
    $MaHP = $_POST['MaHP'];
    
    try {
        // Kiểm tra sinh viên đã đăng ký chưa
        $checkStmt = $pdo->prepare("SELECT * FROM ChiTietDangKy WHERE MaHP = ? AND MaDK IN (SELECT MaDK FROM DangKy WHERE MaSV = ?)");
        $checkStmt->execute([$MaHP, $MaSV]);
        if ($checkStmt->rowCount() > 0) {
            echo "<script>alert('Bạn đã đăng ký học phần này!');</script>";
        } else {
            // Thêm vào bảng DangKy nếu chưa có
            $pdo->beginTransaction();
            $insertDK = $pdo->prepare("INSERT INTO DangKy (NgayDK, MaSV) VALUES (NOW(), ?) ON DUPLICATE KEY UPDATE NgayDK=NOW()");
            $insertDK->execute([$MaSV]);
            
            // Lấy MaDK
            $MaDK = $pdo->lastInsertId();
            
            // Thêm vào bảng ChiTietDangKy
            $insertCTDK = $pdo->prepare("INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)");
            $insertCTDK->execute([$MaDK, $MaHP]);
            
            $pdo->commit();
            echo "<script>alert('Đăng ký thành công!'); window.location.href='list.php';</script>";
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Lỗi đăng ký: " . $e->getMessage());
    }
}
?>

<html>
<head>
    <title>Đăng Ký Học Phần</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">DANH SÁCH HỌC PHẦN</h1>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Mã Học Phần</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= htmlspecialchars($course['MaHP']) ?></td>
                    <td><?= htmlspecialchars($course['TenHP']) ?></td>
                    <td><?= htmlspecialchars($course['SoTinChi']) ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="MaHP" value="<?= htmlspecialchars($course['MaHP']) ?>">
                            <button type="submit" class="btn btn-success">Đăng Ký</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>