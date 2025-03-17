<?php
// File: models/Student.php
class Student {
    public $MaSV;
    public $HoTen;
    public $GioiTinh;
    public $NgaySinh;
    public $Hinh;
    public $MaNganh;

    public function __construct($MaSV, $HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh) {
        $this->MaSV = $MaSV;
        $this->HoTen = $HoTen;
        $this->GioiTinh = $GioiTinh;
        $this->NgaySinh = $NgaySinh;
        $this->Hinh = $Hinh;
        $this->MaNganh = $MaNganh;
    }
}