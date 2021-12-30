<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tableKategori = "tbl_kategori";
        $this->load->helper('ctc');
    }
    function _load_dt($posted)
    {
        $orders_cols = ["id_kategori", "nama_kategori"];
        $output = build_filter_table($posted, $orders_cols);
        $data = $this->db->query("SELECT SQL_CALC_FOUND_ROWS " . implode(",", $orders_cols) . " FROM tbl_kategori")->result_object();
        $found = $this->db->query("SELECT FOUND_ROWS() as total")->result_object();
        $map_data = array_map(function ($dt) {
            return [

                $dt->id_kategori,
                $dt->nama_kategori,
                '<a href="#" class="link-edit-kategori" data-id="' . $dt->id_kategori . '"><i class="fa fa-edit"></i></a>  &nbsp;
						<a href="#" class="link-delete-kategori" data-id="' . $dt->id_kategori . '"><i class="fa fa-trash text-danger"></i></a>
						'
            ];
        }, $data);
        $output->recordsTotal = (sizeof($found) == 0) ? 0 : (int) $found[0]->total;
        $output->recordsFiltered = $output->recordsTotal;
        $output->data = $map_data;
        return (array) $output;
    }
    function _search($where)
    {
        $this->db->select('id_kategori as _id,nama_kategori');
        $this->db->from($this->tableKategori);
        $this->db->where($where);
        return $this->db->get()->result();
    }
    function _save($data, $where, $key)
    {
        if (empty($where)) {
            $this->db->select($key)->from($this->tableKategori)->where($key, $data[$key]);
            $check = $this->db->get()->result();
            if (!empty($check)) return 'exist';
            $this->db->insert($this->tableKategori, $data);
            return $this->db->affected_rows();
        } else {
            $this->db->select('id_kategori')->from($this->tableKategori);
            $this->db->where($key, $data[$key]);
            $this->db->where("id_kategori!=", $where['id_kategori']);
            $check = $this->db->get()->result();
            if (!empty($check)) return 'exist';
            $this->db->update($this->tableKategori, $data, $where);
            return $this->db->affected_rows();
        }
    }
    function _delete($where)
    {
        $this->db->delete($this->tableKategori, $where);
        return $this->db->affected_rows();
    }
}
