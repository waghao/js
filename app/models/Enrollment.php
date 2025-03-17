<?php
// File: models/Enrollment.php
require_once __DIR__ . '/../config/database.php';

class Enrollment {
    public $MaDK;
    public $NgayDK;
    public $MaSV;
    public $MaHP;

    public function __construct($MaSV, $MaHP, $NgayDK = null) {
        $this->MaSV = $MaSV;
        $this->MaHP = $MaHP;
        $this->NgayDK = $NgayDK ?? date('Y-m-d');
    }

    public function save() {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO DangKy (NgayDK, MaSV) VALUES (?, ?)");
        $stmt->execute([$this->NgayDK, $this->MaSV]);
        $this->MaDK = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)");
        $stmt->execute([$this->MaDK, $this->MaHP]);
    }
}