<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class mstatistik extends CI_Model {
    // function __construct()
    // {
    //     parent::__construct();
    // }

    // list tahun

    // get list yg terdaftar di spt
    public function get_list_tahun() {
        $tahun_skrg = date('Y');
        $tahun_start = $tahun_skrg - 5 ;

        for ($i=$tahun_start; $i <= $tahun_skrg; $i++) { 
            $result[] = $i;
        }

        return $result;
    }
    public function get_warna() { 
        return $rs_warna = array(
            0 => '#CC0000', 
            1 => '#FF6600', 
            2 => '#FFCC00', 
            3 => '#009999', 
            4 => '#0066FF', 
            5 => '#00CC00', 
        );
    }


    // GET TOTAL TIKET BY FAMILY - DONUT CHART
    // public function get_total_family() {
    //     $sql = "SELECT  SUBSTR(SERVICEFAMILY, 5, 10) as SERVICEFAMILY_SUBSTR, SERVICEFAMILY , count(*) as total 
    //             FROM faisallubis.TIKET_ITSM 
    //             WHERE STATUS = 'Active' 
    //             AND to_char(CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-1, 'mm/dd/yyyy')
    //             group by SERVICEFAMILY
    //             ORDER BY total DESC
    //     ";
    //     $query = $this->db->query($sql);


    //     if ($query->num_rows() > 0) {
    //         $result = $query->result_array();
    //         $query->free_result();
    //         return $result;
    //     } else {
    //         return NULL;
    //     }
    // }


    // GET TOTAL TIKET BY FAMILY
    // public function get_list_by_family($params) {
    //     $sql = "SELECT INCIDENT,SLACLASS,CASEOWNER,SUMMARY,SERVICETYPE,
    //             CREATEDBY,CREATEDON,CLOSEDDATE,
    //             ASSIGNTO, ASSIGNEDON  
    //             FROM faisallubis.TIKET_ITSM 
    //             WHERE STATUS = 'Active' AND to_char(CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-1, 'mm/dd/yyyy')
    //             and SERVICEFAMILY like ?
    //     ";
    //     $query = $this->db->query($sql,$params);
    //     if ($query->num_rows() > 0) {
    //         $result = $query->result_array();
    //         //$query->free_result();
    //         return $result;
    //     } else {
    //         return NULL;
    //     }
    // }

    // GET TOTAL TIKET BY 
    public function get_total_resolved() {
        $sql = "SELECT SUBSTR(st.SERVICEFAMILY,5,10) as SERVICEFAMILY ,st.total, sv.total_rs  FROM 
                ( Select  a.SERVICEFAMILY , count(*) as total
                FROM faisallubis.TIKET_ITSM a WHERE 
                to_char(a.CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-1, 'mm/dd/yyyy') group by a.SERVICEFAMILY) st
                left join ( select b.SERVICEFAMILY, count(*) as total_rs FROM faisallubis.TIKET_ITSM b
                where status = 'Resolved' and to_char(b.CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-1, 'mm/dd/yyyy') group by b.SERVICEFAMILY) sv
                on st.SERVICEFAMILY = sv.SERVICEFAMILY
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            foreach ($result as $key => $rs) {
                $data['SERVICEFAMILY'][$key] = $rs['SERVICEFAMILY'];
                $data['TOTAL'][$key] = $rs['TOTAL'];
                $data['TOTAL_RS'][$key] = $rs['TOTAL_RS'];
            }
            return $data;
        } else {
            return NULL;
        }
    }
