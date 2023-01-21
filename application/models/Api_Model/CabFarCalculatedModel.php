<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class CabFarCalculatedModel extends CI_Model {
    
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
    
    public function apiGetAllCabCategory() {
       $this->db->where('status','Active');
       $this->db->where('parent_id !=',0);
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
        
        $state_name = $this->db->where('id',$postdata['state'])->get('state')->row_array();
        $city_name = $this->db->where('id',$postdata['city'])->get('city')->row_array();
        $vehicle_type = $this->db->where('id',$postdata['vehicle_type'])->get('cab-category')->row_array();
        
        $data = array(
         'state_name' => $state_name['name'],
         'citi_name'  => $city_name['name'],
         'state_id'  => $postdata['state'],
         'city_id'   => $postdata['city'],
         'vehicle_type' => $postdata['vehicle_type'],
         'vehicle_name' => $vehicle_type['name'],
         'minimum_fare' => $postdata['minimum_fare'],
         'fare_after_5_km' => $postdata['fare_after_5_km'],
         'waiting_ride_charges' => $postdata['waiting_ride_charges'],
         'night_charges' => $postdata['night_charges'],
         'applicable_night_ride' => $postdata['applicable_night_ride'],
         'is_applicable_night' => $postdata['is_applicable_night'],
         'is_strike' => $postdata['is_strike'],
         'strike_charge' => $postdata['strike_charge'],
         'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('all_cab_far_price', $data);
        $insert = $this->db->insert_id();
        if ($insert > 0) {
            return  true;
        } else {         
            return  false;
        }

    }

    public function update($postdata,$id) {
        
        $state_name = $this->db->where('id',$postdata['state'])->get('state')->row_array();
        $city_name = $this->db->where('id',$postdata['city'])->get('city')->row_array();
        $vehicle_type = $this->db->where('id',$postdata['vehicle_type'])->get('cab-category')->row_array();
        
        $data = array(
         'state_name' => $state_name['name'],
         'citi_name'  => $city_name['name'],
         'state_id'  => $postdata['state'],
         'city_id'   => $postdata['city'],
         'vehicle_type' => $postdata['vehicle_type'],
         'vehicle_name' => $vehicle_type['name'],
         'minimum_fare' => $postdata['minimum_fare'],
         'fare_after_5_km' => $postdata['fare_after_5_km'],
         'waiting_ride_charges' => $postdata['waiting_ride_charges'],
         'night_charges' => $postdata['night_charges'],
         'applicable_night_ride' => $postdata['applicable_night_ride'],
         'is_applicable_night' => $postdata['is_applicable_night'],
         'is_strike' => $postdata['is_strike'],
         'strike_charge' => $postdata['strike_charge'],
         'updated_at' => date('Y-m-d H:i:s')
        );
        
        $update = $this->db->where('id',$id)
        ->update('all_cab_far_price', $data);
        if ($update > 0) {
            return  true;
        } else {         
            return  false;
        }
    }

    public function deleteCabFarCalculated($id) {

        $this->db->where('id',$id);        
        $query = $this->db->delete('all_cab_far_price');
        if ($query) {
            return  true;
        } else {         
            return  false;
        }
    }
    
    public function getCity($id) {
        $this->db->where('state_id',$id);        
        $query = $this->db->get('city');
        if ($query->result_array()) {
            return  $query->result_array();
        } else {         
            return  false;
        }
    }
    
    public function getState() {
        $this->db->where('country_id','101');        
        $query = $this->db->get('state');
        if ($query->result_array()) {
            return  $query->result_array();
        } else {         
            return  false;
        }
    }
    
    public function getAllCabFarCalculated() {
        $query = $this->db->get('all_cab_far_price');
        if ($query->result_array()) {
            return  $query->result_array();
        } else {         
            return  false;
        }
    }
    
    public function getAllCabFarCalculatedEdit($id) {
                 $this->db->where('id',$id);
        $query = $this->db->get('all_cab_far_price');
        if ($query->row_array()) {
            return  $query->row_array();
        } else {         
            return  false;
        }
    }
    
    
    
    
    
    
    
    
    
    
}
