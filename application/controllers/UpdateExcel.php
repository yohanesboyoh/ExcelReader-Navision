<?php 
require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

$objPHPExcel= PHPExcel_IOFactory::load('./database_excel/ListCarrefour.xls');

$objPHPExcel->setActiveSheetIndex(0);
$selected_row=$_POST['edit-row'];
$row=$selected_row+1;
// INSERT NEW ROW
$objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1, 1);
// ISI ROW
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, $_POST['edit-barcode']);
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, $_POST['edit-namabarang']);
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row, $_POST['edit-kodebarang']);
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, $_POST['edit-namabarangdrp']);
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, $_POST['edit-newprice']);
// DELETE OLD ROW
$objPHPExcel->getActiveSheet()->removeRow($row+1);
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->save('./database_excel/ListCarrefour.xls');
?>