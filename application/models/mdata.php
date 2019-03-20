<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
  
class mdata extends CI_Model {
    // function __construct()
    // {
    //     parent::__construct();
    //     // set koneksi
    //     $this->pblmig_db = $this->load->database('pblmig', true);
    //     if (!$this->pblmig_db) {
    //         $m = oci_error();
    //         trigger_error(htmlentities($m['message']), E_USER_ERROR);
    //     }
    // }  


    public function cek_password($USERNAME, $PASSLAMA) {
        $this->db->where('ID_USER', $USERNAME);
        $this->db->where('PASSWD', $PASSLAMA);
        $query=$this->db->get('USERTAB');
        return $query->num_rows();
    }
     public function proses_update_password($USERNAME, $PASSBARU) {
        $data=array (
            'PASSWD'=>$PASSBARU
        );
        $this->db->where('ID_USER', $USERNAME);
        $this->db->set($data);
        $this->db->update('USERTAB');
    }
    // public function selisih_rc_bad_detail() {
    //     $this->db->order_by('UPI', 'ASC');
    //     $this->db->where('RPTAG !=', '0');
    //     $this->db->where('RPBK !=', '0');
    //     $query=$this->db->get('VIEW_RC_BAD_DETAIL');
    //     return $query->result();
    // }
    
// <editor-fold defaultstate="collapsed" desc="Tambahan baru - by Arif">
    // generate id
    public function generate_id() {
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        // params
        $prefix = date('ym');
        $params = $prefix . '%';
        // query cek last id ( jika ada )
        $sql = "SELECT SUBSTR(ID_UPLOAD,-4) AS LAST_NUMBER
                FROM UPLOAD_LOG 
                WHERE ID_UPLOAD LIKE :PARAMS AND ROWNUM <= 1
                ORDER BY ID_UPLOAD DESC
                ";
        $stid = oci_parse($this->pblmig_db->conn_id, $sql);
        oci_bind_by_name($stid, ':PARAMS', $params) or die('Error binding string1');
        // execute 
        if (oci_execute($stid)) {
            $res = oci_fetch_array($stid, OCI_ASSOC);
            $num_row = count($res);
            // cek row returned
            if ($num_row > 0) {
                // create next number
                $number = intval($res['LAST_NUMBER']) + 1;
                if ($number > 9999) {
                    $results = false;
                }
                $zero = '';
                for ($i = strlen($number); $i < 4; $i++) {
                    $zero .= '0';
                }
                $results = $prefix . $zero . $number;
            } else {
                // create new number
                $results = $prefix . '0001';
            }
        } else {
            $results = false;
        }
        return $results;
    }

    function save_data_dokumen($save) {
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        $results = '';
        $msg_out = 'TEST';

        $insert = 'INSERT INTO UPLOAD_LOG(ID_UPLOAD,NOAGENDA,NAMA_FILE,MDD,MDB) 
                   VALUES(:ID_UPLOAD, :NOAGENDA, :NAMA_FILE, CURRENT_TIMESTAMP, :MDB)';
        $send = oci_parse($this->pblmig_db->conn_id, $insert);
        //Send parameters variable  value  lenght
        oci_bind_by_name($send, ':ID_UPLOAD', $save['id_upload']) or die('Error binding string1');
        oci_bind_by_name($send, ':NOAGENDA', $save['noagenda']) or die('Error binding string2');
        oci_bind_by_name($send, ':NAMA_FILE', $save['nama_file']) or die('Error binding string3');
        oci_bind_by_name($send, ':MDB', $this->session->userdata('id_user')) or die('Error binding string4');

        if (oci_execute($send)) {
            $results = $msg_out;
        } else {
            $e = oci_error($send);
            $results = $e['message'];
        }
        oci_free_statement($send);
        oci_close($this->pblmig_db->conn_id);

        return $results;
    }

    // insert
    public function insert($params) {
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        return $this->pblmig_db->insert('UPLOAD_LOG', $params);
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
    
    // input new entrry
    public function insert_new_entry($params) {
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        $this->pblmig_db->set('TGL_CATAT',"CURRENT_TIMESTAMP",false);
        return $this->pblmig_db->insert('LOG_PROSES_OPHARAPP', $params);
    }

    // update entry
    public function update_new_entry($params, $where) {
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        $this->pblmig_db->set('TGL_CATAT',"CURRENT_TIMESTAMP",false);
        return $this->pblmig_db->update('LOG_PROSES_OPHARAPP', $params, $where);
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
    // delete
    public function delete_data_upload($where){
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        return $this->pblmig_db->delete('UPLOAD_LOG', $where);
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
    

// </editor-fold>

}
 