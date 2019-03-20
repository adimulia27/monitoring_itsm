<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
  
class mlogin extends CI_Model {

    
    function set_login($username, $password) {       
	   	$this->db->where('ID_USER', $username);
	   	$this->db->where('PASSWD', $password);
	   	$query=$this->db->get('USERTAB');
	   	return $query->result();
    }	
}
