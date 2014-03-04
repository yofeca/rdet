<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class MY_Controller extends CI_Controller{
        
        public function __construct() {
            
            parent::__construct();
            
            $this->header_footer['header'] = $this->load->view('header','',TRUE);
            
            $this->header_footer['footer'] = $this->load->view('footer','',TRUE);
        }
        
        public function header_footer($title = '',
                                      $user = '',
                                      $css_styles = array(), 
                                      $c_jq_files = array()
//                                      $jq_ui_files = array(),
//                                      $jq_ui_themes = array()
                                     ) {
            
            $data['pageTitle'] = $title;
            $data['user'] = $user;
            $data['css_styles'] = $css_styles;
            $data['c_jq_files'] = $c_jq_files;
//            $data['jq_ui_files'] = $jq_ui_files;
//            $data['jq_ui_themes'] = $jq_ui_themes;
            
            if($data['user'] == 'user'){
                $response['header'] = $this->load->view('user/header',$data,TRUE);
                $response['footer'] = $this->load->view('user/footer','',TRUE); 
            }else{
                $response['header'] = $this->load->view('header',$data,TRUE);
                $response['footer'] = $this->load->view('footer','',TRUE);
            }
            return $response;
        }
    }
?>
