<?php
require_once __DIR__ . "/../../config/database.php";

if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];
    $stmt = $pdo->prepare("SELECT * FROM SinhVien WHERE MaSV = ?");
    $stmt->execute([$MaSV]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Xử lý upload ảnh nếu có
    if (!empty($_FILES['Hinh']['name'])) {
        $target_dir = __DIR__ . "/../../public/uploads/";
        $Hinh = basename($_FILES['Hinh']['name']);
        $target_file = $target_dir . $Hinh;
        move_uploaded_file($_FILES['Hinh']['tmp_name'], $target_file);
    } else {
        $Hinh = $student['Hinh']; // Giữ ảnh cũ nếu không có ảnh mới
    }

    $stmt = $pdo->prepare("UPDATE SinhVien SET HoTen = ?, GioiTinh = ?, NgaySinh = ?, Hinh = ?, MaNganh = ? WHERE MaSV = ?");
    $stmt->execute([$HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh, $MaSV]);
    header("Location: list.php");
    exit();
}
?>

<html>
<head><title>Chỉnh Sửa Sinh Viên</title></head>
<body>
    <h1>Chỉnh Sửa Sinh Viên</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="MaSV" value="<?= $student['MaSV'] ?>">
        <label>Họ Tên: <input type="text" name="HoTen" value="<?= $student['HoTen'] ?>" required></label><br>
        <label>Giới Tính: <input type="text" name="GioiTinh" value="<?= $student['GioiTinh'] ?>" required></label><br>
        <label>Ngày Sinh: <input type="date" name="NgaySinh" value="<?= $student['NgaySinh'] ?>" required></label><br>
        <label>Ảnh: <input type="file" name="Hinh"></label><br>
        <label>Mã Ngành: <input type="text" name="MaNganh" value="<?= $student['MaNganh'] ?>" required></label><br>
        <button type="submit">Lưu</button>
    </form>
</body>
</html>
