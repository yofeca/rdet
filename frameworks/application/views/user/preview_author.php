<div class="container">
    <div class="row-fluid">
        <div class="hidden-xs col-sm-3 col-md-2 col-lg-2">
            <h2>MENU</h2>
            <div class="list-group">
                <a class="list-group-item" href="<?php echo base_url('user/home'); ?>">Home</a>
                <a class="list-group-item" href="<?php echo base_url('user/publications'); ?>">Publications</a>
                <a class="list-group-item active" href="<?php echo base_url('user/authors'); ?>">Authors</a>
                <a class="list-group-item" href="<?php echo base_url('user/about'); ?>">About</a>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-md-offset-1">
            <?php $type = ''; ?>

            <h4 style="margin-left: -15px;">Personal Information:</h4>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">First name:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="text" class="form-control" disabled placeholder=".col-xs-3" value="<?php echo $author->first_name; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Middle name:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="text" class="form-control" disabled placeholder=".col-xs-3" value="<?php echo $author->middle_name; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Last name:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="text" class="form-control" disabled placeholder=".col-xs-3" value="<?php echo $author->last_name; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Sex:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="text" class="form-control" disabled placeholder=".col-xs-3" value="<?php echo ucfirst(strtolower($author->sex)); ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                if ($author->type == 1)
                    $type = 'Faculty';
                if ($author->type == 2)
                    $type = 'Student';
                if ($author->type == 3)
                    $type = 'Community';
                ?>

                <div class="form-group">
                    <label class="col-xs-4 col-sm-4 col-md-4 control-label">Type:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="text" class="form-control" disabled placeholder=".col-xs-3" value="<?php echo $type; ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4 col-md-4 col-md-offset-1">
            <h4>Published researches: </h4>
            <?php if($research){ ?>
            <ol>
                <?php
                foreach ($research as $row) {
                    $published = $this->m_publications->fetch_research($row->research_id);

                    echo '<li>';
                    echo '<a href="' . base_url('user/preview_research/0/' . $published->id) . '">' . $published->title . '</a>';

                    if ($published->status == 1) {
                        $d = getdate(strtotime($published->date_completed));
                        echo '<p><i>Completed: </i>' . $d['month'] . ' ' . $d['mday'] . ', ' . $d['year'] . '| Published: ' . $published->year_published . '</p>';
                    } else
                        echo '<p><i>Status:</i> On-going</p>';

                    echo '</li>';
                    ?>
            <?php } ?>
            </ol>
            <?php }else{ echo "<p>No research attached to this author</p>"; } ?>
        </div>
    </div>
</div>