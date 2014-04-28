<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_publications extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function search_research_title_autocomplete($item) { //--------------
        $sql = "SELECT id, title, status, date_completed, year_published
                FROM research
                WHERE title LIKE '%" . $item . "%'";

        $result = $this->db->query($sql)->result();

        if ($result)
            exit(json_encode($result));
        else {
            $response['error'] = 1;
            $response['message'] = 'Account does not exist.';
            exit(json_encode($response));
        }
    }

//--End-of-[search_research_title_autocomplete()]-------------------------

    public function fetch_author_published_books($id) { //----------------------
        $response = array();

        $sql = "SELECT a.id
                FROM authors AS a 
                INNER JOIN person AS p ON a.person_id = p.id 
                WHERE p.id=" . $id;

        $author_id = $this->db->query($sql)->row();

        $sql = "SELECT research_id FROM publish WHERE authors_id=" . $author_id->id;

        $query = $this->db->query($sql)->result();

        foreach ($query as $row) {
            $sql = "SELECT * FROM research WHERE id = " . $row->research_id;
            $response[] = $this->db->query($sql)->row();
        }

        exit(json_encode($response));
    }

//--End-of-[fetch_author_published_books()]-------------------------------

    public function insert_research_title($rid, $pid) { //----------------------
        $response = array();
        $author_id = 0;

        $sql = "SELECT id FROM authors WHERE person_id=" . $pid;

        $row = $this->db->query($sql)->row();
        $author_id = $row->id;

        $sql = "SELECT id FROM publish WHERE authors_id=" . $row->id . " AND research_id=" . $rid;

        $row = $this->db->query($sql)->row();

        if ($row) {
            $response['err'] = 1;
            $response['msg'] = "Duplicate title detected.";
        } else {
            $sql = "INSERT INTO publish SET authors_id=" . $author_id . ", research_id=" . $rid;
            $this->db->query($sql);

            $response['err'] = 0;
            $response['msg'] = "Success.";
        }

        echo json_encode($response);
    }

//--End-of-[insert_research_title()]--------------------------------------

    public function insert_research_author($aid, $rid) { //---------------------
        $response = array();

        $sql = "SELECT id FROM publish WHERE authors_id=" . $aid . " AND research_id=" . $rid;

        $row = $this->db->query($sql)->row();

        if ($row) {
            $response['err'] = 1;
            $response['msg'] = "Duplicate title detected.";
        } else {
            $sql = "INSERT INTO publish SET authors_id=" . $aid . ", research_id=" . $rid;
            $this->db->query($sql);

            $response['rid'] = $rid;
            $response['err'] = 0;
            $response['msg'] = "Success.";
        }

        echo json_encode($response);
    }

//--End-of-[insert_research_author()]-------------------------------------

    public function fetch_research_data($rid) { //------------------------------
        $response = array();

        $sql = "SELECT * FROM research";

        if ($rid != 0)
            $sql .= " WHERE id=" . $rid;

        $row = $this->db->query($sql)->row();

        if ($row->publication_type == 1)
            $response['pt'] = 'International';
        else if ($row->publication_type == 2)
            $response['pt'] = 'National';
        else if ($row->publication_type == 3)
            $response['pt'] = 'Local';
        else
            $response['pt'] = 'Not defined';

        $response['rb'] = $row->research_books;

        $response['rt'] = $row->research_type;

        if ($row->presentation == 1)
            $response['p'] = 'International Fora';
        else if ($row->presentation == 2)
            $response['p'] = 'National Fora';
        else if ($row->presentation == 3)
            $response['p'] = 'Local Fora';
        else
            $response['p'] = 'Not defined';

        if ($row->status == 1)
            $response['s'] = 'Completed';
        else if ($row->status == 2)
            $response['s'] = 'Published';
        else if ($row->status == 3)
            $response['s'] = 'Conducted';
        else if ($row->status == 4)
            $response['s'] = 'Presented';
        else
            $response['s'] = 'Not defined';

        if ($row->date_completed == '0000-00-00' || $row->date_completed == '')
            $response['dc'] = '--';
        else
            $response['dc'] = date("m/d/Y", strtotime($row->date_completed));

        if ($row->year_published == '0000' || $row->year_published == '')
            $response['yp'] = '--';
        else
            $response['yp'] = $row->year_published;

        $response['res'] = $row->researchers;

        $response['venue'] = $row->venue;
        $response['fora'] = $row->fora;

        if ($row->date_of_presentation == '0000-00-00' || $row->date_of_presentation == '')
            $response['dpres'] = '--';
        else
            $response['dpres'] = date("m/d/Y", strtotime($row->date_of_presentation));

        $response['title'] = $row->title;
        $response['agency'] = $row->funding_agency;
        $response['dloads'] = $row->downloads;
        $response['views'] = $row->views;
        $response['rid'] = $row->id;

        echo json_encode($response);
    }

