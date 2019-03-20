<?php

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
defined('BASEPATH') OR exit('No direct script access allowed');

class statistik extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('mdata');
        $this->load->model('mstatistik');
        $this->load->library('datetimemanipulation');
        // LOAD LIBRARY
        $sesi_login = $this->session->userdata('logged');
        if (!isset($sesi_login)) {
            redirect('auth/login');
        }
    }
    // <editor-fold defaultstate="collapsed" desc="Menu Dokumen - By Arif">

    public function index() {
        $data['title'] = "Statistik Data Support";
        $data['konten'] = "statistik/index";
        
        $rs_tiket = $this->mstatistik->get_total_tiket();
        //$data['rs_family'] = $this->mstatistik->get_total_family();
        $data['rs_family'] = $rs_tiket['dataTiketAktif_by_family'];
        // $data['rs_resolved'] = $this->mstatistik->get_total_resolved();
        // $data['rs_total_resolved'] = $this->mstatistik->get_total_resolved();

        $data['rs_resolved'] = $rs_tiket['dataTiketResolved_by_family'];
        $data['rs_total_resolved'] = $rs_tiket['dataTiketResolved_by_family'];
        $data['rs_warna'] = $this->mstatistik->get_warna();

        $data['total_tiket'] = $rs_tiket['dataTiketTotal'][0]['TOTAL_TIKET'];
        $data['tiket_aktif'] = $rs_tiket['dataTiketAktif'][0]['TOTAL_TIKET'];
        $data['tiket_resolved'] = $rs_tiket['dataTiketResolved'][0]['TOTAL_TIKET'];

        $data['rs_bulan'] = $this->datetimemanipulation->get_list_month();
        $data['rs_tahun'] = $this->mstatistik->get_list_tahun();
        $data['waktu_kemarin'] = $this->datetimemanipulation->get_date_yesterday();
        $data['waktu_sekarang'] = $this->datetimemanipulation->get_date_now();


       // print_r($data['rs_jml_pertransaksi']); exit();
        $this->load->view('home', $data);
    }


public function ajax_get_incident()
    {
        $family = $this->input->post('family');
        $group = $this->input->post('group');
        $params = array(
            'SERVICEFAMILY' => $family,
            'SERVICEGROUP' => $group, 
            'SERVICETYPE' => '', 
        );

        $res['rs_tiket'] = $this->mstatistik->get_pkg_detail_incident($params);
        $res['rs_warna'] = $this->mstatistik->get_warna();               

        echo json_encode($res);
    }
    // get data detail h-1
