<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (version_compare(PHP_VERSION, '8.0.0', '<')) {
    require_once APPPATH . "libraries/Excel/PHPExcel.php"; 
    require_once APPPATH . "libraries/Excel/PHPExcel/IOFactory.php"; 
     
    class Excel extends PHPExcel { 
        public function __construct() { 
            parent::__construct(); 
        } 
    }
} else {
    // PHP 8+ Compatibility Wrapper to prevent fatal errors when library('excel') is loaded
    class Excel {
        public function __construct() {}
        public function __call($name, $arguments) { return $this; }
        public function getActiveSheet() { return $this; }
        public function setActiveSheetIndex($i = 0) { return $this; }
        public function setCellValueByColumnAndRow($c, $r, $v) { return $this; }
        public function getColumnDimension($c) { return $this; }
        public function getColumnDimensionByColumn($c) { return $this; }
        public function setWidth($w) { return $this; }
        public function setAutoSize($a = true) { return $this; }
        public function getRowDimension($r) { return $this; }
        public function setRowHeight($h) { return $this; }
        public function getStyle($s) { return $this; }
        public function applyFromArray($a) { return $this; }
        public function getFont() { return $this; }
        public function setColor($c) { return $this; }
        public function getAlignment() { return $this; }
        public function setWrapText($w) { return $this; }
        public function setTitle($t) { return $this; }
        public function disconnectWorksheets() {}
    }
}