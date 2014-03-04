<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Author extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('m_author', '', TRUE);
        $this->load->model('m_publications', '', TRUE);
        $this->load->helper('url');
    }

    
    public function index() {
        $this->preview();
    }

    
    public function search() {
        $item = trim($this->input->get('name_startsWith'));
        if ($item)
            $item = mysql_real_escape_string($item);

        $this->m_author->search($item);
    }

    
    public function preview() {
        if($this->session->userdata('u_id')){
        $data = $this->header_footer(
                'Author', /* title */ 
                'admin', /* user type */ 
                array('common', 'author', 'u.loggedin','ui.jqgrid'), /* css styles */ 
                array('author', 'grid.locale-en', 'jquery.jqGrid.min'));
        $data['content'] = $this->load->view('author/preview_author', '', TRUE);
        $this->load->view('admin/main', $data);
        }else{
            $this->load->view('index');
        }
    }

    
    public function async_jq_grid_authors() {
        $this->m_author->fetch_author_jq_grid_data();
    }

    
    public function async_display_author_details() {
        $id = (int) $this->input->post('pid');
        $this->m_author->fetch_author_data($id);
    }

    
    public function async_author_published_books() {
        $id = (int) $this->input->post('pid');
        $this->m_publications->fetch_author_published_books($id);
    }

    
    public function async_author_published_books_details() {
        $author_id = (int) $this->input->post('auid');
        $this->m_publications->fetch_research_details($author_id);
    }

    
    public function async_author_pid() {
        $this->m_author->fetch_author_person_id();
    }

    
    public function async_author_autocomplete_box() {
        $item = $this->input->post('item');
        $category = (int) $this->input->post('category');
        $this->m_author->fetch_name_for_autocomplete($item, $category);
    }

    
    public function async_author_remove_published_book() {
        $rid = (int) $this->input->post('rid');
        $pid = (int) $this->input->post('pid');
        $auid = $this->m_author->fetch_author_id($pid);
        $this->m_publications->remove_author_published_book($rid, $auid);
    }
    
    
    public function async_author_insert_research_title(){
        $rid = $this->input->post('rid');
        $pid = $this->input->post('pid');
        
        $this->m_publications->insert_research_title($rid, $pid);
    }
    
    
    public function async_i_o_u_author(){
        $data = $this->input->post();
        $this->m_author->insert_update_author($data);
    }
    
    
    public function async_delete_author(){
        $auid = $this->input->post('auid');
        $pid = $this->input->post('pid');
        
        $this->m_author->delete_author($auid, $pid);
    }
    
    
    public function async_research_title_autocomplete(){
        $item = trim($this->input->post('item'));
        $this->m_publications->search_research_title_autocomplete($item);
    }
    
    
    public function async_remove_author(){
        $auid= $this->input->post('auid');
        $this->m_publications->delete_research_author($auid);
    }
    
    public function async_general_search_author(){
        $item = $this->input->post('item');
        $this->m_author->fetch_general_search_authors($item);
    }
}

//    public function insert() {
//        $this->load->view('publication/vj/v-n-res', '', TRUE);
//    }