//--End-of-[fetch_research_data()]----------------------------------------

    public function remove_author_published_book($rid, $auid) { //--------------
        $sql = "DELETE FROM publish WHERE authors_id=" . $auid . " AND research_id=" . $rid;

        $query = $this->db->query($sql);

        echo json_encode($query);
    }

//--End-of-[remove_author_published_book()]-------------------------------
    public function fetch_researches_jq_home_grid_data() {
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort 
        $sord = $_REQUEST['sord']; // get the direction

        $sql_search = "";

        if ($_REQUEST['title'])
            $sql_search = ' title LIKE "%' . $_REQUEST['title'] . '%" ';

        if ($_REQUEST['funding_agency'] && $_REQUEST['title'])
            $sql_search .= ' OR funding_agency LIKE "%' . $_REQUEST['funding_agency'] . '%" ';
        else if ($_REQUEST['funding_agency'])
            $sql_search .= ' funding_agency LIKE "%' . $_REQUEST['funding_agency'] . '%" ';

        if ($sql_search)
            $sql_search = " WHERE " . $sql_search;

        $page = (int) $_GET['page'];

        if (!$page)
            $page = 1;

        $sql = "SELECT * FROM research";

        $result = $this->db->query($sql);

        if ($result) {

            $response = new stdClass;

            $i = 0;
            $pt = '';
            $rb = '';
            $rt = '';
            $p = '';
            $s = '';
            $dp = '';
            $yp = '';

            $total = $result->num_rows();

            $rpp = 50;

            $number_of_pages = ceil($total / $rpp);

            $response->total = $number_of_pages;

            $start = ($page - 1) * $rpp;

            $sql .= $sql_search . " ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . "," . $rpp;

            $result = $this->db->query($sql);

            foreach ($result->result() as $row) {

                if ($row->publication_type == 1)
                    $pt = 'International';
                else if ($row->publication_type == 2)
                    $pt = 'National';
                else if ($row->publication_type == 3)
                    $pt = 'Local';
                else
                    $pt = 'Not defined';

                $rb = $row->research_books;

                $rt = $row->research_type;

                if ($row->presentation == 1)
                    $p = 'International Fora';
                else if ($row->presentation == 2)
                    $p = 'National Fora';
                else if ($row->presentation == 3)
                    $p = 'Local Fora';
                else
                    $p = 'Not defined';

                if ($row->status == 1)
                    $s = 'Completed';
                else if ($row->status == 2)
                    $s = 'Published';
                else if ($row->status == 3)
                    $s = 'Conducted';
                else if ($row->status == 4)
                    $s = 'Presented';
                else
                    $s = 'Not defined';

                if ($row->date_completed == '0000-00-00' || $row->date_completed == '')
                    $dp = '--';
                else
                    $dp = $row->date_completed;

                if ($row->year_published == '0000' || $row->year_published == '')
                    $yp = '--';
                else
                    $yp = $row->year_published;

                $response->rows[$i]['id'] = $row->id;

                $response->rows[$i]['cell'] = array(
                    $start + 1,
                    wordwrap($row->title, 60, '<br>', true),
                    wordwrap($row->funding_agency, 35, '<br>', true),
                    $pt, $rb, $rt, $p, $s, date("m/d/Y", strtotime($dp)), $yp,
                    $row->downloads,
                    $row->views
                );
                $i++;
                $start++;
            }
            echo json_encode($response);
        }
    }

    public function fetch_researches_jq_grid_data() { //------------------------
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort 
        $sord = $_REQUEST['sord']; // get the direction
        $sql_search = "";

        if ($_REQUEST['title'])
            $sql_search = ' title LIKE "%' . $_REQUEST['title'] . '%" ';

        if ($_REQUEST['funding_agency'] && $_REQUEST['title'])
            $sql_search .= ' OR funding_agency LIKE "%' . $_REQUEST['funding_agency'] . '%" ';
        else if ($_REQUEST['funding_agency'])
            $sql_search .= ' funding_agency LIKE "%' . $_REQUEST['funding_agency'] . '%" ';

        if ($sql_search)
            $sql_search = " WHERE " . $sql_search;

        $page = (int) $_GET['page'];

        if (!$page)
            $page = 1;

        $sql = "SELECT * FROM research";

        $result = $this->db->query($sql);

        if ($result) {

            $response = new stdClass;

            $i = 0;
            $pt = '';
            $rb = '';
            $rt = '';
            $p = '';
            $s = '';
            $dp = '';
            $yp = '';

            $total = $result->num_rows();

            $rpp = 8;

            $number_of_pages = ceil($total / $rpp);

            $response->total = $number_of_pages;

            $start = ($page - 1) * $rpp;


            $sql .= $sql_search . " ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . "," . $rpp;

            $result = $this->db->query($sql);

            foreach ($result->result() as $row) {

                if ($row->publication_type == 1)
                    $pt = 'International';
                else if ($row->publication_type == 2)
                    $pt = 'National';
                else if ($row->publication_type == 3)
                    $pt = 'Local';
                else
                    $pt = 'Not defined';

                $rb = $row->research_books;

                $rt = $row->research_type;

                if ($row->presentation == 1)
                    $p = 'International Fora';
                else if ($row->presentation == 2)
                    $p = 'National Fora';
                else if ($row->presentation == 3)
                    $p = 'Local Fora';
                else
                    $p = 'Not defined';

                if ($row->status == 1)
                    $s = 'Completed';
                else if ($row->status == 2)
                    $s = 'Published';
                else if ($row->status == 3)
                    $s = 'Conducted';
                else if ($row->status == 4)
                    $s = 'Presented';
                else
                    $s = 'Not defined';

                if ($row->date_completed == '0000-00-00' || $row->date_completed == '')
                    $dp = '--';
                else
                    $dp = $row->date_completed;

                if ($row->year_published == '0000' || $row->year_published == '')
                    $yp = '--';
                else
                    $yp = $row->year_published;

                $response->rows[$i]['id'] = $row->id;

                $response->rows[$i]['cell'] = array(
                    $start + 1,
                    wordwrap($row->title, 55, '<br>', true),
                    wordwrap($row->funding_agency, 35, '<br>', true),
                    $row->researchers,
                    $pt, $rb, $rt, $p, $s, date("m/d/Y", strtotime($dp)), $yp,
                    $row->downloads,
                    $row->views
                );
                $i++;
                $start++;
            }
            echo json_encode($response);
        }
    }

