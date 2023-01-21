<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class LanguageModel extends CI_Model {

    public function getAllLanguage() {

        $query = $this->db->get('language');
        if ($query->result_array()) {
            return  $query->result_array();
        } else {         
            return  $query->result_array();
        }
    }

    public function getLanguage($id) {

        $this->db->where('id',$id);        
        $query = $this->db->get('language');
        if ($query->row_array()) {
            return  $query->row_array();
        } else {         
            return  false;
        }
    }


    public function save($postdata) {

        $this->db->insert('language', ['name'=>$postdata['name'],'status'=>$postdata['status'],'created_at'=>date('Y-m=d h:i:s'),'updated_at'=>date('Y-m=d h:i:s')]);
        $insert = $this->db->insert_id();
        if ($insert > 0) {
            return  true;
        } else {         
            return  false;
        }
    }

    public function update($postdata,$id) {

        $update = $this->db->where('id',$id)
        ->update('language', ['name'=>$postdata['name'],'status'=>$postdata['status']'updated_at'=>date('Y-m=d h:i:s')]);
        
        if ($update > 0) {
            return  true;
        } else {         
            return  false;
        }
    }

    public function deleteLanguage($id) {

        $this->db->where('id',$id);        
        $query = $this->db->delete('language');
        if ($query) {
            return  true;
        } else {         
            return  false;
        }
    }
}
