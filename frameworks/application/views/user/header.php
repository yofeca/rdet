<?php
$name = $this->input->get('search-name');
$title = $this->input->get('title');
$option = $this->input->get('search-option');
echo $options;
if($name && $option){
    if($option == 'last_name'){
        redirect(base_url('user/preview_author/1/' . $name));
    }else if($option == 'first_name'){
        redirect(base_url('user/preview_author/2/' . $name));
    }else{
        redirect(base_url('user/preview_author/3/' . $name));
    }
}
if($title && !$option)
    redirect(base_url('user/preview_research/1/' . $title));

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
                        <span><img src="<?php echo base_url('media/image/ifsu-logo.png'); ?>" style="width: 40px; margin: -15px 10px; padding: 0;"/></span> RD
                    </a>
                </div>


                <div class="collapse navbar-collapse" id="top-navigations">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo base_url('user/home'); ?>">Home</a></li>
                        <li><a class="ref_pub" href="<?php echo base_url('user/publications'); ?>">Publications</a></li>
                        <li><a class="ref_au" href="<?php echo base_url('user/authors'); ?>">Authors</a></li>
                        <li><a href="<?php echo base_url('user/about'); ?>">About</a></li>
                    </ul>
                    <form class="navbar-form navbar-right" role="search">
                        <input type="text" class="form-control" placeholder="Search" id="s-title" name="title" style="width: 250px"/>
                        <input type="text" class="form-control" placeholder="Search" id="s-name" name="search-name" style="width: 250px"/>
                        <div class="btn-group">
                            <select name="search-option" class="form-control" style="width: 150px; ">
                                <option value="last_name">Last Name</option>
                                <option value="first_name">First Name</option>
                                <option value="middle_name">Middle Name</option>
                            </select>
<!--                            <select name="search-option" class="form-control" style="width: 150px; ">
                                <option value="title">Title</option>
                                <option value="author">Author</option>
                            </select>-->
                        </div>
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
<!--                        <a class="btn btn-success" data-toggle="modal" data-target="#myModal">Advance Search</a>-->
                    </form>

                </div>
            </div>
        </nav>
        
        
        
<!--        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Advance Search</h4>
                    </div>
                    <div class="modal-body">
                        Search Options:<br/>
                        <input type="radio" name="options" value="name">Search Author Name
                        <input type="radio" name="options" value="title">Search Titles
                        <input type="radio" name="options" value="filter">Filter Titles<br/>
                        
                        <select name="status">
                            <option value="0">Select Status:</option>
                            <option value="1">Completed</option>
                            <option value="2">Published</option>
                            <option value="3">Conducted</option>
                            <option value="4">Presented</option>
                        </select>
                        <select name="sel_name">
                            <option value="0">Select Name:</option>
                            <option value="last_name">Last Name</option>
                            <option value="first_name">First Name</option>
                            <option value="middle_name">Middle Name</option>
                        </select>
                        <div id="filter_name">
                            <input type="checkbox" name="last_name" value="last_name">Last Name
                            <input type="checkbox" name="first_name" value="last_name">First Name
                            <input type="checkbox" name="middle_name" value="last_name">Middle Name
                        </div>
                        
                        <div id="name_boxes">
                            <label for="lname" class="lname">Last Name:</label>
                            <input type="text" name="tx-lname" value="" class="lname"/><br/>
                            <label for="lname" class="fname">First Name:</label>
                            <input type="text" name="tx-fname" value="" class="fname"/><br/>
                            <label for="lname" class="mname">Middle Name:</label>
                            <input type="text" name="tx-mname" value="" class="mname"/>
                        </div>
                        <br />
                        <p id="err-selection"></p>
                        <div id="srch">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search_item">
                            </div> /input-group 
                        </div>
                        <div id="filter">
                            <div><strong>Level of Publication:</strong><br/>
                                <input type="radio" name="lo_type" value="1"> International
                                <input type="radio" name="lo_type" value="2"> National
                                <input type="radio" name="lo_type" value="3"> Local
                            </div>
                            <br/>
                            <div><strong>Researchers:</strong><br/>
                                <input type="radio" name="res" value="1">Faculty
                                <input type="radio" name="res" value="2">Students
                                <input type="radio" name="res" value="3">Community
                            </div>
                            <br/>
                            <div><strong>Level of Presentation:</strong><br/>
                                <input type="radio" name="lo_pres" value="1">International Fora
                                <input type="radio" name="lo_pres" value="2">National Fora
                                <input type="radio" name="lo_pres" value="3">Local Fora
                            </div>
                            <br/>
                            <div><strong>Status:</strong><br/>
                                <input type="radio" name="stat" value="1">Completed
                                <input type="radio" name="stat" value="2">Published
                                <input type="radio" name="stat" value="3">Conducted
                                <input type="radio" name="stat" value="4">Presented
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="button" name="submit_filter">Submit</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="button" name="srch_rec">Search <span class="glyphicon glyphicon-search"></span></button>
                                                <button type="button" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>-->

