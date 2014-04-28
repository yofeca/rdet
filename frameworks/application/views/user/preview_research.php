<div class="container">
    <div class="row-fluid">
        <div class="hidden-xs col-sm-3 col-md-3 col-lg-3">
            <h2>MENU</h2>
            <div class="list-group">
                <a class="list-group-item" href="<?php echo base_url('user/home'); ?>">Home</a>
                <a class="list-group-item active" href="<?php echo base_url('user/publications'); ?>">Publications</a>
                <a class="list-group-item" href="<?php echo base_url('user/authors'); ?>">Authors</a>
                <a class="list-group-item" href="<?php echo base_url('user/about'); ?>">About</a>
            </div>
        </div>
        <div class="col-sm-4 col-md-5 col-lg-5">
            <h4 style="margin-left: -15px; border-bottom: 1px solid #000;">Research Information:</h4>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Title of Research:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8" >
                        <textarea class="form-control" disabled id="research-title"><?php echo $research->title ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Funding Agency:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="text" class="form-control" disabled value="<?php echo $research->funding_agency; ?>">
                    </div>
                </div>
            </div>
            <?php
            if ($research->publication_type == 1)
                $type = 'International';
            else if ($research->publication_type == 2)
                $type = 'International';
            else if ($research->publication_type == 3)
                $type = 'International';
            else
                $type = '';
            ?>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Level of Publication:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="text" class="form-control" disabled value="<?php echo $type; ?>">
                    </div>
                </div>
            </div>
            <?php
            if ($research->research_books == 1)
                $type = 'Social Researches';
            else if ($research->research_books == 2)
                $type = 'Upland Farm Journal';
            else
                $type = '';
            ?>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Research Books:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="text" class="form-control" disabled value="<?php echo $type; ?>">
                    </div>
                </div>
            </div>
            <?php
            if ($research->research_type == 1)
                $type = 'Faculty';
            else if ($research->research_type == 2)
                $type = 'Student w/ Faculty';
            else if ($research->research_type == 3)
                $type = 'Community';
            else
                $type = '';
            ?>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Research Type:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="text" class="form-control" disabled value="<?php echo $type; ?>">
                    </div>
                </div>
            </div>
            <?php
            if ($research->presentation == 1)
                $type = 'International Fora';
            else if ($research->presentation == 2)
                $type = 'National Fora';
            else if ($research->presentation == 3)
                $type = 'Local Fora';
            else
                $type = '';
            ?>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Level of Presentation:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="text" class="form-control" disabled value="<?php echo $type; ?>">
                    </div>
                </div>
            </div>
            <?php
            if ($research->status == 1){
                $d = getdate(strtotime($research->date_completed));
                $type = 'Completed (' . $d['month'] . " " . $d['mday'] . ", " . $d['year'] . ') | Published (' . $research->year_published . ')';
            }else if ($research->status == 2)
                $type = 'Ongoing';
            else
                $type = '';
            ?>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Status:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input style="font-size: 12px;" type="text" class="form-control" disabled value="<?php echo $type; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Author(s):</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <?php if($author){ ?>
                            <ul class="list-group">
                                <?php
                                    for ($ctr = 0; $ctr < sizeof($author); $ctr++) {
                                        foreach ($author[$ctr] as $row) {
                                            echo '<li class="list-group-item"><a href=" ' . base_url('user/preview_author/0/' . $row[0]->id) . '">' . $row[0]->last_name . ', ' . $row[0]->first_name . ', ' . $row[0]->middle_name . '</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                            <?php }else{echo '<li class="list-group-item">No author(s) for this title.</li>';} ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4 col-md-4 col-lg-4">
            <h4 style="border-bottom: 1px solid #000;">Attachments:</h4>

<?php $files = $this->m_files->get_user_files($research->id); ?>
                        <?php if (isset($files) && count($files)) { ?>
                        <table class="table table-striped table-hover table-responsive table-bordered">
                            <tr><th>File Name</th><th>Size</th></tr>
                        <?php foreach ($files as $file) { ?>
                                <tr>
                                    <td><a style="margin-left: 5px;" href="<?php echo base_url('files/' . $file->filename); ?>"><?php echo $file->title ?></a></td>
                                    <td><?php echo $file->filesize . ' KB' ?></td>
                                </tr>
                        <?php } ?>
                        </table>
                        <?php } else { ?>
                        <p>No attachments uploaded.</p>
                        <?php } ?>
            </div>
        </div>
    </div>
</div>