//--End-of-[fetch_researches_jq_grid_data()]------------------------------

    public function research_authors($id) { //-----------------------------------
        $sql = "SELECT a.id, p.first_name, p.last_name, p.middle_name
                FROM person AS p
                INNER JOIN authors AS a ON p.id=a.person_id
                INNER JOIN publish AS pb ON a.id=pb.authors_id
                WHERE pb.research_id=" . $id;

        $query = $this->db->query($sql)->result();

        echo json_encode($query);
    }

//--End of [research_authors()]--------------------------------------------

    public function insert_new_research($data) { //------------------------------
        extract($data);

        $sql = "INSERT INTO research SET title='" . mysql_real_escape_string($title) . "'"
                . ",funding_agency='" . mysql_real_escape_string($agency) . "'"
                . ",publication_type=" . $ptype
                . ",research_books='" . $rbooks . "'"
                . ",research_type='" . $rtype . "'"
                . ",researchers='" . $res . "'"
                . ",fora='" . $fora . "'"
                . ",venue='" . $venue . "'"
                . ",date_of_presentation='" . date("Y-m-d", strtotime($dpres)) . "'"
                . ",presentation=" . $pres
                . ",status=" . $status;

        if ($dcomp != '' && $ypub != '') {
            $sql .= ",date_completed='" . date("Y-m-d", strtotime($dcomp)) . "'";
            $sql .= ",year_published=" . $ypub;
        }

        $this->db->query($sql);

        $err = 0;
        $msg = "Save Successful";
        $rid = $this->db->insert_id();

        echo json_encode(array('err' => $err, 'msg' => $msg, 'rid' => $rid));
    }