public function ajax_get_detail() {
        // set page rules
        // get data id
        $family = $this->input->post('family');
        $group = $this->input->post('group');
        $type = $this->input->post('type');
        $html = '';


                                        // ---------------------------------------- Grid 3  Start ----------------------------------- //
                            $params = array(
                                'SERVICEFAMILY' => $family,
                                'SERVICEGROUP' => $group, 
                                'SERVICETYPE' => $type, 
                            );
                             $data = $this->mstatistik->get_pkg_detail_incident($params);                    
                                                  //print_r($params); exit();
                            $no = 1;
                            if (count($data) > 0) {
                                // header table detail
                                $html .= '
                                <div class="table-responsive" style="overflow-x:true; width:100%; max-height:250px;">
                                <table class="table table-bordered table-hover table-striped w-auto detil">
                                    <thead>
                                        <tr>
                                            <th>INCIDENT</th>
                                            <th style="padding: 0 50px">CASEOWNER</th>
                                            <th>CASEOWNEREMAIL</th>
                                            <th>COMPLAINANT</th>
                                            <th>COMPLAINANTEMAIL</th>
                                            <th style="padding: 0 100px">SUMMARY</th>
                                            <th>SOURCE</th>             
                                            <th>CALLTYPE</th>               
                                            <th>STATUS</th>
                                            <th>CREATEDBY</th>
                                            <th>SERVICEFAMILY</th>
                                            <th>SERVICEGROUP</th>
                                            <th>SERVICETYPE</th>
                                            <th> CAUSE </th>
                                            <th> RESOLUTION </th>
                                            <th> CREATEDBY </th>
                                            <th> CREATEDON </th>
                                            <th> RESOLVEDBY </th>
                                            <th> RESOLVEDON </th>
                                            <th> MODIFIEDBY </th>
                                            <th> MODIFIEDON </th>
                                            <th> CLOSEDBY </th>
                                            <th> CLOSEDDATE </th>
                                            <th> SLACLASS </th>
                                            <th> SLALEVEL1 </th>
                                            <th> SLALEVEL2 </th>
                                            <th> SLALEVEL3 </th>
                                            <th> PRIORITY </th>
                                            <th> PRIORITYNAME </th>
                                            <th> ASSIGNTO </th>
                                            <th> FIRSTCALLRESOLUTION </th>
                                            <th> ASSIGNEDON </th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                                foreach ($data['OUT_DATA_INCIDENT'] AS $item) {

                                    $html .= '
                                                        
                                                            
                                        <tr>
                                            <td>'. number_format($item['INCIDENT'], 0, '', '') .'</td>
                                            <td>'.$item["CASEOWNER"].'</td>
                                            <td>'.$item["CASEOWNEREMAIL"].'</td>
                                            <td>'.$item["COMPLAINANT"].'</td>
                                            <td>'.$item["COMPLAINANTEMAIL"].'</td>
                                            <td>'.$item["SUMMARY"].'</td>
                                            <td>'.$item["SOURCE"].'</td>             
                                            <td>'.$item["CALLTYPE"].'</td>               
                                            <td>'.$item["STATUS"].'</td>
                                            <td>'.$item["CREATEDBY"].'</td>
                                            <td>'.$item["SERVICEFAMILY"].'</td>
                                            <td>'.$item["SERVICEGROUP"].'</td>
                                            <td>'.$item["SERVICETYPE"].'</td>
                                            <td>'.$item[" CAUSE "].'</td>
                                            <td>'.$item[" RESOLUTION "].'</td>
                                            <td>'.$item[" CREATEDBY "].'</td>
                                            <td>'.$item[" CREATEDON "].'</td>
                                            <td>'.$item[" RESOLVEDBY "].'</td>
                                            <td>'.$item[" RESOLVEDON "].'</td>
                                            <td>'.$item[" MODIFIEDBY "].'</td>
                                            <td>'.$item[" MODIFIEDON "].'</td>
                                            <td>'.$item[" CLOSEDBY "].'</td>
                                            <td>'.$item[" CLOSEDDATE "].'</td>
                                            <td>'.$item[" SLACLASS "].'</td>
                                            <td>'.$item[" SLALEVEL1 "].'</td>
                                            <td>'.$item[" SLALEVEL2 "].'</td>
                                            <td>'.$item[" SLALEVEL3 "].'</td>
                                            <td>'.$item[" PRIORITY "].'</td>
                                            <td>'.$item[" PRIORITYNAME "].'</td>
                                            <td>'.$item[" ASSIGNTO "].'</td>
                                            <td>'.$item[" FIRSTCALLRESOLUTION "].'</td>
                                            <td>'.$item[" ASSIGNEDON "].'</td>
                                        </tr>';

                                } // foreach 3
                                // tutup table
                                $html .= '
                                        </tbody>
                                    </table>
                                    </div>';
                            } else {
                                $html .= '<table>';
                                $html .= '<tr>';
                                $html .= '<td colspan="4">data tida ditemukan!</td>';
                                $html .= '</tr>';
                                $html .= '</table>';
                            }
    // ---------------------------------------- Grid 3  End ----------------------------------- //



        echo $html;
    }


