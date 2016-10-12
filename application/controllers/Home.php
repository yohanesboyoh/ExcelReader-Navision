<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->helper(array('url'));
		$this->load->helper('html');

	}


	private function getDBExcel ($data_objDatabaseXLS) {

		$db_excel_highest_row = $data_objDatabaseXLS->setActiveSheetIndex(0)->getHighestRow();
		for($i = 2; $i <= $db_excel_highest_row; $i++){
			$barcode_temp = $data_objDatabaseXLS->getSheet(0)->getCell("B".$i)->getValue();
			$namabarang_temp = $data_objDatabaseXLS->getSheet(0)->getCell("C".$i)->getValue();
			$kodebarang_temp = $data_objDatabaseXLS->getSheet(0)->getCell("D".$i)->getValue();
			$namabarangdrp_temp = $data_objDatabaseXLS->getSheet(0)->getCell("E".$i)->getValue();
			$newprice_temp = $data_objDatabaseXLS->getSheet(0)->getCell("F".$i)->getValue();
			
			$dt_return[] = array( 	'barcode' => $barcode_temp,
									'namabarang' => $namabarang_temp,
									'kodebarang' => $kodebarang_temp,
									'namabarangdrp' => $namabarangdrp_temp,
									'newprice' => $newprice_temp
								);
		}
		return $dt_return;
	}



	public function index() {
		$this->load->view('home');
	}

	public function admin() {


		require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

		// GET DATABASE FROM EXCEL
        $Reader_database = PHPExcel_IOFactory::createReaderForFile('./database_excel/ListCarrefour.xls');
		
        $Reader_database->setReadDataOnly(true);
		$objDatabaseXLS = $Reader_database->load('./database_excel/ListCarrefour.xls');
		// PROSES DATA
		$informasi_db_excel = $this->getDBExcel($objDatabaseXLS);
		$data['informasi_db_excel'] = $informasi_db_excel;



		$this->load->view('admin',$data);
		



	}
}