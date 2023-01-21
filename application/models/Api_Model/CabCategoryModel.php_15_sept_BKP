<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class CabCategoryModel extends CI_Model {
    
    public function getAllCabType() {
       $this->db->where('status','Active');
       $this->db->where('parent_id',0);
       $query = $this->db->get('cab-category');
       if ($query->result_array()) {
         return $query->result_array();
        } else {         
        return  array();
      }
    }
    
    public function apiGetAllCabCategory($id) {
       $this->db->where('status','Active');
       $this->db->where('parent_id',$id);
       $query = $this->db->get('cab-category');
       if ($query->result_array()) {
          return $query->result_array();
        } else {         
        return  array();
      }
    }
    
    function getCab(){
        $this->db->where('cc.parent_id !=', 0);
        $this->db->select('cc.name as cab_type,ucl.latitude,ucl.longitude,cc.cab_icon,cc.id as cab_type_id,c.id as cab_id,c2.name as cab_type_name');
        $this->db->from('cab-category as cc');
        $this->db->join('cab as c','c.cab_category_id = cc.id');
        $this->db->join('cab-category as c2','cc.parent_id = c2.id');
        $this->db->join('driver as d','d.id = c.driver_id');
        $this->db->join('user_current_locations as ucl','ucl.user_id = d.id');
        $data =  $this->db->get()->result_array();
        return $data;
    }
    
    //added by lgarg
    function getCab2(){
        $this->db->where('cc.parent_id !=', 0);
        $this->db->where('d.driver_current_status', 'online');
        $this->db->select('cc.name as cab_type,ucl.latitude,ucl.longitude,cc.cab_icon,cc.id as cab_type_id,c.id as cab_id,c2.name as cab_type_name');
        $this->db->from('cab-category as cc');
        $this->db->join('cab as c','c.cab_category_id = cc.id');
        $this->db->join('cab-category as c2','cc.parent_id = c2.id');
        $this->db->join('driver as d','d.id = c.driver_id');
        $this->db->join('user_current_locations as ucl','ucl.user_id = d.id');
        $data =  $this->db->get()->result_array();
        return $data;
    }

    public function getAllCabCategory() {

        $this->db->select('c.name as name,c.id,c.status,c2.name as parentCategoryName');
        $this->db->from('cab-category as c');
        $this->db->join('cab-category as c2','c.parent_id = c2.id','left');
        $this->db->order_by('c.id','desc');
        $query = $this->db->get();
        if ($query->result_array()) {
            return  $query->result_array();
        } else {         
            return  $query->result_array();
        }
    }
    
    public function getParentCategory() {
                 $this->db->where('parent_id', 0);
        $query = $this->db->get('cab-category');
        if ($query->result_array()) {
            return  $query->result_array();
        } else {         
            return  $query->result_array();
        }
    }

    public function getCabCategory($id=null) {

        $this->db->where('id',$id);        
        $query = $this->db->get('cab-category');
        if ($query->row_array()) {
            return  $query->row_array();
        } else {         
            return  false;
        }
    }
    
    public function getVehicleType() {

        $this->db->where('status','Active');        
        $query = $this->db->get('cab-category');
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        } else {         
            return  false;
        }
    }


    public function save($postdata) {
                        // debug($postdata);die;
        $data = array(
        'name'=>$postdata['name'],
        'status'=>$postdata['status'],
        'parent_id'=>$postdata['parent_id']
        );
        // debug($data);die;
        $this->db->insert('cab-category', $data);
        $insert = $this->db->insert_id();
        if ($insert > 0) {
            return  true;
        } else {         
            return  false;
        }

    }

    public function update($postdata,$id) {
              $data = array(
        'name'=>$postdata['name'],
        'status'=>$postdata['status'],
        'parent_id'=>$postdata['parent_id']
        );
        
        $update = $this->db->where('id',$id)
        ->update('cab-category', $data);
        if ($update > 0) {
            return  true;
        } else {         
            return  false;
        }
    }

    public function deleteCabCategory($id) {

        $this->db->where('id',$id);        
        $query = $this->db->delete('cab-category');
        if ($query) {
            return  true;
        } else {         
            return  false;
        }
    }

}
