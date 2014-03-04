<?php
class M_admin extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function login($data){
        extract($data);
        
        $sql = "SELECT user_accounts.id, privilege, first_name, last_name FROM person ";
        $sql .= "INNER JOIN user_accounts ON person.id = user_accounts.person_id ";
        $sql .= "WHERE MD5(username) = '" . mysql_real_escape_string(md5($username)) ."' " .
                "AND password = '" . md5(mysql_real_escape_string($password)) . "' " .
                "AND active = 1";
        
        $query = $this->db->query($sql);
        
        if($query->num_rows()){
            
            $user = $query->row();
               
            $this->session->set_userdata('u_id', $user->id);
            $this->session->set_userdata('u_level', $user->privilege);
            $this->session->set_userdata('u_name',$user->last_name .', '. $user->first_name);
        }else{
            redirect(base_url('admin/login?e=1&u='.$username));
        }      
    }
       
    public function insert_account($data){
        //date("d-m-Y", strtotime($originalDate)
        extract($data);
        $response = array();
                
        $sql = "INSERT INTO person SET first_name='".mysql_real_escape_string($fname)."',";
        $sql .= "middle_name='".mysql_real_escape_string($mname)."',";
        $sql .= "last_name='".mysql_real_escape_string($lname)."',";
        $sql .= "birth_date='".mysql_real_escape_string(date("Y-m-d",strtotime($bdate)))."',";
        $sql .= "sex='".mysql_real_escape_string($sex)."',";
        $sql .= "address='".  mysql_real_escape_string($addr)."'";

        $this->db->query($sql);

        $response['pid'] = $this->db->insert_id();
        
        $sql = "INSERT INTO user_accounts SET person_id='".$this->db->insert_id()."',";
        $sql .= "emp_id='".mysql_real_escape_string($emp_id)."',";
        $sql .= "username='".mysql_real_escape_string($uname)."',";
        $sql .= "password='".md5(mysql_real_escape_string($pword1))."',";
        $sql .= "privilege='". (int) $privilege."',";
        $sql .= "active='".(int) $active."'";
    
        $this->db->query($sql);
               
        exit(json_encode($response));
    }
    
    public function update_account($data){
        extract($data);
        
        $response = array();
        
        $response['pid'] = $pid;
        
        $sql = "UPDATE person SET first_name='".mysql_real_escape_string($fname)."',";
        $sql .= "middle_name='".mysql_real_escape_string($mname)."',";
        $sql .= "last_name='".mysql_real_escape_string($lname)."',";
        $sql .= "birth_date='".mysql_real_escape_string(date("Y-m-d",strtotime($bdate)))."',";
        $sql .= "sex='".mysql_real_escape_string($sex)."',";
        $sql .= "address='".  mysql_real_escape_string($addr)."' ";
        $sql .= "WHERE id='". $pid ."'";

        $this->db->query($sql);

        $sql = "UPDATE user_accounts SET emp_id='".mysql_real_escape_string($emp_id)."',";
//        $sql .= "username='".mysql_real_escape_string($uname)."',";
//        $sql .= "password='".mysql_real_escape_string($pword1)."',";
        $sql .= "privilege='". (int) $privilege."',";
        $sql .= "active='" . (int) $active . "' ";
        $sql .= "WHERE person_id='" . (int) $pid . "'";
    
        $this->db->query($sql);
        
        exit(json_encode($response));
    }
    
    public function search_accounts($person_id){     
            $sql = "SELECT p.id, u.emp_id, p.first_name, p.middle_name, p.last_name, p.birth_date, p.sex, p.address, u.username,
            u.password , u.active, u.privilege
            FROM person AS p
            INNER JOIN user_accounts AS u ON p.id = u.person_id
            WHERE p.id=" . (int) $person_id;

        $result = $this->db->query($sql);
        
        $account = $result->row();
        
        if ($account) {
            $response['pid'] = $account->id;
            $response['emp_id'] = $account->emp_id;
            $response['fname'] = $account->first_name;
            $response['mname'] = $account->middle_name;
            $response['lname'] = $account->last_name;
            
            if($account->birth_date != '' || $account->birth_date != NULL){
                $d = getdate(strtotime($account->birth_date));
                $d = $d['month'] . " " . $d['mday'] . ", " . $d['year'];
            }else $d = "";
            
            $response['bdate'] = $d;
            $response['sex'] = $account->sex;
            $response['addr'] = $account->address;
            $response['uname'] = $account->username;
//            $response['pword'] = $account->password;
            $response['active'] = $account->active;
            $response['privilege'] = $account->privilege;
        } else {
            $response['error'] = 1;
            $response['message'] = 'Account does not exist.';
        }
        exit(json_encode($response));
    }
    
    public function fetch_accounts() {
        $page = (int) $_GET['page'];
        if (!$page)
            $page = 1;

        /*
          $total = 23; (Records)
          $rpp = 5; // Record per page
          $number_of_pages = 23/5
         */

        $sql = "SELECT p.id, person_id, u.emp_id, p.first_name, p.middle_name, p.last_name, u.privilege, u.active
                FROM person AS p
                INNER JOIN user_accounts AS u ON p.id = u.person_id";

        $result = $this->db->query($sql);

        if ($result) {

            $response = new stdClass;
            $x = 0; $p = 0;
            
            
            $total = $result->num_rows();
            $rpp = 10;
            $number_of_pages = ceil($total / $rpp);
            
            $response->total = $number_of_pages;//$result->num_rows();
            
            $start = ($page - 1) * $rpp;

            $sql .= " LIMIT " . $start . "," . $rpp;
            
            $result = $this->db->query($sql);

            foreach($result->result() as $row){
                
                if($row->privilege == 1) $p = 'Administrator';
                if($row->privilege == 2) $p = 'User';
                
                $response->rows[$x]['id'] = $row->id;

                $response->rows[$x]['cell'] = array(
                    $x+1,
                    $row->emp_id,
                    $row->first_name,
                    $row->middle_name,
                    $row->last_name,
                    $p,
                    $row->active
                );
                $x++;
            }
            echo json_encode($response);
        }
    }
    
