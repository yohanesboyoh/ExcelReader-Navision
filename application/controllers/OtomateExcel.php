<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OtomateExcel extends CI_Controller {


	private $mNewNameStore;
	private $mTanggalOrder;
	private $mNomorOder;
	private $mCDT;
	private $mPI;
	private $mTaxTenPercent;
	private $mPiPlusTaxTenPercent;
	private $mSo;
	private $mSelisih;


	function __construct(){
		parent::__construct();

		$this->load->helper(array('url','html','form'));
		$this->load->library('session');
		require_once('vendor/autoload.php');
		//$this->load->library('pdf');

		$this->mNewNameStore = null;
		$this->mTanggalOrder = null;
		$this->mNomorOder = null;
		$this->mCDT = null;
		$this->mPI = null;
		$this->mTaxTenPercent = null;
		$this->mPiPlusTaxTenPercent = null;
		$this->mSo = null;
		$this->mSelisih = null;

	}

	public function index() {

		$table_data = null;
		$error = null;

		// CEK IF DATA TABLE EXIST
		$download_file = 'download/file_rekapan.csv';
		if(file_exists($download_file)) {
			$table_data = $this->getTableData();	
		}

		if($this->session->flashdata('error')) {
			$error = $this->session->flashdata('error');
		}

		$parameter = array(	'error' => $error,
							'table_data' => $table_data
						);

		$this->load->view('otomate_excel', $parameter);

	}

	public function addData(){

		$config['upload_path']          = './uploads/otomate/';
        $config['allowed_types']        = 'xlsx';
        $config['max_size']             = 10000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file_upload')) {
            $error = "Ada Error : ".$this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
        }
        else {

            try {
            	
            	// GET DATA UPLOAD
	            $data_upload = $this->upload->data();

				$get_file_name_excel = $config['upload_path'].$data_upload['file_name'];

				// SET DATA
				$this->getSetData($get_file_name_excel);

				// CHECK DATA REKAPAN IF EXISTS
				$download_file = 'download/file_rekapan.csv';
				if(file_exists($download_file)) {
					$this->addNewExcelRekapanCarrefour($download_file);
				} else {
					// 	WRITE DATA TO EXCEL
					$this->createNewExcelRekapanCarrefour($download_file);
				}

			} catch(Exception $e) {
	            $parameter = "Error loading file : ".$e->getMessage();
            	$this->session->set_flashdata('error', $parameter);
			}

        }

    	redirect(base_url().'otomate-excel');

	}

	public function deleteData() {

		$data_post = $this->input->get_post("data");

		$data_cdt = $data_post;

		require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

		$get_file_name_excel = "download/file_rekapan.csv";

		$Reader = PHPExcel_IOFactory::createReaderForFile($get_file_name_excel);

		$Reader->setReadDataOnly(true);

		$objPHPExcel = $Reader->load($get_file_name_excel);

		$key_row = $this->findPivotString("500", "Z", $data_cdt, $objPHPExcel)['row'];

		$objPHPExcel = PHPExcel_IOFactory::load($get_file_name_excel);
		
		$objPHPExcel->getActiveSheet()->removeRow($key_row);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "csv");

		$objWriter->save($get_file_name_excel);

    	redirect(base_url().'otomate-excel');

	}

	public function downloadData() {

		$download_file = "download/file_rekapan.csv";

		header("Cache-Control: public");
	    header("Content-Description: File Transfer");
	    header("Content-Disposition: attachment; filename='file_rekapan.csv'");
	    header("Content-Type: application/zip");
	    header("Content-Transfer-Encoding: binary");

	    readfile($download_file);
	    
	}




	// PRIVATE METHOD
	private function getTableData() {

		require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

		$retval = null;

		$get_file_name_excel = "download/file_rekapan.csv";
		$Reader = PHPExcel_IOFactory::createReaderForFile($get_file_name_excel);
		$Reader->setReadDataOnly(true);
		$objPHPExcel = $Reader->load($get_file_name_excel);

		$lastRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

		for ($i=2; $i <= $lastRow; $i++) { 
			$rowValue = $objPHPExcel->getActiveSheet()->getRowIterator($i)->current();

			$cellIterator = $rowValue->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false);

			foreach ($cellIterator as $cell) {
			    $retval[$i][] = $cell->getValue();
			}
		}

		return $retval;
	}

	private function getSetData($get_file_name_excel) {

		require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

		$Reader = PHPExcel_IOFactory::createReaderForFile($get_file_name_excel);
		$Reader->setReadDataOnly(true);
		$objUploadXLS = $Reader->load($get_file_name_excel);

		// CARI VALUE CDT
		$this->mCDT = $this->findValueInExcel($objUploadXLS, "CDT", 50, 'Z');
		if($this->mCDT == null) {
			throw new Exception("Data CDT Tidak ada");
		}

		// CARI VALUE PI
		$this->mPI = $this->findValueInExcel($objUploadXLS, "TOTAL HARGA", 500, 'Z');
		if($this->mPI == null) {
			throw new Exception("Data PI Tidak ada");
		}

		// CARI NOMOR ORDER
		$this->mNomorOder = $this->findValueInExcel($objUploadXLS, "Nomor Order", 50, 'Z');
		if($this->mNomorOder == null) {
			throw new Exception("Data Nomor Order Tidak ada");
		}

		// CARI NOMOR ORDER
		$this->mTanggalOrder = $this->findValueInExcel($objUploadXLS, "Tanggal Order", 50, 'Z');
		if($this->mTanggalOrder == null) {
			throw new Exception("Data Tanggal Order Tidak ada");
		}

		$this->mNewNameStore = $this->findValueInExcel($objUploadXLS, "Kode Penerima", 50, 'Z');
		if($this->mNewNameStore == null) {
			throw new Exception("Data Kode Penerima Tidak ada");
		}


		$this->mTaxTenPercent = $this->mPI[1] / 10;

		$this->mPiPlusTaxTenPercent = $this->mPI[1] + $this->mTaxTenPercent;

		$this->mSo = "0";
		
		$this->mSelisih = $this->mPiPlusTaxTenPercent - $this->mSo;

		$retval = array( 	"cdt" => $this->mCDT,
							"pi" => $this->mPI,
							"nomor_order" => $this->mNomorOder,
							"tanggal_order" => $this->mTanggalOrder,
							"new_name_store" => $this->mNewNameStore,
							"tax_ten_percent" => $this->mTaxTenPercent,
							"pi_plus_tax_ten_percent" => $this->mPiPlusTaxTenPercent,
							"so" => $this->mSo,
							"selisih" => $this->mSelisih
						);

		return $retval;

	}

	private function createNewExcelRekapanCarrefour($download_file) {

		$objWriteExcel = new PHPExcel;
		// set default font
		$objWriteExcel->getDefaultStyle()->getFont()->setName('Calibri');
		// set default font size
		$objWriteExcel->getDefaultStyle()->getFont()->setSize(8);
		// create the writer
		$objWriter = PHPExcel_IOFactory::createWriter($objWriteExcel, "CSV");
		$objSheet = $objWriteExcel->getActiveSheet();
		$objSheet->setTitle('Sheet1');

		$objSheet->getCell('A1')->setValue('No');
		$objSheet->getCell('B1')->setValue('New Name Store');
		$objSheet->getCell('C1')->setValue('Tanggal Order');
		$objSheet->getCell('D1')->setValue('No.Order');
		$objSheet->getCell('E1')->setValue('CDT');
		$objSheet->getCell('F1')->setValue('PI');
		$objSheet->getCell('G1')->setValue('Tax 10%');
		$objSheet->getCell('H1')->setValue('PI+Tax 10%');
		$objSheet->getCell('I1')->setValue('So');
		$objSheet->getCell('J1')->setValue('Selisih');

		$objSheet->getCell('A2')->setValue('1');
		$objSheet->getCell('B2')->setValue($this->mNewNameStore[0]);
		$objSheet->getCell('C2')->setValue($this->mTanggalOrder[0]);
		$objSheet->getCell('D2')->setValue($this->mNomorOder[0]);
		$objSheet->getCell('E2')->setValue($this->mCDT[0]);
		$objSheet->getCell('F2')->setValue($this->mPI[1]);
		$objSheet->getCell('G2')->setValue($this->mTaxTenPercent);
		$objSheet->getCell('H2')->setValue($this->mPiPlusTaxTenPercent);
		$objSheet->getCell('I2')->setValue($this->mSo);
		$objSheet->getCell('J2')->setValue($this->mSelisih);

		$objWriter->save($download_file);

	}
	
	private function addNewExcelRekapanCarrefour($get_file_name_excel) {

		$Reader = PHPExcel_IOFactory::createReaderForFile($get_file_name_excel);
		//$Reader->setReadDataOnly(true);
		$objUploadXLS = $Reader->load($get_file_name_excel);

		// CARI VALUE TERAKHIR
		$lastRow = $objUploadXLS->setActiveSheetIndex(0)->getHighestRow();
		$lastRow++;

		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('A'.$lastRow, $lastRow-1);
		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('B'.$lastRow, $this->mNewNameStore[0]);
		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('C'.$lastRow, $this->mTanggalOrder[0]);
		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('D'.$lastRow, $this->mNomorOder[0]);
		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('E'.$lastRow, $this->mCDT[0]);
		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('F'.$lastRow, $this->mPI[1]);
		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('G'.$lastRow, $this->mTaxTenPercent);
		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('H'.$lastRow, $this->mPiPlusTaxTenPercent);
		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('I'.$lastRow, $this->mSo);
		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('J'.$lastRow, $this->mSelisih);

		$objWriter = PHPExcel_IOFactory::createWriter($objUploadXLS, 'csv');
		$objWriter->save($get_file_name_excel);

	}



	private function findValueInExcel($objUploadXLS, $findThing, $max_row_search, $max_column_search) {
		
		$pivot_value = $this->findPivotString($max_row_search, $max_column_search, $findThing, $objUploadXLS);
		$column = $pivot_value['column'];
		$column++;
		$value_thing = null;
		for($i = 1; $i <= 30; $i++){
			$is_search = $objUploadXLS->getSheet(0)->getCell($column.$pivot_value['row'])->getValue();
			if($is_search != null) {
				$value_thing[] = $is_search;
			}
			$column++;
		}
		return $value_thing;

	}

	// MANUAL SEARCH FOR KODE BARANG (dari atas ke bawah sampai batas yg dikasih, slanjutnya ke kanan dan seterusnya)
	private function findPivotString($max_row_search, $max_column_search, $is_search_par, $data_objXLS){

		$row = 1;
		$column = 'A';
		$is_search_par_length = strlen($is_search_par);

		for($row = 1; $row <= $max_row_search; $row++) {
			$is_search = $data_objXLS->getSheet(0)->getCell($column.$row)->getValue();
			$is_search_length = strlen($is_search);
			if($is_search == $is_search_par && $is_search_length == $is_search_par_length){
				$rt_data = array(	'column' => $column,
									'row' => $row);
				//echo "1 : ".$is_search." 2 : ".$is_search_par." end<br>";
				break;
			}
			if($row == $max_row_search) {
				$row = 1;
				$column++;
			}
			if($column == $max_column_search) {
				break;
			}
		}
		return $rt_data;

	}

}
?>