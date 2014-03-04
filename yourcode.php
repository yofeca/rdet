<?php

$page = (int) $_GET['page'];
if(! $page) $page = 1;

/*
 $total = 23; (Records)
 $rpp = 5; // Record per page
 $number_of_pages = 23/5
*/

mysql_connect('localhost', 'root', 'qwerty');
mysql_select_db('jqgrid');

$sql = "SELECT * FROM users";
$result = mysql_query($sql);

if($result) {
    
    $response = new stdClass;
    $x = 0;
    $response->total = mysql_num_rows($result);
	
	$rpp = 1;
	$number_of_pages = ceil($response->total / $rpp);
	
	$start = ($page - 1) * $rpp;
	
	
	// SELECT * FROM users LIMIT 10,5
	
	$sql .= " LIMIT " . $start . "," . $rpp;
	$result = mysql_query($sql);
	print_r($result);
	// LIMIT 5,5
	
    while($row = mysql_fetch_object($result)) {
        
        $response->rows[$x]['id'] = $row->id;
            
        $response->rows[$x]['cell'] = array(
            $row->id,
            date('M d, Y h:i A', strtotime($row->created)),
            $row->firstname,
            $row->lastname
        );

        $x++;
    }
	
	/*while($row = mysql_fetch_assoc($result)) {
        
        $response->rows[$x]['id'] = $row['id'];
            
        $response->rows[$x]['cell'] = array(
            $row['id'],
            date('M d, Y h:i A', strtotime($row['created'])),
            $row['firstname'],
            $row['lastname']
        );

        $x++;
    }*/
	
    echo json_encode($response);
}