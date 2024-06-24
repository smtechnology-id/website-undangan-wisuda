<?php
class ModelTamu extends CI_Model
{
    public function get_data($table)
    {
        return $this->db->get($table);
    }

    public function insert_data($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function update_data($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
    }

    public function delete_data($table, $where)
    {
        $this->db->delete($table, $where);
    }

    public function get_tamu_with_golongan()
    {
        $this->db->select('tamu.*, golongan.nama_golongan');
        $this->db->from('tamu');
        $this->db->join('golongan', 'tamu.id_golongan = golongan.id');
        return $this->db->get()->result();
    }

    public function get_tamu_count_by_golongan()
    {
        $this->db->select('golongan.nama_golongan, COUNT(tamu.id) as jumlah_tamu');
        $this->db->from('tamu');
        $this->db->join('golongan', 'tamu.id_golongan = golongan.id');
        $this->db->group_by('tamu.id_golongan');
        return $this->db->get()->result();
    }
    public function get_tamu_by_golongan($id_golongan)
    {
        $this->db->select('tamu.*, golongan.nama_golongan');
        $this->db->from('tamu');
        $this->db->join('golongan', 'tamu.id_golongan = golongan.id');
        $this->db->where('tamu.id_golongan', $id_golongan);
        return $this->db->get()->result();
    }
    public function get_tamu_by_id($id)
    {
        return $this->db->get_where('tamu', ['id' => $id])->row();
    }
    public function get_by_id($id)
    {
        return $this->db->get_where('tamu', ['id' => $id])->row();
    }
    public function count_all_tamu()
    {
        return $this->db->count_all('tamu');
    }

    public function update_tamu($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tamu', $data);
    }

    public function get_tamu_golongan_id($id)
    {
        $this->db->select('id_golongan');
        $this->db->from('tamu');
        $this->db->where('id', $id);
        $result = $this->db->get()->row();
        return $result ? $result->id_golongan : null;
    }
    
}
