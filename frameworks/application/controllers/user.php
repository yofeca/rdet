<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('m_publications', '', TRUE);
        $this->load->model('m_author', '', TRUE);
        $this->load->model('m_files', '', TRUE);
    }

    public function index() {
        $this->home();
    }

    public function home() {
        $data = $this->header_footer(
                'Home', 'user', array('myStyle'), array('u-h-js', 'u-s-b-js'));
        $data['bar_title'] = 'HOME (List Of Pubications)';
        $data['content'] = $this->load->view('user/home', '', TRUE);
        $this->load->view('user/main', $data);
    }

    public function list_publications() {
        $this->load->view('user/view_list_of_titles');
    }

    public function preview_research( $option=3, $research_id= "0" ) {
    	if($option != 3 && $research_id != "0"){
        	if( $option == 1 ){
        		$research_data['research'] = $this->m_publications->fetch_research_search($research_id);

        		if($research_data['research']){
            		$research_data['author'] = $this->m_publications->fetch_authors($research_data['research']->id);
                    $content = $this->load->view('user/preview_research', $research_data, TRUE);
                }else{
                    $content = $data['content'] = $this->load->view('user/preview_research_empty', '', TRUE);
                }
        	}else{
            	$research_data['research'] = $this->m_publications->fetch_research($research_id);
            	$research_data['author'] = $this->m_publications->fetch_authors($research_id);
                $content = $this->load->view('user/preview_research', $research_data, TRUE);
        	}

        	$data = $this->header_footer(
                    'Preview Research', /* title */ 'user', /* user type */ array('myStyle'), /* css styles */ array('u-v-r')); /* jquery ui themes */
        	$data['content'] = $content;
            $this->load->view('user/main', $data);
        }else{
            $this->load->view('index');
        }
    }

    public function preview_author($option=3, $author_id="0") {
        if( $option !=3 && $author_id != "0" ){

            if($option == 1){
                $info['author'] = $this->m_author->fetch_author_search($author_id);

                if($info['author']){
                    $info['research'] = $this->m_publications->fetch_author_published($info['author']->id);
                    $content = $this->load->view('user/preview_author', $info, TRUE);
                }else{
                    $content = $this->load->view('user/preview_author_empty', '', TRUE);
                }

            }else{
                $info['author'] = $this->m_author->fetch_author((int)$author_id);
                $info['research'] = $this->m_publications->fetch_author_published((int)$author_id);
                $content = $this->load->view('user/preview_author', $info, TRUE);
            }

            $data = $this->header_footer(
                    'Author', 'user', array('myStyle'), array('u-s-b-js', 'js-a-p-author'));
            $data['content'] = $content;
            $this->load->view('user/main', $data);
        }else{
            $this->load->view('index');
        }
    }

    public function preview_publications($author_id = 0) {
        $info['author'] = $this->m_author->fetch_author($author_id);

        if ($author_id == 0) {
            $auid = $this->m_author->fetch_author_first_row();
            $author_id = $auid->id;
        }

        $info['research'] = $this->m_publications->fetch_author_published($author_id);

        $data = $this->header_footer(
                'Author', /* title */ 'user', /* user type */ array('myStyle'), /* css styles */ array('u-s-b-js', 'js-a-p-author'));
        $data['content'] = $this->load->view('user/list_publications', $info, TRUE);
        $this->load->view('user/main', $data);
    }

    public function about() {
        $data = $this->header_footer(
                'Home', 'user', array('myStyle'), array('u-h-js', 'u-s-b-js'));
        $data['bar_title'] = 'ABOUT US';
        $data['content'] = $this->load->view('user/about', '', TRUE);
        $this->load->view('user/main', $data);
    }

    public function publications() {
        $data = $this->header_footer(
                'Publications', 'user', array('myStyle'), array('user-publications'));
        $data['content'] = $this->load->view('user/publications', '', TRUE);
        $this->load->view('user/main', $data);
    }
    
    public function authors() {
        $data = $this->header_footer(
                'Authors', 'user', array('myStyle'), array('user-authors'));
        $data['content'] = $this->load->view('user/authors', '', TRUE);
        $this->load->view('user/main', $data);
    }
}

?>
