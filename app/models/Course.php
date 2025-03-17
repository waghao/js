<?php
// File: models/Course.php
class Course {
    public $MaHP;
    public $TenHP;
    public $SoTinChi;

    public function __construct($MaHP, $TenHP, $SoTinChi) {
        $this->MaHP = $MaHP;
        $this->TenHP = $TenHP;
        $this->SoTinChi = $SoTinChi;
    }
}
