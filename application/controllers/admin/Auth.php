<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    var $data;
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('auth', $this->session->userdata('site_lang'));
		$this->load->model("admin/Auth_model","auth");
		$this->load->model("Common_model","common");
		$this->data=array();
	}
	public function genPassword($password=''){
		if($password!='') echo "password: ".md5(base64_encode($password));
	}
	public function index()
	{
		$data['company_logo']=base_url(conf('company_logo'));
		if($this->input->get('redirect')) $data['redirect']=$this->input->get('redirect');
		$this->load->view('admin/auth/signin',$data);
	}
	public function signin()
	{
		$posted=$this->input->post();
		if(empty($posted)) redirect("admin/auth");
		if($posted['username']=="" || $posted['password']==""){
			$this->session->set_flashdata('message', lang('msg_username_password_required'));
			redirect("admin/auth","refresh");
		}
		$res=$this->auth->signin($posted['username'],hashPasswd($posted['password']));
		if(empty($res)){
			$this->session->set_flashdata('message', lang('msg_invalid_username'));
			redirect("admin/auth","refresh");
		}else{
			if($res[0]->level==$this->config->item('super_admin_code')){
				$base_menu=$this->common->get_base_menus($res[0]->level);
				$menus=$this->common->get_menus($res[0]->level);
			}else{
				$base_menu=$this->common->get_base_menus(explode(",",$res[0]->accessibility));
				$menus=$this->common->get_menus(explode(",",$res[0]->accessibility));
			}
			generateMenu($base_menu,$menus,$res[0]);
			generateToken($res[0]);
		}
	}
	// public function signup(){
	// 	$data['company_logo']=base_url(conf('company_logo'));
	// 	$this->load->view('auth/signup',$this->data);
	// }
	public function signout(){
		clearToken();
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
