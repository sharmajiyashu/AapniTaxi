<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class CabModel extends CI_Model {
    
    public function apiSaveCabDetail($postdata) {
    
        extract($postdata);
        
        // we are getting cab_type_id in variable from the app end cab_type_name i.e. 
        $new_cab_type_id = $cab_type_name;
        
        //Get the cab_type_name on the basic of cab_type_id
        $new_cab_type_name = $this->getCabTypeName($new_cab_type_id);
         
         
        // we are getting cab_category_id in variable from the app end cab_category_name i.e. 
        $new_cab_category_id = $cab_category_name;
        
        //Get the cab_category_name on the basic of cab_category_id
        $new_cab_category_name = $this->getCabTypeName($new_cab_category_id);
         
       
        if(!empty($new_cab_type_name) && $new_cab_type_name != '' && !empty($new_cab_category_name) && $new_cab_category_name != ''){
           
           // get cab type
            $cabTypeData = $this->getCabCategoryDataByName($new_cab_type_name);
            $cab_type_id = isset($cabTypeData['id'])  ? $cabTypeData['id'] : '';
            //get cab id
            $cabCategoryData = $this->getCabCategoryDataByName($new_cab_category_name);
            $cab_category_id = isset($cabCategoryData['id']) ? $cabCategoryData['id'] : '';
            
          $data = array(
            'driver_id'=> isset($driver_id) ? $driver_id : '',
            'cab_category_id'=> isset($cab_category_id) ? $cab_category_id : '',
            'cab_category_name'=> isset($new_cab_category_name) ? $new_cab_category_name : '',
            'cab_type_id'=> isset($cab_type_id) ? $cab_type_id : '',
            'cab_type_name'=> isset($new_cab_type_name) ? $new_cab_type_name : '',
            'registration_number'=> isset($registration_number) ? $registration_number : '',
            'rc_expiry_date'=> isset($rc_expiry_date) ? $rc_expiry_date : '',
            'manufacture_year'=> isset($manufacture_year)  ? $manufacture_year : '',
            'engine_number'=> isset($engine_number) ? $engine_number : '',
            'chassis_number '=> isset($chassis_number) ? $chassis_number : '',
            'is_insurance'=> isset($is_insurance) ? $is_insurance : '',
            'insurance_number'=> isset($insurance_number) ? $insurance_number : '',
            'insurance_expiry_date'=> isset($insurance_expiry_date) ? $insurance_expiry_date : '',
            'is_fitness'=> isset($is_fitness) ? $is_fitness : '',
            'fitness_number'=> isset($fitness_number) ? $fitness_number : '',
            'fitness_expiry_date'=> isset($fitness_expiry_date)  ? $fitness_expiry_date : '',
            'is_puc'=> isset($is_puc)  ? $is_puc : '',
            'puc_number'=> isset($puc_number) ? $puc_number : '',
            'puc_expiry_date'=> isset($puc_expiry_date)  ? $puc_expiry_date : '',
            'cab_model_name'=> isset($cab_model_name) ? $cab_model_name : '',
            'owner_name'=> isset($owner_name) ? $owner_name : '',
            'status'=>0,
            'created_at'=>date("Y-m-d h:i:s"),
            'created_by'=> isset($driver_id) ? $driver_id : '',
            'updated_by'=> isset($driver_id) ? $driver_id : '',
            'updated_at'=>date("Y-m-d h:i:s"),
            );
            
            $this->db->insert('cab', $data);
            $id = $this->db->insert_id();
            if ($id > 0) {
                $cabData = $this->getCabDetail($id);
                $this->db->where('id',$driver_id);
                $this->db->update('driver', array('cab_id' => $id));
                return  $cabData;
            } else {         
                return  false;
            }
             
         } else {
             return false;
         }
    }
    
    public function apiUpdateCabDetail($postdata) {
        extract($postdata);
        
        // we are getting cab_type_id in variable from the app end cab_type_name i.e. 
        $new_cab_type_id = $cab_type_name;
        
        //Get the cab_type_name on the basic of cab_type_id
        $new_cab_type_name = $this->getCabTypeName($new_cab_type_id);
         
         
        // we are getting cab_category_id in variable from the app end cab_category_name i.e. 
        $new_cab_category_id = $cab_category_name;
        
        //Get the cab_category_name on the basic of cab_category_id
        $new_cab_category_name = $this->getCabTypeName($new_cab_category_id);
         
        if(!empty($new_cab_type_name) && $new_cab_type_name != '' && !empty($new_cab_category_name) && $new_cab_category_name != ''){
        
            // get cab type
            $cabTypeData = $this->getCabCategoryDataByName($new_cab_type_name);
            $cab_type_id = $cabTypeData['id'];
            //get cab id
            $cabCategoryData = $this->getCabCategoryDataByName($new_cab_category_name);
            $cab_category_id = $cabCategoryData['id'];
            
           $data = array(
            'driver_id'=> isset($driver_id) ? $driver_id : '',
            'cab_category_id'=> isset($cab_category_id) ? $cab_category_id : '',
            'cab_category_name'=> isset($new_cab_category_name) ? $new_cab_category_name : '',
            'cab_type_id'=> isset($cab_type_id) ? $cab_type_id : '',
            'cab_type_name'=> isset($new_cab_type_name) ? $new_cab_type_name : '',
            'registration_number'=> isset($registration_number) ? $registration_number : '',
            'rc_expiry_date'=> isset($rc_expiry_date) ? $rc_expiry_date : '',
            'manufacture_year'=> isset($manufacture_year) ? $manufacture_year : '',
            'engine_number'=> isset($engine_number) ? $engine_number : '',
            'chassis_number '=> isset($chassis_number) ? $chassis_number : '',
            'is_insurance'=> isset($is_insurance) ? $is_insurance : '',
            'insurance_number'=> isset($insurance_number) ? $insurance_number : '',
            'insurance_expiry_date'=> isset($insurance_expiry_date) ? $insurance_expiry_date : '',
            'is_fitness'=> isset($is_fitness) ? $is_fitness : '',
            'fitness_number'=> isset($fitness_number) ? $fitness_number : '',
            'fitness_expiry_date'=> isset($fitness_expiry_date) ? $fitness_expiry_date : '',
            'is_puc'=> isset($is_puc) ? $is_puc : '',
            'puc_number'=> isset($puc_number) ? $puc_number : '',
            'puc_expiry_date'=> isset($puc_expiry_date) ? $puc_expiry_date : '',
            'cab_model_name'=> isset($cab_model_name) ? $cab_model_name : '',
            'owner_name'=> isset($owner_name)  ? $owner_name : '',
            'status'=>0,
            'updated_by'=> isset($cab_id)  ? $cab_id : '',
            'updated_at'=>date("Y-m-d h:i:s"),
            );
            $this->db->where('id',$cab_id);
            $update = $this->db->update('cab', $data);
            if ($update) {
                $cabData = $this->getCabDetail($cab_id);
                return  $cabData;
            } else {         
                return  false;
            }
        } else {
            return false;
        }
    }
    
    public function getCabCategoryDataByName($cabName) {
        $this->db->where('name',$cabName);        
        $query = $this->db->get('cab-category');
        if ($query->row_array()) {
            return  $query->row_array();
        } else {         
            return  false;
        }
    }
    
    public function getCabTypeName($cab_type_id) {
        $this->db->where('id',$cab_type_id);        
        $query = $this->db->select('name')->get('cab-category')->row_array();
        if(!empty($query)){
            if(isset($query['name'])){
                return $query['name'];
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
        
   public function getCabDetail($id=null) {
        $this->db->where('id',$id);        
        $query = $this->db->get('cab');
        if ($query->row_array()) {
            return  $query->row_array();
        } else {         
            return  $this->cabDetailBlankArray();
        }
    }
    
    public function cabDetailBlankArray(){
        return $data = array(
        "id"=>"",
        "driver_id"=>"",
        "cab_category_id"=>"",
        "cab_category_name"=>"",
        "cab_type_id"=>"",
        "cab_type_name"=>"",
        "registration_number"=>"",
        "engine_number"=>"",
        "chassis_number"=>"",
        "rc"=>"",
        "rc_expiry_date"=> "",
        "is_insurance"=> "",
        "insurance_number"=> "",
        "insurance_expiry_date"=> "",
        "is_fitness"=>"",
        "fitness_number"=> "",
        "fitness_expiry_date" =>"",
        "is_puc"=> "",
        "puc_number"=> "",
        "puc_expiry_date" =>"",
        "rc_front_image"=> "",
        "rc_back_image"=> "",
        "insurance_image"=> "",
        "fitness_image"=> "",
        "puc_image"=> "",
        "car_model_id" =>"",
        "cab_model_name"=> "",
        "owner_name"=> "",
        "owner_image"=>"",
        "vehicle_image1"=> "",
        "vehicle_image2"=>"",
        "vehicle_image3"=>"",
        "vehicle_image4"=>"",
        "manufacture_year"=>"",
        "owner_id"=>"",
        "status"=> "",
        "created_at"=> "",
        "updated_at"=> "",
        "created_by"=> "",
        "updated_by"=> ""
        );
    }
    
    public function getCabDetailByDriverId($id=null) {

        $this->db->where('driver_id',$id);        
        $query = $this->db->get('cab');
        if ($query->row_array()) {
            return  $query->row_array();
        } else {         
            return  $this->cabDetailBlankArray();
        }
    }
    
    function updateCabDoc($key,$file_name,$id){
			$data=array(
				$key=>$file_name,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $id,
			);
		if(empty($data)){
		    return false;
		}
		$this->db->where('id', $id);
		$update = $this->db->update('cab', $data);
		if ($update > 0) {
			$cabDetail = $this->getCabDetail($id);
			return  $cabDetail;
		} else {         
			return  false;
		}
	}
	
	public function checkUniqeVehicleNumber($registration_number,$id) {
	    
	    if(isset($id) && $id != '' && $id != 0){
	    
	        $this->db->where('id != ',$id);
	    }
        $this->db->where('registration_number',$registration_number);        
        $query = $this->db->get('cab');
        if ($query->num_rows()) {
            return  $query->num_rows();
        } else {
            return 0;
        }
    }
    
    public function checkUniqeEngineNumber($engine_number,$id) {
        if(isset($id) && $id != '' && $id != 0){
	        $this->db->where('id != ',$id);
	    }
        $this->db->where('engine_number',$engine_number);        
        $query = $this->db->get('cab');
        if ($query->num_rows()) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }
    
    public function checkUniqeChassisNumber($chassis_number,$id) {
        if(isset($id) && $id != '' && $id != 0){
	        $this->db->where('id != ',$id);
	    }
        $this->db->where('chassis_number',$chassis_number);        
        $query = $this->db->get('cab');
        if ($query->num_rows()) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }
    
    public function checkUniqeInsuranceNumber($insurance_number,$id) {
        if(isset($id) && $id != '' && $id != 0){
	        $this->db->where('id != ',$id);
	    }
        $this->db->where('insurance_number',$insurance_number);        
        $query = $this->db->get('cab');
        if ($query->num_rows()) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }
    
    public function checkUniqeFitnessNumber($fitness_number,$id) {
        if(isset($id) && $id != '' && $id != 0){
	        $this->db->where('id != ',$id);
	    }
        $this->db->where('fitness_number',$fitness_number);        
        $query = $this->db->get('cab');
        if ($query->num_rows()) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }
    
    public function checkUniqePucNumber($puc_number,$id) {
        if(isset($id) && $id != '' && $id != 0){
	        $this->db->where('id != ',$id);
	    }
        $this->db->where('puc_number',$puc_number);        
        $query = $this->db->get('cab');
        if ($query->num_rows()) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }
    
	
}
