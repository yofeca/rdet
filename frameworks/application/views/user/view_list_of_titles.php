<?php
$data['filter_by_status'] = $this->input->post('filter_by_status');
$data['filter_by_presentation'] = $this->input->post('filter_by_presentation');

$query = $this->m_publications->get_publication_list($data);

if ($query) {
    $alt = 0; $class = ''; $au = '';
    $response = array();

    $response[] = '<div id="list"><table>';
//    $response[] = '<caption>LIST OF TITLES</caption>';
//    $response[] = '<tr>
//                       <th>Research Title</th>
//                       <th>Author(s)</th>
//                       <th class="agency">Funding Agency</th>
//                       <th>Status</th>
//                   </tr>';

    foreach ($query->result() as $row) {
        
        if ($row->status == 1)
            $status = 'completed';
        else
            $status = 'on-going';
        
        if($alt % 2 == 1) 
            $class = 'class="alt"';
        else 
            $class ='';
        
        $response[] = '<tr '.$class.'>';
        $response[] = '<td><a href="'. base_url('user/preview_research/'.$row->id). '">' . $row->title . '</a></td>';
        
            $authors = $this->m_publications->fetch_authors($row->id);
                for ($ctr = 0; $ctr < sizeof($authors); $ctr++) {
                    foreach ($authors[$ctr] as $author) {
                        $au .= $author[0]->first_name . " " . $author[0]->last_name . ", ";
                    }
            }
            $response[] = '<td>'.$au.'</td>';
            $au='';
        
        $response[] = '<td>' . $row->funding_agency . '</td>';
        $response[] = '<td>' . $status . '</td>';
        $response[] = '</tr>';
        
        $alt++;
    }
    $response[] = '</table></div>';

    if (count($response))
        $response = implode('', $response);
} else
    $response = 'No result(s) found.';

echo $response;
