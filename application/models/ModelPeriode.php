<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelPeriode extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_data($table)
    {
        return $this->db->get($table);
    }
    public function insert($data)
    {
        return $this->db->insert('periode', $data);
    }
    public function update($id, $data)
    {
        $this->db->where('id', $id); // Sesuaikan dengan nama kolom ID Anda
        return $this->db->update('periode', $data); // Sesuaikan dengan nama tabel Anda
    }
    public function delete($id)
    {
        $this->db->where('id', $id); // Sesuaikan dengan nama kolom ID Anda
        return $this->db->delete('periode'); // Sesuaikan dengan nama tabel Anda
    }
}
