<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 */
class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->library('ciqrcode');
        $this->load->model('ModelGolongan');
        $this->load->model('ModelUndangan');
        $this->load->model('ModelTamu');
        $this->load->model('ModelBukuTamu');
    }

    public function index()
    {
        if (!$this->session->userdata('email')) {
            redirect('auth/login'); // Redirect ke halaman login jika belum login
        }

        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Dashboard Panitia';
        $data['jumlah_golongan'] = $this->ModelGolongan->count_all_golongan();
        $data['jumlah_undangan'] = $this->ModelUndangan->count_all_undangan();
        $data['jumlah_tamu'] = $this->ModelTamu->count_all_tamu();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer', $data);
    }
    public function undangan()
{
    $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    $data['golongan'] = $this->ModelGolongan->get_golongan_with_tamu_count();
    $data['tamu_count_by_golongan'] = $this->ModelTamu->get_tamu_count_by_golongan(); // Data jumlah tamu per golongan
    $data['undangan'] = $this->ModelUndangan->get_undangan_with_golongan(); // Fetch all data for the undangan table

    $data['title'] = 'Daftar Undangan';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/navbar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/undangan', $data);
    $this->load->view('templates/footer', $data);
}



    public function preview()
    {
        // Ambil ID undangan dari URL
        $id = $this->input->get('id');

        // Dapatkan data pengguna yang sedang login
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        // Dapatkan data undangan berdasarkan ID
        $data['undangan'] = $this->ModelUndangan->get_undangan_by_id($id);

        // Dapatkan data golongan (jika diperlukan)
        $data['golongan'] = $this->ModelGolongan->get_by_id($data['undangan']->golongan_id);

        // Set judul halaman
        $data['title'] = 'Preview Undangan ' . $data['undangan']->nama_acara;

        // Load view
        $this->load->view('admin/preview', $data);
    }

    public function setujuiUndangan()
    {
        $undangan_id = $this->input->get('id'); // Ambil id undangan dari URL

        if ($undangan_id) {
            // Update status undangan menjadi accepted
            $data = ['status' => 'accepted'];
            $this->ModelUndangan->update_data('undangan', $data, ['id' => $undangan_id]);

            // Redirect ke halaman daftar undangan atau halaman lain yang diinginkan
            redirect('user/undangan'); // Ganti dengan halaman yang sesuai
        } else {
            // Handle case when undangan id is not provided
            echo "ID undangan tidak ditemukan.";
        }
    }
}
