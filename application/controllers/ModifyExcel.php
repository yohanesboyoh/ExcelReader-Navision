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

		$objPHPExcel= PHPExcel_IOFactory::load('./database_excel/ListCarrefour.xls');
		$objPHPExcel->setActiveSheetIndex(0);

		// READ LASTROW
		$highestRow=$objPHPExcel->getActiveSheet()->getHighestRow();
		$row=$highestRow+1;

		// ISI ROW
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, $_POST['insert-barcode']);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row, $_POST['insert-kodebarang']);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, $_POST['insert-namabarang']);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, $_POST['insert-namabarangdrp']);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, $_POST['insert-newprice']);
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save('./database_excel/ListCarrefour.xls');    
		//$this->load->view('admin');
	}
	
	// Fungsi Update data Row dari Excel
	public function UpdateExcel(){
	
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
		//$this->load->view('admin');
	}
	
		// Fungsi Delete Row dari Excel
	public function DeleteExcel(){
	
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
		//$this->load->view('admin');
	}
	
	
}
?>