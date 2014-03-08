<html>
    <head>
        <title>Print - Research Preview</title>
        <style>
            <?php echo '@import url("' . base_url('media/css/a/print-research-preview.css') . '");'; ?>
        </style>
    </head>
    <body>
        <div id="header">
            <div id="ifsu-logo"><img src="<?php echo base_url('media/image/ifsu-logo.png')?>"/></div>
            <div id="ifsu-name">
                <span class="ifsu">IFUGAO STATE UNIVERSITY</span><br>
                <span class="ifsu-add">Nayon, Lamut, Ifugao</span><br>
                <span class="ifsu-rdet">Research and Development, Extension and Training</span>
            </div>
        </div>
        <div style="clear: both;"></div>
        <hr>
        <div id="list-of-researches">
            <?php $items = $this->m_publications->fetch_print_preview_table_data(); ?>
            
            <table border="1">
                <caption>LIST OF RESEARCHES <button id="print" onClick="window.print()">Print</button><a id="home-link" href="<?php echo base_url('research/preview');?>">Back</a></caption>
                <tr>
                    <th>No.</th>
                    <th>Research Title</th>
                    <th>Author(s)</th>
                    <th>Funding Agency</th>
                    <th>Date Completed</th>
                </tr>
                
                <?php for($i = 0, $t = count($items->rows); $i < $t; $i++){?>
                    <tr>
                        <?php for($j = 0, $tt = count($items->rows[$i]['cell']); $j < $tt; $j++){ ?>
                        <?php   if($j==2){ ?>
                                    <td>
                                        <?php
                                            for($y = 0, $ttt = count($items->rows[$i]['cell'][$j]); $y < $ttt; $y++){
                                                
                                                echo "- ".$items->rows[$i]['cell'][$j][$y][0][0]->first_name . " ";
                                                
                                                if($items->rows[$i]['cell'][$j][$y][0][0]->middle_name == "_")
                                                    echo " ";
                                                else
                                                    echo $items->rows[$i]['cell'][$j][$y][0][0]->middle_name . " ";
                                                
                                                echo $items->rows[$i]['cell'][$j][$y][0][0]->last_name;
                                                echo "<br/>";
                                            }
                                            //print_r($items->rows[$i]['cell'][2]);
                                        ?>
                                    
                                    </td>
                        <?php } else{ ?>
                                    <td><?php echo $items->rows[$i]['cell'][$j] ?></td>
                        <?php } ?>
                        <?php } ?>
                    </tr>
                <?php } ?>
                    <tr><td colspan="9">
                            <ul class="pagination">
                        <?php for($k = 1; $k < $items->total+1; $k++){?>
                                <li><a href="<?php echo base_url('research/print_research_preview/?page='.$k); ?>"><?php echo "Page ". $k; ?></a></li>
                        <?php } ?>
                            </ul>
                    </td></tr>
            </table>
        </div>
    </body>
</html>