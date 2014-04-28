<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_author extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function fetch_name_for_autocomplete($item, $category){ //-----------
        
        $sql = "SELECT p.id, p.first_name, p.last_name
                FROM person AS p
                INNER JOIN authors AS a ON p.id = a.person_id ";
        
        if($category == 0) $sql .= "WHERE last_name LIKE '%" . $item . "%'";
        if($category == 1) $sql .= "WHERE first_name LIKE '%" . $item . "%'";

        $result = $this->db->query($sql)->result();
        
        exit(json_encode($result));
        
    } //--End-of-[fetch_name_for_autocomplete()]--------------------------------

    
    public function fetch_author_jq_grid_data(){ //-----------------------------
        
        $page = (int) $_GET['page'];
        if (!$page) $page = 1;

        $sql = "SELECT p.id, type, p.first_name, p.middle_name, p.last_name, p.sex
                FROM person AS p
                INNER JOIN authors AS a ON p.id = a.person_id";

        $result = $this->db->query($sql);

        if ($result) {

            $response = new stdClass; $x = 0; $type = 0;
            
            $total = $result->num_rows();
            
            $rpp = 5;
            
            $number_of_pages = ceil($total / $rpp);
            
            $response->total = $number_of_pages;
            
            $start = ($page - 1) * $rpp;
            
            $sql .= " ORDER BY p.last_name ASC";
            
            $sql .= " LIMIT " . $start . "," . $rpp;
            
            $result = $this->db->query($sql);

            foreach($result->result() as $row){
                
                if($row->type == 1) $type = 'Faculty';
                if($row->type == 2) $type = 'Student';
                if($row->type == 3) $type = 'Community';
                
                $response->rows[$x]['id'] = $row->id;

                $response->rows[$x]['cell'] = array(
                    $start+1,
                    $row->first_name,
                    $row->middle_name,
                    $row->last_name,
                    ucwords(strtolower($row->sex)),
                    $type,
                );
                $x++;
                $start++;
            }
            echo json_encode($response);  
        }
        
    } //--End-fo-[fetch_author_jq_grid_data()]----------------------------------
    
    
    public function fetch_author_data($id){ //----------------------------------
        $response = array(); $type = ''; 
        
        $sql = "SELECT a.id, p.id AS person_id, a.type, p.first_name, p.middle_name, p.last_name, p.sex
                FROM person AS p
                INNER JOIN authors AS a ON p.id = a.person_id ";
        
        if($id) $sql .= "WHERE p.id=" . $id;
        
        $row = $this->db->query($sql)->row();

        if($row->type == 1) $type = 'Faculty';
        if($row->type == 2) $type = 'Student';
        if($row->type == 3) $type = 'Community';
        
        $response['auid'] = $row->id;
        $response['pid'] = $row->person_id;
        $response['fname'] = $row->first_name;
        $response['mname'] = $row->middle_name;
        $response['lname'] = $row->last_name;
        $response['sex'] = ucwords(strtolower($row->sex));
        $response['type'] = $type;
        
        echo json_encode($response);
        
    } //--End-of-[fetch_author_data()]------------------------------------------
    
    
    public function insert_update_author($data){ //-----------------------------
        
        extract($data);
        
        $response = array();
        
        if($id == 0) $sql = "INSERT INTO person ";
        else $sql = "UPDATE person ";
        
            $sql .= "SET first_name='".mysql_real_escape_string($fname)."', ";
            $sql .= "middle_name='".mysql_real_escape_string($mname)."', ";
            $sql .= "last_name='".mysql_real_escape_string($lname)."', ";
            $sql .= "sex='".mysql_real_escape_string($sex)."'";
            
        if($id != 0) $sql .= " WHERE id = " . $id;
            
        $this->db->query($sql);
         
        if($id == 0){
            $sql = "INSERT INTO authors ";
            $sql .= "SET person_id='".$this->db->insert_id()."', ";
            $sql .= "type='".mysql_real_escape_string($type)."'";
            
            $responsep['id'] = $this->db->insert_id();
            
         } else {
            $sql = "UPDATE authors ";
            $sql .= "SET type='".mysql_real_escape_string($type)."'";
            $sql .= " WHERE person_id = " . $id;
            
            $response['id'] = $id;
         }
        
         $this->db->query($sql);
         
         echo json_encode($response);
         
        } //--End-of-[insert_update_author()]-----------------------------------
        
    
    public function delete_author($auid, $pid){ //------------------------------
        
        $response = array();
        
        $sql = "SELECT id FROM publish WHERE authors_id=" . (int) $auid;
        
        $row = $this->db->query($sql)->row();

        if ($row){
            $response['err'] = 1;
            $response['msg'] = 'The author research books is not empty.';
            exit(json_encode($response));
        }else{
            $sql = "SELECT id FROM user_accounts WHERE person_id = " . (int) $pid;
            
            $row = $this->db->query($sql)->row();
            
            if($row){
                $response['err'] = 1;
                $response['msg'] = 'The author appears to be an RDET user.';
                exit(json_encode($response));
            }else{
                $sql = "DELETE FROM authors WHERE id=" . (int) $auid;
                $this->db->query($sql);
                
                $sql = "DELETE FROM person where id=" . (int) $pid;
                $this->db->query($sql);
                
                $response['err'] = 0;
                $response['msg'] = 'Delete success.';
                
                exit(json_encode($response));
            }
        }
        
    } //--End-of-[delete_author()]----------------------------------------------
    
    
    public function research_author_autocomplete($lastname) { //----------------
        
        $sql = "SELECT a.id, p.first_name, p.middle_name, p.last_name "
                . " FROM person as p"
                . " INNER JOIN authors as a ON p.id = a.person_id"
                . " WHERE last_name LIKE '%". mysql_real_escape_string($lastname) ."%'";

        $result = $this->db->query($sql)->result();
        
        if ($result) exit(json_encode($result));
        else {
            $response['error'] = 1;
            $response['message'] = 'Account does not exist.';
            exit(json_encode($response));
        }
        
    } //--End-of-[research_author_autocomplete()]-------------------------------

    
    public function fetch_general_search_authors($item){ //----------------------
        
        $response = array();
        
        $sql = "SELECT a.id, p.last_name, p.first_name, p.middle_name, a.type"
                . " FROM person AS p"
                . " INNER JOIN authors AS a"
                . " ON p.id = a.person_id"
                . " WHERE last_name"
                . " LIKE '%" . $item . "%'"
                . " LIMIT 0, 6";
        
        $result = $this->db->query($sql)->result();
        
        if(! $result){
            $sql = "SELECT a.id, p.last_name, p.first_name, p.middle_name, a.type"
                . " FROM person AS p"
                . " INNER JOIN authors AS a"
                . " ON p.id = a.person_id"
                . " WHERE first_name"
                . " LIKE '%" . $item . "%'"
                . " LIMIT 0, 6";
        
            $result = $this->db->query($sql)->result();
        }
        
        foreach($result as $row){
            if($row->type == 1) $t = 'Faculty';
            else if($row->type == 2) $t = 'Student w/ Faculty';
            else if($row->type == 3) $t = 'Community';
            else $t = '';
                      
            $response[] = array('response' => array(
                '0' => $row->id, 
                '1' => $row->last_name . ", " . $row->first_name . " " . $row->middle_name, 
                '2' => '', 
                '3' => '', 
                '4' => $t
            ));
        }
        
        echo json_encode($response);
        
    } //--End-of-[fetch_general_search_titles()]--------------------------------
    
    
