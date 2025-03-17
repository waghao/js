<?php
require_once __DIR__ . "/../../config/database.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Kiểm tra xem mã sinh viên đã tồn tại chưa
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM SinhVien WHERE MaSV = ?");
    $checkStmt->execute([$MaSV]);
    if ($checkStmt->fetchColumn() > 0) {
        $error = "Mã sinh viên đã tồn tại!";
    } else {
        // Xử lý upload ảnh
        $Hinh = "";
        if (!empty($_FILES['Hinh']['name'])) {
            $target_dir = __DIR__ . "/../../public/uploads/";
            $Hinh = time() . "_" . basename($_FILES['Hinh']['name']); // Đổi tên file để tránh trùng
            $target_file = $target_dir . $Hinh;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Chỉ cho phép các định dạng ảnh hợp lệ
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedTypes)) {
                $error = "Chỉ chấp nhận file ảnh (JPG, JPEG, PNG, GIF).";
            } else {
                if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $target_file)) {
                    $stmt = $pdo->prepare("INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) VALUES (?, ?, ?, ?, ?, ?)");
                    if ($stmt->execute([$MaSV, $HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh])) {
                        $success = "Thêm sinh viên thành công!";
                    } else {
                        $error = "Lỗi khi thêm sinh viên.";
                    }
                } else {
                    $error = "Lỗi khi upload ảnh.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Thêm Sinh Viên</h3>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Mã SV</label>
                        <input type="text" name="MaSV" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Họ Tên</label>
                        <input type="text" name="HoTen" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giới Tính</label>
                        <select name="GioiTinh" class="form-select" required>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày Sinh</label>
                        <input type="date" name="NgaySinh" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh Đại Diện</label>
                        <input type="file" name="Hinh" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mã Ngành</label>
                        <input type="text" name="MaNganh" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Thêm Sinh Viên</button>
                    <a href="list.php" class="btn btn-secondary">Quay lại danh sách</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
