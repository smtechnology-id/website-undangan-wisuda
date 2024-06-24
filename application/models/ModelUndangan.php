<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelUndangan extends CI_Model
{
    // Method untuk mendapatkan semua data dari tabel
    public function get_data($table)
    {
        return $this->db->get($table);
    }

    // Method untuk menyisipkan data ke dalam tabel
    public function insert_data($table, $data)
    {
        $this->db->insert($table, $data);
    }

    // Method untuk memperbarui data dalam tabel berdasarkan id
    public function update_data($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
    }

    // Method untuk menghapus data dari tabel berdasarkan id
    public function delete_data($table, $where)
    {
        $this->db->delete($table, $where);
    }
    public function get_undangan_with_golongan()
    {
        $this->db->select('undangan.*, golongan.nama_golongan');
        $this->db->from('undangan');
        $this->db->join('golongan', 'undangan.golongan_id = golongan.id');
        return $this->db->get()->result();
    }


    public function get_undangan_by_id($id)
    {
        return $this->db->get_where('undangan', ['id' => $id])->row();
    }
    public function get_by_id($id)
    {
        return $this->db->get_where('undangan', ['id' => $id])->row();
    }
    public function count_all_undangan()
    {
        return $this->db->count_all('undangan');
    }
    
}
