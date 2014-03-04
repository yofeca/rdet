<div class="container-fluid">
    <div class="row-fluid">
        <div class="hidden-xs col-sm-3 col-md-3 col-lg-3">
            <h2>MENU</h2>
            <div class="list-group">
                <a class="list-group-item" href="<?php echo base_url('user/home'); ?>">Home</a>
                <a class="list-group-item" href="<?php echo base_url('user/publications'); ?>">Publications</a>
                <a class="list-group-item active" href="<?php echo base_url('user/authors'); ?>">Authors</a>
                <a class="list-group-item" href="<?php echo base_url('user/about'); ?>">About</a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <?php $items = $this->m_author->fetch_author_table_data();?>
            
            <h3>List of Authors:</h3>
            <table class="table table-responsive table-striped table-condensed table-hover table-bordered">
                <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Sex</th>
                </tr>
                <?php for($i = 0; $i < count($items->rows); $i++){?>
                    <tr>
                        <?php for($j = 1; $j < count($items->rows[$i]['cell']); $j++){ ?>
                            <?php if($j == 1){ ?>
                                <td><a href="<?php echo base_url('user/preview_author/0/'.$items->rows[$i]['id']); ?>"><?php echo $items->rows[$i]['cell'][1] ?></a></td>
                            <?php continue; } ?>
                                <td><?php echo $items->rows[$i]['cell'][$j] ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                    <tr><td colspan="9" style="text-align: center;">
                            <ul class="pagination">
                        <?php for($k = 1; $k < $items->total+1; $k++){?>
                                <li><a href="<?php echo base_url('user/authors/?page='.$k); ?>"><?php echo "Page ". $k; ?></a></li>
                        <?php } ?>
                            </ul>
                    </td></tr>
            </table>
        </div>
    </div>
</div>