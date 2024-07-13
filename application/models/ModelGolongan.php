<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelGolongan extends CI_Model
{
    public function get_data($table)
    {
        return $this->db->get($table);
    }

    public function insert_data($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function update_data($table, $data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    public function delete_data($table, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

    public function get_golongan_with_tamu_count()
    {
        $this->db->select('golongan.*, COUNT(tamu.id) as jumlah_tamu');
        $this->db->from('golongan');
        $this->db->join('tamu', 'tamu.id_golongan = golongan.id', 'left');
        $this->db->group_by('golongan.id');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('golongan', ['id' => $id])->row();
    }

    public function count_all_golongan()
    {
        return $this->db->count_all('golongan');
    }
    public function check_unique_golongan($nama_golongan)
    {
        $this->db->select('id')->from('golongan')->where('nama_golongan', $nama_golongan);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function check_unique_golongan_update($id, $nama_golongan)
    {
        $this->db->select('id')->from('golongan')->where('nama_golongan', $nama_golongan)->where('id !=', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    
}