public function get_total_tiket() {
        $cursor='';
        $results = '';
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        $stid = oci_parse($this->pblmig_db->conn_id, 'begin OPHARAPP.PKG_TESTING.GET_DATA_H_MIN1 (:OUT_DATA_TOTAL_TIKET, :OUT_DATA_TIKET_AKTIF, :OUT_DATA_TIKET_RESOLVED, :OUT_DATA_TIKET_AKTIF_BY_FAMILY, :OUT_DATA_TOTAL_RESOLVE_BY_FMLY ); end;');
        $OUT_DATA_TOTAL_TIKET = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_TIKET_AKTIF = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_TIKET_RESOLVED = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_TIKET_AKTIF_BY_FAMILY = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_TOTAL_RESOLVE_BY_FMLY = oci_new_cursor($this->pblmig_db->conn_id);
  
        oci_bind_by_name($stid, ':OUT_DATA_TOTAL_TIKET', $OUT_DATA_TOTAL_TIKET,-1, OCI_B_CURSOR) or die('Error binding string3');
        oci_bind_by_name($stid, ':OUT_DATA_TIKET_AKTIF', $OUT_DATA_TIKET_AKTIF,-1, OCI_B_CURSOR) or die('Error binding string4');
        oci_bind_by_name($stid, ':OUT_DATA_TIKET_RESOLVED', $OUT_DATA_TIKET_RESOLVED,-1, OCI_B_CURSOR) or die('Error binding string4');
        oci_bind_by_name($stid, ':OUT_DATA_TIKET_AKTIF_BY_FAMILY', $OUT_DATA_TIKET_AKTIF_BY_FAMILY,-1, OCI_B_CURSOR) or die('Error binding AKTIF_BY_FAMILY');
        oci_bind_by_name($stid, ':OUT_DATA_TOTAL_RESOLVE_BY_FMLY', $OUT_DATA_TOTAL_RESOLVE_BY_FMLY,-1, OCI_B_CURSOR) or die('Error binding RESLV_BY_FAMILY');
                //Bind Cursor     put -1
        //var_dump($stid);
        if(oci_execute($stid)){
            oci_execute($OUT_DATA_TOTAL_TIKET, OCI_DEFAULT);
            oci_execute($OUT_DATA_TIKET_AKTIF, OCI_DEFAULT);
            oci_execute($OUT_DATA_TIKET_RESOLVED, OCI_DEFAULT);
            oci_execute($OUT_DATA_TIKET_AKTIF_BY_FAMILY, OCI_DEFAULT);
            oci_execute($OUT_DATA_TOTAL_RESOLVE_BY_FMLY, OCI_DEFAULT);
            
            //oci_fetch_all($OUT_DATA_TOTAL_TIKET, $cursor, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_TOTAL_TIKET, $cursor['dataTiketTotal'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_TIKET_AKTIF, $cursor['dataTiketAktif'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_TIKET_RESOLVED, $cursor['dataTiketResolved'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_TIKET_AKTIF_BY_FAMILY, $cursor['dataTiketAktif_by_family'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_TOTAL_RESOLVE_BY_FMLY, $cursor['dataTiketResolved_by_family'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
        

            foreach ( $cursor['dataTiketResolved_by_family'] as $key => $rs) {
                $data['SERVICEFAMILY'][$key] = $rs['SERVICEFAMILY'];
                $data['TOTAL'][$key] = $rs['TOTAL'];
                $data['TOTAL_RS'][$key] = $rs['TOTAL_RS'];
            }
            $cursor['dataTiketResolved_by_family'] = $data;
                  //echo '<br>';
            $results = $cursor;
                  //print_r($cursor);  
        }else{
            $e = oci_error($stid);
            $results =  $e['message'];
        } 
          oci_free_statement($stid);
          oci_close($this->pblmig_db->conn_id);

          return $results;
        
    }












    // GET TOTAL SUPPORT
    public function get_total_support($params) {
        $sql = "SELECT COUNT(*) AS TOTAL_SUPPORT
        FROM (SELECT ID_USER
        FROM LOG_PROSES_OPHARAPP 
        WHERE ID_USER IS NOT NULL AND TO_CHAR(TGL_CATAT,'YYYY') = ?
        GROUP BY  ID_USER)
        ";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL_SUPPORT'];
        } else {
            return NULL;
        }
    }

    // GET TOTAL SUPPORT
    public function get_jml_pertransaksi($params) {
        $sql = "SELECT * FROM (
        SELECT JENIS_TRANSAKSI, COUNT(JENIS_TRANSAKSI) AS TOTAL_PERTRANSAKSI 
        FROM LOG_PROSES_OPHARAPP 
        WHERE STATUS='RESOLVED' AND  TO_CHAR(TGL_CATAT,'YYYY') = ?
        GROUP BY JENIS_TRANSAKSI 
        ORDER BY TOTAL_PERTRANSAKSI DESC 
        )
        WHERE ROWNUM <= 6
        ";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }


    // GET TOP 5 SUPPORT THIS MONTH
    public function get_jml_tiket_support($params) {
        $sql = "SELECT * FROM 
        (
        SELECT ID_USER, COUNT(*) AS TIKET_BULAN_INI, TO_CHAR(SYSDATE,'YYYYMM') AS THBL
        FROM LOG_PROSES_OPHARAPP
        WHERE TO_CHAR(TGL_CATAT, 'YYYYMM') = ?
        GROUP BY ID_USER
        ORDER BY TIKET_BULAN_INI DESC
        )
        WHERE ROWNUM <= 5
        ";
        $query = $this->db->query($sql,$params);


        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            // set facebook id
            foreach ($result as $key => $data) {
                $result[$key]['fb_id'] = $this->get_list_fb_id($data['ID_USER']);
            }



            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get list yg terdaftar di spt
    public function get_list_fb_id($ID_USER) {
        $rs_fb = array(
            'PS.PUSAT.DEDESUPRIATNA' => '100009199784352', 
            'PS.PUSAT.DODO' => 'widodo.tama', 
            'PUSAT.ISKANDAR' => 'iskandar.zulqornain', 
            'PS.PUSAT.HERLANDANI' => 'herlandani', 
            'PS.PUSAT.DIANSEPTIANA' => 'dian.septiana', 
            'PUSAT.LUQMAN' => 'xxxx', 
            'PS.PUSAT.BAMBANG' => 'xxxx', 
            'PS.PUSAT.DODIK' => 'xxxx', 
            'PS.PUSAT.FAIZAL' => 'xxxx', 
            'SINTO' => 'xxxx', 
        );

        $result = isset($rs_fb[$ID_USER]) ? $rs_fb[$ID_USER] : null;
        return $result;
    }

    // list data
    public function get_list_top_tiket($params) {
        $sql = "SELECT NOAGENDA, JENIS_TRANSAKSI, NO_TIKET, NO_BA, TGL_PERMINTAAN, STATUS, TGL_CATAT, PERIHAL, PERMINTAAN_DARI, ID_USER
        FROM LOG_PROSES_OPHARAPP
        WHERE TO_CHAR(TGL_CATAT,'YYYYMM') = ?
        AND ROWNUM <= 8
        ORDER BY TGL_CATAT DESC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }








    // update
    public function update($params, $where) {
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        return $this->pblmig_db->update('UPLOAD_LOG', $params, $where);
    }
    
    // delete
    public function delete_data_ophar($where){
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        return $this->pblmig_db->delete('LOG_PROSES_OPHARAPP', $where);
    }
    // detail data
    public function get_file_by_id($params) {
        $sql = "SELECT *
        FROM UPLOAD_LOG 
        WHERE ID_UPLOAD = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // list data
    public function get_list_jenis_transaksi() {
        $sql = "SELECT JENIS_TRANSAKSI FROM LOG_PROSES_OPHARAPP GROUP BY JENIS_TRANSAKSI
        ORDER BY JENIS_TRANSAKSI ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // list data
    public function get_list_nama_support() {
        $sql = "SELECT ID_USER, UNITUP, NAMA_USER FROM USERTAB ORDER BY NAMA_USER ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // list data
    public function get_list_opharapp_by_params($params) {
        $sql = "SELECT A.NOAGENDA, IDPEL, A.JENIS_TRANSAKSI, A.NO_TIKET, A.NO_BA, TGL_PERMINTAAN, ID_UPLOAD, B.NAMA_FILE, TGL_CATAT, PERIHAL, PERMINTAAN_DARI, ID_USER
        FROM LOG_PROSES_OPHARAPP A
        LEFT JOIN UPLOAD_LOG B ON A.NOAGENDA = B.NOAGENDA AND A.NO_BA = B.NO_BA AND A.NO_TIKET = B.NO_TIKET
        WHERE A.NOAGENDA LIKE ? 
        AND A.NO_BA LIKE ? 
        AND A.JENIS_TRANSAKSI LIKE ? 
        AND A.NO_TIKET LIKE ?
        AND NULLIF(TO_CHAR(TGL_CATAT, 'MM/DD/YYYY'), '')  LIKE ?
        AND PERIHAL LIKE ?
        ORDER BY TGL_CATAT DESC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // list data
    public function get_detail_opharappp($params) {
        $sql = "SELECT NO_TIKET, NOAGENDA, IDPEL, PERMINTAAN_DARI, JENIS_TRANSAKSI, PERIHAL, NO_BA, A.ID_USER, NAMA_USER, B.UNITUP, TGL_PERMINTAAN, RESULOTION,  TGL_CATAT, STATUS
        FROM LOG_PROSES_OPHARAPP A
        LEFT JOIN USERTAB B ON A.ID_USER = B.ID_USER
        WHERE NOAGENDA = ? 
        AND NO_BA = ? 
        AND NO_TIKET = ?
        ORDER BY TGL_CATAT DESC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_list_dokumen_by_agenda($params) {
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        $results = '';
        $stid = oci_parse($this->pblmig_db->conn_id, 'SELECT * FROM UPLOAD_LOG WHERE NOAGENDA = :NOAGENDA');
        oci_bind_by_name($stid, ':NOAGENDA', $params['noagenda']) or die('Error binding string1');
        if (oci_execute($stid)) {
            oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            $results = $res;
        } else {
            $e = oci_error($stid);
            $results = $e['message'];
        }
        // return
        return $results;
    }
    















    // STATISTIK HARIAN

    // GET TOTAL TIKET BY FAMILY - DONUT CHART
    public function get_total_family_harian($params) {
        $sql = "SELECT  SERVICEFAMILY , SUBSTR(SERVICEFAMILY, 5, 10) as SERVICEFAMILY_SUBSTR , count(*) as total 
                FROM faisallubis.TIKET_ITSM_HISTO 
                WHERE STATUS = 'Active' 
                AND to_char(CREATEDON, 'dd-mm-yyyy') = ?
                group by SERVICEFAMILY
                ORDER BY total DESC
        ";
        $query = $this->db->query($sql, $params);


        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return NULL;
        }
    }


    // GET TOTAL TIKET BY 
    public function get_total_resolved_harian($params) {
        $params = array($params , $params);
        $sql = "SELECT SUBSTR(st.SERVICEFAMILY,5,10) as SERVICEFAMILY ,st.total, sv.total_rs  FROM 
                ( Select  a.SERVICEFAMILY , count(*) as total
                FROM faisallubis.TIKET_ITSM_HISTO a WHERE 
                to_char(a.CREATEDON, 'dd-mm-yyyy') = ? group by a.SERVICEFAMILY) st
                left join ( select b.SERVICEFAMILY, count(*) as total_rs FROM faisallubis.TIKET_ITSM b
                where status = 'Resolved' and to_char(b.CREATEDON, 'dd-mm-yyyy') = ? group by b.SERVICEFAMILY) sv
                on st.SERVICEFAMILY = sv.SERVICEFAMILY
        ";
        $query = $this->db->query($sql,  $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            foreach ($result as $key => $rs) {
                $data['SERVICEFAMILY'][$key] = $rs['SERVICEFAMILY'];
                $data['TOTAL'][$key] = $rs['TOTAL'];
                $data['TOTAL_RS'][$key] = $rs['TOTAL_RS'];
            }
            return $data;
        } else {
            return NULL;
        }
    }

    // GET TOTAL TIKET H-1
    public function get_total_tiket_harian($params) {
        $sql = "SELECT COUNT(*) TOTAL_TIKET FROM FAISALLUBIS.TIKET_ITSM_HISTO 
        WHERE to_char(CREATEDON, 'dd-mm-yyyy') = ?
        ";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL_TIKET'];
        } else {
            return NULL;
        }
    }
    // GET TOTAL TIKET AKTIF H-1
    public function get_total_tiket_aktif_harian($params) {
        $sql = "SELECT COUNT(*) TOTAL_TIKET FROM FAISALLUBIS.TIKET_ITSM_HISTO 
        WHERE to_char(CREATEDON, 'dd-mm-yyyy') = ?
        AND STATUS = 'Active'
        ";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL_TIKET'];
        } else {
            return NULL;
        }
    }
    // GET TOTAL TIKET RESOLVED H-1
    public function get_total_tiket_resolved_harian($params) {
        $sql = "SELECT COUNT(*) TOTAL_TIKET FROM FAISALLUBIS.TIKET_ITSM_HISTO 
        WHERE to_char(CREATEDON, 'dd-mm-yyyy') = ?
        AND STATUS = 'Resolved'
        ";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL_TIKET'];
        } else {
            return NULL;
        }
    }



    // menampilkan detail data dari chart
    public function get_list_by_family_harian($params) {
        $sql = "SELECT INCIDENT,SLACLASS,CASEOWNER,SUMMARY,SERVICETYPE,
                CREATEDBY,CREATEDON,CLOSEDDATE,
                ASSIGNTO, ASSIGNEDON  
                FROM faisallubis.TIKET_ITSM 
                WHERE STATUS = 'Active' AND to_char(CREATEDON, 'dd-mm-yyyy') = ?
                and SERVICEFAMILY like ?
        ";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            //$query->free_result();
            return $result;
        } else {
            return NULL;
        }
    }


    public function get_pkg_detail_incident($params){
        $msg_out = '';
        $results = '';
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }

        $stid = oci_parse($this->pblmig_db->conn_id, 'begin OPHARAPP.PKG_TESTING.GET_DATA_INCIDENT(:IN_servicefamily, :IN_SERVICEGROUP, :IN_SERVICETYPE, :OUT_DATA_SERVICEGROUP, :OUT_DATA_SERVICETYPE, :OUT_DATA_INCIDENT, :OUT_MESSAGE); end;');
        $OUT_DATA_SERVICEGROUP = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_SERVICETYPE = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_INCIDENT = oci_new_cursor($this->pblmig_db->conn_id);

        //Send parameters variable  value  lenght
        oci_bind_by_name($stid, ':IN_servicefamily', $params['SERVICEFAMILY']) or die('Error binding PAGENUMBER');
        oci_bind_by_name($stid, ':IN_SERVICEGROUP', $params['SERVICEGROUP']) or die('Error binding IN_SERVICEGROUP');
        oci_bind_by_name($stid, ':IN_SERVICETYPE', $params['SERVICETYPE']) or die('Error binding IN_SERVICETYPE');
        oci_bind_by_name($stid, ':OUT_DATA_SERVICEGROUP', $OUT_DATA_SERVICEGROUP,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA_SERVICEGROUP');
        oci_bind_by_name($stid, ':OUT_DATA_SERVICETYPE', $OUT_DATA_SERVICETYPE,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA_SERVICETYPE');
        oci_bind_by_name($stid, ':OUT_DATA_INCIDENT', $OUT_DATA_INCIDENT,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA_INCIDENT');
        oci_bind_by_name($stid, ':OUT_MESSAGE', $msg_out,100, SQLT_CHR) or die('Error binding string12');


        //Bind Cursor     put -1
        $func_result = oci_execute($stid);
        if($func_result){
            oci_execute($OUT_DATA_SERVICEGROUP, OCI_DEFAULT);
            oci_execute($OUT_DATA_SERVICETYPE, OCI_DEFAULT);
            oci_execute($OUT_DATA_INCIDENT, OCI_DEFAULT);
            oci_fetch_all($OUT_DATA_SERVICEGROUP, $cursor['OUT_DATA_SERVICEGROUP'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_SERVICETYPE, $cursor['OUT_DATA_SERVICETYPE'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_INCIDENT, $cursor['OUT_DATA_INCIDENT'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
          //echo '<br>';
            $results = $cursor;
          //print_r($cursor);  
        }else{
            $e = oci_error($stid);
            $results =  $e['message'];
        } 
        oci_free_statement($stid);
        oci_close($this->pblmig_db->conn_id);

        return $results;

    }


    public function get_pkg_detail_incident_by_tgl($params){
        $msg_out = '';
        $results = '';
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }

        $stid = oci_parse($this->pblmig_db->conn_id, 'begin OPHARAPP.PKG_TESTING.GET_DATA_INCIDENT_BY_TGL(:IN_TANGGAL, :IN_servicefamily, :IN_SERVICEGROUP, :IN_SERVICETYPE, :OUT_DATA_SERVICEGROUP, :OUT_DATA_SERVICETYPE, :OUT_DATA_INCIDENT, :OUT_MESSAGE); end;');
        $OUT_DATA_SERVICEGROUP = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_SERVICETYPE = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_INCIDENT = oci_new_cursor($this->pblmig_db->conn_id);

        //Send parameters variable  value  lenght
        oci_bind_by_name($stid, ':IN_TANGGAL', $params['INTANGGAL']) or die('Error binding IN_TANGGAL');
        oci_bind_by_name($stid, ':IN_servicefamily', $params['SERVICEFAMILY']) or die('Error binding PAGENUMBER');
        oci_bind_by_name($stid, ':IN_SERVICEGROUP', $params['SERVICEGROUP']) or die('Error binding IN_SERVICEGROUP');
        oci_bind_by_name($stid, ':IN_SERVICETYPE', $params['SERVICETYPE']) or die('Error binding IN_SERVICETYPE');
        oci_bind_by_name($stid, ':OUT_DATA_SERVICEGROUP', $OUT_DATA_SERVICEGROUP,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA_SERVICEGROUP');
        oci_bind_by_name($stid, ':OUT_DATA_SERVICETYPE', $OUT_DATA_SERVICETYPE,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA_SERVICETYPE');
        oci_bind_by_name($stid, ':OUT_DATA_INCIDENT', $OUT_DATA_INCIDENT,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA_INCIDENT');
        oci_bind_by_name($stid, ':OUT_MESSAGE', $msg_out,100, SQLT_CHR) or die('Error binding string12');


        //Bind Cursor     put -1
        $func_result = oci_execute($stid);
        if($func_result){
            oci_execute($OUT_DATA_SERVICEGROUP, OCI_DEFAULT);
            oci_execute($OUT_DATA_SERVICETYPE, OCI_DEFAULT);
            oci_execute($OUT_DATA_INCIDENT, OCI_DEFAULT);
            oci_fetch_all($OUT_DATA_SERVICEGROUP, $cursor['OUT_DATA_SERVICEGROUP'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_SERVICETYPE, $cursor['OUT_DATA_SERVICETYPE'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_INCIDENT, $cursor['OUT_DATA_INCIDENT'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
          //echo '<br>';
            $results = $cursor;
          //print_r($cursor);  
        }else{
            $e = oci_error($stid);
            $results =  $e['message'];
        } 
        oci_free_statement($stid);
        oci_close($this->pblmig_db->conn_id);

        return $results;

    }


// menampilkan detail data dari Grafik
    public function get_pkg_detail_incident_total($params) {
        $msg_out = '';
        $results = '';
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }

        $stid = oci_parse($this->pblmig_db->conn_id, 'begin OPHARAPP.PKG_TESTING.GET_DATA_INCIDENT_TOTAL(:IN_servicefamily, :IN_SERVICEGROUP, :IN_SERVICETYPE, :OUT_DATA_SERVICEGROUP, :OUT_DATA_SERVICETYPE, :OUT_DATA_INCIDENT, :OUT_MESSAGE); end;');
        $OUT_DATA_SERVICEGROUP = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_SERVICETYPE = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_INCIDENT = oci_new_cursor($this->pblmig_db->conn_id);

        //Send parameters variable  value  lenght
        oci_bind_by_name($stid, ':IN_servicefamily', $params['SERVICEFAMILY']) or die('Error binding PAGENUMBER');
        oci_bind_by_name($stid, ':IN_SERVICEGROUP', $params['SERVICEGROUP']) or die('Error binding IN_SERVICEGROUP');
        oci_bind_by_name($stid, ':IN_SERVICETYPE', $params['SERVICETYPE']) or die('Error binding IN_SERVICETYPE');
        oci_bind_by_name($stid, ':OUT_DATA_SERVICEGROUP', $OUT_DATA_SERVICEGROUP,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA_SERVICEGROUP');
        oci_bind_by_name($stid, ':OUT_DATA_SERVICETYPE', $OUT_DATA_SERVICETYPE,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA_SERVICETYPE');
        oci_bind_by_name($stid, ':OUT_DATA_INCIDENT', $OUT_DATA_INCIDENT,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA_INCIDENT');
        oci_bind_by_name($stid, ':OUT_MESSAGE', $msg_out,100, SQLT_CHR) or die('Error binding string12');


        //Bind Cursor     put -1
        $func_result = oci_execute($stid);
        if($func_result){
            oci_execute($OUT_DATA_SERVICEGROUP, OCI_DEFAULT);
            oci_execute($OUT_DATA_SERVICETYPE, OCI_DEFAULT);
            oci_execute($OUT_DATA_INCIDENT, OCI_DEFAULT);
            oci_fetch_all($OUT_DATA_SERVICEGROUP, $cursor['OUT_DATA_SERVICEGROUP'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_SERVICETYPE, $cursor['OUT_DATA_SERVICETYPE'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_INCIDENT, $cursor['OUT_DATA_INCIDENT'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
          //echo '<br>';
            $results = $cursor;
          //print_r($cursor);  
        }else{
            $e = oci_error($stid);
            $results =  $e['message'];
        } 
        oci_free_statement($stid);
        oci_close($this->pblmig_db->conn_id);

        return $results;
    }

    // DATA STATISTIK PERBULAN
    public function get_pkg_incident_perbulan($params){
        $msg_out = '';
        $results = '';
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }

        $stid = oci_parse($this->pblmig_db->conn_id, 'begin OPHARAPP.PKG_TESTING.GET_DATA_INCIDENT_PERBULAN(:IN_BLTH, :OUT_DATA_TOTAL_TIKET, :OUT_DATA_LIST_SLA, :OUT_DATA_TIKET_BY_BULAN, :OUT_TIKET_TOTAL, :OUT_TIKET_OVERSLA, :OUT_TIKET_RESOLVED, :OUT_TIKET_RESOLVED_AVG, :OUT_MESSAGE); end;');
        $OUT_DATA_TOTAL_TIKET = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_LIST_SLA = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_DATA_TIKET_BY_BULAN = oci_new_cursor($this->pblmig_db->conn_id);
        $OUT_TIKET_RESOLVED_AVG = oci_new_cursor($this->pblmig_db->conn_id);

        //Send parameters variable  value  lenght
        oci_bind_by_name($stid, ':IN_BLTH', $params) or die('Error binding IN_BLTH');
        oci_bind_by_name($stid, ':OUT_DATA_TOTAL_TIKET', $OUT_DATA_TOTAL_TIKET,-1, OCI_B_CURSOR) or die('Error bind OUT_DATA');
        oci_bind_by_name($stid, ':OUT_DATA_LIST_SLA', $OUT_DATA_LIST_SLA,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA');
        oci_bind_by_name($stid, ':OUT_DATA_TIKET_BY_BULAN', $OUT_DATA_TIKET_BY_BULAN,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA');
        oci_bind_by_name($stid, ':OUT_TIKET_TOTAL', $results['OUT_TIKET_TOTAL'],100, SQLT_CHR) or die('Error binding total');
        oci_bind_by_name($stid, ':OUT_TIKET_OVERSLA', $results['OUT_TIKET_OVERSLA'],100, SQLT_CHR) or die('Error binding oversla');
        oci_bind_by_name($stid, ':OUT_TIKET_RESOLVED', $results['OUT_TIKET_RESOLVED'],100, SQLT_CHR) or die('Error binding resolved');
        oci_bind_by_name($stid, ':OUT_TIKET_RESOLVED_AVG', $OUT_TIKET_RESOLVED_AVG,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA');
        oci_bind_by_name($stid, ':OUT_MESSAGE', $msg_out,100, SQLT_CHR) or die('Error binding Message');
        //Bind Cursor     put -1
        $func_result = oci_execute($stid);
        if($func_result){
            oci_execute($OUT_DATA_TOTAL_TIKET, OCI_DEFAULT);
            oci_execute($OUT_DATA_LIST_SLA, OCI_DEFAULT);
            oci_execute($OUT_DATA_TIKET_BY_BULAN, OCI_DEFAULT);
            oci_execute($OUT_TIKET_RESOLVED_AVG, OCI_DEFAULT);
            oci_fetch_all($OUT_DATA_TOTAL_TIKET, $results['OUT_DATA_TOTAL_TIKET'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_LIST_SLA, $results['OUT_DATA_LIST_SLA'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_DATA_TIKET_BY_BULAN, $results['OUT_DATA_TIKET_BY_BULAN'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            oci_fetch_all($OUT_TIKET_RESOLVED_AVG, $results['OUT_TIKET_RESOLVED_AVG'], null, null, OCI_FETCHSTATEMENT_BY_ROW);
            //$results = $cursor;
        }else{
            $e = oci_error($stid);
            $results =  $e['message'];
        } 
        oci_free_statement($stid);
        oci_close($this->pblmig_db->conn_id);

        return $results;

    }

// </editor-fold>

}