//******************************************************************************
   public function search($last_name){
        $sql = "SELECT authors.id, first_name, middle_name, last_name, sex, type
                FROM person
                INNER JOIN authors ON person.id = authors.person_id
                WHERE last_name LIKE '%".$last_name."%'";

        $result = $this->db->query($sql)->result();
        //$account = $result->row();

        if ($result) {
            exit(json_encode($result));
        } else {
            $response['error'] = 1;
            $response['message'] = 'Account does not exist.';
            exit(json_encode($response));
        }
    }
    
    public function fetch_author($author_id){
        
        if($author_id == 0){
            $auid = $this->fetch_author_first_row();
            $author_id = $auid->id;
        }
        
        $sql = "SELECT authors.id, first_name, middle_name, last_name, sex, type
                FROM person
                INNER JOIN authors ON person.id = authors.person_id
                WHERE authors.id ='".$author_id."'";

        $result = $this->db->query($sql)->row();
        
        return $result;
    }

    public function fetch_author_search($option, $item){
        
        if($option == 1) $opt = 'last_name';
        else if($option == 2) $opt = 'first_name';
        else if($option == 3) $opt = 'middle_name';
        
        $sql = "SELECT authors.id, first_name, middle_name, last_name, sex, type
                FROM person
                INNER JOIN authors ON person.id = authors.person_id
                WHERE ".$opt." LIKE '%".mysql_real_escape_string(urldecode($item))."%'";
        
        $result = $this->db->query($sql)->row();
        
        return $result;
        //echo $sql;
    }
    
    public function fetch_author_advsearch($n,$skey){
        
        $sql = "SELECT authors.id, first_name, middle_name, last_name, sex, type
                FROM person
                INNER JOIN authors ON person.id = authors.person_id";
        $sql .= " WHERE " . $n . " LIKE '%".mysql_real_escape_string(urldecode($skey))."%'";

        
        $result = $this->db->query($sql)->row();
        
        return $result;
    }
    
    public function fetch_author_first_row(){
        $sql = "SELECT id FROM authors";
        
        $auid = $this->db->query($sql);
        
        return $auid->row();
    }
    
    public function fetch_author_table_data(){ //-----------------------------
        
        if(isset($_GET['page']))
            $page = $_GET['page'];
        else
            $page = 1;
            
        if (!$page) $page = 1;

        $sql = "SELECT a.id, type, p.first_name, p.middle_name, p.last_name, p.sex
                FROM person AS p
                INNER JOIN authors AS a ON p.id = a.person_id";

        $result = $this->db->query($sql);

        if ($result) {

            $response = new stdClass; $x = 0; $type = 0;
            
            $total = $result->num_rows();
            
            $rpp = 10;
            
            $number_of_pages = ceil($total / $rpp);
            
            $response->total = $number_of_pages;
            
            $start = ($page - 1) * $rpp;
            
            $sql .= " ORDER BY p.last_name ASC";
            
            $sql .= " LIMIT " . $start . "," . $rpp;
            
            $result = $this->db->query($sql);

            foreach($result->result() as $row){
                
                $response->rows[$x]['id'] = $row->id;

                $response->rows[$x]['cell'] = array(
                    $start+1,
                    $row->first_name,
                    $row->middle_name,
                    $row->last_name,
                    ucwords(strtolower($row->sex))
                );
                $x++;
                $start++;
            }
            return $response;  
        }
        
    }
