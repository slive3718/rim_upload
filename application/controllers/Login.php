<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Presenter_Logger');
    }

    public function index()
    {
        $login_status = $this->session->userdata('uploads_login_status');
        if ($login_status === true)
            redirect(base_url('dashboard'));

        $this->load->view('presenter/head');
        $this->load->view('presenter/login');
        $this->load->view('presenter/foot');
        $this->load->view('presenter/models/forgot-password');
    }

    public function verify()
    {
        $post = $this->input->post();

        $this->db->select('*');
        $this->db->from('presenter');
        $this->db->where("email", $post['email']);
        $this->db->where("password", $post['password']);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {

            $this->session->set_userdata('uploads_login_status', true);
            $this->session->set_userdata('admin_login_status', false);
            $this->session->set_userdata('user_id', $result->row()->presenter_id);
            $this->session->set_userdata('email', $result->row()->email);
            $this->session->set_userdata('name_prefix', $result->row()->name_prefix);
            $this->session->set_userdata('first_name', $result->row()->first_name);
            $this->session->set_userdata('last_name', $result->row()->last_name);
            $this->session->set_userdata('fullname', $result->row()->first_name.' '.$result->row()->last_name);

            $this->Presenter_Logger->log("Login");

            echo json_encode(array('status'=>'success'));
            return;
        } else {
            echo json_encode(array('status'=>'error', 'msg'=>'Incorrect username or password'));
            return;
        }
    }

    public function resetPassword()
    {
        $login_status = $this->session->userdata('uploads_login_status');
        if ($login_status != true)
            echo json_encode(array('status'=>'error', 'msg'=>'You are not logged in'));

        $user_id = $this->session->userdata('user_id');
        $newPass = $this->input->post()['newPass'];

        $this->db->set('password', $newPass);
        $this->db->where('presenter_id', $user_id);
        $this->db->update('presenter');

        if($this->db->affected_rows() > 0){

            $this->Presenter_Logger->log("Password reset");
            $this->Presenter_Logger->log("Logout");

            $this->session->unset_userdata('uploads_login_status');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('name_prefix');
            $this->session->unset_userdata('first_name');
            $this->session->unset_userdata('last_name');
            $this->session->unset_userdata('fullname');

            echo json_encode(array('status'=>'success', 'msg'=>'Your password is now reset, please login again'));
        }else{
            echo json_encode(array('status'=>'error', 'msg'=>'Unable to reset your password'));
        }

        return;


    }

    public function logout()
    {
        $this->Presenter_Logger->log("Logout");

        $this->session->unset_userdata('uploads_login_status');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('name_prefix');
        $this->session->unset_userdata('first_name');
        $this->session->unset_userdata('last_name');
        $this->session->unset_userdata('fullname');
        header('location:' . base_url());
    }

    public function forgot_password(){
        $email_exist = $this->db->select('*')
            ->from('presenter')
            ->where('email', $this->input->post('email'))
            ->get();

        if($email_exist->num_rows()>0){

            if($this->newPassword($email_exist->result()[0]->email) !== 'error'){
                $newPassword = $this->newPassword($email_exist->result()[0]->email);
                $this->sendForgotPasswordEmail($email_exist->result()[0]->email, $newPassword );
            }else{
                echo json_encode(array('msg'=>'error', 'status'=>'Error 503, Please contact administrator'));
            }

        }else{
            echo json_encode(array('msg'=>'error', 'status'=>'Email not found'));
        }
    }

    function newPassword($email){
        $this->load->helper('string');


        $newPassword =random_string('alpha', 6);

        $this->db->where('email', $email);
        $this->db->update('presenter', array('password'=>$newPassword));

        if($this->db->affected_rows()>0)
        return $newPassword;
        else return 'error';
    }

    function sendForgotPasswordEmail($email, $newPassword){

            $subject = "LSRS Forgot Password";
            $content = 'Your new password is '. $newPassword . '<br> Click the link below to <a href="https://yourconference.live/LSRS/upload"><u>Login Page</u></a>';

            $this->load->config('email', TRUE);

            if (!$this->config->config['email']['smtp_user'])
            {
                $response = array(
                    'status' => 'failed',
                    'msg' => "Send email option is not configured, please contact system administrator."
                );

                echo json_encode($response);

                return;
            }

            $config = Array(
                'protocol' => $this->config->config['email']['email_protocol'],
                'smtp_host' => $this->config->config['email']['smtp_host'],
                'smtp_port' => $this->config->config['email']['smtp_port'],
                'smtp_user' => $this->config->config['email']['smtp_user'],
                'smtp_pass' => $this->config->config['email']['smtp_pass'],
                'mailtype' => $this->config->config['email']['mailtype'],
                'charset' => $this->config->config['email']['charset'],
                'smtp_crypto'   => 'ssl'
            );
            $this->load->library('email', $config);

            $this->email->from('presentations@yourconference.live', 'LSRS Presentation Submission');
            $this->email->to($email);

            $this->email->subject($subject);

            $this->email->message($content);
            $result = $this->email->send();

            if($result){
                echo json_encode(array('msg'=>'success', 'status'=>'Email Successfully Sent'));
            }else{
                echo json_encode(array('msg'=>'error', 'status'=>'Error sending email, Please contact administrator'));
            }
            return;
    }

}
