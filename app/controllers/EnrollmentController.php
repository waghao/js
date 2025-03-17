<?php
// File: controllers/EnrollmentController.php
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Course.php';

class EnrollmentController {
    // Hiển thị danh sách đăng ký
    public function list() {
        global $pdo;
        $stmt = $pdo->query("SELECT DangKy.MaDK, DangKy.NgayDK, SinhVien.HoTen, HocPhan.TenHP 
                             FROM DangKy 
                             JOIN SinhVien ON DangKy.MaSV = SinhVien.MaSV 
                             JOIN ChiTietDangKy ON DangKy.MaDK = ChiTietDangKy.MaDK 
                             JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP");
        $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../views/Enrollment/list.php';
    }

    // Xử lý đăng ký học phần
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $MaSV = $_POST['MaSV'];
            $MaHP = $_POST['MaHP'];
            $enrollment = new Enrollment($MaSV, $MaHP);
            $enrollment->save();
            header('Location: /views/Enrollment/list.php');
            exit();
        } else {
            global $pdo;
            $students = $pdo->query("SELECT * FROM SinhVien")->fetchAll(PDO::FETCH_ASSOC);
            $courses = $pdo->query("SELECT * FROM HocPhan")->fetchAll(PDO::FETCH_ASSOC);
            require __DIR__ . '/../views/Enrollment/add.php';
        }
    }
}