/*-------Async Accounts ------------------------------------------------------*/
    public function update_user_account($data){
        extract($data);
        $sql = "UPDATE user_accounts SET username='".mysql_real_escape_string($uname)."',";
        $sql .= "password='".md5(mysql_real_escape_string($pword))."' ";
        $sql .= "WHERE person_id=" . (int) $pid;
        
        $result = $this->db->query($sql);
        
        return $result;
    }
    
    public function check_emp_id($emp_id){
        $sql = "SELECT emp_id FROM user_accounts WHERE emp_id='".$emp_id."'";
        $query = $this->db->query($sql);
        return($query->num_rows());
    }
    
    public function fetch_person_id(){
        $response = array();
        
        $sql = "SELECT p.id FROM person AS p INNER JOIN user_accounts AS u ON p.id = u.person_id";
        
        $query = $this->db->query($sql)->row();
        $response['pid'] = $query->id;
        
        exit(json_encode($response));
    }
    
    public function delete_account($person_id){
        $sql = "DELETE FROM user_accounts where person_id=" . $person_id;
        
        $this->db->query($sql);
        
        $sql = "DELETE FROM person where id=" . $person_id;
        
        $this->db->query($sql);
    }
/*------My Profile-------------------------------------------------------------*/
public function fetch_my_profile($profile_id){
        $sql = "SELECT person.id AS pid, user_accounts.id AS uid, emp_id, first_name, middle_name, last_name, birth_date, sex, address, username,
                password
                FROM person
                INNER JOIN user_accounts ON person.id = user_accounts.person_id
                WHERE user_accounts.id ='". $profile_id ."'";
        
        $query = $this->db->query($sql);
        
        return $query->row();
    }
    
    public function update_myprofile($data){
        extract($data);
        
        $sql = "UPDATE person SET first_name='".mysql_real_escape_string($fname)."',";
        $sql .= "middle_name='".mysql_real_escape_string($mname)."',";
        $sql .= "last_name='".mysql_real_escape_string($lname)."',";
        
        if($bdate) $sql .= "birth_date='".date("Y-m-d",strtotime($bdate))."',";
        else $sql .= " birth_date=NULL, ";
        
        $sql .= "sex='".mysql_real_escape_string($sex)."',";
        $sql .= "address='".  mysql_real_escape_string($addr)."' ";
        $sql .= "WHERE id='".$pid."'";
        
        $this->db->query($sql);

        $sql = "UPDATE user_accounts SET emp_id='" . mysql_real_escape_string($emp_id) . "' ";
        $sql .= "WHERE id='".$uid."'";
    
        
        return $this->db->query($sql);
    }
    
    
    public function fetch_general_search_accounts($item){ //----------------------
        
        $response = array();
        
        $sql = "SELECT u.id, u.emp_id, u.username, u.privilege,  p.last_name, p.first_name, p.middle_name"
                . " FROM person AS p"
                . " INNER JOIN user_accounts AS u"
                . " ON p.id = u.person_id"
                . " WHERE last_name"
                . " LIKE '%" . $item . "%'"
                . " LIMIT 0, 6";
        
        $result = $this->db->query($sql)->result();
        
        if(! $result){
            $sql = "SELECT u.id, u.emp_id, u.username, u.privilege,  p.last_name, p.first_name, p.middle_name"
                . " FROM person AS p"
                . " INNER JOIN user_accounts AS u"
                . " ON p.id = u.person_id"
                . " WHERE first_name"
                . " LIKE '%" . $item . "%'"
                . " LIMIT 0, 6";
        
            $result = $this->db->query($sql)->result();
        }
        
        foreach($result as $row){
            if($row->privilege == 1) $u = 'Administrator';
            else if($row->privilege == 2) $u = 'RDET User';
            else $u = '';
                      
            $response[] = array('response' => array(
                '0' => $row->id, 
                '1' => $row->last_name . ", " . $row->first_name . " " . $row->middle_name, 
                '2' => $row->emp_id, 
                '3' => $u, 
                '4' => $row->username
            ));
        }
        
        echo json_encode($response);
        
    } //--End-of-[fetch_general_search_titles()]--------------------------------
}
?>