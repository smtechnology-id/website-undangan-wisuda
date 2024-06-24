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
        $this->load->library('ciqrcode');
        $this->load->model('ModelGolongan');
        $this->load->model('ModelUndangan');
        $this->load->model('ModelTamu');
        $this->load->model('ModelBukuTamu');
    }
    function hariIndo($tanggal)
    {
        $hariInggris = date('l', strtotime($tanggal));
        $hariIndonesia = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        return $hariIndonesia[$hariInggris];
    }




    public function index()
    {
        if (!$this->session->userdata('email')) {
            redirect('auth/login'); // Redirect ke halaman login jika belum login
        }

        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Dashboard Admin';
        $data['jumlah_golongan'] = $this->ModelGolongan->count_all_golongan();
        $data['jumlah_undangan'] = $this->ModelUndangan->count_all_undangan();
        $data['jumlah_tamu'] = $this->ModelTamu->count_all_tamu();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function golongan()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['golongan'] = $this->ModelGolongan->get_golongan_with_tamu_count();
        $data['title'] = 'Daftar Golongan';

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
    public function updateGolongan()
    {
        // Set aturan validasi untuk form
        $this->form_validation->set_rules('id', 'ID', 'required');
        $this->form_validation->set_rules('nama_golongan', 'Nama Golongan', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan kembali form dengan pesan error
            $this->load->view('admin/golongan'); // Pastikan ini merujuk ke view yang benar
        } else {
            // Tangani input form di sini karena validasi berhasil
            $id = $this->input->post('id');
            $nama_golongan = $this->input->post('nama_golongan');
            $keterangan = $this->input->post('keterangan');

            // Contoh penyimpanan data ke database menggunakan model
            $data = array(
                'nama_golongan' => $nama_golongan,
                'keterangan' => $keterangan
            );

            $this->ModelGolongan->update_data('golongan', $data, $id);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data Berhasil Di Update
            </div>');

            // Redirect atau tampilkan pesan sukses
            redirect('admin/golongan'); // Ganti 'admin/golongan' dengan halaman yang sesuai
        }
    }
    public function deleteGolongan()
    {
        $id = $this->input->get('id');
        if ($id) {
            $this->ModelGolongan->delete_data('golongan', $id);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Data Berhasil Dihapus
                </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Data Gagal Dihapus
                </div>');
        }
        redirect('admin/golongan');
    }

    public function get_undangan_with_golongan()
    {
        $this->db->select('undangan.*, golongan.nama_golongan');
        $this->db->from('undangan');
        $this->db->join('golongan', 'undangan.golongan_id = golongan.id');
        return $this->db->get()->result();
    }

    public function undangan()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['golongan'] = $this->ModelGolongan->get_golongan_with_tamu_count();
        $data['tamu_count_by_golongan'] = $this->ModelTamu->get_tamu_count_by_golongan(); // Data jumlah tamu per golongan
        $data['undangan'] = $this->ModelUndangan->get_undangan_with_golongan('undangan'); // Fetch data for the undangan table

        $data['title'] = 'Daftar Undangan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/undangan', $data);
        $this->load->view('templates/footer', $data);
    }


    public function addUndangan()
    {
        $this->form_validation->set_rules('nama_acara', 'Nama Acara', 'required');
        $this->form_validation->set_rules('detail_acara', 'Detail Acara', 'required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'required');
        $this->form_validation->set_rules('tempat', 'Tempat', 'required');
        $this->form_validation->set_rules('alamat_acara', 'Alamat Acara', 'required');
        $this->form_validation->set_rules('link_maps', 'Link Maps', 'required');
        $this->form_validation->set_rules('golongan_id', 'Golongan', 'required');  // Tambah validasi untuk golongan

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
            $data['title'] = 'Tambah Undangan';
            $data['golongan'] = $this->ModelGolongan->get_data('golongan')->result();
            $data['undangan'] = $this->ModelUndangan->get_undangan_with_golongan();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/undangan', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $data = [
                'nama_acara' => $this->input->post('nama_acara'),
                'detail_acara' => $this->input->post('detail_acara'),
                'waktu' => $this->input->post('waktu'),
                'tempat' => $this->input->post('tempat'),
                'alamat_acara' => $this->input->post('alamat_acara'),
                'link_maps' => $this->input->post('link_maps'),
                'status' => 'pending',
                'golongan_id' => $this->input->post('golongan_id'),  // Tambahkan golongan_id
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->ModelUndangan->insert_data('undangan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Undangan berhasil ditambahkan!</div>');
            redirect('admin/undangan');
        }
    }



    public function tamu()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['tamu'] = $this->ModelTamu->get_tamu_with_golongan();
        $data['title'] = 'Daftar Tamu';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/tamu', $data);
        $this->load->view('templates/footer', $data);
    }
    public function addTamu()
    {
        $this->form_validation->set_rules('nama_tamu', 'Nama Tamu', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('id_golongan', 'Golongan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
            $data['golongan'] = $this->ModelGolongan->get_data('golongan')->result();
            $data['title'] = 'Tambah Tamu';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/golongan', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $data = [
                'nama_tamu' => $this->input->post('nama_tamu'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat'),
                'id_golongan' => $this->input->post('id_golongan')
            ];

            $this->ModelTamu->insert_data('tamu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Tamu berhasil ditambahkan!</div>');
            redirect('admin/golongan');
        }
    }

    public function listTamuGolongan()
    {
        $golongan_id = $this->input->get('id');
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['tamu'] = $this->ModelTamu->get_tamu_by_golongan($golongan_id);
        $data['golongan'] = $this->ModelGolongan->get_by_id($golongan_id); // Changed here
        $data['title'] = 'Daftar Tamu Golongan ' . $data['golongan']->nama_golongan;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/list_tamu_golongan', $data);
        $this->load->view('templates/footer', $data);
    }
    public function deleteTamu()
    {
        $id = $this->input->get('id');
        // Get the tamu data to find the golongan_id before deletion
        $tamu = $this->ModelTamu->get_tamu_by_id($id);

        if ($tamu) {
            $id_golongan = $tamu->id_golongan;

            // Delete the tamu record
            $this->ModelTamu->delete_data('tamu', ['id' => $id]);

            // Set a success message
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Tamu berhasil dihapus!</div>');

            // Redirect back to the listTamuGolongan view with the appropriate golongan_id
            redirect('admin/listTamuGolongan?id=' . $id_golongan);
        } else {
            // Set an error message if the tamu record is not found
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tamu tidak ditemukan!</div>');

            // Redirect back to the golongan list
            redirect('admin/golongan');
        }
    }

    public function updateUndangan()
    {
        $this->form_validation->set_rules('nama_acara', 'Nama Acara', 'required');
        $this->form_validation->set_rules('detail_acara', 'Detail Acara', 'required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'required');
        $this->form_validation->set_rules('tempat', 'Tempat', 'required');
        $this->form_validation->set_rules('alamat_acara', 'Alamat Acara', 'required');
        $this->form_validation->set_rules('link_maps', 'Link Maps', 'required');
        $this->form_validation->set_rules('golongan_id', 'Golongan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
            $data['undangan'] = $this->ModelUndangan->get_data('undangan')->result();
            $data['golongan'] = $this->ModelGolongan->get_data('golongan')->result();
            $data['title'] = 'Daftar Undangan';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/undangan', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $id = $this->input->post('id');
            $data = [
                'nama_acara' => $this->input->post('nama_acara'),
                'detail_acara' => $this->input->post('detail_acara'),
                'waktu' => $this->input->post('waktu'),
                'tempat' => $this->input->post('tempat'),
                'alamat_acara' => $this->input->post('alamat_acara'),
                'link_maps' => $this->input->post('link_maps'),
                'golongan_id' => $this->input->post('golongan_id')
            ];

            $this->ModelUndangan->update_data('undangan', $data, ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Undangan berhasil diperbarui!</div>');
            redirect('admin/undangan');
        }
    }
    public function deleteUndangan()
    {
        $id = $this->input->get('id');

        // Menghapus data undangan berdasarkan ID
        $this->ModelUndangan->delete_data('undangan', ['id' => $id]);

        // Set flash data untuk pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Undangan berhasil dihapus!</div>');

        // Redirect ke halaman undangan
        redirect('admin/undangan');
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

    public function acara()
    {
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['golongan'] = $this->ModelGolongan->get_golongan_with_tamu_count();
        $data['tamu_count_by_golongan'] = $this->ModelTamu->get_tamu_count_by_golongan(); // Data jumlah tamu per golongan
        $data['undangan'] = $this->ModelUndangan->get_undangan_with_golongan('undangan', 'accepted');
        $data['title'] = 'Daftar Undangan';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/acara', $data);
        $this->load->view('templates/footer', $data);
    }
    public function bukuTamu()
    {
        $undangan_id = $this->input->get('id'); // Ambil id undangan dari URL
        $data['undangan'] = $this->ModelUndangan->get_by_id($undangan_id); // Mendapatkan data undangan berdasarkan id

        if ($data['undangan']) {
            // Mendapatkan daftar tamu berdasarkan id_golongan dari undangan
            $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
            $data['title'] = 'Daftar Buku Tamu';

            $id_golongan = $data['undangan']->golongan_id;
            $data['tamu'] = $this->ModelTamu->get_tamu_by_golongan($id_golongan);

            // Mendapatkan buku tamu berdasarkan id undangan
            $data['buku_tamu'] = $this->ModelBukuTamu->get_buku_tamu_by_undangan($undangan_id);

            // Load view untuk menampilkan buku tamu
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/bukuTamu', $data); // Pastikan sesuaikan dengan nama file view yang Anda gunakan
            $this->load->view('templates/footer', $data);
        } else {
            // Handle case when undangan with given id is not found
            echo "Undangan tidak ditemukan";
        }
    }
    public function tambahKehadiran()
    {
        $id_undangan = $this->input->get('id_undangan');
        $id_tamu = $this->input->get('id_tamu');

        // Periksa apakah entri sudah ada
        $existing_entry = $this->db->get_where('buku_tamu', [
            'id_undangan' => $id_undangan,
            'id_tamu' => $id_tamu
        ])->row();

        if (!$existing_entry) {
            $data = [
                'id_undangan' => $id_undangan,
                'id_tamu' => $id_tamu,
                'status' => 'hadir'
            ];

            $this->ModelBukuTamu->insert_data('buku_tamu', $data);
            echo "Kehadiran berhasil ditambahkan.";
        } else {
            echo "Tamu sudah terdaftar hadir.";
        }
    }
    public function undanganWisuda()
    {
        $id_undangan = $this->input->get('id_undangan');
        $id_tamu = $this->input->get('id_tamu');

        $data['undangan'] = $this->ModelUndangan->get_by_id($id_undangan);
        $data['tamu'] = $this->ModelTamu->get_by_id($id_tamu);

        if ($data['undangan'] && $data['tamu']) {
            $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
            $data['title'] = 'Detail Undangan Wisuda';
            $url = base_url('admin/tambahKehadiran?id_undangan=' . $id_undangan . '&id_tamu=' . $id_tamu);
            $data['qr_code_url'] = $this->generateQRCode($url);

            $this->load->view('admin/undanganWisuda', $data);
        } else {
            echo "Data undangan atau tamu tidak ditemukan.";
        }
    }
    public function generateQRCode($url)
    {
        $config['cacheable'] = true;
        $config['cachedir'] = './assets/';
        $config['errorlog'] = './assets/';
        $config['imagedir'] = './assets/images/';
        $config['quality'] = true;
        $config['size'] = '1024';
        $config['black'] = [224, 255, 255];
        $config['white'] = [70, 130, 180];
        $this->ciqrcode->initialize($config);

        $image_name = 'qrcode_' . md5($url) . '.png';
        $params['data'] = $url;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name;
        $this->ciqrcode->generate($params);

        return base_url('assets/images/' . $image_name);
    }
    public function updateTamu()
    {
        $this->form_validation->set_rules('nama_tamu', 'Nama Tamu', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Gagal mengupdate data tamu. Pastikan semua kolom diisi dengan benar.');
            redirect('admin/editTamu?id=' . $this->input->post('id'));
        } else {
            $data = [
                'nama_tamu' => $this->input->post('nama_tamu'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat')
            ];

            $id = $this->input->post('id');
            $id_golongan = $this->ModelTamu->get_tamu_golongan_id($id); // Mendapatkan id_golongan dari tamu

            $this->ModelTamu->update_tamu($id, $data);

            $this->session->set_flashdata('success', 'Data tamu berhasil diupdate.');
            redirect('admin/listTamuGolongan?id=' . $id_golongan); // Redirect ke halaman listTamuGolongan
        }
    }
}
