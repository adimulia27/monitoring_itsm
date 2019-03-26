<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class mexcell extends CI_Model {

 function __construct()
 {
    parent::__construct();
        // set koneksi
    $this->pblmig_db = $this->load->database('pblmig', true);
    if (!$this->pblmig_db) {
        $m = oci_error();
        trigger_error(htmlentities($m['message']), E_USER_ERROR);
    }
}  

public function insert2($params) {
        // Before running, create the table:
//     CREATE TABLE MYTABLE (mykey NUMBER, myclob CLOB);

        //print_r($params); exit();

    $conn = $this->pblmig_db->conn_id;
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    foreach ($params as $dt) {

            // conversi
        $CREATEDON = ($dt['CREATEDON'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['CREATEDON'] ."', 'DD/MM/YYYY HH24:MI:SS')";
        $RESOLVEDON = ($dt['RESOLVEDON'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['RESOLVEDON'] ."', 'DD/MM/YYYY HH24:MI:SS')";
        $MODIFIEDON = ($dt['MODIFIEDON'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['MODIFIEDON'] ."', 'DD/MM/YYYY HH24:MI:SS')";
        $CLOSEDDATE = ($dt['CLOSEDDATE'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['CLOSEDDATE'] ."', 'DD/MM/YYYY HH24:MI:SS')";
        $SLALEVEL180PERSEN = ($dt['SLALEVEL180PERSEN'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['SLALEVEL180PERSEN'] ."', 'DD/MM/YYYY HH24:MI:SS')";
        $SLALEVEL1 = ($dt['SLALEVEL1'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['SLALEVEL1'] ."', 'DD/MM/YYYY HH24:MI:SS')";
        $SLALEVEL2 = ($dt['SLALEVEL2'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['SLALEVEL2'] ."', 'DD/MM/YYYY HH24:MI:SS')";
        $SLALEVEL3 = ($dt['SLALEVEL3'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['SLALEVEL3'] ."', 'DD/MM/YYYY HH24:MI:SS')";
        $ASSIGNEDON = ($dt['ASSIGNEDON'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['ASSIGNEDON'] ."', 'DD/MM/YYYY HH24:MI:SS')";
     
        $sql = "INSERT INTO faisallubis.TIKET_ITSM_UPLOAD (INCIDENT, PRIORITYNAME, SLACLASS, CASEOWNER, CASEOWNEREMAIL, UNITINDUK, UNITPELAKSANA, UNITSUB PELAKSANA, COMPLAINANT, COMPLAINANTEMAIL, SUMMARY, SOURCE, CALLTYPE, STATUS, DESCRIPTION, SERVICEFAMILY, SERVICEGROUP, SERVICETYPE, CAUSE, CAUSECODE, RESOLUTION, CREATEDBY, CREATEDON, TASKCREATEDON, ASSIGNTO, ASSIGNEDON, RESOLVEDBY, RESOLVEDON, MODIFIEDBY, MODIFIEDON, CLOSEDBY, CLOSEDDATE, PRIORITY, SLALEVEL180PERSEN, SLALEVEL1, SLALEVEL2, SLALEVEL3, FIRSTCALLRESOLUTION, TGLUPLOAD, UPLOADBY)
        VALUES (:INCIDENT, :PRIORITYNAME, :SLACLASS, :CASEOWNER, :CASEOWNEREMAIL, :UNITINDUK, :UNITPELAKSANA, :UNITSUBPELAKSANA, :COMPLAINANT, :COMPLAINANTEMAIL, :SUMMARY, :SOURCE, :CALLTYPE, :STATUS, EMPTY_CLOB(), :SERVICEFAMILY, :SERVICEGROUP, :SERVICETYPE, EMPTY_CLOB(), EMPTY_CLOB(), EMPTY_CLOB(), :CREATEDBY, $CREATEDON, :TASKCREATEDON, :ASSIGNTO, $ASSIGNEDON, :RESOLVEDBY, $RESOLVEDON, :MODIFIEDBY, $MODIFIEDON, :CLOSEDBY, $CLOSEDDATE, :PRIORITY, $SLALEVEL180PERSEN, $SLALEVEL1, $SLALEVEL2, $SLALEVEL3, :FIRSTCALLRESOLUTION, SYSDATE, :UPLOADBY)
        RETURNING DESCRIPTION, CAUSE, RESOLUTION  INTO :DESCRIPTION, :CAUSE, :RESOLUTION";

        $stid = oci_parse($conn, $sql);
        $clob_DESCRIPTION = oci_new_descriptor($conn, OCI_D_LOB);
        $clob_CAUSE = oci_new_descriptor($conn, OCI_D_LOB);
        $clob_RESOLUTION = oci_new_descriptor($conn, OCI_D_LOB);
        oci_bind_by_name($stid, ":INCIDENT", $dt['INCIDENT']);
        oci_bind_by_name($stid, ":PRIORITYNAME", $dt['PRIORITYNAME']);
        oci_bind_by_name($stid, ":SLACLASS", $dt['SLACLASS']);
        oci_bind_by_name($stid, ":CASEOWNER", $dt['CASEOWNER']);
        oci_bind_by_name($stid, ":CASEOWNEREMAIL", $dt['CASEOWNEREMAIL']);
        oci_bind_by_name($stid, ":UNITINDUK", $dt['UNITINDUK']);
        oci_bind_by_name($stid, ":UNITPELAKSANA", $dt['UNITPELAKSANA']);
        oci_bind_by_name($stid, ":UNITSUBPELAKSANA", $dt['UNITSUBPELAKSANA']);
        oci_bind_by_name($stid, ":COMPLAINANT", $dt['COMPLAINANT']);
        oci_bind_by_name($stid, ":COMPLAINANTEMAIL", $dt['COMPLAINANTEMAIL']);
        oci_bind_by_name($stid, ":SUMMARY", $dt['SUMMARY']);
        oci_bind_by_name($stid, ":SOURCE", $dt['SOURCE']);
        oci_bind_by_name($stid, ":CALLTYPE", $dt['CALLTYPE']);
        oci_bind_by_name($stid, ":STATUS", $dt['STATUS']);
        oci_bind_by_name($stid, ":DESCRIPTION",  $clob_DESCRIPTION, -1, OCI_B_CLOB);
        oci_bind_by_name($stid, ":SERVICEFAMILY", $dt['SERVICEFAMILY']);
        oci_bind_by_name($stid, ":SERVICEGROUP", $dt['SERVICEGROUP']);
        oci_bind_by_name($stid, ":SERVICETYPE", $dt['SERVICETYPE']);
        oci_bind_by_name($stid, ":CAUSE",  $clob_CAUSE, -1, OCI_B_CLOB);
        oci_bind_by_name($stid, ":CAUSECODE",  $clob_CAUSE, -1, OCI_B_CLOB);
        oci_bind_by_name($stid, ":RESOLUTION",  $clob_RESOLUTION, -1, OCI_B_CLOB);
        oci_bind_by_name($stid, ":CREATEDBY", $dt['CREATEDBY']);
            // oci_bind_by_name($stid, ":CREATEDON", $dt['CREATEDON']);
        oci_bind_by_name($stid, ":RESOLVEDBY", $dt['RESOLVEDBY']);
            // oci_bind_by_name($stid, ":RESOLVEDON", $dt['RESOLVEDON']);
        oci_bind_by_name($stid, ":MODIFIEDBY", $dt['MODIFIEDBY']);
            // oci_bind_by_name($stid, ":MODIFIEDON", $dt['MODIFIEDON']);
        oci_bind_by_name($stid, ":CLOSEDBY", $dt['CLOSEDBY']);
            // oci_bind_by_name($stid, ":CLOSEDDATE", $dt['CLOSEDDATE']);
            // oci_bind_by_name($stid, ":SLACLASS", $dt['SLACLASS']);
            // oci_bind_by_name($stid, ":SLALEVEL1", $dt['SLALEVEL1']);
            // oci_bind_by_name($stid, ":SLALEVEL2", $dt['SLALEVEL2']);
            // oci_bind_by_name($stid, ":SLALEVEL3", $dt['SLALEVEL3']);
        oci_bind_by_name($stid, ":PRIORITY", $dt['PRIORITY']);
        oci_bind_by_name($stid, ":ASSIGNTO", $dt['ASSIGNTO']);
        oci_bind_by_name($stid, ":FIRSTCALLRESOLUTION", $dt['FIRSTCALLRESOLUTION']);
            //oci_bind_by_name($stid, ":ASSIGNEDON", $ASSIGNEDON);
        oci_bind_by_name($stid, ":UPLOADBY", $dt['UPLOADBY']);

            $r = oci_execute($stid, OCI_NO_AUTO_COMMIT); // use OCI_DEFAULT for PHP <= 5.3.1
            $clob_RESOLUTION->save($dt['RESOLUTION']);
            $clob_DESCRIPTION->save($dt['DESCRIPTION']);
            $clob_CAUSE->save($dt['CAUSE']);

            if (!$r) {
                $e = oci_error($stid);  // For oci_execute errors pass the statement handle
                return $e;
                // print htmlentities($e['message']);
                // print "\n<pre>\n";
                // print htmlentities($e['sqltext']);
                // printf("\n%".($e['offset']+1)."s", "^");
                // print  "\n</pre>\n";
            }
            oci_commit($conn);
        }

        return 'sukses';
    }



    function insert_itsm_upload($params) {        
        $results = '';
        $noagendalama = ""; 
        $tiket = "999998"; 
        $nama = "ARIF";
        $msg_out = '';
        $retval = '';

        $this->pblmig_db = $this->load->database('pblmig', true);
        foreach ($params as $dt) {

                // conversi
            $TASKCREATEDON = ($dt['TASKCREATEDON'] == '30/12/1899 00:00:00') ? NULL : $dt['TASKCREATEDON'];
            $CREATEDON = ($dt['CREATEDON'] == '30/12/1899 00:00:00') ? NULL : $dt['CREATEDON'];
            $RESOLVEDON = ($dt['RESOLVEDON'] == '30/12/1899 00:00:00') ? NULL : $dt['RESOLVEDON'];
            $MODIFIEDON = ($dt['MODIFIEDON'] == '30/12/1899 00:00:00') ? NULL : $dt['MODIFIEDON'] ;
            $CLOSEDDATE = ($dt['CLOSEDDATE'] == '30/12/1899 00:00:00') ? NULL : $dt['CLOSEDDATE'] ;
            $SLALEVEL180PERSEN = ($dt['SLALEVEL180PERSEN'] == '30/12/1899 00:00:00') ? NULL : $dt['SLALEVEL180PERSEN'] ;
            $SLALEVEL1 = ($dt['SLALEVEL1'] == '30/12/1899 00:00:00') ? NULL : $dt['SLALEVEL1'] ;
            $SLALEVEL2 = ($dt['SLALEVEL2'] == '30/12/1899 00:00:00') ? NULL : $dt['SLALEVEL2'] ;
            $SLALEVEL3 = ($dt['SLALEVEL3'] == '30/12/1899 00:00:00') ? NULL : $dt['SLALEVEL3'] ;
            $ASSIGNEDON = ($dt['ASSIGNEDON'] == '30/12/1899 00:00:00') ? NULL : $dt['ASSIGNEDON'] ;
        
            $stid = oci_parse($this->pblmig_db->conn_id, 'begin PKG_TESTING.INSERT_ITSM_UPLOAD(:IN_INCIDENT, :IN_PRIORITYNAME, :IN_SLACLASS, :IN_CASEOWNER, :IN_CASEOWNEREMAIL, :IN_UNITINDUK, :IN_UNITPELAKSANA, :IN_UNITSUBPELAKSANA, :IN_COMPLAINANT, :IN_COMPLAINANTEMAIL, :IN_SUMMARY, :IN_SOURCE, :IN_CALLTYPE, :IN_STATUS, :IN_DESCRIPTION, :IN_SERVICEFAMILY, :IN_SERVICEGROUP, :IN_SERVICETYPE, :IN_CAUSE, :IN_CAUSECODE, :IN_RESOLUTION, :IN_CREATEDBY, :IN_CREATEDON, :IN_TASKCREATEDON, :IN_ASSIGNTO, :IN_ASSIGNEDON, :IN_RESOLVEDBY, :IN_RESOLVEDON, :IN_MODIFIEDBY, :IN_MODIFIEDON, :IN_CLOSEDBY, :IN_CLOSEDDATE, :IN_PRIORITY, :IN_SLALEVEL180PERSEN, :IN_SLALEVEL1, :IN_SLALEVEL2, :IN_SLALEVEL3, :IN_FIRSTCALLRESOLUTION, :IN_UPLOADBY, :IN_REPLACE, :OUT_RETVAL, :OUT_MESSAGE); END;');

            //Send parameters variable  value  lenght
            oci_bind_by_name($stid, ':IN_INCIDENT', $dt['INCIDENT']) or die('Error binding IN_INCIDENT');
            oci_bind_by_name($stid, ':IN_PRIORITYNAME', $dt['PRIORITYNAME']) or die('Error binding IN_PRIORITYNAME');
            oci_bind_by_name($stid, ':IN_SLACLASS', $dt['SLACLASS']) or die('Error binding IN_SLACLASS') ;
            oci_bind_by_name($stid, ':IN_CASEOWNER', $dt['CASEOWNER']) or die('Error binding IN_CASEOWNER');
            oci_bind_by_name($stid, ':IN_CASEOWNEREMAIL', $dt['CASEOWNEREMAIL']) or die('Error binding CASEOWNEREMAIL');
            oci_bind_by_name($stid, ':IN_UNITINDUK', $dt['UNITINDUK']) or die('Error binding IN_UNITINDUK') ;
            oci_bind_by_name($stid, ':IN_UNITPELAKSANA', $dt['UNITPELAKSANA']) or die('Error binding IN_UNITPELAKSANA') ;
            oci_bind_by_name($stid, ':IN_UNITSUBPELAKSANA', $dt['UNITSUBPELAKSANA']) or die('Error binding IN_UNITSUBPELAKSANA') ;
            oci_bind_by_name($stid, ':IN_COMPLAINANT', $dt['COMPLAINANT']) or die('Error binding noagendalama');
            oci_bind_by_name($stid, ':IN_COMPLAINANTEMAIL', $dt['COMPLAINANTEMAIL']) or die('Error binding COMPLAINANTEMAIL');
            oci_bind_by_name($stid, ':IN_SUMMARY', $dt['SUMMARY']) or die('Error binding SUMMARY');
            oci_bind_by_name($stid, ':IN_SOURCE', $dt['SOURCE']) or die('Error binding SOURCE');
            oci_bind_by_name($stid, ':IN_CALLTYPE', $dt['CALLTYPE']) or die('Error binding CALLTYPE');
            oci_bind_by_name($stid, ':IN_STATUS', $dt['STATUS']) or die('Error binding STATUS');
            oci_bind_by_name($stid, ':IN_DESCRIPTION', $dt['DESCRIPTION']) or die('Error binding DESCRIPTION');
            oci_bind_by_name($stid, ':IN_SERVICEFAMILY', $dt['SERVICEFAMILY']) or die('Error binding SERVICEFAMILY');
            oci_bind_by_name($stid, ':IN_SERVICEGROUP', $dt['SERVICEGROUP']) or die('Error binding SERVICEGROUP');
            oci_bind_by_name($stid, ':IN_SERVICETYPE', $dt['SERVICETYPE']) or die('Error binding SERVICETYPE');
            oci_bind_by_name($stid, ':IN_CAUSE', $dt['CAUSE']) or die('Error binding CAUSE');
            oci_bind_by_name($stid, ':IN_CAUSECODE', $dt['CAUSECODE']) or die('Error binding CAUSECODE');
            oci_bind_by_name($stid, ':IN_RESOLUTION', $dt['RESOLUTION']) or die('Error binding RESOLUTION');
            oci_bind_by_name($stid, ':IN_CREATEDBY', $dt['CREATEDBY']) or die('Error binding CREATEDBY');
            oci_bind_by_name($stid, ':IN_CREATEDON', $CREATEDON) or die('Error binding CREATEDON');
            oci_bind_by_name($stid, ':IN_TASKCREATEDON', $TASKCREATEDON) or die('Error binding TASKCREATEDON');
            oci_bind_by_name($stid, ':IN_ASSIGNTO', $dt['ASSIGNTO']) or die('Error binding ASSIGNTO');
            oci_bind_by_name($stid, ':IN_ASSIGNEDON', $ASSIGNEDON) or die('Error binding ASSIGNEDON');
            oci_bind_by_name($stid, ':IN_RESOLVEDBY', $dt['RESOLVEDBY']) or die('Error binding RESOLVEDBY');
            oci_bind_by_name($stid, ':IN_RESOLVEDON', $RESOLVEDON) or die('Error binding RESOLVEDON');
            oci_bind_by_name($stid, ':IN_MODIFIEDBY', $dt['MODIFIEDBY']) or die('Error binding MODIFIEDBY');
            oci_bind_by_name($stid, ':IN_MODIFIEDON', $MODIFIEDON) or die('Error binding MODIFIEDON');
            oci_bind_by_name($stid, ':IN_CLOSEDBY', $dt['CLOSEDBY']) or die('Error binding CLOSEDBY');
            oci_bind_by_name($stid, ':IN_CLOSEDDATE', $CLOSEDDATE) or die('Error binding CLOSEDDATE');
            oci_bind_by_name($stid, ':IN_PRIORITY', $dt['PRIORITY']) or die('Error binding PRIORITY');
            oci_bind_by_name($stid, ':IN_SLALEVEL180PERSEN', $SLALEVEL180PERSEN) or die('Error binding SLALEVEL180PERSEN');
            oci_bind_by_name($stid, ':IN_SLALEVEL1', $SLALEVEL1) or die('Error binding SLALEVEL1');
            oci_bind_by_name($stid, ':IN_SLALEVEL2', $SLALEVEL2) or die('Error binding SLALEVEL2');
            oci_bind_by_name($stid, ':IN_SLALEVEL3', $SLALEVEL3) or die('Error binding SLALEVEL3');
            oci_bind_by_name($stid, ':IN_FIRSTCALLRESOLUTION', $dt['FIRSTCALLRESOLUTION']) or die('Error binding FIRSTCALLRESOLUTION');
            oci_bind_by_name($stid, ':IN_UPLOADBY', $dt['UPLOADBY']) or die('Error binding UPLOADBY');
            oci_bind_by_name($stid, ':IN_REPLACE', $dt['REPLACE']) or die('Error binding Replace');
            oci_bind_by_name($stid, ':OUT_RETVAL', $retval,100, SQLT_CHR) or die('Error binding string12');
            oci_bind_by_name($stid, ':OUT_MESSAGE', $msg_out,100, SQLT_CHR) or die('Error binding string12');

            if(oci_execute($stid)){
                if($msg_out != 'sukses'){
                    oci_close($this->pblmig_db->conn_id);
                    return $msg_out;
                }
            }else{
                $e = oci_error($stid);
                $error_msg =  $e['message'].' ----error oci_execute() '. $retval;
                oci_close($this->pblmig_db->conn_id);
                return $error_msg;
            } 
            oci_free_statement($stid);
        } // end foreach
        oci_close($this->pblmig_db->conn_id);
        return $msg_out;
    } 

    function kirim_to_itsm() {        
        $msg_out = '';
        $retval = '';
        $user = $this->session->userdata('id_user');
        $this->pblmig_db = $this->load->database('pblmig', true);
        $stid = oci_parse($this->pblmig_db->conn_id, 'begin PKG_TESTING.KIRIM_TO_ITSM(:IN_LOGBY, :OUT_RETVAL, :OUT_MESSAGE); END;');
        //Send parameters variable  value  lenght
        oci_bind_by_name($stid, ':IN_LOGBY', $user) or die('Error binding IN_LOGBY') ;
        oci_bind_by_name($stid, ':OUT_RETVAL', $retval,100, SQLT_CHR) or die('Error binding string12');
        oci_bind_by_name($stid, ':OUT_MESSAGE', $msg_out,100, SQLT_CHR) or die('Error binding string12');

        if(oci_execute($stid)){
            $result = $msg_out;
        }else{
            $e = oci_error($stid);
            $result =  $e['message'].' ----error oci_execute() '. $retval;
        } 
        oci_free_statement($stid);
        oci_close($this->pblmig_db->conn_id);
        return $result;
    } 

    // delete data tiket
    function delete_itsm_upload() {
        $sql = "DELETE FROM FAISALLUBIS.TIKET_ITSM_UPLOAD";
        $query = $this->db->query($sql);
    }


    // list data itsm with blob
    public function get_list_tiket_itsm($params) {
        $pagenumber = $params[0];
        $pagesize = $params[1];
        // Prepare the statement
        $conn = $this->pblmig_db->conn_id;
        $stid = oci_parse($conn, "SELECT * FROM
            (
            SELECT a.*, rownum r__
            FROM
            (
            SELECT * FROM FAISALLUBIS.TIKET_ITSM_UPLOAD  ORDER BY INCIDENT ASC
            ) a
            WHERE rownum < (($pagenumber * $pagesize) + 1 )
            )
            WHERE r__ >= ((($pagenumber-1) * $pagesize) + 1)"
        );
        if (!$stid) {
            $e = oci_error($conn);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Perform the logic of the query
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Fetch the results of the query
        //$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS);
        while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {
            
            $result[] = $row;
            
        }

        oci_free_statement($stid);
        oci_close($conn);
        return $result;

    }

    // get total data tiket
    function get_total_tiket() {
        $sql = "SELECT COUNT(*) AS TOTAL
        FROM faisallubis.TIKET_ITSM_UPLOAD";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['TOTAL'];
        } else {
            return array();
        }
    }


    public function get_list_tiket_itsm_pkg($params){
        $IN_PAGENUMBER = $params[0];
        $IN_PAGESIZE = $params[1];
        $msg_out = '';

        $results = '';
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }

        //$v = '';


        $stid = oci_parse($this->pblmig_db->conn_id, 'begin OPHARAPP.PKG_TESTING.GET_ITSM_UPLOAD_PAGINATION(:IN_PAGENUMBER, :IN_PAGESIZE, :OUT_DATA, :OUT_MESSAGE); end;');
        $OUT_DATA = oci_new_cursor($this->pblmig_db->conn_id);

        //Send parameters variable  value  lenght
        oci_bind_by_name($stid, ':IN_PAGENUMBER', $IN_PAGENUMBER) or die('Error binding PAGENUMBER');
        oci_bind_by_name($stid, ':IN_PAGESIZE', $IN_PAGESIZE) or die('Error binding PAGESIZE');
        oci_bind_by_name($stid, ':OUT_DATA', $OUT_DATA,-1, OCI_B_CURSOR) or die('Error binding OUT_DATA');
        oci_bind_by_name($stid, ':OUT_MESSAGE', $msg_out,100, SQLT_CHR) or die('Error binding string12');


        //Bind Cursor     put -1
        $func_result = oci_execute($stid);
        if($func_result){
            oci_execute($OUT_DATA, OCI_DEFAULT);
            oci_fetch_all($OUT_DATA, $cursor, null, null, OCI_FETCHSTATEMENT_BY_ROW);
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
// </editor-fold>

}
