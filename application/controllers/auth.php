<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
defined('BASEPATH') OR exit('No direct script access allowed');
class auth extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
			 */
	public function __construct()
    {
        parent::__construct();
        $this->load->model('mlogin');
        $sesi_login=$this->session->userdata('logged');
        if (isset ($sesi_login)) {
			redirect('');
		}

    }  	
	public function index()
	{
		redirect('auth/login');
	}
	public function login() {
		$this->load->view('login');
	}
	public function ceklogin() {
		$proseslogin=$this->input->post('proseslogin');
		if (isset ($proseslogin) and ($proseslogin!='')) {
			$username=$this->input->post('username');
			$password=$this->input->post('password');
			
			$result=$this->mlogin->set_login($username, $password);
			if ((!empty ($username) and ($password)) and (empty ($result))) {
				$gagal[]="Username dan password salah";
			}
			if (empty ($username)) {
				$gagal[]="Username tidak boleh kosong";
			}
			if (empty ($password)) {
				$gagal[]="Password tidak boleh kosong";
			}
			$hitung=count($gagal);
			if ($hitung>0) {
				$response['status']="Gagal";
				foreach ($gagal as $pesan_gagal) {
					$row=array();
                    $row="<p>- ".$pesan_gagal."</p>";
                    $hasilrow[]=$row;
				}
				$response['pesan']=$hasilrow;
				echo json_encode($response);
			}
			else {
				foreach ($result as $data) {
					$id_user = $data->ID_USER;
					$unit_up = $data->UNITUP;
                    $nama_user = $data->NAMA_USER;
                    $tglinsert = $data->TGLINSERT;
                    $disable_user = $data->DISABLE_USER;
                }
                $session = array(
					'logged' => TRUE,
					'id_user'=>$id_user,
					'unit_up'=>$unit_up,
					'nama_user'=>$nama_user,
					'tglinsert'=>$tglinsert,
					'disable_user'=>$disable_user,
					'loginstate'=>1,
				);
				$this->session->set_userdata($session);
				$response['status']="Sukses";
				$response['url']="".base_url('statistik')."";
				echo json_encode($response);
			}
    	}
    	else {
    		redirect('auth/login');
    	}
	}
}
