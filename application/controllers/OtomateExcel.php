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

		$this->arrNameStore = array(	"CTRI16121612281989" => "011 - Cempaka Putih",
										"CTRI16121612281126" => "012 - Duta Merlin",
										"CTRI16121612283552" => "015 - MT. Haryono",
										"CTRI16121612284319" => "016 - Megamall Pluit",
										"CTRI16121612284936" => "018 - Cempaka Mas",
										"CTRI16121612284665" => "019 - Lebak Bulus",
										"CTRI16121612280943" => "020 - Puri Indah",
										"CTRI16121612280305" => "021 - Ambassador",
										"CTRI16121612282840" => "024 - Palembang Square",
										"CTRI16121612282285" => "025 - Permata Hijau", // 10

										"CTRI16121612282906" => "026 - Medan Fair",
										"CTRI16121612282043" => "027 - Mangga Dua Square",
										"CTRI16121612281283" => "028 - ITC BSD",
										"CTRI16121612283570" => "029 - ITC DEPOK",
										"CTRI16121612284186" => "030 - Panakukang Mas",
										"CTRI16121612280899" => "031 - Taman Palem",
										"CTRI16121612284758" => "033 - Plaza Ambarukmo",
										"CTRI16121612284206" => "034 - Keppel Bubutan",
										"CTRI16121612280572" => "035 - Sukajadi",
										"CTRI16121612283196" => "036 - Tamini Square", // 20

										"CTRI16121612282627" => "037 - ITC Surabaya",
										"CTRI16121612283870" => "038 - Kramatjati Indah",
										"CTRI16121612283443" => "039 - Blue Mall Bekasi",
										"CTRI16121612282576" => "040 - Carrefour Cikarang",
										"CTRI16121612284079" => "041 - Kelapa Gading",
										"CTRI16121612280762" => "042 - Carrefour Denpasar",
										"CTRI16121612282098" => "043 - Carrefour Semarang",
										"CTRI16121612284754" => "044 - Kiara Condong",
										"CTRI16121612280534" => "045 - Cibinong",
										"CTRI16121612282439" => "046 - Carrefour Kalimas", // 30

										"CTRI16121612282748" => "047 - Ciledug",
										"CTRI16121612281074" => "051 - Carrefour Buaran",
										"CTRI16121612281564" => "053 - Bekasi Square",
										"CTRI16121612281740" => "054 - Carrefour Blok M",
										"CTRI16121612280094" => "055 - Carrefour Madiun",
										"CTRI16121612281371" => "056 - Carrefour Ciputat",
										"CTRI16121612284615" => "057 - Carrefour CBD Pluit",
										"CTRI16121612282916" => "058 - Carrefour Karawang",
										"CTRI16121612283371" => "059 - Central Park",
										"CTRI16121612286149" => "060 - Carrefour Serang", // 40

										"CTRI16121612282776" => "061 - Season City",
										"CTRI16121612282726" => "062 - Medan Citra",
										"CTRI16121612284921" => "063 - Carrefour Pekalongan",
										"CTRI16121612283279" => "064 - Supermal Karawaci",
										"CTRI16121612281985" => "065 - Carrefour Cipinang",
										"CTRI16121612282556" => "066 - Cibinong City Mall",
										"CTRI16121612283216" => "067 - Batam Muka Kuning",
										"CTRI16121612283419" => "068 - Mojokerto",
										"CTRI16121612285112" => "069 - Semarang Srondol",
										"CTRI16121612280627" => "070 - Solo Paragon", // 50

										"CTRI16121612280484" => "071 - Trans Studio MKS",
										"CTRI16121612286202" => "072 - Kota Kasablanka",
										"CTRI16121612286776" => "073 - OPI Mall Palembang",
										"CTRI16121612283349" => "074 - Tangerang Center",
										"CTRI16121612283918" => "075 - Tangerang City",
										"CTRI16121612283506" => "076 - Pasuruan Land",
										"CTRI16121612284565" => "077 - Magelang Armada",
										"CTRI16121612285519" => "078 - Atrium Pondok Gede",
										"CTRI16121612285642" => "080 - X-Mall Kalimalang",
										"CTRI16121612285532" => "081 - GALARA MALL PALU", // 60

										"CTRI16121612286093" => "082 - CIMAHI",
										"CTRI16121612286848" => "083 - Cipadung Bandung",
										"CTRI16121612286413" => "084 - Kediri",
										"CTRI16121612286076" => "086 - Grand Daya Makassar",
										"CTRI16121612286146" => "087 - Cilandak",
										"CTRI16121612285686" => "088 - Balikpapan Daun Village",
										"CTRI16121612286826" => "090 - Living Plaza Cirebon",
										"CTRI16121612286636" => "402 - Kebayoran",
										"CTRI16121612286624" => "404 - Blimbing Malang",
										"CTRI16121612286108" => "405 - Meruya", // 70

										"CTRI16121612286949" => "406 - Hayam Wuruk Jember",
										"CTRI16121612286242" => "408 - Pengayoman Makassar",
										"CTRI16121612285685" => "411 - Dukuh Kupang Sby",
										"CTRI16121612285341" => "412 - Ahmad Yani Surabaya",
										"CTRI16121612286270" => "416 - Sunter Jakarta",
										"CTRI16121612286461" => "417 - Bintaro Jakarta",
										"CTRI16121612286046" => "418 - Menteng Prada",
										"CTRI16121612286498" => "419 - Baru Solo",
										"CTRI16121612285752" => "420 - Pasar Minggu Jakarta",
										"CTRI16121612286257" => "425 - Karebosi Makassar", // 80

										"CTRI16121612285727" => "426 - Tamalanrea Makassar",
										"CTRI16121612286066" => "427 - Pamulang",
										"CTRI16121612286410" => "428 - Bekasi Harapan",
										"CTRI16121612286939" => "435 - Link Karebosi MKS",
										"CTRI16121612286444" => "438 - Pontianak Matahari",
										"CTRI16121612286814" => "439 - Bali Singaraja",
										"CTRI16121612282678" => "201 - Bekasi Juanda Groserindo",
										"CTRI16121612286886" => "202 - Bonjol Denpasar Groserindo",
										"CTRI16121612286385" => "701 - Mega Tendean Jakarta",
										"CTRI16121612285711" => "703 - Lebak Bulus Express", // 90

										"CTRI16121612285717" => "704 - Batam Muka Kuning Express",
										"CTRI16121612285718" => "706 - Solo Paragon Express",
										"CTRI16121612285714" => "707 - Season City Express", // 93
										"CTRI16121612285714" => "707 - Season Ciasdasdty Express", // 93
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
		$this->mNewNameStore = $this->getNewNameStore($this->mCDT[0]);

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
		$objSheet->getCell('B2')->setValue($this->mNewNameStore);
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
		$objUploadXLS->setActiveSheetIndex(0)->setCellValue('B'.$lastRow, $this->mNewNameStore);
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