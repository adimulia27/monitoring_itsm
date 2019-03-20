<?php

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
defined('BASEPATH') OR exit('No direct script access allowed');
//lets Use the Spout Namespaces
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class cexcell extends CI_Controller {

	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		ini_set('max_execution_time', 0);
		set_time_limit(0);
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper(array('path'));
		$this->load->file('assets/plugins/spout-master/src/Spout/Autoloader/autoload.php');
		$this->load->library('pagination');
		$this->load->model('mexcell');
        // LOAD LIBRARY
		$sesi_login = $this->session->userdata('logged');
		if (!isset($sesi_login)) {
			redirect('auth/login');
		}
	}
	

	public function index() {

		$data['title'] = "Upload Data ITSM";
		$data['konten'] = "vUploadExcell";
		/* start of pagination --------------------- */
        // pagination
		$config['base_url'] = site_url("cexcell/index");
        //$params = array($data_status);
		$config['total_rows'] = $this->mexcell->get_total_tiket();
		$config['uri_segment'] = 3;
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		$pagination['data'] = $this->pagination->create_links();
        // pagination attribute
		$start = $this->uri->segment(3, 0) + 1;
		$end = $this->uri->segment(3, 0) + $config['per_page'];
		$end = (($end > $config['total_rows']) ? $config['total_rows'] : $end);
		$pagination['start'] = ($config['total_rows'] == 0) ? 0 : $start;
		$pagination['end'] = $end;
		$pagination['total'] = $config['total_rows'];
        // pagination assign value
		$data['pagination'] = $pagination;
		$data['no'] = $start;
		/* end of pagination ---------------------- */
        // get list oracle vs mysql -> $start : $perpage 
        // pagenumber : per_page   -> start : per_page
        // hal1 = 1 : 10 -> 1 : 10
        // hal2 = 2 : 10 -> 11 : 10
        // hal3 = 3 : 10 -> 21 : 10
        // hal4 = 4 : 10 -> 31 : 10    
        // jadi untuk oracle
		$pagenumber = (($start -1 )/10) + 1 ;
		$params = array(($pagenumber ), $config['per_page']);
		$data['uploadItsm'] = $this->mexcell->get_list_tiket_itsm_pkg($params);
		$this->load->view('home', $data);
		
// $message = $this->mexcell->insert_itsm_upload($params);
// print_r($message);
	}

	//import database
	public function importDataExcell(){
		
			if(!empty($this->input->post("btn_kirim_itsm", TRUE))){
				$this->kirim_to_itsm();
			}
		try 
		{
			$inputFileName = $_FILES['file']['tmp_name'];
			//print_r($inputFileName); exit();
			//Lokasi file excel       
			$file_path = $inputFileName;                     
			$reader = ReaderFactory::create(Type::XLSX); //set Type file xlsx
			$reader->open($inputFileName); //open the file          

			if($this->input->post("replace", TRUE) == 'REPLACE'){
				$this->mexcell->delete_itsm_upload();
			}
			//echo "<pre>";           
			$i=0;
			
			foreach ($reader->getSheetIterator() as $sheet) {
				
				foreach ($sheet->getRowIterator() as $row) {
					
					if ($i >= 1){
						
						$CREATEDON = new DateTime("1899-12-30 + ". round($row[22] * 86400) . " seconds");
						$TASKCREATEDON = new DateTime("1899-12-30 + ". round($row[23] * 86400) . " seconds");
						$RESOLVEDON = new DateTime("1899-12-30 + ". round($row[27] * 86400) . " seconds");
						$MODIFIEDON = new DateTime("1899-12-30 + ". round($row[29] * 86400) . " seconds");
						$CLOSEDDATE = new DateTime("1899-12-30 + ". round($row[31] * 86400) . " seconds");
						$SLALEVEL180 = new DateTime("1899-12-30 + ". round($row[33] * 86400) . " seconds");
						$SLALEVEL1 = new DateTime("1899-12-30 + ". round($row[34] * 86400) . " seconds");
						$SLALEVEL2 = new DateTime("1899-12-30 + ". round($row[35] * 86400) . " seconds");
						$SLALEVEL3 = new DateTime("1899-12-30 + ". round($row[36] * 86400) . " seconds");
						$ASSIGNEDON = new DateTime("1899-12-30 + ". round($row[25] * 86400) . " seconds");

						$params[] = array(
							'INCIDENT' => $row[0],
							'PRIORITYNAME' => $row[1],
							'SLACLASS' => $row[2],
							'CASEOWNER' => $row[3],
							'CASEOWNEREMAIL' => $row[4],
							'UNITINDUK' => $row[5],
							'UNITPELAKSANA' => $row[6],
							'UNITSUBPELAKSANA' => $row[7],
							'COMPLAINANT' => $row[8],
							'COMPLAINANTEMAIL' => $row[9],
							'SUMMARY' => $row[10],
							'SOURCE' => $row[11],
							'CALLTYPE' => $row[12],
							'STATUS' => $row[13],
							'DESCRIPTION' => $row[14],
							'SERVICEFAMILY' => $row[15],
							'SERVICEGROUP' => $row[16],
							'SERVICETYPE' => $row[17],
							'CAUSE' => $row[18],
							'CAUSECODE' => $row[19],
							'RESOLUTION' => $row[20],
							'CREATEDBY' => $row[21],
							'CREATEDON' => $CREATEDON->format("d/m/Y H:i:s"),
							'TASKCREATEDON' => $TASKCREATEDON->format("d/m/Y H:i:s"),
							'ASSIGNTO' => $row[24],
							'ASSIGNEDON' => $ASSIGNEDON->format("d/m/Y H:i:s"),
							'RESOLVEDBY' => $row[26],
							'RESOLVEDON' => $RESOLVEDON->format("d/m/Y H:i:s"),
							'MODIFIEDBY' => $row[28],
							'MODIFIEDON' => $MODIFIEDON->format("d/m/Y H:i:s"),
							'CLOSEDBY' => $row[30],
							'CLOSEDDATE' => $CLOSEDDATE->format("d/m/Y H:i:s"),
							'PRIORITY' => $row[32],
							'SLALEVEL180%' => $SLALEVEL1->format("d/m/Y H:i:s"),						
							'SLALEVEL1' => $SLALEVEL1->format("d/m/Y H:i:s"),
							'SLALEVEL2' => $SLALEVEL2->format("d/m/Y H:i:s"),
							'SLALEVEL3' => $SLALEVEL3->format("d/m/Y H:i:s"),						
							'FIRSTCALLRESOLUTION' => $row[37],
							
							//'TGLUPLOAD' => $row[32],
							//'UPLOADBY' => $this->session->userdata('id_user'),
							//'REPLACE' => $this->input->post("replace", TRUE)
						);
						
					}
					$i++;
					
				}
				
			}
			$message = $this->mexcell->insert_itsm_upload($params);             
			//print_r($message); exit();
			$reader->close();
			if($message == 'sukses'){
				$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan.');
				redirect("cexcell");
			}else{
				$this->session->set_flashdata('gagal', $message);
				redirect("cexcell");
			}

		} catch (Exception $e) {
			$this->session->set_flashdata('gagal', $e->getMessage());
			redirect("cexcell");
		}
	}

	public function kirim_to_itsm(){
		$result = $this->mexcell->kirim_to_itsm();             
		//print_r($message); exit();
		if($result == 'sukses'){
			$this->session->set_flashdata('pesan', 'Data berhasil dikirim.');
			redirect("cexcell");
		}else{
			$this->session->set_flashdata('gagal', $result);
			redirect("cexcell");
		}
	}
}