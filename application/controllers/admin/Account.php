<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller
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

    }

    public function saveAdminAccount(){
        $post = $this->input->post();
        $field_set = array(
            'first_name'=>trim($post['first_name']),
            'last_name'=>trim($post['last_name']),
            'email'=>trim($post['email']),
            'password'=>trim($post['password']),
            'level'=>$post['level'],
        );

        if($this->checkEmailExists($post['email']) !== 'exist'){
            $this->db->insert('admin', $field_set);
            if($this->db->insert_id()){
                echo json_encode(array('status'=>'success', 'icon'=>'success', 'msg'=>'Account Successfully Created'));
            }else{
                echo json_encode(array('status'=>'Error', 'icon'=>'error', 'msg'=>'Problem Creating Account'));
            }
        }else{
            echo json_encode(array('status'=>'Error', 'icon'=>'warning', 'msg'=>'Email Already Exist'));
        }
    }

    function checkEmailExists($email){
        $result = $this->db->select('*')->from('admin')->where('email', $email)->get();

        if($result->num_rows() > 0){
            return 'exist';
        }else{
            return '1';
        }
    }


}