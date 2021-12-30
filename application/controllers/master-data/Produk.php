<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('master-data/produk', $this->session->userdata('site_lang'));
		$this->load->model("master-data/Produk_model", "produk");
		$this->load->helper('Authentication');
		$this->data = isAuthorized();
	}

	public function index()
	{
		$this->data["web_title"] 	= lang('app_name_short') . " | produk";
		$this->data["page_title"]	= "produk";
		$this->data['js_control'] 	= "master-data/produk/index.js";
		$this->data['datatable'] 	= true;
		$this->data['chartjs'] = false;

		$this->template->load(get_template(), 'master-data/produk/index', $this->data);
	}
	public function load_dt()
	{
		header('Content-Type: application/json');
		requiredMethod('POST');
		$posted = $this->input->input_stream();
		$data = $this->produk->_load_dt($posted);
		echo json_encode($data);
	}

	public function search__($id = '')
	{
		header('Content-Type: application/json');
		$gets = $this->input->get();
		$id = ($id != '') ? $id : $gets['id'];
		$id = htmlentities(trim($id));
		if ($id == '' || $id == null) sendError("Missing ID");
		$search = $this->produk->_search(array("id_produk" => $id));
		if (empty($search)) sendError(lang('msg_no_record'));
		echo json_encode(array("data" => $search[0]));
	}
	public function save__()
	{
		header('Content-Type: application/json');
		$method = $this->input->method(true);
		if ($method != "POST" && $method != "PUT") sendError(lang('msg_method_post_put_required'), [], 405);
		if (isset($_FILES["file"]["name"])) {
			$config['upload_path'] = './assets/img';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('file')) {
				echo $this->upload->display_errors();
			} else {
				$data = array('upload_data' => $this->upload->data());

				$posted = $this->input->post();
				foreach ($posted as $key => $value) {
					$$key = htmlentities(trim($value));
				}
				if ($nama == "") return sendError("Nama wajib diisi");
				$image = $data['upload_data']['file_name'];
				if (!isset($posted['_id']) || $posted['_id'] == "") {
					$save = $this->produk->_save(array(
						"nama" 	=> $nama,
						"deskripsi" => $deskripsi,
						"harga" => $harga,
						"fk_kategori" => $fk_kategori,
						"image" => $image,
					), array(), "nama");
					if ($save == 'exist') {
						sendError('data Sudah terdaftar');
					} else {

						echo json_encode(array("message" => "Penambahan berhasil"));
					}
				} else {
					$id_produk = htmlentities(trim($posted['_id']));
					$data = array(
						"nama" 	=> $nama,
						"deskripsi" => $deskripsi,
						"harga" => $harga,
						"fk_kategori" => $fk_kategori,
						"image" => $image,
					);
					$where = ["id_produk" => $id_produk];
					$save = $this->produk->_save($data, $where, "nama");
					if ($save === "exist") {
						sendError("Data telah tersedia");
					} else {
						$dta = array(
							"message" => "Data Berhasil di Update",
							"action" => "call_print"
						);
						echo json_encode($dta);
					}
				}
			}
		}
	}
	public function delete__($id = '')
	{
		header('Content-Type: application/json');
		$method = $this->input->method(true);
		if ($method != "DELETE") sendError(lang('msg_method_delete_required'), [], 405);
		$result = $this->produk->_delete(array('id_produk' => htmlentities(trim($id))));
		if ($result == 1) {
			sendSuccess(lang('msg_delete_success'), []);
		} else {
			sendError(lang('msg_delete_failed'));
		}
	}
	public function select2_()
	{
		header('Content-Type: application/json');
		$gets = $this->input->get();
		$key = (isset($gets['search']) && $gets['search'] != '') ? $gets['search'] : "";
		$search = $this->produk->_search_select2($key);
		echo json_encode($search);
	}
	public function get_active_lang()
	{
		header('Content-Type: application/json');
		echo json_encode($this->lang->language);
	}


	// function image_upload()
	// {
	// 	if (isset($_FILES["file"]["name"])) {
	// 		$config['upload_path'] = './assets/img';
	// 		$config['allowed_types'] = 'jpg|jpeg|png|gif';
	// 		$this->load->library('upload', $config);
	// 		if (!$this->upload->do_upload('file')) {
	// 			echo $this->upload->display_errors();
	// 		} else {
	// 			$data = array('upload_data' => $this->upload->data());

	// 			$id = $this->input->post('_id');
	// 			$nama = $this->input->post('nama');
	// 			$deskripsi = $this->input->post('deskripsi');
	// 			$harga = $this->input->post('harga');
	// 			$fk_kategori = $this->input->post('fk_kategori');
	// 			$image = $data['upload_data']['file_name'];

	// 			if ($id == "") {
	// 				$this->produk->save_upload($nama, $deskripsi, $harga, $fk_kategori, $image);
	// 			} else {
	// 				$this->produk->update_upload($nama, $deskripsi, $harga, $fk_kategori, $image, $id);
	// 			}

	// 			echo '<img src="' . base_url() . 'assets/img/' . $image . '" width="300" height="225" class="img-thumbnail" />';
	// 		}
	// 	}
	// }
}