//--End-of-[insert_new_research()]-----------------------------------------

    public function update_research($data) { //----------------------------------
        extract($data);

        $sql = "UPDATE research SET title='" . mysql_real_escape_string($title) . "'"
                . ",funding_agency='" . mysql_real_escape_string($agency) . "'"
                . ",publication_type=" . $ptype
                . ",research_books='" . $rbooks . "'"
                . ",research_type='" . $rtype . "'"
                . ",researchers='" . $res . "'"
                . ",fora='" . $fora . "'"
                . ",venue='" . $venue . "'"
                . ",date_of_presentation='" . date("Y-m-d", strtotime($dpres)) . "'"
                . ",presentation=" . $pres
                . ",status=" . $status;


        if ($ypub != '') {
            $sql .= ",year_published=" . $ypub;
        }

        if ($dcomp != '') {
            $sql .= ",date_completed='" . date("Y-m-d", strtotime($dcomp)) . "'";
        }

//        if ($dcomp != '' && $ypub != '') {
//            $sql .= ",date_completed='" . date("Y-m-d", strtotime($dcomp)) . "'";
//            $sql .= ",year_published=" . $ypub;
//        }

        $sql .= " WHERE id=" . $rid;

        $this->db->query($sql);

        $err = 0;
        $msg = "Update Successful";

        echo json_encode(array('err' => $err, 'msg' => $msg, 'rid' => $rid));
    }

//--End-of-[update_research()]--------------------------------------------

    public function delete_research($rid) { //-----------------------------------
        $sql = "SELECT id FROM publish WHERE research_id=" . $rid;

        $result = $this->db->query($sql)->row();

        if ($result) {
            $err = 1;
            $msg = "You cannot delte this Research if there are Authors linked to it.";
        } else {
            $sql = "SELECT id FROM files WHERE research_id=" . $rid;

            $result = $this->db->query($sql)->row();

            if ($result) {
                $err = 1;
                $msg = "You cannot delete this Research if there are attached files to it.";
            } else {
                $sql = "DELETE FROM research WHERE id=" . $rid;

                $result = $this->db->query($sql);

                if ($result) {
                    $err = 0;
                    $msg = "Successfully deleted the Research";
                }
            }
        }
        echo json_encode(array('$err' => $err, 'msg' => $msg));
    }

//--End-of-[delete_research()]--------------------------------------------

    public function fetch_general_search_titles($item) { //----------------------
        $response = array();
        $sql = "SELECT id, title, status, date_completed, year_published"
                . " FROM research"
                . " WHERE title"
                . " LIKE '%" . $item . "%'"
                . " LIMIT 0, 6";

        $result = $this->db->query($sql)->result();

        foreach ($result as $row) {
            if ($row->status == 1)
                $s = 'Completed';
            else if ($row->status == 2)
                $st = 'Published';
            else if ($row->status == 3)
                $st = 'Conducted';
            else if ($row->status == 4)
                $st = 'Presented';
            else
                $st = '';

            $response[] = array('response' => array('0' => $row->id, '1' => $row->title, '2' => $st, '3' => $row->date_completed, '4' => $row->year_published));
        }

        echo json_encode($response);
    }

