<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
class LibConvertPDF {

	function __construct(){
		//parent::__construct();

		//$this->load->helper('url');
		//$this->load->library('ConvertPDF');

	}

	public function do_convert($data_upload) {


		echo "do_convert<br>";
		var_dump($data_upload);
	}
}
	
/* End of file Mylibrary.php */