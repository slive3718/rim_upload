<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Session_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getSessions(){
        $sessions = $this->db->select('*')
            ->get('sessions');

        if($sessions->num_rows() > 0){
            return $sessions->result();
        }else
            return '';
    }

    function saveSession(){
        $post = $this->input->post();
        $field_array = array(
            'name'=>trim($post['session_name']),
            'full_name'=>trim($post['session_full_name']),
            'session_date'=>($post['session_date']),
            'start_time'=>($post['session_start']),
            'end_time'=>($post['session_end']),
        );
        $exist_session = $this->db->select('*')
            ->from('sessions')
            ->where('name', $post['session_name'])
            ->get();
        if($exist_session->num_rows()>0){
            return json_encode(array('status'=>'info', 'msg'=>'Duplicate session name'));
        }
        else
        $this->db->insert('sessions', $field_array);

        if($this->db->insert_id())
            return json_encode(array('status'=>'success', 'msg'=>'Session saved successfully!'));
        else
            return json_encode(array('status'=>'error', 'msg'=>'Something went wrong'));
    }

    function updateSession(){
        $post = $this->input->post();
       $field_set = array(
           'name'=>$post['name'],
           'full_name'=>$post['full_name'],
           'session_date'=>($post['session_date']),
           'start_time'=>($post['session_start']),
           'end_time'=>($post['session_end']),
       );

        $this->db->where('id', $post['sessionId']);
        $update = $this->db->update('sessions',$field_set);
        if($update){
            return json_encode(array('status'=>'success', 'data'=>$update));
        }else{
            return  json_encode(array('status'=>'error','msg'=>'Something went wrong!'));
        }
    }

    function checkSessionName($name){
        $result = $this->db->select('*')
            ->from('sessions')
            ->where('name', $name)
            ->get();

        if($result->num_rows()>0){
            return 'exist';
        }else{
            return 'empty';
        }
    }
}