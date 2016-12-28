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

	private $arrNameStore;

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

		$this->arrNameStore = array(	"011" => "011 - Cempaka Putih",
										"012" => "012 - Duta Merlin",
										"015" => "015 - MT. Haryono",
										"016" => "016 - Megamall Pluit",
										"018" => "018 - Cempaka Mas",
										"019" => "019 - Lebak Bulus",
										"020" => "020 - Puri Indah",
										"021" => "021 - Ambassador",
										"024" => "024 - Palembang Square",
										"025" => "025 - Permata Hijau", // 10

										"026" => "026 - Medan Fair",
										"027" => "027 - Mangga Dua Square",
										"028" => "028 - ITC BSD",
										"029" => "029 - ITC DEPOK",
										"030" => "030 - Panakukang Mas",
										"031" => "031 - Taman Palem",
										"033" => "033 - Plaza Ambarukmo",
										"034" => "034 - Keppel Bubutan",
										"035" => "035 - Sukajadi",
										"036" => "036 - Tamini Square", // 20

										"037" => "037 - ITC Surabaya",
										"038" => "038 - Kramatjati Indah",
										"039" => "039 - Blue Mall Bekasi",
										"040" => "040 - Carrefour Cikarang",
										"041" => "041 - Kelapa Gading",
										"042" => "042 - Carrefour Denpasar",
										"043" => "043 - Carrefour Semarang",
										"044" => "044 - Kiara Condong",
										"045" => "045 - Cibinong",
										"046" => "046 - Carrefour Kalimas", // 30

										"047" => "047 - Ciledug",
										"051" => "051 - Carrefour Buaran",
										"053" => "053 - Bekasi Square",
										"054" => "054 - Carrefour Blok M",
										"055" => "055 - Carrefour Madiun",
										"056" => "056 - Carrefour Ciputat",
										"057" => "057 - Carrefour CBD Pluit",
										"058" => "058 - Carrefour Karawang",
										"059" => "059 - Central Park",
										"060" => "060 - Carrefour Serang", // 40

										"061" => "061 - Season City",
										"062" => "062 - Medan Citra",
										"063" => "063 - Carrefour Pekalongan",
										"064" => "064 - Supermal Karawaci",
										"065" => "065 - Carrefour Cipinang",
										"066" => "066 - Cibinong City Mall",
										"067" => "067 - Batam Muka Kuning",
										"068" => "068 - Mojokerto",
										"069" => "069 - Semarang Srondol",
										"070" => "070 - Solo Paragon", // 50

										"071" => "071 - Trans Studio MKS",
										"072" => "072 - Kota Kasablanka",
										"073" => "073 - OPI Mall Palembang",
										"074" => "074 - Tangerang Center",
										"075" => "075 - Tangerang City",
										"076" => "076 - Pasuruan Land",
										"077" => "077 - Magelang Armada",
										"078" => "078 - Atrium Pondok Gede",
										"080" => "080 - X-Mall Kalimalang",
										"081" => "081 - GALARA MALL PALU", // 60

										"082" => "082 - CIMAHI",
										"083" => "083 - Cipadung Bandung",
										"084" => "084 - Kediri",
										"086" => "086 - Grand Daya Makassar",
										"087" => "087 - Cilandak",
										"088" => "088 - Balikpapan Daun Village",
										"088" => "088 - Living Plaza Cirebon",
										"402" => "402 - Kebayoran",
										"404" => "404 - Blimbing Malang",
										"405" => "405 - Meruya", // 70

										"406" => "406 - Hayam Wuruk Jember",
										"408" => "408 - Pengayoman Makassar",
										"411" => "411 - Dukuh Kupang Sby",
										"412" => "412 - Ahmad Yani Surabaya",
										"416" => "416 - Sunter Jakarta",
										"417" => "417 - Bintaro Jakarta",
										"418" => "418 - Menteng Prada",
										"419" => "419 - Baru Solo",
										"420" => "420 - Pasar Minggu Jakarta",
										"425" => "425 - Karebosi Makassar", // 80

										"426" => "426 - Tamalanrea Makassar",
										"427" => "427 - Pamulang",
										"428" => "428 - Bekasi Harapan",
										"435" => "435 - Link Karebosi MKS",
										"438" => "438 - Pontianak Matahari",
										"439" => "439 - Bali Singaraja",
										"201" => "201 - Bekasi Juanda Groserindo",
										"202" => "202 - Bonjol Denpasar Groserindo",
										"701" => "701 - Mega Tendean Jakarta",
										"703" => "703 - Lebak Bulus Express", // 90

										"704" => "704 - Batam Muka Kuning Express",
										"706" => "706 - Solo Paragon Express",
										"707" => "707 - Season City Express", // 93
									);

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
    	    redirect(base_url().'otomate-excel');
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

					echo "buka file lama<br>";
					$this->addNewExcelRekapanCarrefour($download_file);



				} else {

					// 	WRITE DATA TO EXCEL
					$this->createNewExcelRekapanCarrefour($download_file);
				}


				// READ DATA TO ARRAY



    	        //$this->load->view('otomate_excel', $parameter);
    	        redirect(base_url().'otomate-excel');

				
			} catch(Exception $e) {
	            $parameter = "Error loading file : ".$e->getMessage();
            	$this->session->set_flashdata('error', $parameter);
    	        redirect(base_url().'otomate-excel');
			}

        }

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
			    //echo $cell->getValue()."<br>";
			    $retval[$i][] = $cell->getValue();
			}
		}
		//var_dump($retval);

		
		return $retval;
	}



	private function deleteRowTableData($row) {

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

		// selaraskan data cmd dengan new name store
		/*
		$pembandingNameStore = substr($this->mNomorOder[0], 1, 3);
		var_dump($pembandingNameStore);
		$this->mNewNameStore = $this->getNewNameStore($pembandingNameStore);
		*/
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


	private function getNewNameStore($cdt) {

		$retval = $this->arrNameStore[$cdt];
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







}
?>