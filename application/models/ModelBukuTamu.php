<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelBukuTamu extends CI_Model
{
    public function get_buku_tamu_with_status()
    {
        $this->db->select('buku_tamu.*, tamu.nama_tamu, tamu.no_hp, undangan.status');
        $this->db->from('buku_tamu');
        $this->db->join('tamu', 'buku_tamu.id_tamu = tamu.id');
        $this->db->join('undangan', 'buku_tamu.id_undangan = undangan.id');
        return $this->db->get()->result();
    }
    public function get_buku_tamu_by_undangan($id_undangan)
    {
        $this->db->select('buku_tamu.*, tamu.nama_tamu, tamu.no_hp');
        $this->db->from('buku_tamu');
        $this->db->join('tamu', 'buku_tamu.id_tamu = tamu.id');
        $this->db->where('buku_tamu.id_undangan', $id_undangan);
        return $this->db->get()->result();
    }
    public function insert_data($table, $data)
    {
        $this->db->insert($table, $data);
    }
}
