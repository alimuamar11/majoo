<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('master-data/kategori', $this->session->userdata('site_lang'));
        $this->load->model("master-data/Kategori_model", "kategori");
        $this->load->helper('Authentication');
        $this->data = isAuthorized();
    }

    public function index()
    {
        $this->data["web_title"]     = lang('app_name_short') . " | kategori";
        $this->data["page_title"]    = "kategori";
        $this->data['js_control']     = "master-data/kategori/index.js";
        $this->data['datatable']     = true;
        $this->data['chartjs'] = false;

        $this->template->load(get_template(), 'master-data/kategori/index', $this->data);
    }
    public function load_dt()
    {
        header('Content-Type: application/json');
        requiredMethod('POST');
        $posted = $this->input->input_stream();
        $data = $this->kategori->_load_dt($posted);
        echo json_encode($data);
    }

    public function search__($id = '')
    {
        header('Content-Type: application/json');
        $gets = $this->input->get();
        $id = ($id != '') ? $id : $gets['id'];
        $id = htmlentities(trim($id));
        if ($id == '' || $id == null) sendError("Missing ID");
        $search = $this->kategori->_search(array("id_kategori" => $id));
        if (empty($search)) sendError(lang('msg_no_record'));
        echo json_encode(array("data" => $search[0]));
    }
    public function save__()
    {
        header('Content-Type: application/json');
        $method = $this->input->method(true);
        if ($method != "POST" && $method != "PUT") sendError(lang('msg_method_post_put_required'), [], 405);
        $posted = $this->input->post();
        foreach ($posted as $key => $value) {
            $$key = htmlentities(trim($value));
        }
        if ($nama_kategori == "") return sendError("Nama wajib diisi");
        if (!isset($posted['_id']) || $posted['_id'] == "") {
            $save = $this->kategori->_save(array(
                "nama_kategori"     => $nama_kategori,
            ), array(), "nama_kategori");
            if ($save == 'exist') {
                sendError('Data Sudah terdaftar');
            } else {

                echo json_encode(array("message" => "Penambahan berhasil"));
            }
        } else {
            $id_kategori = htmlentities(trim($posted['_id']));
            $data = array(
                "nama_kategori"     => $nama_kategori,
            );
            $where = ["id_kategori" => $id_kategori];
            $save = $this->kategori->_save($data, $where, "nama_kategori");
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

    public function delete__($id = '')
    {
        header('Content-Type: application/json');
        $method = $this->input->method(true);
        if ($method != "DELETE") sendError(lang('msg_method_delete_required'), [], 405);
        $result = $this->kategori->_delete(array('id_kategori' => htmlentities(trim($id))));
        if ($result == 1) {
            sendSuccess(lang('msg_delete_success'), []);
        } else {
            sendError(lang('msg_delete_failed'));
        }
    }
    public function get_active_lang()
    {
        header('Content-Type: application/json');
        echo json_encode($this->lang->language);
    }
}
