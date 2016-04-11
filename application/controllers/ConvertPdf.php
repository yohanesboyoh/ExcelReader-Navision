<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConvertPdf extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->helper(array('url','html','form'));
		//$this->load->library('ConvertPDF');
	}

	public function index() {

		$error = array('error' => '');
		$this->load->view('convert_pdf', $error);
	}

	public function do_upload(){

		$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 10000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file_upload')) {
            $error = array('error' => 'Ada Error : '.$this->upload->display_errors());
            $this->load->view('convert_pdf', $error);
        }
        else {
            $data_upload = $this->upload->data();

            $get_file_pdf = $data_upload['file_path'].$data_upload['file_name'];



            //var_dump($get_file_pdf);
            /*
            echo "siapkan doconvert<br>";
			$this->load->library('libconvertpdf');
			$this->libconvertpdf->do_convert($data_upload);
			*/




			$parser = new \Smalot\PdfParser\Parser();
			$pdf    = $parser->parseFile($get_file_pdf);

			$details  = $pdf->getDetails();
			$text = $pdf->getText();

			$explode_text = explode(" ", $text);





			var_dump($text);


     	}

	}


}
?>