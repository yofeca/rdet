<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" />
        <style>
            <?php 
                echo '@import url("'.base_url('media/css/jquery-ui-1.10.3.custom.min.css').'");' . "\n\t\t\t";
                
            ?>
            <?php //import custom css styles
                if ($user == 'admin'){
                    if(sizeof($css_styles) != 0){
                        for($ctr = 0; $ctr<sizeof($css_styles); $ctr++){
                            echo '@import url("'. base_url('media/css/a/' . $css_styles[$ctr] . '.css').'");'."\n\t\t\t";
                        }
                    }
                }
                
                if($user == 'user'){
                    if(sizeof($css_styles) != 0){
                        for($ctr = 0; $ctr<sizeof($css_styles); $ctr++){
                            echo '@import url("'. base_url('media/css/u/' . $css_styles[$ctr] . '.css').'");';
                        }
                    }
                }
            
            //import jquery ui themes
//                if(sizeof($jq_ui_themes)!=0){
//                    for($ctr = 0; $ctr<sizeof($jq_ui_themes); $ctr++){
//                        echo '@import url("'. base_url('media/css/themes/base/' . $jq_ui_themes[$ctr] . '.css').'");'."\n\t\t\t";
//                    }
//                }
            ?>
        </style>
        
        <script type="text/javascript" src="<?php echo base_url('media/js/jquery-1.7.2.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('media/js/jquery-ui-1.10.3.custom.min.js') ?>"></script>
        
                
        <?php 
            //import custom jquery and ajax files
            if(sizeof($c_jq_files) !=0){
                for($ctr = 0; $ctr < sizeof($c_jq_files); $ctr++){
                    echo '<script type="text/javascript" src="' . base_url('media/js/jqcustom/' . $c_jq_files[$ctr] . '.js') . '"></script>' ."\n\t\t";
                }
            }
            
//            //import jquery ui files
//            if(sizeof($jq_ui_files) != 0) {
//                for ($ctr = 0; $ctr < sizeof($jq_ui_files); $ctr++) {
//                    echo '<script type="text/javascript" src="' . base_url('media/js/ui/' . $jq_ui_files[$ctr]) . '.js' . '"></script>'."\n\t\t";
//                }
//            }
        ?>
        <title><?php echo $pageTitle ?></title>
    </head>
    
    <body>

    <div id="wrapper">
