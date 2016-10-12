<?php 
//var_dump($_POST);

require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

$objPHPExcel= PHPExcel_IOFactory::load('./database_excel/ListCarrefour.xls');

$objPHPExcel->setActiveSheetIndex(0);
$highestRow=$objPHPExcel->getActiveSheet()->getHighestRow();
//var_dump($highestRow);
$row=$highestRow+1;
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, $_POST['insert-barcode']);
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, $_POST['insert-namabarang']);
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row, $_POST['insert-kodebarang']);
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, $_POST['insert-namabarangdrp']);
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, $_POST['insert-newprice']);
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->save('./database_excel/ListCarrefour.xls');    

?>