<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Presenter_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getPresenters(){
        $this->db->select('*');
        $this->db->from('presenter');
        $this->db->order_by('presenter_id','asc');
        $qstr = $this->db->get();
        if($qstr->num_rows() > 0){
            return $qstr;
        }

    }

    function updatePresenter($post){
        $first_name= $post['first_name'];
        $last_name= $post['last_name'];
        $email= $post['email'];
        $password= $post['password'];
        $presenter_id= $post['presenter_id'];
        $name_prefix= $post['name_prefix'];
        $date_updated = date('Y-m-d h:i:s');

//        print_r($post);exit;
        $set_field=array(
            'name_prefix'=>$name_prefix,
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'email'=>$email,
            'password'=>$password,
            'updated_date'=>$date_updated
        );
        $this->db->select('*');
        $this->db->from('presenter');
        $this->db->where('presenter_id=',$presenter_id);
        $update =  $this->db->update('presenter',$set_field);
        if($update){
            return $update;
        }else{
            return '';
        }
    }

    function addPresenter(){
        $post = $this->input->post();
        $post['creation_date'] = date('Y-m-d H:i:s');
        if($this->checkExistEmail($post['email'])=='true'){
            return 'email_exist';
        }else{
            $this->db->insert('presenter', $post);

            if($this->db->affected_rows() > 0 ){
                return 'success';
            }else{
                return 'error';
            }
        }

    }

    function checkExistEmail($email){
        $email_exist = $this->db->select('*')
            ->from('presenter')
            ->where('email', $email)
            ->get();

        if($email_exist->num_rows() > 0){
            return 'true';
        }else
            return 'false';

    }
}