//--End-of-[fetch_general_search_titles()]--------------------------------
//*******************************************************************************
    public function get_publication_list($data) {

        extract($data);

        $sql = 'SELECT id, title, status, funding_agency FROM research';

        if (($filter_by_status == 0) && ($filter_by_presentation > 0))
            $sql .= ' WHERE presentation="' . $filter_by_presentation . '"';

        if (($filter_by_status > 0) && ($filter_by_presentation == 0))
            $sql .= ' WHERE status="' . $filter_by_status . '"';

        if (($filter_by_status != 0) && ($filter_by_presentation != 0))
            $sql .= ' WHERE status="' . $filter_by_status . '" AND presentation="' . $filter_by_presentation . '"';

        $sql .= ' ORDER BY title ASC';

        $query = $this->db->query($sql);

        $_POST['total_pub_list_rows'] = $query->num_rows();

        return $query;
    }

    public function fetch_authors($research_id) {
        $authors = array();
        $ctr = 0;
        $sql = "SELECT authors_id FROM publish WHERE research_id =" . $research_id;

        $query = $this->db->query($sql);
        if ($query) {
            foreach ($query->result() as $row) {
                $sql = "SELECT authors.id, first_name, middle_name, last_name, sex, type ";
                $sql .= "FROM person INNER JOIN authors ON person.id = authors.person_id ";
                $sql .= "WHERE authors.id =" . $row->authors_id;

                $query = $this->db->query($sql);
                $authors[] = array($query->result());
                $ctr++;
            }
            return $authors;
        }
    }

    public function search_autocomplete($item) {
        $sql = "SELECT id, title
                FROM research
                WHERE title LIKE '%" . $item . "%'";

        $result = $this->db->query($sql)->result();

        if ($result) {
            exit(json_encode($result));
        } else {
            $response['error'] = 1;
            $response['message'] = 'Account does not exist.';
            exit(json_encode($response));
        }
    }

    public function fetch_research($research_id) {
        $sql = "SELECT * FROM research ";
        $sql .= "WHERE id = '" . $research_id . "'";

        $query = $this->db->query($sql);
        return $query->row();
    }

    public function fetch_research_search($item,$status='') {
        $sql = "SELECT * FROM research ";
        $sql .= "WHERE title LIKE '%" . mysql_real_escape_string(urldecode($item)) . "%'";
        
        if($status)
            $sql .= " AND status = '".(int)$status."'";
        
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function fetch_author_published($author_id) {

        $sql = "SELECT research_id FROM publish WHERE authors_id='" . $author_id . "'";

        $query = $this->db->query($sql)->result();

        return $query;
    }

    public function fetch_publications($limit, $start, $type) {

        $sql = "SELECT * FROM research ";
        $sql .= "WHERE publication_type = " . $type;
        $sql .= " ORDER BY date_added DESC LIMIT " . $start . ", " . $limit;

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function count_publications($type) {

        $sql = "SELECT COUNT(*) FROM research ";
        $sql .= "WHERE publication_type = " . $type;

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function fetch_uv_research_authors($id) { //-----------------------------------
        $sql = "SELECT a.id, p.first_name, p.last_name, p.middle_name
                FROM person AS p
                INNER JOIN authors AS a ON p.id=a.person_id
                INNER JOIN publish AS pb ON a.id=pb.authors_id
                WHERE pb.research_id=" . $id;

        $query = $this->db->query($sql)->result();

        return $query;
    }

    public function fetch_table_data() { //------------------------
        if (isset($_GET['page']))
            $page = (int) $_GET['page'];
        else
            $page = 1;

        if (!$page)
            $page = 1;

        $sql = "SELECT * FROM research";

        $result = $this->db->query($sql);

        if ($result) {

            $response = new stdClass;

            $i = 0;
            $pt = '';
            $rb = '';
            $rt = '';
            $p = '';
            $s = '';

            $total = $result->num_rows();

            $rpp = 5;

            $number_of_pages = ceil($total / $rpp);

            $response->total = $number_of_pages;

            $start = ($page - 1) * $rpp;

            $sql .= " LIMIT " . $start . "," . $rpp;

            $result = $this->db->query($sql);

            foreach ($result->result() as $row) {

                if ($row->publication_type == 1)
                    $pt = 'International';
                else if ($row->publication_type == 2)
                    $pt = 'National';
                else if ($row->publication_type == 3)
                    $pt = 'Local';
                else
                    $pt = 'Not defined';

                $rb = $row->research_books;

                $rt = $row->research_type;

                if ($row->presentation == 1)
                    $p = 'International Fora';
                else if ($row->presentation == 2)
                    $p = 'National Fora';
                else if ($row->presentation == 3)
                    $p = 'Local Fora';
                else
                    $p = 'Not defined';

                if ($row->status == 1)
                    $s = 'Completed';
                else if ($row->status == 2)
                    $s = 'Published';
                else if ($row->status == 3)
                    $s = 'Conducted';
                else if ($row->status == 4)
                    $s = 'Presented';
                else
                    $s = 'Not defined';

                if ($row->date_completed == '0000-00-00' || $row->date_completed == '' || $row->date_completed == NULL)
                    $dp = '--';
                else {
                    $d = getdate(strtotime($row->date_completed));
                    $dp = $d['month'] . ' ' . $d['mday'] . ', ' . $d['year'];
                }

                if ($row->year_published == '0000' || $row->year_published == '')
                    $yp = '--';
                else
                    $yp = $row->year_published;

                $response->rows[$i]['id'] = $row->id;

                $response->rows[$i]['cell'] = array(
                    $start + 1,
                    wordwrap($row->title, 70, '<br>', true),
                    wordwrap($row->funding_agency, 35, '<br>', true),
                    $row->researchers, $row->venue, $row->fora, $row->date_of_presentation,
                    $pt, $rb, $rt, $p, $s, $dp, $yp,
                );
                $i++;
                $start++;
            }
            return $response;
        }
    }

    public function fetch_print_preview_table_data() { //------------------------
        if (isset($_GET['page']))
            $page = (int) $_GET['page'];
        else
            $page = 1;

        if (!$page)
            $page = 1;

        $sql = "SELECT * FROM research";

        $result = $this->db->query($sql);

        if ($result) {

            $response = new stdClass;

            $i = 0;

            $total = $result->num_rows();

            $rpp = 10;

            $number_of_pages = ceil($total / $rpp);

            $response->total = $number_of_pages;

            $start = ($page - 1) * $rpp;

            $sql .= " ORDER BY date_completed DESC LIMIT " . $start . "," . $rpp;

            $result = $this->db->query($sql);

            foreach ($result->result() as $row) {

                $auid_arr = $this->fetch_authors($row->id);
//                $sql = "SELECT authors_id FROM publish WHERE research_id=" . $row->id;
//                
//                $auid = $this->db->query($sql)->result();  
//                
//                $auid_arr = array();
//                
//                for($x = 0, $t = count($auid); $x < $t; $x++){
//                    $auid_arr[] = $auid[$x]->authors_id;
//                }

                if ($row->date_completed == '0000-00-00' || $row->date_completed == '' || $row->date_completed == NULL)
                    $dp = '--';
                else {
                    $d = getdate(strtotime($row->date_completed));
                    $dp = $d['month'] . ' ' . $d['mday'] . ', ' . $d['year'];
                }

                $response->rows[$i]['id'] = $row->id;

                $response->rows[$i]['cell'] = array(
                    $start + 1,
                    wordwrap($row->title, 50, '<br>', true),
                    $auid_arr,
                    wordwrap($row->funding_agency, 35, '<br>', true),
                    $dp
                );
                $i++;
                $start++;
            }
            return $response;
        }
    }

//--Advance Search

    public function fetch_adv_research_data($rid) { //------------------------------
        $response = array();

        $sql = "SELECT * FROM research";

        if ($rid != 0)
            $sql .= " WHERE id=" . $rid;

        $row = $this->db->query($sql)->row();

        if ($row->publication_type == 1)
            $response['pt'] = 'International';
        else if ($row->publication_type == 2)
            $response['pt'] = 'National';
        else if ($row->publication_type == 3)
            $response['pt'] = 'Local';
        else
            $response['pt'] = 'Not defined';

        $response['rb'] = $row->research_books;

        $response['rt'] = $row->research_type;

        if ($row->presentation == 1)
            $response['p'] = 'International Fora';
        else if ($row->presentation == 2)
            $response['p'] = 'National Fora';
        else if ($row->presentation == 3)
            $response['p'] = 'Local Fora';
        else
            $response['p'] = 'Not defined';

        if ($row->status == 1)
            $response['s'] = 'Completed';
        else if ($row->status == 2)
            $response['s'] = 'Published';
        else if ($row->status == 3)
            $response['s'] = 'Conducted';
        else if ($row->status == 4)
            $response['s'] = 'Presented';
        else
            $response['s'] = 'Not defined';

        if ($row->date_completed == '0000-00-00' || $row->date_completed == '')
            $response['dc'] = '--';
        else
            $response['dc'] = date("m/d/Y", strtotime($row->date_completed));

        if ($row->year_published == '0000' || $row->year_published == '')
            $response['yp'] = '--';
        else
            $response['yp'] = $row->year_published;

        $response['res'] = $row->researchers;

        $response['venue'] = $row->venue;
        $response['fora'] = $row->fora;

        if ($row->date_of_presentation == '0000-00-00' || $row->date_of_presentation == '')
            $response['dpres'] = '--';
        else
            $response['dpres'] = date("m/d/Y", strtotime($row->date_of_presentation));

        $response['title'] = $row->title;
        $response['agency'] = $row->funding_agency;
        $response['dloads'] = $row->downloads;
        $response['views'] = $row->views;
        $response['rid'] = $row->id;

        echo json_encode($response);
    }

//******************************************************************************
}

//******************************************************************************
//--END-OF-[MODEL]

//
//    public function fetch_research_details($research_id) {
//        $sql = "SELECT * FROM research ";
//        $sql .= "WHERE id = '" . $research_id . "'";
//
//        $query = $this->db->query($sql);
//        return $query->row();
//    }
