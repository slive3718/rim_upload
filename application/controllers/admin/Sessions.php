<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sessions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $login_status = $this->session->userdata('admin_login_status');
        if ($login_status != true)
            redirect(base_url('admin'));

        $this->load->model('Admin_Logger');
        $this->load->model('admin/Session_model','m_session');
    }

    public function index()
    {
        if ($this->session->userdata('level') != 1)
            redirect(base_url('admin'));
        $this->load->view('admin/head');
        $this->load->view('admin/sessions');
        $this->load->view('admin/models/create-session-modal');
        $this->load->view('admin/foot');
    }

    public function getSessions(){
        echo json_encode($this->m_session->getSessions());
    }

    public function saveSession(){
        $result = $this->m_session->saveSession();
        echo $result;
    }

    public function updateSession(){
       echo $this->m_session->updateSession();
    }

}