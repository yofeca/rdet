<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Research extends MY_Controller{
        public function __construct() {
        parent::__construct();
        
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->model('m_publications', '', TRUE);
        $this->load->model('m_author','',TRUE);
        $this->load->model('m_files','',TRUE);
        $this->load->helper('url');
    }
    
    
    public function index() {
        $this->preview();
    }

    public function find(){
        $item = trim($this->input->get('name_startsWith'));
        $type = $this->input->get('searchType');
        
        if($item) $item = mysql_real_escape_string($item);
        if($type == 1) $this->m_publications->search_autocomplete($item, $type);
        if($type == 2) $this->m_author->search($item);
    }
    
    
    public function preview($rid = 0){
        if($this->session->userdata('u_id')){
        $data = $this->header_footer(
                'Manage Publications', 
                'admin', 
                array('common','publications', 'u.loggedin', 'ui.jqgrid'),
                array('publications','jquery.jqGrid.min','grid.locale-en','ajaxfileupload'));
        $info['rid'] = $rid;
        $data['content'] = $this->load->view('publication/preview', $info, TRUE);
        $this->load->view('admin/main', $data);
        }else{
            $this->load->view('index');
        }
    }

    
    public function async_autocomplete_search_box(){
        $item = trim($this->input->get('name_startsWith'));
        $type = $this->input->get('searchType');
        
        if($item) $item = mysql_real_escape_string($item);
        if($type == 1) $this->m_publications->search_autocomplete($item, $type);
        if($type == 2) $this->m_author->fetch_name_for_autocomplete($item);
    }
    
    public function print_research_preview(){
        $this->load->view('publication/print_research_preview');
    }
    
    public function async_jq_researches(){
        $this->m_publications->fetch_researches_jq_grid_data();
    }

    public function async_jq_home_researches(){
        $this->m_publications->fetch_researches_jq_home_grid_data();
    }

    
    public function async_research_data(){
        $id = (int) $this->input->post('rid');
        $this->m_publications->fetch_research_data($id);
    }
    
    
    public function async_research_authors(){
        $rid = $this->input->post('rid');
        $this->m_publications->research_authors($rid);
    }
    
    
    public function async_remove_research_authors() {
        $rid = (int) $this->input->post('rid');
        $auid = (int) $this->input->post('auid');
        $this->m_publications->remove_author_published_book($rid, $auid);
    }
    
    
    public function async_research_author_autocomplete(){
        $lastname = trim($this->input->post('lastname'));
        $this->m_author->research_author_autocomplete($lastname);
    }
    
    
    public function async_insert_research_author(){
        $aid = $this->input->post('aid');
        $rid = $this->input->post('rid');
        
        $this->m_publications->insert_research_author($aid, $rid);
    }
    
    
    public function async_insert_new_research(){
        $data = $this->input->post();
        $this->m_publications->insert_new_research($data);
    }
    
    
    public function async_update_research(){
        $data = $this->input->post();
        $this->m_publications->update_research($data);
    }
    
    public function async_delete_research(){
        $rid= $this->input->post('rid');
        $this->m_publications->delete_research($rid);
    }
    
    
    public function async_general_search_title(){
        $item = $this->input->post('item');
        
        $this->m_publications->fetch_general_search_titles($item);
    }
}

//    public function publications(){
//        $data = $this->header_footer(
//                'Home', 
//                'admin', 
//                array('common','css-a-p-list', 'css-a-s-box'),
//                array('js-a-p-list','js-a-main', 'js-a-s-box'), 
//                array('jquery.ui.core', 
//                    'jquery.ui.widget', 
//                    'jquery.ui.button',
//                    'jquery.ui.autocomplete',
//                    'jquery.ui.menu','jquery.ui.position'), 
//                array('jquery.ui.all'));
//        $data['content'] = $this->load->view('publication/list_publications', '', TRUE);
//        $this->load->view('admin/main', $data);
//    }

//    public function validate_list(){
//        if($this->session->userdata('u_id') && $this->session->userdata('u_id'))
//            $this->load->view('publication/vj/a-v-list.php');
//        else
//            echo 'Page Not Found!';
//    }

//    public function preview1($research_id){
//        $research_data['research'] = $this->m_publications->fetch_publication_research_details($research_id);
//        $research_data['author'] = $this->m_publications->fetch_authors($research_id);
//        $data = $this->header_footer(
//                'Preview Research', /* title */ 
//                'admin', /* user type */ 
//                array('common', 'a.pr.research', 'a.u.loggedin'), /* css styles */ 
//                array('a.pr.research'), /* custom jquery files */ 
//                array('jquery.ui.core',
//                    'jquery.ui.widget',
//                    'jquery.ui.mouse',
//                    'jquery.ui.draggable',
//                    'jquery.ui.position',
//                    'jquery.ui.resizable',
//                    'jquery.ui.datepicker',
//                    'jquery.ui.dialog',
//                    'jquery.ui.effect',
//                    'jquery.ui.menu',
//                    'jquery.ui.button',
//                    'jquery.ui.autocomplete'), /* jquery ui files */ 
//                array('jquery.ui.all')); /* jquery ui themes */
//        $data['content'] = $this->load->view('publication/preview_research', $research_data, TRUE);
//        $this->load->view('admin/main', $data);
//    }
//    
//    public function validate_preview(){
//        if($this->session->userdata('u_id') && $this->session->userdata('u_id'))
//            $this->load->view('admin/publication/vj/preview.php');
//        else
//            echo 'Page Not Found!';
//    }

//    public function view_research(){
//        $data = $this->header_footer(
//                'Publication', /* title */ 
//                'admin', /* user type */ 
//                array('common', 'css-a-v-res'), /* css styles */ 
//                array('js-a-v-res'), /* custom jquery files */ 
//                array('jquery.ui.core',
//                    'jquery.ui.widget',
//                    'jquery.ui.mouse',
//                    'jquery.ui.button',
//                    'jquery.ui.draggable',
//                    'jquery.ui.position',
//                    'jquery.ui.resizable',
//                    'jquery.ui.datepicker',
//                    'jquery.ui.button',
//                    'jquery.ui.dialog',
//                    'jquery.ui.effect',
//                    'jquery.ui.menu',
//                    'jquery.ui.autocomplete'), /* jquery ui files */ 
//                array('jquery.ui.all')); /* jquery ui themes */
//
//        $data['content'] = $this->load->view('publication/view_research', '', TRUE);
//        $this->load->view('admin/main', $data);
//    }

//    public function new_research(){
//        $data = $this->header_footer('Publication', /*title*/
//                'admin',/*user type*/
//                array('common','css-a-n-research'),/*css styles*/
//                array('js-a-n-res'),/*custom jquery files*/
//                array('jquery.ui.core', 
//                    'jquery.ui.widget',
//                    'jquery.ui.mouse',
//                    'jquery.ui.button',
//                    'jquery.ui.draggable',
//                    'jquery.ui.position',
//                    'jquery.ui.resizable',
//                    'jquery.ui.datepicker', 
//                    'jquery.ui.button',
//                    'jquery.ui.dialog',
//                    'jquery.ui.effect',
//                    'jquery.ui.menu',
//                    'jquery.ui.autocomplete'),/*jquery ui files*/
//                    array('jquery.ui.all'));/*jquery ui themes*/
//   
//        $data['content'] = $this->load->view('publication/new_research', '', TRUE);
//        $this->load->view('admin/main', $data);
//    }

//    public function insert(){
//        $this->load->view('publication/vj/a-v-n-res','',TRUE);
//    }