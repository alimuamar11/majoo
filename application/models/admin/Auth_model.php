<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {	
	function __construct(){
        parent::__construct();
        $this->load->database();
  }
  function signin($username,$password){
		$this->db->select('uid,email,name,accessibility,actions_code,level,last_page,template,lang,profile');
		$this->db->from('c_users user');
		$this->db->where(array(
			"uname"=>$username,
			"passwd"=>$password,
			"enabled"=>1
		));
		$res_auth=$this->db->get()->result();
	    return $res_auth;
    }
}

/* End of file Auth_model.php */
/* Location: ./application/models/Auth_model.php */
