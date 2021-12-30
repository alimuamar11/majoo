<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('home', $this->session->userdata('site_lang'));
		$this->load->model("master-data/Produk_model", "produk");
		$this->load->helper('Authentication');
		$this->data = isAuthorized();
	}
	public function index()
	{
		$this->data["web_title"] = lang('app_name_short') . " | Home";
		$this->data["page_title"] = "Homepage";
		$this->data["page_title_small"] = "";
		$this->data['js_control'] = "home.js";
		$this->data['datatable'] = false;
		$this->data['chartjs'] = false;

		$this->data['detail_produk'] = $this->produk->detail_produk();
		$this->template->load(get_template(), 'admin/home', $this->data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
