<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConvertExcel extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->helper(array('url','html','form'));
	}

	public function index() {

		$error = array('error' => '');
		$this->load->view('convert_excel', $error);
	}

	public function getDBExcel ($data_objDatabaseXLS) {

		$db_excel_highest_row = $data_objDatabaseXLS->setActiveSheetIndex(0)->getHighestRow();
		for($i = 2; $i <= $db_excel_highest_row; $i++){
			$barcode_temp = $data_objDatabaseXLS->getSheet(0)->getCell("B".$i)->getValue();
			$namabarang_temp = $data_objDatabaseXLS->getSheet(0)->getCell("C".$i)->getValue();
			$kodebarang_temp = $data_objDatabaseXLS->getSheet(0)->getCell("D".$i)->getValue();
			$namabarangdrp_temp = $data_objDatabaseXLS->getSheet(0)->getCell("E".$i)->getValue();
			$newprice_temp = $data_objDatabaseXLS->getSheet(0)->getCell("F".$i)->getValue();
			
			$dt_return[$barcode_temp] = array( 	'namabarang' => $namabarang_temp,
												'kodebarang' => $kodebarang_temp,
												'namabarangdrp' => $namabarangdrp_temp,
												'newprice' => $newprice_temp
											);
		}
		return $dt_return;
	}

	

	// MANUAL SEARCH FOR KODE BARANG (dari atas ke bawah sampai batas yg dikasih, slanjutnya ke kanan dan seterusnya)
	public function findPivotString($max_row_search, $max_column_search, $is_search_par, $data_objXLS){
		$row = 1;
		$column = 'A';
		$is_search_par_length = strlen($is_search_par);

		for($row = 1; $row <= $max_row_search; $row++){
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


	private function doUpload($get_file_name_excel){


		require_once(APPPATH.'third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');

		$Reader = PHPExcel_IOFactory::createReaderForFile($get_file_name_excel);
		$Reader->setReadDataOnly(true);
		$objUploadXLS = $Reader->load($get_file_name_excel);
		

		// MANUAL SEARCH FOR KODE BARANG (dari atas ke bawah sampai batas yg dikasih, slanjutnya ke kanan dan seterusnya)
		$pivot_kode_barang = $this->findPivotString(50, 'Z', 'Kode Barang', $objUploadXLS);
		$number_arr = 1;
		for ($i = $pivot_kode_barang['row']; $i < $pivot_kode_barang['row']+2000; $i++) {
			// CARI KODE BARANG
			$value_temp = $objUploadXLS->getSheet(0)->getCell($pivot_kode_barang['column'].$i)->getValue();
			if(is_numeric($value_temp)) {
				$value_kode_barang = $value_temp;
				$informasi_dt_upload['kode_barang'][$number_arr] = $value_kode_barang;
				$number_arr++;
			}
		}

		// MANUAL SEARCH FOR QUANTITY
		$pivot_total_qty = $this->findPivotString(50, 'Z', "Total Qty", $objUploadXLS);
		$number_arr = 1;
		for ($i = $pivot_total_qty['row']; $i < $pivot_total_qty['row']+2000; $i++) {
			// CARI NAMA BARANG
			$value_temp = $objUploadXLS->getSheet(0)->getCell($pivot_total_qty['column'].$i)->getValue();
			if(is_numeric($value_temp)) {
				$value_total_qty = $value_temp;
				$informasi_dt_upload['total_qty'][$number_arr] = $value_total_qty;
				$number_arr++;
			}

		}


		// GET DATABASE FROM EXCEL
        $Reader_database = PHPExcel_IOFactory::createReaderForFile('./database_excel/ListCarrefour.xls');
        $Reader_database->setReadDataOnly(true);
		$objDatabaseXLS = $Reader_database->load('./database_excel/ListCarrefour.xls');
		$informasi_db_excel = $this->getDBExcel($objDatabaseXLS);
		

		// BANDINGKAN ANTARA DATABASE_EXCEL DAN DATA_UPLOAD
		//$get_date = getdate();
		$today_date = date('Ymd');

		$objWriteExcel = new PHPExcel;
		// set default font
		$objWriteExcel->getDefaultStyle()->getFont()->setName('Calibri');
		// set default font size
		$objWriteExcel->getDefaultStyle()->getFont()->setSize(8);
		// create the writer
		$objWriter = PHPExcel_IOFactory::createWriter($objWriteExcel, "CSV");
		$objSheet = $objWriteExcel->getActiveSheet();
		$objSheet->setTitle('Sheet1');

		$objSheet->getCell('A1')->setValue('CUST-');
		$objSheet->getCell('B1')->setValue('Sales Invoice');
		$objSheet->getCell('C1')->setValue('SH');
		$objSheet->getCell('D1')->setValue('');
		$objSheet->getCell('E1')->setValue($today_date);

		$number = 1;
		$number_row_excel = 2;
		$nomor_urut = 1000;
		foreach ($informasi_dt_upload['kode_barang'] as $key_kode_barang => $value_kode_barang) {

			try {

				// JIKA DATA ADA DI EXCEL
				if(isset($informasi_db_excel[$value_kode_barang]['kodebarang'])){
					$kode_barang = $informasi_db_excel[$value_kode_barang]['kodebarang'];
					$qty = $informasi_dt_upload['total_qty'][$key_kode_barang];
					$harga = $informasi_db_excel[$value_kode_barang]['newprice'];
				}
				else {
					$kode_barang = 'Data Excel Not Found for kode barang ('.$value_kode_barang.')';
					$qty = 'Data Excel Not Found for kode barang ('.$value_kode_barang.')';
					$harga = 'Data Excel Not Found for kode barang ('.$value_kode_barang.')';
				}

			} catch(Exception $e){
				// JIKA ADA ERROR YANG TIDAK DI KETAHUI
				$kode_barang = 'Error for kode barang ('.$value_kode_barang.')';
				$qty = 'Error for kode barang ('.$value_kode_barang.')';
				$harga = 'Error for kode barang ('.$value_kode_barang.')';
			}
				$objSheet->getCell('A'.$number_row_excel)->setValue('CUST-');
				$objSheet->getCell('B'.$number_row_excel)->setValue('Sales Invoice');
				$objSheet->getCell('C'.$number_row_excel)->setValue('SL');
				$objSheet->getCell('D'.$number_row_excel)->setValue('');
				$objSheet->getCell('E'.$number_row_excel)->setValue("$today_date");
				$objSheet->getCell('F'.$number_row_excel)->setValue($kode_barang);
				$objSheet->getCell('G'.$number_row_excel)->setValue($nomor_urut);
				$objSheet->getCell('H'.$number_row_excel)->setValue($qty);
				$objSheet->getCell('I'.$number_row_excel)->setValue('PCS');
				$objSheet->getCell('J'.$number_row_excel)->setValue($harga);
				$objSheet->getCell('K'.$number_row_excel)->setValue('110000');
				$objSheet->getCell('L'.$number_row_excel)->setValue('0');

			$number++;
			$number_row_excel++;
			$nomor_urut += 1000;
		}

		$download_file = 'download/file_so.csv';
		$objWriter->save($download_file);


		return $download_file;


	}


	public function mainDoUpload() {

		$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'xls';
        $config['max_size']             = 10000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file_upload')) {
            $error = array('error' => 'Ada Error : '.$this->upload->display_errors());
            $this->load->view('convert_excel', $error);
        }
        else {
            
            // UPLOAD DATA	
            $data_upload = $this->upload->data();
            

			try {
            	
            	// GET DATA UPLOAD
				$get_file_name_excel ='./uploads/'.$data_upload['file_name'];
				
				// RUN doUpload() FUNCTION
				$download_file = $this->doUpload($get_file_name_excel);

				header("Cache-Control: public");
			    header("Content-Description: File Transfer");
			    header("Content-Disposition: attachment; filename=$download_file");
			    header("Content-Type: application/zip");
			    header("Content-Transfer-Encoding: binary");

			    readfile($download_file);
				unlink($get_file_name_excel);
				unlink($download_file);
				
			} catch(Exception $e) {
			    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
     	}
	}














}
?>