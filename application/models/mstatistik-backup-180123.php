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
    public function get_total_family() {
        $sql = "SELECT  SUBSTR(SERVICEFAMILY, 5, 10) as SERVICEFAMILY , count(*) as total 
                FROM faisallubis.TIKET_ITSM 
                WHERE STATUS = 'Active' 
                AND to_char(CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-30, 'mm/dd/yyyy')
                group by SERVICEFAMILY
                ORDER BY total DESC
        ";
        $query = $this->db->query($sql);


        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return NULL;
        }
    }


    // GET TOTAL TIKET BY FAMILY
    public function get_list_by_family($params) {
        $sql = "SELECT INCIDENT,SLACLASS,CASEOWNER,SUMMARY,SERVICETYPE,
                CREATEDBY,CREATEDON,CLOSEDDATE,
                ASSIGNTO, ASSIGNEDON  
                FROM faisallubis.TIKET_ITSM 
                WHERE STATUS = 'Active' AND to_char(CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-30, 'mm/dd/yyyy')
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

    // GET TOTAL TIKET BY 
    public function get_total_resolved() {
        $sql = "SELECT SUBSTR(st.SERVICEFAMILY,5,10) as SERVICEFAMILY ,st.total, sv.total_rs  FROM 
                ( Select  a.SERVICEFAMILY , count(*) as total
                FROM faisallubis.TIKET_ITSM a WHERE 
                to_char(a.CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-30, 'mm/dd/yyyy') group by a.SERVICEFAMILY) st
                left join ( select b.SERVICEFAMILY, count(*) as total_rs FROM faisallubis.TIKET_ITSM b
                where status = 'Resolved' and to_char(b.CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-30, 'mm/dd/yyyy') group by b.SERVICEFAMILY) sv
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

    // GET TOTAL TIKET H-1
    public function get_total_tiket() {
        $sql = "SELECT COUNT(*) TOTAL_TIKET FROM FAISALLUBIS.TIKET_ITSM 
        WHERE TO_CHAR(CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-30, 'mm/dd/yyyy')
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL_TIKET'];
        } else {
            return NULL;
        }
    }
    // GET TOTAL TIKET AKTIF H-1
    public function get_total_tiket_aktif($params) {
        $sql = "SELECT COUNT(*) TOTAL_TIKET FROM FAISALLUBIS.TIKET_ITSM 
        WHERE TO_CHAR(CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-30, 'mm/dd/yyyy')
        AND STATUS = 'Active'
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL_TIKET'];
        } else {
            return NULL;
        }
    }
    // GET TOTAL TIKET RESOLVED H-1
    public function get_total_tiket_resolved($params) {
        $sql = "SELECT COUNT(*) TOTAL_TIKET FROM FAISALLUBIS.TIKET_ITSM 
        WHERE TO_CHAR(CREATEDON, 'mm/dd/yyyy') = to_char(sysdate-30, 'mm/dd/yyyy')
        AND STATUS = 'Resolved'
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL_TIKET'];
        } else {
            return NULL;
        }
    }

    // Grafik Total tiket bulanan
    public function get_list_bulanan_total($params) {
        $sql = "Select  a.SERVICEFAMILY , count(*) as total
        FROM faisallubis.TIKET_ITSM a where 
        to_char(a.CREATEDON, 'yyyymm') = ? group by a.SERVICEFAMILY
        ";
        $query = $this->db->query($sql,$params);


        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return NULL;
        }
    }
    // Grafik Total tiket SLA bulanan
    public function get_list_sla_bulanan($params) {
        $sql = "select SERVICEFAMILY, count(*) as total_sla FROM faisallubis.TIKET_ITSM
        where to_char(CREATEDON, 'yyyymm') = ? 
        and to_char(RESOLVEDON, 'mm/dd/yyyy') > to_char(SLALEVEL1, 'mm/dd/yyyy')
        or to_char(RESOLVEDON, 'mm/dd/yyyy') > to_char(SLALEVEL2, 'mm/dd/yyyy') 
        or to_char(RESOLVEDON, 'mm/dd/yyyy') > to_char(SLALEVEL3, 'mm/dd/yyyy')
        group by SERVICEFAMILY
        ";
        $query = $this->db->query($sql,$params);


        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return NULL;
        }
    }

    // GET TOTAL TIKET BULANAN
    public function get_total_tiket_bulanan($params) {
        $sql = "SELECT COUNT(*) TOTAL_TIKET FROM FAISALLUBIS.TIKET_ITSM 
        WHERE TO_CHAR(CREATEDON, 'YYYYMM') = ?
        ";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL_TIKET'];
        } else {
            return 0;
        }
    }
    // GET TOTAL TIKET BULANAN
    public function get_tiket_oversla_bulanan($params) {
        $sql = "SELECT COUNT(*) TOTAL_SLA FROM FAISALLUBIS.TIKET_ITSM
        WHERE TO_CHAR(CREATEDON, 'YYYYMM') = ? AND  
        TO_CHAR(RESOLVEDON, 'MM/DD/YYYY') > TO_CHAR(SLALEVEL1, 'MM/DD/YYYY')
        OR TO_CHAR(RESOLVEDON, 'MM/DD/YYYY') > TO_CHAR(SLALEVEL2, 'MM/DD/YYYY') 
        OR TO_CHAR(RESOLVEDON, 'MM/DD/YYYY') > TO_CHAR(SLALEVEL3, 'MM/DD/YYYY')
        ";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL_SLA'];
        } else {
            return NULL;
        }
    }
    // GET TOTAL TIKET BULANAN
    public function get_tiket_resolved_bulanan($params) {
        $sql = "SELECT COUNT(*) TOTAL_RS FROM FAISALLUBIS.TIKET_ITSM WHERE 
        TO_CHAR(CREATEDON, 'YYYYMM') = ? AND
        STATUS = 'Resolved'
        ";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL_RS'];
        } else {
            return NULL;
        }
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
    public function get_jml_tiket_bulanan($params) {
        $sql = "SELECT TO_CHAR(CREATEDON, 'MM') AS BULAN, COUNT(*) AS TIKET_PERBULAN 
        FROM faisallubis.TIKET_ITSM
        WHERE TO_CHAR(CREATEDON,'YYYY') = '2017'
        GROUP BY TO_CHAR(CREATEDON, 'MM')
        ORDER BY BULAN ASC
        ";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
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
    

// </editor-fold>

}
