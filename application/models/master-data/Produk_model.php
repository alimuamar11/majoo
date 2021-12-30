<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tableProduk = "tbl_produk";
        $this->tableKategori = "tbl_kategori";
        $this->load->helper('ctc');
    }
    function _load_dt($posted)
    {
        $orders_cols = ["id_produk", "nama", "deskripsi", "harga", "nama_kategori", "image"];
        $output = build_filter_table($posted, $orders_cols);
        $data = $this->db->query("SELECT SQL_CALC_FOUND_ROWS " . implode(",", $orders_cols) . " FROM tbl_produk JOIN tbl_kategori ON tbl_produk.fk_kategori=tbl_kategori.id_kategori")->result_object();
        $found = $this->db->query("SELECT FOUND_ROWS() as total")->result_object();
        $map_data = array_map(function ($dt) {

            return [

                $dt->id_produk,
                $dt->nama,
                $dt->deskripsi,
                $dt->harga,
                $dt->nama_kategori,
                $dt->image,
                '<a href="#" class="link-edit-produk" data-id="' . $dt->id_produk . '"><i class="fa fa-edit"></i></a>  &nbsp;
						<a href="#" class="link-delete-produk" data-id="' . $dt->id_produk . '"><i class="fa fa-trash text-danger"></i></a>
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
        $this->db->select('id_produk as _id,nama, deskripsi,harga,fk_kategori,id_kategori,nama_kategori');
        $this->db->from($this->tableProduk);
        $this->db->join($this->tableKategori, 'tbl_kategori.id_kategori=tbl_produk.fk_kategori');
        $this->db->where($where);
        return $this->db->get()->result();
    }
    function _search_select2($key = "")
    {
        $this->db->select('id_kategori as id, nama_kategori as text');
        $this->db->from($this->tableKategori);
        if ($key != "") {
            $this->db->like('nama_kategori', $key);
        }
        $this->db->limit(30);
        return $this->db->get()->result_array();
    }
    function _save($data, $where, $key)
    {
        if (empty($where)) {
            $this->db->select($key)->from($this->tableProduk)->where($key, $data[$key]);
            $check = $this->db->get()->result();
            if (!empty($check)) return 'exist';
            $this->db->insert($this->tableProduk, $data);
            return $this->db->affected_rows();
        } else {
            $this->db->select('id_produk')->from($this->tableProduk);
            $this->db->where($key, $data[$key]);
            $this->db->where("id_produk!=", $where['id_produk']);
            $check = $this->db->get()->result();
            if (!empty($check)) return 'exist';
            $this->db->update($this->tableProduk, $data, $where);
            return $this->db->affected_rows();
        }
    }
    function _delete($where)
    {
        $this->db->delete($this->tableProduk, $where);
        return $this->db->affected_rows();
    }
    function detail_produk()
    {
        $data = $this->db->query("SELECT * from tbl_produk")->result();
        return $data;
    }
}
