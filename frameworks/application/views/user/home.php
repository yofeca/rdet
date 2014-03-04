<div class="container-fluid">
<div class="row-fluid">
    <div class="hidden-xs col-sm-3 col-md-3 col-lg-3">
        <h2>MENU</h2>
        <div class="list-group">
            <a class="list-group-item active" href="<?php echo base_url('user/home'); ?>">Home</a>
            <a class="list-group-item" href="<?php echo base_url('user/publications'); ?>">Publications</a>
            <a class="list-group-item" href="<?php echo base_url('user/authors'); ?>">Authors</a>
            <a class="list-group-item" href="<?php echo base_url('user/about'); ?>">About</a>
        </div>
    </div>

    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" ><!--Contents-->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#international" data-toggle="tab">International Publications</a></li>
            <li><a href="#national" data-toggle="tab">National Publications</a></li>
            <li><a href="#local" data-toggle="tab">Local Publications</a></li>
        </ul>

        <div class="tab-content"><!-- Tab panes -->
            <div class="tab-pane fade in active" id="international"><!-- International Publications -->
                <h4 class="bg-info" style="padding: 5px;">Latest International Publications.</h4>
                <?php
                $results = $this->m_publications->fetch_publications(10, 0, 1);
                ?>
                <table class="table table-responsive table-striped table-hover table-condensed">
                    <tr>
                        <th>Title</th>
                        <th>Author(s)</th>
                        <th>Funding Agency</th>
                        <th>Status</th>
                    </tr>

                    <?php foreach ($results as $data) { ?>

                        <tr>
                            <td>
                                <a href="<?php echo base_url('user/preview_research/0/'. $data->id); ?>">
                                    <?php echo $data->title; ?>
                                </a>
                            </td>

                            <td>
                                <?php
                                $author = $this->m_publications->fetch_uv_research_authors($data->id);

                                if($author){
                                    for ($i = 0; $i < count($author); $i++) {
                                        echo "<a href=" . base_url('user/preview_author/0/' . $author[$i]->id) . ">" . $author[$i]->first_name . " " . $author[$i]->last_name . "</a>";

                                        if ($i < count($author) - 1) {
                                            echo ", ";
                                        }
                                    }
                                }else{
                                    echo "No author(s) for this title.";
                                }
                                ?>
                            </td>

                            <td>
                                <?php echo $data->funding_agency; ?>
                            </td>
                            <td>
                                <?php
                                $d = getdate(strtotime($data->date_completed));

                                if ($data->status == 1)
                                    echo 'Completed (' . $d['month'] . ' ' . $d['mday'] . ', ' . $d['year'] . ")";
                                else
                                    echo 'On-going';
                                ?>
                            </td>
                            <?php
                            echo "</tr>";
                        }
                        ?>
                </table>
            </div><!-- End of International Publications -->

            <div class="tab-pane fade" id="national"><!-- National Publications -->
                <h4 class="bg-info" style="padding: 5px;">Latest National Publications.</h4>
                <?php
                $results = $this->m_publications->fetch_publications(10, 0, 2);
                ?>
                <table class="table table-responsive table-striped table-hover table-condensed">
                    <tr>
                        <th>Title</th>
                        <th>Author(s)</th>
                        <th>Funding Agency</th>
                        <th>Status</th>
                    </tr>

                    <?php foreach ($results as $data) { ?>

                        <tr>
                            <td>
                                <a href="<?php echo base_url('user/preview_research/0/'. $data->id); ?>">
                                    <?php echo $data->title; ?>
                                </a>
                            </td>

                            <td>
                                <?php
                                $author = $this->m_publications->fetch_uv_research_authors($data->id);

                                if($author){
                                    for ($i = 0; $i < count($author); $i++) {
                                        echo "<a href=" . base_url('user/preview_author/0/' . $author[$i]->id) . ">" . $author[$i]->first_name . " " . $author[$i]->last_name . "</a>";

                                        if ($i < count($author) - 1) {
                                            echo ", ";
                                        }
                                    }
                                }else{
                                    echo "No author(s) for this title.";
                                }
                                ?>
                            </td>

                            <td>
                                <?php echo $data->funding_agency; ?>
                            </td>
                            <td>
                                <?php
                                $d = getdate(strtotime($data->date_completed));

                                if ($data->status == 1)
                                    echo 'Completed (' . $d['month'] . ' ' . $d['mday'] . ', ' . $d['year'] . ")";
                                else
                                    echo 'On-going';
                                ?>
                            </td>
                            <?php
                            echo "</tr>";
                        }
                        ?>
                </table>
            </div><!-- End of National Publications -->

            <div class="tab-pane fade" id="local"><!-- Local Publications -->
                <h4 class="bg-info" style="padding: 5px;">Latest Local Publications.</h4>
                <?php
                $results = $this->m_publications->fetch_publications(10, 0, 3);
                ?>
                <table class="table table-responsive table-striped table-hover table-condensed">
                    <tr>
                        <th>Title</th>
                        <th>Author(s)</th>
                        <th>Funding Agency</th>
                        <th>Status</th>
                    </tr>

                    <?php foreach ($results as $data) { ?>

                        <tr>
                            <td>
                                <a href="<?php echo base_url('user/preview_research/0/' . $data->id); ?>">
                                    <?php echo $data->title; ?>
                                </a>
                            </td>

                            <td>
                                <?php
                                $author = $this->m_publications->fetch_uv_research_authors($data->id);

                                if($author){
                                    for ($i = 0; $i < count($author); $i++) {
                                        echo "<a href=" . base_url('user/preview_author/0/' . $author[$i]->id) . ">" . $author[$i]->first_name . " " . $author[$i]->last_name . "</a>";

                                        if ($i < count($author) - 1) {
                                            echo ", ";
                                        }
                                    }
                                }else{
                                    echo "No author(s) for this title.";
                                }
                                ?>
                            </td>

                            <td>
                                <?php echo $data->funding_agency; ?>
                            </td>
                            <td>
                                <?php
                                $d = getdate(strtotime($data->date_completed));

                                if ($data->status == 1)
                                    echo 'Completed (' . $d['month'] . ' ' . $d['mday'] . ', ' . $d['year'] . ")";
                                else
                                    echo 'On-going';
                                ?>
                            </td>
                            <?php
                            echo "</tr>";
                        }
                        ?>
                </table>
            </div><!-- End of Local Publications -->
        </div><!-- End of Tab Panes -->

    </div><!--End of contents-->
</div><!--End of row-fluid-->
</div>