// UNTUK DETAIL GRAFIK
    public function ajax_get_incident_total()
    {
        $family = $this->input->post('family');
        $group = $this->input->post('group');
        $params = array(
            'SERVICEFAMILY' => $family,
            'SERVICEGROUP' => $group, 
            'SERVICETYPE' => '', 
        );
        $res['rs_tiket'] = $this->mstatistik->get_pkg_detail_incident_total($params);
        $res['rs_warna'] = $this->mstatistik->get_warna();               

        echo json_encode($res);
    }

    public function ajax_get_incident_total_awal() {
        // set page rules
        // get data id
        $family = $this->input->post('family');

        // ---------------------------------------- Grid 1  Start ----------------------------------- //
        $params = array(
            'SERVICEFAMILY' => $family,
            'SERVICEGROUP' => '', 
            'SERVICETYPE' => '', 
        );
         $data = $this->mstatistik->get_pkg_detail_incident_total($params);
         // BUILD HTML

        // table
        $html = '';

        $no = 1;
        if (count($data) > 0) {
            $html .= '
            <table class="table table-responsive w-auto">
                  <thead>
                    <tr style="border-bottom-style: none; border-top-style: none; background-color: #3C8DBC;">
                      <th>#SERVICEFAMILY : '.$family.'</th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                </table>'; 

            foreach ($data['OUT_DATA_SERVICEGROUP'] AS $item) {

                //$id_collapse = 'collapse' . substr($item['SERVICEGROUP'], 0,2);
                $id_collapse = 'colls' . substr($item['SERVICEFAMILY'], 0,2)  . substr($item['SERVICEGROUP'], 0,2) .$no++ ;
         $html .= '

                <table class="table table-responsive w-auto">
                    <tbody>

                      <tr class="success">
                        <td class="bg-light-blue" scope="row" width="40px">
                          <a class="btn btn-primary btn-xs collapsed" onclick="changeIcon(\''.$id_collapse.'\')" data-toggle="collapse" href="#'.$id_collapse.'" role="button"   aria-expanded="false" aria-controls="'.$id_collapse.'">
                            <i id="fa_'.$id_collapse.'" class=" fa fa-plus"></i>
                          </a>
                        </td>
                        <td class="bg-light-blue"  width="110px" >SERVICEGROUP : </td>
                        <td width="200px" style="padding-left:10px">' . $item['SERVICEGROUP'] . '</td>
                        <td width="50px"><span class="badge bg-red">' . $item['RECORD'] . '</span></td>
                        <td ></td>
                      </tr>
                    </tbody>
                </table> 
                  <div class="pohon1 collapse" id="'.$id_collapse.'">
                    <div class="card card-body">';
        // ---------------------------------------- Grid 2  Start ----------------------------------- //
        $params = array(
            'SERVICEFAMILY' => $item['SERVICEFAMILY'],
            'SERVICEGROUP' => $item['SERVICEGROUP'], 
            'SERVICETYPE' => '', 
        );
         $data = $this->mstatistik->get_pkg_detail_incident_total($params);                    
                              
        $no2 = 1;
        if (count($data) > 0) {
            foreach ($data['OUT_DATA_SERVICETYPE'] AS $item) {

                $id_collapse = $id_collapse .'child'. $no2++;
                $html .= '
                    <table class="table table-responsive w-auto">
                    <tbody>
                      <tr class="success">
                        <td class="bg-light-blue" scope="row" width="40px">
                          <a class="btn btn-primary btn-xs collapsed"   data-toggle="collapse" href="#'.$id_collapse.'" role="button"   aria-expanded="false" aria-controls="'.$id_collapse.'">
                            <i class="'.$id_collapse.' fa fa-plus"></i>
                          </a>
                        </td>

                        <td class="bg-light-blue"  width="110px" >SERVICETYPE : </td>
                        <td width="250px"  style="padding-left:10px">' . $item['SERVICETYPE'] . '</td>
                        <td width="50px"><span class="badge bg-red">' . $item['RECORD'] . '</span></td>
                        <td></td>
                      </tr>
                    </tbody>
                </table> 
                                  

                  <div class="collapse" id="'.$id_collapse.'">
                    <div class="card card-body">
                                        ';


                                        // ---------------------------------------- Grid 3  Start ----------------------------------- //
                            $params = array(
                                'SERVICEFAMILY' => $item['SERVICEFAMILY'],
                                'SERVICEGROUP' => $item['SERVICEGROUP'], 
                                'SERVICETYPE' => $item['SERVICETYPE'], 
                            );
                             $data = $this->mstatistik->get_pkg_detail_incident_total($params);                    
                                                  
                            $no = 1;
                            if (count($data) > 0) {
                                // header table detail
                                $html .= '
                                <div class="table-responsive" style="overflow-x:true; width:100%">
                                <table class="table table-bordered table-hover table-striped w-auto detil">
                                    <thead>
                                        <tr>
                                            <th>INCIDENT</th>
                                            <th style="padding: 0 50px">CASEOWNER</th>
                                            <th>CASEOWNEREMAIL</th>
                                            <th>COMPLAINANT</th>
                                            <th>COMPLAINANTEMAIL</th>
                                            <th style="padding: 0 100px">SUMMARY</th>
                                            <th>SOURCE</th>             
                                            <th>CALLTYPE</th>               
                                            <th>STATUS</th>
                                            <th>CREATEDBY</th>
                                            <th>SERVICEFAMILY</th>
                                            <th>SERVICEGROUP</th>
                                            <th>SERVICETYPE</th>
                                            <th> CAUSE </th>
                                            <th> RESOLUTION </th>
                                            <th> CREATEDBY </th>
                                            <th> CREATEDON </th>
                                            <th> RESOLVEDBY </th>
                                            <th> RESOLVEDON </th>
                                            <th> MODIFIEDBY </th>
                                            <th> MODIFIEDON </th>
                                            <th> CLOSEDBY </th>
                                            <th> CLOSEDDATE </th>
                                            <th> SLACLASS </th>
                                            <th> SLALEVEL1 </th>
                                            <th> SLALEVEL2 </th>
                                            <th> SLALEVEL3 </th>
                                            <th> PRIORITY </th>
                                            <th> PRIORITYNAME </th>
                                            <th> ASSIGNTO </th>
                                            <th> FIRSTCALLRESOLUTION </th>
                                            <th> ASSIGNEDON </th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                                foreach ($data['OUT_DATA_INCIDENT'] AS $item) {

                                    $html .= '
                                                        
                                                            
                                        <tr>
                                            <td>'. number_format($item['INCIDENT'], 0, '', '') .'</td>
                                            <td>'.$item["CASEOWNER"].'</td>
                                            <td>'.$item["CASEOWNEREMAIL"].'</td>
                                            <td>'.$item["COMPLAINANT"].'</td>
                                            <td>'.$item["COMPLAINANTEMAIL"].'</td>
                                            <td>'.$item["SUMMARY"].'</td>
                                            <td>'.$item["SOURCE"].'</td>             
                                            <td>'.$item["CALLTYPE"].'</td>               
                                            <td>'.$item["STATUS"].'</td>
                                            <td>'.$item["CREATEDBY"].'</td>
                                            <td>'.$item["SERVICEFAMILY"].'</td>
                                            <td>'.$item["SERVICEGROUP"].'</td>
                                            <td>'.$item["SERVICETYPE"].'</td>
                                            <td>'.$item[" CAUSE "].'</td>
                                            <td>'.$item[" RESOLUTION "].'</td>
                                            <td>'.$item[" CREATEDBY "].'</td>
                                            <td>'.$item[" CREATEDON "].'</td>
                                            <td>'.$item[" RESOLVEDBY "].'</td>
                                            <td>'.$item[" RESOLVEDON "].'</td>
                                            <td>'.$item[" MODIFIEDBY "].'</td>
                                            <td>'.$item[" MODIFIEDON "].'</td>
                                            <td>'.$item[" CLOSEDBY "].'</td>
                                            <td>'.$item[" CLOSEDDATE "].'</td>
                                            <td>'.$item[" SLACLASS "].'</td>
                                            <td>'.$item[" SLALEVEL1 "].'</td>
                                            <td>'.$item[" SLALEVEL2 "].'</td>
                                            <td>'.$item[" SLALEVEL3 "].'</td>
                                            <td>'.$item[" PRIORITY "].'</td>
                                            <td>'.$item[" PRIORITYNAME "].'</td>
                                            <td>'.$item[" ASSIGNTO "].'</td>
                                            <td>'.$item[" FIRSTCALLRESOLUTION "].'</td>
                                            <td>'.$item[" ASSIGNEDON "].'</td>
                                        </tr>';

                                } // foreach 3
                                // tutup table
                                $html .= '
                                        </tbody>
                                    </table>
                                    </div>';
                            } else {
                                $html .= '<table>';
                                $html .= '<tr>';
                                $html .= '<td colspan="4">data tida ditemukan!</td>';
                                $html .= '</tr>';
                                $html .= '</table>';
                            }
    // ---------------------------------------- Grid 3  End ----------------------------------- //


                $html .='                        
                                          
                                        </div>
                                      </div> ';

            } // foreach 2
        } else {
            $html .= '<table>';
            $html .= '<tr>';
            $html .= '<td colspan="4">data tida ditemukan!</td>';
            $html .= '</tr>';
            $html .= '</table>';
        }
    // ---------------------------------------- Grid 2  End ----------------------------------- //
         $html .= '

                            </div>
                          </div>

         ';

            } // foreach 1
        } else { // tutup if
            $html .= '<table>';
            $html .= '<tr>';
            $html .= '<td colspan="4">data tida ditemukan!</td>';
            $html .= '</tr>';
            $html .= '</table>';
        } // tutup if
        // ---------------------------------------- Grid 1  End ----------------------------------- //


        echo $html;
    }


    
    public function harian() {
        $data['title'] = "Statistik Data Support";
        $data['konten'] = "statistik/harian";


        // get search parameter
        $search = $this->session->userdata('data_search_harian');
        if (!empty($search)) {
            $data['search'] = $search;
        } else {
            $data['search']['INTANGGAL'] =  date('d-m-Y', strtotime("-1 day"));
        }
        // search parameters
        //$data['bulan'] = empty($data['bulan']) ? date('Y') : $data['bulan'];
        $INTANGGAL = $data['search']['INTANGGAL'];

        $data['rs_family'] = $this->mstatistik->get_total_family_harian($INTANGGAL);
        $data['rs_resolved'] = $this->mstatistik->get_total_resolved_harian($INTANGGAL);
        $data['rs_total_resolved'] = $this->mstatistik->get_total_resolved_harian($INTANGGAL);
        $data['rs_warna'] = $this->mstatistik->get_warna();
        $data['total_tiket'] = $this->mstatistik->get_total_tiket_harian($INTANGGAL);
        $data['tiket_aktif'] = $this->mstatistik->get_total_tiket_aktif_harian($INTANGGAL);
        $data['tiket_resolved'] = $this->mstatistik->get_total_tiket_resolved_harian($INTANGGAL);


        $data['rs_bulan'] = $this->datetimemanipulation->get_list_month();
        $data['rs_tahun'] = $this->mstatistik->get_list_tahun();
        $data['waktu_sekarang'] = $this->datetimemanipulation->get_date_now();
        $data['INTANGGAL'] = $INTANGGAL;


       // print_r($data['rs_jml_pertransaksi']); exit();
        $this->load->view('home', $data);
    }

    // search process
    public function search_process_harian() {
        // data
        if ($this->input->post('button') == "reset") {
            $this->session->unset_userdata('data_search_harian');
        } else {
            $params = array(
                "INTANGGAL" => $this->input->post("INTANGGAL", TRUE),
            );
            $this->session->set_userdata("data_search_harian", $params);
        }
        // redirect ke fungsi index
        redirect("statistik/harian");
    }


    // get data detail h-1
    public function ajax_get_incident_harian() {

        $family = $this->input->post('family');
        $tgl = $this->input->post('INTANGGAL');
        $INTANGGAL = substr($tgl, 6,4).substr($tgl, 3,2).substr($tgl, 0,2);
        // ---------------------------------------- Grid 1  Start ----------------------------------- //
        $params = array(
            'INTANGGAL' => $INTANGGAL, 
            'SERVICEFAMILY' => $family,
            'SERVICEGROUP' => '', 
            'SERVICETYPE' => '', 
        );
         $data = $this->mstatistik->get_pkg_detail_incident_by_tgl($params);
         // BUILD HTML

        // table
        $html = '';

        $no = 1;
        if (count($data) > 0) {
            $html .= '
            <table class="table table-responsive w-auto">
                  <thead>
                    <tr style="border-bottom-style: none; border-top-style: none; background-color: #3C8DBC;">
                      <th>#SERVICEFAMILY : '.$family.'</th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                </table>'; 

            foreach ($data['OUT_DATA_SERVICEGROUP'] AS $item) {

                //$id_collapse = 'collapse' . substr($item['SERVICEGROUP'], 0,2);
                $id_collapse = 'colls' . substr($item['SERVICEFAMILY'], 0,2)  . substr($item['SERVICEGROUP'], 0,2) .$no++ ;
         $html .= '

                <table class="table table-responsive w-auto">
                    <tbody>

                      <tr class="success">
                        <td class="bg-light-blue" scope="row" width="40px">
                          <a class="btn btn-primary btn-xs collapsed" onclick="changeIcon(\''.$id_collapse.'\')" data-toggle="collapse" href="#'.$id_collapse.'" role="button"   aria-expanded="false" aria-controls="'.$id_collapse.'">
                            <i id="fa_'.$id_collapse.'" class=" fa fa-plus"></i>
                          </a>
                        </td>
                        <td class="bg-light-blue"  width="110px" >SERVICEGROUP : </td>
                        <td width="200px" style="padding-left:10px">' . $item['SERVICEGROUP'] . '</td>
                        <td width="50px"><span class="badge bg-red">' . $item['RECORD'] . '</span></td>
                        <td ></td>
                      </tr>
                    </tbody>
                </table> 
                  <div class="pohon1 collapse" id="'.$id_collapse.'">
                    <div class="card card-body">';
        // ---------------------------------------- Grid 2  Start ----------------------------------- //
        $params = array(
            'INTANGGAL' => $INTANGGAL, 
            'SERVICEFAMILY' => $item['SERVICEFAMILY'],
            'SERVICEGROUP' => $item['SERVICEGROUP'], 
            'SERVICETYPE' => '', 
        );
         $data = $this->mstatistik->get_pkg_detail_incident_by_tgl($params);                    
                              
        $no2 = 1;
        if (count($data) > 0) {
            foreach ($data['OUT_DATA_SERVICETYPE'] AS $item) {

                $id_collapse = $id_collapse .'child'. $no2++;
                $html .= '
                    <table class="table table-responsive w-auto">
                    <tbody>
                      <tr class="success">
                        <td class="bg-light-blue" scope="row" width="40px">
                          <a class="btn btn-primary btn-xs collapsed"   data-toggle="collapse" href="#'.$id_collapse.'" role="button"   aria-expanded="false" aria-controls="'.$id_collapse.'">
                            <i class="'.$id_collapse.' fa fa-plus"></i>
                          </a>
                        </td>

                        <td class="bg-light-blue"  width="110px" >SERVICETYPE : </td>
                        <td width="250px"  style="padding-left:10px">' . $item['SERVICETYPE'] . '</td>
                        <td width="50px"><span class="badge bg-red">' . $item['RECORD'] . '</span></td>
                        <td></td>
                      </tr>
                    </tbody>
                </table> 
                                  

                  <div class="collapse" id="'.$id_collapse.'">
                    <div class="card card-body">
                                        ';


                                        // ---------------------------------------- Grid 3  Start ----------------------------------- //
                            $params = array(
                                'INTANGGAL' => $INTANGGAL, 
                                'SERVICEFAMILY' => $item['SERVICEFAMILY'],
                                'SERVICEGROUP' => $item['SERVICEGROUP'], 
                                'SERVICETYPE' => $item['SERVICETYPE'], 
                            );
                             $data = $this->mstatistik->get_pkg_detail_incident_by_tgl($params);                    
                                                  
                            $no = 1;
                            if (count($data) > 0) {
                                // header table detail
                                $html .= '
                                <div class="table-responsive" style="overflow-x:true; width:100%">
                                <table class="table table-bordered table-hover table-striped w-auto detil">
                                    <thead>
                                        <tr>
                                            <th>INCIDENT</th>
                                            <th style="padding: 0 50px">CASEOWNER</th>
                                            <th>CASEOWNEREMAIL</th>
                                            <th>COMPLAINANT</th>
                                            <th>COMPLAINANTEMAIL</th>
                                            <th style="padding: 0 100px">SUMMARY</th>
                                            <th>SOURCE</th>             
                                            <th>CALLTYPE</th>               
                                            <th>STATUS</th>
                                            <th>CREATEDBY</th>
                                            <th>SERVICEFAMILY</th>
                                            <th>SERVICEGROUP</th>
                                            <th>SERVICETYPE</th>
                                            <th> CAUSE </th>
                                            <th> RESOLUTION </th>
                                            <th> CREATEDBY </th>
                                            <th> CREATEDON </th>
                                            <th> RESOLVEDBY </th>
                                            <th> RESOLVEDON </th>
                                            <th> MODIFIEDBY </th>
                                            <th> MODIFIEDON </th>
                                            <th> CLOSEDBY </th>
                                            <th> CLOSEDDATE </th>
                                            <th> SLACLASS </th>
                                            <th> SLALEVEL1 </th>
                                            <th> SLALEVEL2 </th>
                                            <th> SLALEVEL3 </th>
                                            <th> PRIORITY </th>
                                            <th> PRIORITYNAME </th>
                                            <th> ASSIGNTO </th>
                                            <th> FIRSTCALLRESOLUTION </th>
                                            <th> ASSIGNEDON </th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                                foreach ($data['OUT_DATA_INCIDENT'] AS $item) {

                                    $html .= '
                                                        
                                                            
                                        <tr>
                                            <td>'. number_format($item['INCIDENT'], 0, '', '') .'</td>
                                            <td>'.$item["CASEOWNER"].'</td>
                                            <td>'.$item["CASEOWNEREMAIL"].'</td>
                                            <td>'.$item["COMPLAINANT"].'</td>
                                            <td>'.$item["COMPLAINANTEMAIL"].'</td>
                                            <td>'.$item["SUMMARY"].'</td>
                                            <td>'.$item["SOURCE"].'</td>             
                                            <td>'.$item["CALLTYPE"].'</td>               
                                            <td>'.$item["STATUS"].'</td>
                                            <td>'.$item["CREATEDBY"].'</td>
                                            <td>'.$item["SERVICEFAMILY"].'</td>
                                            <td>'.$item["SERVICEGROUP"].'</td>
                                            <td>'.$item["SERVICETYPE"].'</td>
                                            <td>'.$item[" CAUSE "].'</td>
                                            <td>'.$item[" RESOLUTION "].'</td>
                                            <td>'.$item[" CREATEDBY "].'</td>
                                            <td>'.$item[" CREATEDON "].'</td>
                                            <td>'.$item[" RESOLVEDBY "].'</td>
                                            <td>'.$item[" RESOLVEDON "].'</td>
                                            <td>'.$item[" MODIFIEDBY "].'</td>
                                            <td>'.$item[" MODIFIEDON "].'</td>
                                            <td>'.$item[" CLOSEDBY "].'</td>
                                            <td>'.$item[" CLOSEDDATE "].'</td>
                                            <td>'.$item[" SLACLASS "].'</td>
                                            <td>'.$item[" SLALEVEL1 "].'</td>
                                            <td>'.$item[" SLALEVEL2 "].'</td>
                                            <td>'.$item[" SLALEVEL3 "].'</td>
                                            <td>'.$item[" PRIORITY "].'</td>
                                            <td>'.$item[" PRIORITYNAME "].'</td>
                                            <td>'.$item[" ASSIGNTO "].'</td>
                                            <td>'.$item[" FIRSTCALLRESOLUTION "].'</td>
                                            <td>'.$item[" ASSIGNEDON "].'</td>
                                        </tr>';

                                } // foreach 3
                                // tutup table
                                $html .= '
                                        </tbody>
                                    </table>
                                    </div>';
                            } else {
                                $html .= '<table>';
                                $html .= '<tr>';
                                $html .= '<td colspan="4">data tida ditemukan!</td>';
                                $html .= '</tr>';
                                $html .= '</table>';
                            }
    // ---------------------------------------- Grid 3  End ----------------------------------- //


                $html .='                        
                                          
                                        </div>
                                      </div> ';

            } // foreach 2
        } else {
            $html .= '<table>';
            $html .= '<tr>';
            $html .= '<td colspan="4">data tida ditemukan!</td>';
            $html .= '</tr>';
            $html .= '</table>';
        }
    // ---------------------------------------- Grid 2  End ----------------------------------- //
         $html .= '

                            </div>
                          </div>

         ';

            } // foreach 1
        } else { // tutup if
            $html .= '<table>';
            $html .= '<tr>';
            $html .= '<td colspan="4">data tida ditemukan!</td>';
            $html .= '</tr>';
            $html .= '</table>';
        } // tutup if
        // ---------------------------------------- Grid 1  End ----------------------------------- //


        echo $html;
    }




    // LOAD DATA TABLE
    // public function dokumen_load_params_harian() {
    //     $family = $this->input->post('family');
    //     $INTANGGAL = $this->input->post('INTANGGAL');
    //     // get params
    //     $family = empty($family) ? '' : "%".$family."%";
    //     // parameter
    //     $params = array($INTANGGAL, $family);
    //     $res = $this->mstatistik->get_list_by_family_harian($params);
    //     // get data
    //     if (empty($res)) {
    //         $output = array(
    //             "data" => [],
    //         );
    //         echo json_encode($output);
    //     } else {
    //         $session_data['rs_ophar'] = $res;
    //         $this->session->set_userdata($session_data);
    //         foreach ($res as $data) {
    //             $row = array();
    //             $row[] = number_format($data['INCIDENT'], 0, '', '');
    //             $row[] = $data['CASEOWNER'];
    //             $row[] = $data['SLACLASS'];
    //             $row[] = $data['SUMMARY'];
    //             $row[] = $data['SERVICETYPE'];
    //             $row[] = $data['CREATEDBY'];
    //             $row[] = $data['CREATEDON'];
    //             $row[] = $data['CLOSEDDATE'];
    //             $row[] = $data['ASSIGNTO'];
    //             $row[] = $data['ASSIGNEDON'];
    //             $dataarray[] = $row;
    //         }
    //         $output = array(
    //             "data" => $dataarray
    //         );
    //         echo json_encode($output);
    //     }
    // }


    
    public function bulanan() {
        $data['title'] = "Statistik Data Support";
        $data['konten'] = "statistik/bulanan";


        // get search parameter
        $search = $this->session->userdata('data_search');
        if (!empty($search)) {
            $data['search'] = $search;
        } else {
            $data['search']['bulan'] =  date('m');
            $data['search']['tahun'] =  date('Y');
        }
        // search parameters
        //$data['bulan'] = empty($data['bulan']) ? date('Y') : $data['bulan'];
        $blth = $data['search']['tahun'].$data['search']['bulan'];

        $rs_tiket = $this->mstatistik->get_pkg_incident_perbulan($blth);

        $data['rs_total_tiket'] = $rs_tiket['OUT_DATA_TOTAL_TIKET'];
        $data['rs_tiket_sla'] = $rs_tiket['OUT_DATA_LIST_SLA'];
        $data['total_tiket'] = $rs_tiket['OUT_TIKET_TOTAL'];
        $data['tiket_oversla'] = $rs_tiket['OUT_TIKET_OVERSLA'];
        $data['tiket_resolved'] = $rs_tiket['OUT_TIKET_RESOLVED'];
        $data['rs_tiket_bulanan'] = $rs_tiket['OUT_DATA_TIKET_BY_BULAN'];
        $data['rs_bulan'] = $this->datetimemanipulation->get_list_month();
        $data['rs_tahun'] = $this->mstatistik->get_list_tahun();
        $data['waktu_sekarang'] = $this->datetimemanipulation->get_date_now();


       // print_r($rs_tiket); exit();
        $this->load->view('home', $data);
    }

    // search process
    public function search_process_bulanan() {
        // data
        if ($this->input->post('button') == "reset") {
            $this->session->unset_userdata('data_search');
        } else {
            $params = array(
                "bulan" => $this->input->post("bulan", TRUE),
                "tahun" => $this->input->post("tahun", TRUE),
            );
            $this->session->set_userdata("data_search", $params);
        }
        // redirect ke fungsi index
        redirect("statistik/bulanan");
    }


 // LOAD DATA TABLE
    public function dokumen_load_params_detail() {
        $family = $this->input->post('family');
        $INTANGGAL = $this->input->post('INTANGGAL');
        // get params
        $family = empty($family) ? '' : "%".$family."%";
        // parameter
        $params = array($INTANGGAL, $family);
        $res = $this->mstatistik->get_list_by_family_harian($params);
        // get data
        if (empty($res)) {
            $output = array(
                "data" => [],
            );
            echo json_encode($output);
        } else {
            $session_data['rs_ophar'] = $res;
            $this->session->set_userdata($session_data);
            foreach ($res as $data) {
                $row = array();
                $row[] = number_format($data['INCIDENT'], 0, '', '');
                $row[] = $data['CASEOWNER'];
                $row[] = $data['SLACLASS'];
                $row[] = $data['SUMMARY'];
                $row[] = $data['SERVICETYPE'];
                $row[] = $data['CREATEDBY'];
                $row[] = $data['CREATEDON'];
                $row[] = $data['CLOSEDDATE'];
                $row[] = $data['ASSIGNTO'];
                $row[] = $data['ASSIGNEDON'];
                $dataarray[] = $row;
            }
            $output = array(
                "data" => $dataarray
            );
            echo json_encode($output);
        }
    }


    // </editor-fold>
}
