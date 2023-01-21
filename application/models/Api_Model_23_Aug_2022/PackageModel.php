<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class PackageModel extends CI_Model {

    
    public function savePackage($postdata) {
        extract($postdata);
        $data = array(
        'user_id'=>$user_id,
        'vehicle_type'=>$vehicle_type,
        'vechicle_name'=>$vechicle_name,
        'cab_id'=>$cab_id,
        'driver_id'=>$driver_id,
        'current_location'=>$current_location,
        'source_location'=>$source_location,
        'package_description'=>$package_description,
        'package_weight'=>$package_weight,
        'created_at'=>date('Y-m-d h:i:s'),
        'updated_at'=>date('Y-m-d h:i:s'),
        'created_by'=>$postdata['user_id'],
        'updated_by'=>$postdata['user_id']
        );
        $this->db->insert('package', $data);
        $insert = $this->db->insert_id();
        if ($insert > 0) {
            return  true;
        } else {         
            return  false;
        }
    }
    
    public function cancelPackage($postdata) {

        extract($postdata);
        $data = array(
                        'canceled_type'=>'User',
                        'canceled_reason'=>$canceled_reason,
                        'canceled'=>1,
                        'updated_at'=>date('Y-m-d h:i:s'),
                        'updated_by'=>$postdata['user_id']
        );
    
        $this->db->where('id',$id);
        $update = $this->db->update('package', $data);
        
        if ($update) {
            return  true;
        } else {         
            return  false;
        }
    }
    
    
    
    public function getWalletAmount($user_id) {
        
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('wallet');
        if ($query->num_rows() > 0) {
            return  $query->row_array();
        } else {         
            return  false;
        }
    }
    
    
}
