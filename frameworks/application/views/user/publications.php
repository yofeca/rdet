<div class="container-fluid no-print">
    <div class="row-fluid">
        <div class="hidden-xs col-sm-2 col-md-2 col-lg-2">
            <h2>MENU</h2>
            <div class="list-group">
                <a class="list-group-item" href="<?php echo base_url('user/home'); ?>">Home</a>
                <a class="list-group-item active ref_pub" href="<?php echo base_url('user/publications'); ?>">Publications</a>
                <a class="list-group-item ref_au" href="<?php echo base_url('user/authors'); ?>">Authors</a>
                <a class="list-group-item" href="<?php echo base_url('user/about'); ?>">About</a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10" style="overflow-x: auto !important;">
            <?php $items = $this->m_publications->fetch_table_data(); ?>

            <h3>List of Researches</h3>
<!--            <button class="btn btn-group-sm btn-success" data-toggle="modal" data-target="#print-pub"><span>Print</span></button>-->

            <div class="table-responsive table-condensed table-hover table-striped">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Funding Agency</th>
                            <th>Researchers</th>
                            <th>Venue</th>
                            <th>Fora</th>
                            <th>Date of Presentation</th>
                            <th>Level of Publication</th>
                            <th>Research Books</th>
                            <th>Research Type</th>
                            <th>Level of Presentation</th>
                            <th>Status</th>
                            <th>Date Completed</th>
                            <th>Year Published</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php $colwidth = array(500, 150, 30, 80, 30, 30, 30, 30, 30, 30, 25, 80, 15); ?>
                        <?php for ($i = 0, $trows = count($items->rows); $i < $trows; $i++) { ?>
                            <tr>
                                <?php for ($j = 1; $j < count($items->rows[$i]['cell']); $j++) { ?>
                                    <?php if ($j == 1) { ?>
                                        <td style="min-width: <?php echo $colwidth[$j - 1] . "px;" ?>"><a href="<?php echo base_url('user/preview_research/0/' . $items->rows[$i]['id']); ?>"><?php echo $items->rows[$i]['cell'][1] ?></a></td>
                                        <?php continue;
                                    }
                                    ?>
                                    <td style="min-width: <?php echo $colwidth[$j - 1] . 'px;' ?>"><?php echo $items->rows[$i]['cell'][$j]; ?></td>
                                    
                            <?php } ?>
                            </tr>
<?php } ?>
                        <tr><td colspan="13" style="text-align: left;">

                                <ul class="pagination">
                                    <li><span>Pages:</span></li>
                                    <?php for ($k = 1; $k < $items->total + 1; $k++) { ?>
                                        <li><a href="<?php echo base_url('user/publications/?page=' . $k); ?>"><?php echo $k; ?></a></li>
<?php } ?>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="print-pub">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header no-print">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Print Preview</h4>
            </div>
            <div class="modal-body">

                <div id="header">
                    <div id="ifsu-logo"><img src="<?php echo base_url('media/image/ifsu-logo.png') ?>"/></div>
                    <div id="ifsu-name">
                        <span class="ifsu">IFUGAO STATE UNIVERSITY</span><br>
                        <span class="ifsu-add">Nayon, Lamut, Ifugao</span><br>
                        <span class="ifsu-rdet">Research and Development, Extension and Training</span>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <hr>
                <?php $items = $this->m_publications->fetch_table_data(); ?>

            <h3 class="no-print">List of Researches</h3>

            <div class="table-responsive table-condensed table-hover table-striped">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author(s)</th>
                        </tr>
                    </thead>
                    <tbody> 
                        
                        <?php for ($i = 0, $trows = count($items->rows); $i < $trows; $i++) { ?>
                            <tr>
                                <?php for ($j = 1; $j < 3; $j++) { ?>
                                    <?php if ($j == 1) { ?>
                                        <td style="min-width: 400px;"><?php echo $items->rows[$i]['cell'][1] ?></td>
                                        <?php continue;
                                    }
                                    ?>
                                        
                                        <td>
                                            <?php $author = $this->m_publications->fetch_authors($items->rows[$i]['id']); ?>
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
                                        </td>
<!--                                    <td style="min-width: <?php echo $colwidth[$j - 1] . 'px;' ?>"><?php echo $items->rows[$i]['cell'][$j]; ?></td>-->
                            <?php } ?>
                            </tr>
<?php } ?>
                        
                    </tbody>
                </table>
            </div>

            </div>
            <div class="modal-footer no-print">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="print-print" onClick="window.print()">Print</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->