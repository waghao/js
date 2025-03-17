<?php
require_once 'models/Course.php';

class CourseController {
    // Hiển thị danh sách học phần
    public function list() {
        $courses = Course::getAll();
        require 'views/Course/list.php';
    }

    // Thêm học phần
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $course = new Course($_POST['MaHP'], $_POST['TenHP'], $_POST['SoTinChi']);
            $course->save();
            header('Location: /views/Course/list.php');
            exit();
        } else {
            require 'views/Course/add.php';
        }
    }

    // Sửa học phần
    public function edit($MaHP) {
        $course = Course::find($MaHP);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $course->TenHP = $_POST['TenHP'];
            $course->SoTinChi = $_POST['SoTinChi'];
            $course->update();
            header('Location: /views/Course/list.php');
            exit();
        } else {
            require 'views/Course/edit.php';
        }
    }

    // Xóa học phần
    public function delete($MaHP) {
        Course::delete($MaHP);
        header('Location: /views/Course/list.php');
        exit();
    }

    // Xem chi tiết học phần
    public function detail($MaHP) {
        $course = Course::find($MaHP);
        require 'views/Course/detail.php';
    }
}
?>
