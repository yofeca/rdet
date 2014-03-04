<?php

class M_files extends CI_Model {

    public function insert_file($filename, $filetype, $filesize, $title, $rid) {
        
        $sql = "INSERT INTO files SET filename='" . $filename . "',"
                . " filetype='" . $filetype . "',"
                . " filesize='" . $filesize . "',"
                . " title='" . $title . "', "
                . " research_id=" . $rid;

        $query = $this->db->query($sql);
        if($query)
            return $this->db->insert_id();
        else
            return 0;
    }

    public function fetch_research_files($rid) {//------------------------------
        $sql = "SELECT id, title, filename, filetype, filesize "
                . "FROM files "
                . "WHERE research_id=" . $rid;
        
        $query = $this->db->query($sql);
        
        echo json_encode($query->result());
    }

    public function delete_research_file($fid) {//------------------------------
        
        $file = $this->get_files($fid);
                
        if($file->filename){
            
            $sql = "DELETE FROM files WHERE id=" . $fid;
            $this->db->query($sql);
            
            unlink('./files/' . $file->filename);
            
            $err = 0;
            $msg = "Delete Successfull.";
            
        }else{
            
            $err = 1;
            $msg = "Unable to delete the file.";
            
        }
        
       echo json_encode(array('err' => $err, 'msg' => $msg));
    }

    public function get_user_files($fid) {//--------------------------------------

        $sql = "SELECT * FROM files WHERE research_id=" . $fid;
        
        $query = $this->db->query($sql);   
        
        return $query->result();
    }
    
    public function get_files($fid) {//--------------------------------------

        $sql = "SELECT filename FROM files WHERE id=" . $fid;
        
        $query = $this->db->query($sql);   
        
        return $query->row();
    }
    
}

?>
