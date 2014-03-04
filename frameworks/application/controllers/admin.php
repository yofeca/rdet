<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('m_admin', '', TRUE);
        $this->load->model('m_publications','',TRUE);
        $this->load->helper('url');
        //$this->library('pagination');
    }

    
    public function index() {
        $this->login();
    }
    
   
    public function login() {
        if($this->session->userdata('u_id') && $this->session->userdata('u_level')){
            $this->home();
        }else{
            if (!isset($_POST['username']) && !isset($_POST['password'])) {
                $data['content'] = $this->load->view('admin/login');
            } else {
                $this->m_admin->login($_POST);
                $this->home();
            }
        }
    }
    
    
    public function logout() {
            $this->session->unset_userdata('u_id');
            $this->session->unset_userdata('u_level');
            $this->login();
    }

    
    public function home() {
        if($this->session->userdata('u_id') && $this->session->userdata('u_level')){
            $data = $this->header_footer(
                    'Publications', 
                    'admin', 
                    array('common','portal', 'u.loggedin','ui.jqgrid'),
                    array('portal', 'jquery.jqGrid.min','grid.locale-en'));
            $data['content'] = $this->load->view('publication/portal', '', TRUE);
            $this->load->view('admin/main', $data);
        }else{
            $this->load->view('index');
        }
    }

    
    public function myprofile($profile_id=0){
        if($this->session->userdata('u_id')){
        $info['profile'] = $this->m_admin->fetch_my_profile($profile_id);
        $data = $this->header_footer(
                'My Profile',
                'admin', 
                array('common','my.profile','u.loggedin'),
                array('my.profile'));
        $data['content'] = $this->load->view('admin/my_profile', $info, TRUE);
        $this->load->view('admin/main', $data);
        }else{
            $this->load->view('index');
        }
    }
    
    
    public function manage_accounts() {
        if($this->session->userdata('u_id')){
            $data = $this->header_footer(
                'Manage Accounts', 'admin', 
                array('common', 'm.accounts', 'u.loggedin','ui.jqgrid'), 
                array('m.accounts', 'jquery.jqGrid.min','grid.locale-en','jquery.jqGrid.min'));
            
            $data['content'] = $this->load->view('admin/manage_accounts', '', TRUE);
            $this->load->view('admin/main', $data);
            }else{
            $this->load->view('index');
        }
    }

    
    public function async_delete_account(){
        $person_id = (int) $this->input->post('pid');
        $this->m_admin->delete_account($person_id);
    }
    
    
    public function async_save_account(){
        $this->load->view('admin/vj/acc-registration.php');
    }
    
    
    public function async_get_account(){
        $search_id = (int) $this->input->post('pid');
        $this->m_admin->search_accounts($search_id);
    }
    
    
    public function async_fetch_person_id(){
        $this->m_admin->fetch_person_id();
    }
    
    
    public function async_employee_id(){
        $response = array();
        $emp_id = $this->input->post('emp_id');
        $result = $this->m_admin->check_emp_id($emp_id);
        if($result) $response['err'] = 1;
        
        exit(json_encode($response));
    }
    
    public function async_accounts(){
        $this->m_admin->fetch_accounts();
    }

    
    public function async_update_user_account(){
        $response = array();
        $data = $this->input->post();
        $result = $this->m_admin->update_user_account($data);
        
        if($result){
            $response['error'] = 0;
            $response['message'] = 'Successfully updated User Account.';
        }else{
            $response['error'] = 1;
            $response['message'] = 'Unable to update User Account.';
        }
        exit(json_encode($response));
    }
    
    
    public function update_myprofile(){
        $response = array();
        $data = $this->input->post();
        $result = $this->m_admin->update_myprofile($data);
        
        if($result){
            $response['error'] = 0;
            $response['message'] = 'Successfully updated your Profile.';
        }else{
            $response['error'] = 1;
            $response['message'] = 'Unable to update your Profile.';
        }
        exit(json_encode($response));
    }
    
    
    public function registration() {
        $data = $this->header_footer('User Registration', 'admin.styles');
        $data['content'] = $this->load->view('admin/portal', '', TRUE);
        $this->load->view('admin/main', $data);
    }
    
    public function async_general_search_account(){
        $item = $this->input->post('item');
        $this->m_admin->fetch_general_search_accounts($item);
    }
    
}
