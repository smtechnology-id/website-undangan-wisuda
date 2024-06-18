<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelGolongan extends CI_Model
{
    public function get_data($table)
    {
        return $this->db->get($table);
    }

    public function insert_data($table, $data) {
        $this->db->insert($table, $data);
    }
}
