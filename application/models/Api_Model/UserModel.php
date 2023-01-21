<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class UserModel extends MY_Model {

        public function saveUserFavoritePalace($postData) {
        
        extract($postData);
        $data = array(  'user_id'=>$user_id,
                        'address'=>isset($address) ? $address : '',
                        'created_at'=>date('Y-m-d h:i:s'),
                        'updated_at'=>date('Y-m-d h:i:s'),
                        'created_by'=> isset($user_id) ? $user_id : '',
                        'updated_by'=> isset($user_id) ? $user_id : '',
        );
        // print_r($data);die;
        $this->db->insert('user_favorite_palace', $data);
        $save = $this->db->insert_id();
        if ($save > 0) {
            return  $save;
        } else {         
            return  false;
        }
    }

    public function userListing() {

        $this->db->where(['type' => 'User']);        
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        } else {         
            return  false;
        }
    }
    
    
     public function getUserFavoritePalace($user_id) {

        $this->db->where(['user_id' => $user_id]);        
        $query = $this->db->get('user_favorite_palace');
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        } else {         
            return  false;
        }
    }
    
    public function getUserLocation($user_id) {
        $this->db->where(['user_id' => $user_id,'user_type'=>'User']);        
        $query = $this->db->get('user_current_locations');
        if ($query->row_array()) {
            return  $query->row_array();
        } else {         
            return  false;
        }
    }
    
      public function checkCurrentLocation($postData) {

        $this->db->where(['user_id' => $postData['id'],'user_type'=> $postData['type']]);        
        $query = $this->db->get('user_current_locations');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }
    
    
    public function saveUserCurrentLocation($postData) {
       // $cabId = $this->db->where('driver_id',$postData['id'])->get('cab')->row_array('id');
        $cabId = $this->db->where('driver_id',$postData['id'])->get('cab')->row_array();
        $data = array(
        'user_id'=>$postData['id'],
        'cab_id' => isset($cabId['id']) ? $cabId['id'] : '',
        'cab_type_id' => isset($cabId['cab_type_id']) ? $cabId['cab_type_id'] : '',
        'user_type'=> isset($postData['type']) ? $postData['type'] : '',
        'city_id'=> isset($postData['city_id']) ? $postData['city_id'] : '',
        'latitude'=>isset($postData['latitude']) ? $postData['latitude'] : '',
        'longitude'=>isset($postData['longitude']) ? $postData['longitude'] : '',
        'created_at'=>date('Y-m-d h:i:s'),
        'updated_at'=>date('Y-m-d h:i:s'),
        'created_by'=> isset($postData['id']) ? $postData['id'] : '',
        'updated_by'=> isset($postData['id']) ? $postData['id'] : '',
        );
        $this->db->insert('user_current_locations', $data);
        $save = $this->db->insert_id();
        if ($save > 0) {
            return  $save;
        } else {         
            return  false;
        }
    }
    
    public function updateUserCurrentLocation($postData) {
        // $cabId = $this->db->where('driver_id',$postData['id'])->get('cab')->row_array('id');
        $cabId = $this->db->where('driver_id',$postData['id'])->get('cab')->row_array();
        $data = array(  
            'city_id'=> isset($postData['city_id']) ? $postData['city_id'] : '',
            'cab_id' => isset($cabId['id']) ? $cabId['id'] : '',
            'cab_type_id' => isset($cabId['cab_type_id']) ? $cabId['cab_type_id'] : '',
            'latitude'=>isset($postData['latitude']) ? $postData['latitude'] : '',
            'longitude'=>isset($postData['longitude']) ? $postData['longitude'] : '',
            'updated_at'=>date('Y-m-d h:i:s'),
            'updated_by'=> isset($postData['id']) ? $postData['id'] : '',
        );
        $this->db->where('user_id', $postData['id']);
        $update = $this->db->update('user_current_locations', $data);
        if ($update > 0) {
            return  $update;
        } else {         
            return  false;
        }
    }
}
