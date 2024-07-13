<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;


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
        // Set validation rules for the form
        $this->form_validation->set_rules('nama_golongan', 'Nama Golongan', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('periode', 'Periode', 'required');

        if ($this->form_validation->run() == FALSE) {
            // If validation fails, redisplay the form with error messages
            $this->load->view('admin/golongan'); // Replace 'nama_view_form' with your form view name
        } else {
            // Handle form input here since validation is successful
            $nama_golongan = $this->input->post('nama_golongan');
            $keterangan = $this->input->post('keterangan');
            $periode = $this->input->post('periode');

            // Check if the nama_golongan is already unique before saving
            $is_unique = $this->ModelGolongan->check_unique_golongan($nama_golongan);

            if (!$is_unique) {
                // If not unique, display an error message
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Nama Golongan Sudah Digunakan
                </div>');

                // Redirect back to the form
                redirect('admin/golongan');
            } else {
                // If unique, proceed with saving the data
                $data = array(
                    'nama_golongan' => $nama_golongan,
                    'keterangan' => $keterangan,
                    'periode' => $periode
                );

                $this->ModelGolongan->insert_data('golongan', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Data Berhasil Di Tambahkan
                </div>');

                // Redirect or show success message
                redirect('admin/golongan'); // Replace 'admin/index' with the appropriate page
            }
        }
    }

    public function updateGolongan()
    {
        // Set validation rules for the form
        $this->form_validation->set_rules('id', 'ID', 'required');
        $this->form_validation->set_rules('nama_golongan', 'Nama Golongan', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('periode', 'Periode', 'required');

        if ($this->form_validation->run() == FALSE) {
            // If validation fails, redisplay the form with error messages
            $this->load->view('admin/golongan'); // Make sure this points to the correct view
        } else {
            // Handle form input here since validation is successful
            $id = $this->input->post('id');
            $nama_golongan = $this->input->post('nama_golongan');
            $keterangan = $this->input->post('keterangan');
            $periode = $this->input->post('periode');

            // Check if the updated nama_golongan is unique (excluding the current record)
            $is_unique = $this->ModelGolongan->check_unique_golongan_update($id, $nama_golongan);

            if (!$is_unique) {
                // If not unique, display an error message
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Nama Golongan Sudah Digunakan
                </div>');

                // Redirect back to the form
                redirect('admin/golongan');
            } else {
                // If unique, proceed with saving the updated data
                $data = array(
                    'nama_golongan' => $nama_golongan,
                    'keterangan' => $keterangan,
                    'periode' => $periode
                );

                $this->ModelGolongan->update_data('golongan', $data, $id);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Data Berhasil Di Update
                </div>');

                // Redirect or show success message
                redirect('admin/golongan'); // Replace 'admin/golongan' with the appropriate page
            }
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
        $undangan_id = $this->input->get('id');
        $data['undangan'] = $this->ModelUndangan->get_by_id($undangan_id);

        if ($data['undangan']) {
            $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
            $data['title'] = 'Daftar Buku Tamu';

            $id_golongan = $data['undangan']->golongan_id;
            $data['tamu'] = $this->ModelTamu->get_tamu_by_golongan($id_golongan);
            $data['buku_tamu'] = $this->ModelBukuTamu->get_buku_tamu_by_undangan($undangan_id);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/bukuTamu', $data);
            $this->load->view('templates/footer', $data);
        } else {
            echo "Undangan tidak ditemukan";
        }
    }

    public function cetakBukuTamu()
    {
        $undangan_id = $this->input->get('id');
        $undangan = $this->ModelUndangan->get_by_id($undangan_id);
    
        if ($undangan) {
            $id_golongan = $undangan->golongan_id;
            $dataTamu = $this->ModelTamu->get_tamu_by_golongan($id_golongan);
            $bukuTamu = $this->ModelBukuTamu->get_buku_tamu_by_undangan($undangan_id);
    
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
    
            // Set Title
            $title = 'Daftar Buku Tamu - ' . $undangan->nama_acara; // Menambahkan nama acara ke judul
            $sheet->setCellValue('A1', $title);
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
            // Set Print Date
            $printDate = 'Tanggal Cetak: ' . date('d-m-Y');
            $sheet->setCellValue('A2', $printDate);
            $sheet->mergeCells('A2:E2');
            $sheet->getStyle('A2')->getFont()->setSize(12);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    
            // Set Column Headers
            $sheet->setCellValue('A3', 'No');
            $sheet->setCellValue('B3', 'Nama Tamu');
            $sheet->setCellValue('C3', 'No HP');
            $sheet->setCellValue('D3', 'Status Undangan');
            $sheet->setCellValue('E3', 'Waktu Hadir'); // Perbaiki header kolom
    
            // Set Header Styles
            $sheet->getStyle('A3:E3')->getFont()->setBold(true);
            $sheet->getStyle('A3:E3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
            // Fill Data
            $row = 4;
            $no = 1;
            foreach ($dataTamu as $tamu) {
                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $tamu->nama_tamu);
                $sheet->setCellValue('C' . $row, $tamu->no_hp);
    
                $status = 'Belum Hadir';
                $waktu_hadir = '';
                foreach ($bukuTamu as $bt) {
                    if ($bt->id_tamu == $tamu->id && $bt->id_undangan == $undangan->id) {
                        $status = 'Hadir';
                        $waktu_hadir = date('d-m-Y H:i:s', strtotime($bt->waktu)); // Format waktu
                        break;
                    }
                }
                $sheet->setCellValue('D' . $row, $status);
                $sheet->setCellValue('E' . $row, $waktu_hadir); // Isi kolom waktu hadir
    
                $row++;
            }
    
            // Auto-size columns
            foreach (range('A', 'E') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
    
            $writer = new Xlsx($spreadsheet);
            $filename = 'Buku_Tamu_Undangan_' . $undangan->nama_acara . '.xlsx';
    
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
    
            $writer->save('php://output');
        } else {
            echo "Undangan tidak ditemukan";
        }
    }
    
    public function tambahKehadiran()
    {
        $id_undangan = $this->input->get('id_undangan');
        $id_tamu = $this->input->get('id_tamu');

        // Check for existing entry using id_undangan and id_tamu
        $existing_entry = $this->db->get_where('buku_tamu', [
            'id_undangan' => $id_undangan,
            'id_tamu' => $id_tamu
        ])->row();

        if (!$existing_entry) {
            $data = [
                'id_undangan' => $id_undangan,
                'id_tamu' => $id_tamu,
                'status' => 'hadir',
                'waktu' => date('Y-m-d H:i:s') // Use 'date()' for current datetime
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
    public function exportTamuGolongan()
    {
        $golongan_id = $this->input->get('id');
        $dataTamu = $this->ModelTamu->get_tamu_by_golongan($golongan_id);
        $golongan = $this->ModelGolongan->get_by_id($golongan_id);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Title
        $title = 'Daftar Tamu Golongan ' . $golongan->nama_golongan;
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells('A1:E1'); // Merge cells for title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Set Column Headers
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nama Tamu');
        $sheet->setCellValue('C2', 'No HP');
        $sheet->setCellValue('D2', 'Alamat');
        $sheet->setCellValue('E2', 'Golongan');

        // Set Header Styles
        $sheet->getStyle('A2:E2')->getFont()->setBold(true);
        $sheet->getStyle('A2:E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Fill Data
        $row = 3;
        $no = 1;
        foreach ($dataTamu as $tamu) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $tamu->nama_tamu);
            $sheet->setCellValue('C' . $row, $tamu->no_hp);
            $sheet->setCellValue('D' . $row, $tamu->alamat);
            $sheet->setCellValue('E' . $row, $tamu->nama_golongan);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Daftar_Tamu_Golongan_' . $golongan->nama_golongan . '.xlsx';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