//******************************************************************************
} //--END-OF-[MODEL]------


    //    public function insert($data){
//        extract($data);
//        
//        foreach($new_author as $row){
//            if($row['sex'] == 1) $sex = 'MALE';
//            if($row['sex'] == 2) $sex = 'FEMALE';
//            
//            $sql = "INSERT INTO person ";
//            $sql .= "SET first_name='".mysql_real_escape_string($row['fname'])."', ";
//            $sql .= "middle_name='".mysql_real_escape_string($row['mname'])."', ";
//            $sql .= "last_name='".mysql_real_escape_string($row['lname'])."', ";
//            $sql .= "sex='".mysql_real_escape_string($sex)."'";
//            
//            $this->db->query($sql);
//            
//            $sql = "INSERT INTO authors ";
//            $sql .= "SET person_id='".$this->db->insert_id()."', ";
//            $sql .= "type='".mysql_real_escape_string($row['au_type'])."'";
//            
//            $this->db->query($sql);
//        }
//    }
    
    //    public function fetch_author_person_id(){
//        $sql = "SELECT p.id, p.last_name
//                FROM person AS p
//                INNER JOIN authors AS a ON p.id = a.person_id ORDER BY p.last_name ASC";
//
//        $result = $this->db->query($sql)->row();
//        echo json_encode($result);
//    }


//    public function fetch_author($author_id){
//        $sql = "SELECT p.id, p.first_name, p.middle_name, p.last_name, p.sex, a.type
//                FROM person AS p
//                INNER JOIN authors AS a ON p.id = a.person_id
//                WHERE a.id ='".$author_id."'";
//
//        $result = $this->db->query($sql)->row();
//        return $result;
//
//    }

//    public function fetch_author_id($person_id){ //-----------------------------
//        
//        $sql = "SELECT a.id
//                FROM authors AS a 
//                INNER JOIN person AS p ON a.person_id = p.id 
//                WHERE p.id=" . (int) $person_id;
//
//        $author_id = $this->db->query($sql)->row();
//        
//        return($author_id->id);
//    }