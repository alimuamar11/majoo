<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrative_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->TableUser="c_users";
        $this->TableBaseMenu="c_base_menu";
        $this->TableMenu="c_menus";
    }
    function dt_users($where){
    	$this->datatables->select('uid,name,uname as username,email,enabled');
    	$this->datatables->from($this->TableUser." user");
        $this->datatables->where("uname!=",conf("super_admin_id"));
        $this->datatables->add_column('edit', '<a href="#" class="link-edit-user" data-id="$1"><i class="fa fa-edit"></i></a>', 'uid');
        return $this->datatables->generate();
    }
    function search_user($where){
        $this->db->select('uid as user_id,name,uname as username,email,accessibility,actions_code,level');
        $this->db->from($this->TableUser." user");
        $this->db->where($where);
        return $this->db->get()->result();
    }
    function save_user($data,$where){
        if(empty($where)){
            // check before insert
            $this->db->select('uid')->from($this->TableUser)->where("uname",$data['uname']);
            $check=$this->db->get()->result();
            if(!empty($check)) return 'exist';
            $this->db->insert($this->TableUser,$data);
            return $this->db->affected_rows();
        }else{
            $this->db->select('uid')->from($this->TableUser);
            $this->db->where("uname",$data['uname']);
            $this->db->where("uid!=",$where['uid']);
            $check=$this->db->get()->result();
            
            if(!empty($check)){
                return 'exist';  
            } 
            $this->db->update($this->TableUser,$data,$where);
            return $this->db->affected_rows();
        }
    }
    function enable_disable_user($data,$where){
        $this->db->update($this->TableUser,$data,$where);
        return $this->db->affected_rows();
    }
    function load_base_menu(){
        $this->db->select("title,icon,access_code,actions_code");
        $this->db->from($this->TableBaseMenu);
        $this->db->order_by("order_no");
        return $this->db->get()->result();
    }

	function save_backup_db($data){
		$this->db->insert('c_backup_list',$data);
		return $this->db->insert_id();
	}
	function delete_old_backup_db(){
		$this->db->query('DELETE FROM c_backup_list WHERE created_at < NOW() - INTERVAL 2 DAY');
		return $this->db->affected_rows();
	}
}

/* End of file Administrative_model.php */
/* Location: ./application/models/Administrative_model.php */
