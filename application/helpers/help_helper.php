<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        // Perbaikan query
        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        
        // Pastikan menu ditemukan
        if ($queryMenu) {
            $menuId = $queryMenu['id'];

            $userAccess = $ci->db->get_where('user_access_menu', [
                'role_id' => $role_id,
                'menu_id' => $menuId
            ]);

            if ($userAccess->num_rows() < 1) {
                redirect('auth/blocked');
            }
        } else {
            // Jika menu tidak ditemukan, arahkan ke halaman blokir
            redirect('auth/blocked');
        }
    }
}
