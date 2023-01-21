<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class CityModel extends CI_Model {

    public function getAllCity() {

        $query = $this->db->get('city');
        if ($query->result_array()) {
            return  $query->result_array();
        } else {         
            return  $query->result_array();
        }
    }

    public function getAllActiveCity() {
       $this->db->where('status','Active');
       $query = $this->db->get('city');
       if ($query->result_array()) {
           
        // $data = array();
        // foreach($query->result_array() as $key => $row){
        //     (int) $key = $row['id'];
        //     $data[$key] = $row['name'];
        //     // break;
        //     // $data[$key]['id'] = $id;
        // }
        return $query->result_array();
        
        
    } else {         
        return  array();
    }
}


public function getCity($id) {

    $this->db->where('id',$id);        
    $query = $this->db->get('city');
    if ($query->row_array()) {
        return  $query->row_array();
    } else {         
        return  false;
    }
}


public function save($postdata) {

    $this->db->insert('city', ['name'=>$postdata['name'],'status'=>$postdata['status']]);
    $insert = $this->db->insert_id();
    if ($insert > 0) {
        return  true;
    } else {         
        return  false;
    }

}

public function update($postdata,$id) {

    $update = $this->db->where('id',$id)
    ->update('city', ['name'=>$postdata['name'],'status'=>$postdata['status']]);

    if ($update > 0) {
        return  true;
    } else {         
        return  false;
    }
}

public function deleteCity($id) {

    $this->db->where('id',$id);        
    $query = $this->db->delete('city');
    if ($query) {
        return  true;
    } else {         
        return  false;
    }
}

}
