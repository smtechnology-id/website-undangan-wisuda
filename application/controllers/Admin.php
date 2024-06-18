<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Panggil fungsi pengecekan login (misalnya is_logged_in())
        is_logged_in();

        // Load library-session, database, dan model
        $this->load->library('session');
        $this->load->database();
        $this->load->model('ModelGolongan');
    }


    public function index()
    {
        if (!$this->session->userdata('email')) {
            redirect('auth/login'); // Redirect ke halaman login jika belum login
        }

        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Dashboard Admin';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function golongan()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['golongan'] = $this->ModelGolongan->get_data('golongan')->result();
        $data['title'] = 'Golongan Tamu - Dashboard Admin';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/golongan', $data);
        $this->load->view('templates/footer', $data);
    }
    public function addGolongan()
    {
        // Set aturan validasi untuk form
        $this->form_validation->set_rules('nama_golongan', 'Nama Golongan', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan kembali form dengan pesan error
            $this->load->view('admin/golongan'); // Ganti 'nama_view_form' dengan nama view form Anda
        } else {
            // Tangani input form di sini karena validasi berhasil
            $nama_golongan = $this->input->post('nama_golongan');
            $keterangan = $this->input->post('keterangan');

            // Contoh penyimpanan data ke database menggunakan model
            $data = array(
                'nama_golongan' => $nama_golongan,
                'keterangan' => $keterangan
            );

            $this->ModelGolongan->insert_data('golongan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data Berhasil Di Tambahkan
            </div>');

            // Redirect atau tampilkan pesan sukses
            redirect('admin/golongan'); // Ganti 'admin/index' dengan halaman yang sesuai
        }
    }
}
