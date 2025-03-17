<?php
require_once 'models/Student.php';

class StudentController {
    // Hiển thị danh sách sinh viên
    public function list() {
        $students = Student::getAll();
        require 'views/Student/list.php';
    }

    // Thêm sinh viên
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $student = new Student($_POST['MaSV'], $_POST['HoTen'], $_POST['GioiTinh'], $_POST['NgaySinh'], $_POST['Hinh'], $_POST['MaNganh']);
            $student->save();
            header('Location: /views/Student/list.php');
            exit();
        } else {
            require 'views/Student/add.php';
        }
    }

    // Sửa sinh viên
    public function edit($MaSV) {
        $student = Student::find($MaSV);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $student->HoTen = $_POST['HoTen'];
            $student->GioiTinh = $_POST['GioiTinh'];
            $student->NgaySinh = $_POST['NgaySinh'];
            $student->Hinh = $_POST['Hinh'];
            $student->MaNganh = $_POST['MaNganh'];
            $student->update();
            header('Location: /views/Student/list.php');
            exit();
        } else {
            require 'views/Student/edit.php';
        }
    }

    // Xóa sinh viên
    public function delete($MaSV) {
        Student::delete($MaSV);
        header('Location: /views/Student/list.php');
        exit();
    }

    // Xem chi tiết sinh viên
    public function detail($MaSV) {
        $student = Student::find($MaSV);
        require 'views/Student/detail.php';
    }
}
?>