<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['member'] = $this->db->get('user')->result();
        $data['news'] = $this->db->get('news')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }


    public function role()
    {
        $data['title'] = 'Role';

        if (!empty($_POST)) {
            $role = $_POST['role'];
            $this->db->insert('user_role', array('role' => $role));
        }
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }


    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }


    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    // public function roleEdit($role_id)
    // {
    //     $data['title'] = 'Role';

    //     if (!empty($_POST)) {
    //         $role = $_POST['role'];
    //         $this->db->update('user_role', array('role' => $role), array('id' => $role_id));
    //     }

    //     $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    //     $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/topbar', $data);
    //     $this->load->view('admin/role_edit', $data);
    //     $this->load->view('templates/footer');
    // }

    public function member()
    {
        $data['title'] = 'Member';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['users'] = $this->db->get('user')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/member', $data);
        $this->load->view('templates/footer');
    }

    public function newsTable()
    {
        $data['title'] = 'News Table';

        if (!empty($_POST)) {

            $title = $_POST['title'];
            $news_content = $_POST['news_content'];
            
            $this->db->insert('news', array('title' => $title,'news_content' => $news_content));
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Content added!</div>');
            redirect('admin/newsTable');
        }
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['news'] = $this->db->get('news')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/newsTable', $data);
        $this->load->view('templates/footer');
    }

    public function newsEdit($news_id)
    {
        $data['title'] = 'News Table';

        if (!empty($_POST)) {
            $title = $_POST['title'];
            $news_content = $_POST['news_content'];
            $this->db->update('news', array('title' => $title, 'news_content' => $news_content), array('id_news' => $news_id));
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Content Updated!</div>');
            redirect('admin/newsTable');
        }

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['news'] = $this->db->get_where('news', ['id_news' => $news_id])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/newsEdit', $data);
        $this->load->view('templates/footer');
    }

    public function newsDelete($news_id)
    {
        $this->db->delete('news', array('id_news' => $news_id));
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Content Deleted!</div>');
        redirect('admin/newsTable');
    }
}
