<?php 
	$item = $this->input->get('search-item');
	$option = $this->input->get('search-option');

	if( $option=="title" )
		redirect(base_url('user/preview_research/1/'. $item));
	if( $option=="author" )
		redirect(base_url('user/preview_author/1/'. $item ));
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" />
        <style>
<?php
echo '@import url("' . base_url('media/css/jquery-ui-1.10.3.custom.min.css') . '");' . "\n\t\t\t";
echo '@import url("' . base_url('media/css/bootstrap.min.css') . '");' . "\n\t\t\t";
echo '@import url("' . base_url('media/css/bootstrap-responsive.min.css') . '");' . "\n";
?>
<?php
//import custom css styles
if ($user == 'admin') {
    if (sizeof($css_styles) != 0) {
        for ($ctr = 0; $ctr < sizeof($css_styles); $ctr++) {
            echo '@import url("' . base_url('media/css/a/' . $css_styles[$ctr] . '.css') . '");' . "\n\t\t\t";
        }
    }
}

if ($user == 'user') {
    if (sizeof($css_styles) != 0) {
        for ($ctr = 0; $ctr < sizeof($css_styles); $ctr++) {
            echo '@import url("' . base_url('media/css/u/' . $css_styles[$ctr] . '.css') . '");';
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
        <script type="text/javascript" src="<?php echo base_url('media/js/bootstrap.min.js') ?>"></script>


        <?php
        //import custom jquery and ajax files
        if (sizeof($c_jq_files) != 0) {
            for ($ctr = 0; $ctr < sizeof($c_jq_files); $ctr++) {
                echo '<script type="text/javascript" src="' . base_url('media/js/jqcustom/' . $c_jq_files[$ctr] . '.js') . '"></script>' . "\n\t\t";
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

    <body style="background: #FFF;">
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-navigations">
                        <span class="sr-only">Toggle Top Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="<?php echo base_url('user/home'); ?>">
                        <span><img src="<?php echo base_url('media/image/ifsu-logo.png'); ?>" style="width: 40px; margin: -15px 10px; padding: 0;"/></span> RDET
                    </a>
                </div>


                <div class="collapse navbar-collapse" id="top-navigations">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo base_url('user/home'); ?>">Home</a></li>
                        <li><a href="<?php echo base_url('user/publications'); ?>">Publications</a></li>
                        <li><a href="<?php echo base_url('user/authors'); ?>">Authors</a></li>
                        <li><a href="<?php echo base_url('user/about'); ?>">About</a></li>
                    </ul>
                    <form class="navbar-form navbar-right" role="search">
                        <input type="text" class="form-control" placeholder="Search" name="search-item" style="width: 250px"/>
                        <div class="btn-group">
                            <select name="search-option" class="form-control" style="width: 150px; ">
                            	<option value="title">Title</option>
                            	<option value="author">Author</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>

                </div>
            </div>
    </nav>
        

