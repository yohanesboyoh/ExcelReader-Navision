<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModifyExcel extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->helper(array('url','html','form'));
	}

	// Fungsi Insert Row ke Excel
	public function InsertExcel(){	
		require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

		// GET DATABASE FROM EXCEL
		$objPHPExcel= PHPExcel_IOFactory::load('./database_excel/ListCarrefour.xls');
		$sheet=$objPHPExcel->getSheet(0);

		// READ LASTROW
		$highestrow=$_POST['insert-row'];
		
		$row=$highestrow+1;
		// REMOVE separator FROM POST
		$newprice=$_POST['insert-newprice'];	
		$newprice = (int)str_replace('.','',$newprice);
		


		// ISI ROW
		$sheet->SetCellValue('B'.$row, $_POST['insert-barcode']);
		$sheet->SetCellValue('D'.$row, $_POST['insert-kodebarang']);
		$sheet->SetCellValue('C'.$row, $_POST['insert-namabarang']);
		$sheet->SetCellValue('E'.$row, $_POST['insert-namabarangdrp']);
		$sheet->SetCellValue('F'.$row, $newprice);
		//$sheet->SetCellValue('F'.$row, $_POST['insert-newprice']);
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save('./database_excel/ListCarrefour.xls');    
		
		// LOAD ADMIN PAGE
		echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Succesfully Inserted')
    window.location.href='admin';
    </SCRIPT>");
	}
	
	// Fungsi Update data Row dari Excel
	public function UpdateExcel(){
		require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

		$objPHPExcel= PHPExcel_IOFactory::load('./database_excel/ListCarrefour.xls');
		$sheet=$objPHPExcel->getSheet(0);
		
		$selected_row=$_POST['edit-row'];
		$row=$selected_row+1;
		// INSERT NEW ROW
		$sheet->insertNewRowBefore($row+1, 1);
		
		// REMOVE separator FROM POST
		$newprice=$_POST['edit-newprice'];
		$newprice = str_replace('.','',$newprice);

		// ISI ROW
		$sheet->SetCellValue('B'.$row, $_POST['edit-barcode']);
		$sheet->SetCellValue('C'.$row, $_POST['edit-namabarang']);
		$sheet->SetCellValue('D'.$row, $_POST['edit-kodebarang']);
		$sheet->SetCellValue('E'.$row, $_POST['edit-namabarangdrp']);
		$sheet->SetCellValue('F'.$row, $newprice);
		//$sheet->SetCellValue('F'.$row, $_POST['edit-newprice']);

		// DELETE OLD ROW
		$sheet->removeRow($row+1);
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save('./database_excel/ListCarrefour.xls');
		// LOAD ADMIN PAGE
		echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated')
    window.location.href='admin';
    </SCRIPT>");

	}
	
		// Fungsi Delete Row dari Excel
	public function DeleteExcel(){
		require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

		$objPHPExcel= PHPExcel_IOFactory::load('./database_excel/ListCarrefour.xls');
		$sheet=$objPHPExcel->getSheet(0);
		// READ ROW TO DELETE
		$selected_row=$_POST['delete-row'];
		$row=$selected_row+1;

		// DELETE ROW
		$sheet->removeRow($row);
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save('./database_excel/ListCarrefour.xls');
		// LOAD ADMIN PAGE
		echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Succesfully Deleted')
    window.location.href='admin';
    </SCRIPT>");
	}
	
	
}
?>