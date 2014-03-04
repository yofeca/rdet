<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_files');
        $this->load->model('m_publications');
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
    }

    public function index($rid) {
        $info['research'] = $this->m_publications->fetch_research_details($rid);
        $data = $this->header_footer(
                'Research attachments', /* title */ 
                'admin', /* user type */ 
                array('common', 'file-upload', 'a.u.loggedin'), /* css styles */ 
                array('file-upload','ajaxfileupload'));
        $data['content'] = $this->load->view('upload/upload', $info , TRUE);
        $this->load->view('admin/main', $data);
    }

    public function async_upload_file() {
        
        $title = trim($this->input->post('title'));
        $rid = (int) $this->input->post('rid');
        
        $file_element_name = 'userfile';

        $config['upload_path'] = './files/';
        $config['allowed_types'] = 'jpg|jpeg|doc|docx|pdf';
        $config['max_size'] = '100000';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($file_element_name)) {
            $err = 1;
            $msg = $this->upload->display_errors('', '');
        } else {
            $data = $this->upload->data();
            //$this->m_publications->get_files();
//            $msg = $data['file_name'] .'-'. $data['file_type'] .'-'.$data['file_size'] .'-'.$title .'-'.$rid;
//            $msg = $title . '=' . $rid;
            //$this->m_files->insert_file($data['file_name'], $data['file_type'], $data['file_size'], $title, $rid);
            $file_id = $this->m_files->insert_file($data['file_name'], $data['file_type'], $data['file_size'], $title, $rid);
            if ($file_id) {
                $err = 0;
                $msg = "File successfully uploaded";
            } else {
                unlink($data['full_path']);
                $err = 1;
                $msg = "Something went wrong when saving the file, please try again.";
            }
        }
        
        @unlink($_FILES[$file_element_name]);
        
        echo json_encode(array('err' => $err, 'msg' => $msg));
    }

//    public function files() {
//        $files = $this->m_files->get_files($this->session->userdata('f_u_refid'));
//        $this->load->view('upload/files', array('files' => $files));
//    }

    public function async_delete_research_file() {
        $fid = $this->input->post('fid');
        $this->m_files->delete_research_file($fid);
    }

    public function async_research_files(){
        $rid = (int)$this->input->post('rid');
        $this->m_files->fetch_research_files($rid);
    }
}