<?php 

require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

$objPHPExcel= PHPExcel_IOFactory::load('./database_excel/ListCarrefour.xls');

$objPHPExcel->setActiveSheetIndex(0);

// READ ROW TO DELETE
$selected_row=$_POST['delete-row'];
$row=$selected_row+1;

// DELETE ROW
$objPHPExcel->getActiveSheet()->removeRow($row);
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->save('./database_excel/ListCarrefour.xls');
?>