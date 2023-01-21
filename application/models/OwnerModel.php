<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class OwnerModel extends CI_Model {


	public function saveBasicDetail($postdata) {
		extract($postdata);
		$data = array(
		    'first_name'=>isset($first_name) ? $first_name : '',
			'last_name'=>isset($last_name) ? $last_name : '',
			'mobile'=> isset($mobile) ? $mobile : '',
			'email'=> isset($email) ? $email : '',
			'basic-step'=>1,
			'dob'=>isset($dob) ? date('Y-m-d',strtotime($dob)) : '',
			'gender'=>isset($gender) ? $gender : '',
			'is_owner' => 'Yes',
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
			'created_at'=>date('Y-m-d h:i:s'),
			'created_by' => $this->session->userdata('user_id'),
		);
	
		$this->db->insert('owner', $data);
		$insert = $this->db->insert_id();
		if ($insert > 0) {
			return  $insert;
		} else {         
			return  false;
		}
	}
	

	public function updateBasicDetail($postdata,$id) {

		extract($postdata);
		$data = array('first_name'=>$first_name,
			'last_name'=>$last_name,
			'mobile'=> $mobile,
			'email'=> $email,
			'basic-step'=>1,
			'dob'=>$dob,
			'gender'=>$gender,
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),			
		);		
		$update = $this->db->where('id',$id)
		->update('owner', $data);
		if ($update > 0) {
			return  $update;
		} else {         
			return  false;
		}
	}

	public function updateProfilePhoto($key,$target_file,$id){

		$data=array();		        
		if($key == 'profile_pic'){
			$data=array(
				'profile_pic'=>$target_file,
				'basic-step'=>1,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}
		$this->db->where('id', $id);
		$update = $this->db->update('owner', $data);

		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	
	function updateDriverDoc($key,$file_name,$id){
		$data=array(
			$key=>$file_name,
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $id,
		);
		if(empty($data)){
		    return false;
		}
		$this->db->where('id', $id);
		$update = $this->db->update('owner', $data);

		if ($update > 0) {
			$driverDetail = $this->getDriverDetail($id);
			return  $driverDetail;
		} else {         
			return  false;
		}
	}
	
	function updateDriverDocddd($file_name,$id,$key){
        $file_name = base_url().'public/driver/'.$file_name;
        $data = array(
                $key => $file_name
            );
        $this->db->where('id', $id);
        $sql_query = $this->db->update('owner', $data);
        if($sql_query){
            return true;
        } else {
            return false;
        }
    }

	public function addressDetail($postdata,$id) {
		extract($postdata);

		$data = array('present_address'=> isset($present_address) ? $present_address : '',
			'permanent_address'=> isset($permanent_address) ? $permanent_address : '',			
			'city '=> isset($city) ? $city : '',			
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
			'address-step'=>1,
		);
		$update = $this->db->where('id',$id)
		->update('owner', $data);

		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	public function drivingLicence($postdata,$id) {
		extract($postdata);
		$data = array(			
			'driving_licence_number '=> isset($driving_licence_number) ? $driving_licence_number : '',
			'dl_expiry_date'=> date('Y-m-d',strtotime($dl_expiry_date)),
			'experience'=> isset($experience) ? $experience : '',
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
			'licence-step'=>1
		);		
		$update = $this->db->where('id',$id)
		->update('owner', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	public function updatelicenceImage($key,$target_file,$id){

		$data=array();		        
		if($key == 'licence_front_image'){
			$data=array(
				'licence_front_image'=>$target_file,
				'licence-step'=>1,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}
		if($key == 'licence_back_image'){
			$data=array(
				'licence_back_image'=>$target_file,
				'licence-step'=>1,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}
		$this->db->where('id', $id);
		$update = $this->db->update('owner', $data);

		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}

	public function checkDlLicence($dl,$id) {
		$checkExist = $this->db->where('driving_licence_number', $dl)
		->where('id !=', $id)
		->get('owner')
		->num_rows();
		if($checkExist > 0){
			return true;
		}else{
			return false;
		}
	}
	public function checkUniqueMobile($mobile,$id=null) {
		$this->db->where('mobile', $mobile);
		if ($id != '') {					
			$this->db->where('id !=', $id);
		}
		$checkExist = $this->db->get('owner')
		->num_rows();
		if($checkExist > 0){
			return true;
		}else{
			return false;
		}
	}
	public function checkUniqueEmail($email,$id=null) {
		$this->db->where('email', $email);		
		if ($id != '') {					
			$this->db->where('id !=', $id);
		}
		$checkExist =$this->db->get('owner')
		->num_rows();
		if($checkExist > 0){
			return true;
		}else{
			return false;
		}
	}
	public function accidentDetail($postdata,$id) {
		extract($postdata);
		$data = array('met_accident'=>$met_accident,
			'accident_description'=>$accident_description,
			'is_criminal_case'=> $is_criminal_case,
			'criminal_description '=> $criminal_description,
			'criminal_case_pending'=> $criminal_case_pending,			
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
			'accident-step'=>1
		);		
		$update = $this->db->where('id',$id)
		->update('owner', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	public function getDriverCurrentLocation($user_id) {
	    $this->db->select('latitude,longitude');
        $this->db->where(['user_id' => $user_id,'user_type'=>'Driver']);        
        $query = $this->db->get('user_current_locations')->row();
        if (!empty($query)) {
            return $query ;
        } else {         
                $data = array('driverLocation',array('latitude'=>(double)$query['latitude'],'longitude'=>(double)$query['longitude']));
        }
    }
	function updatePoliceDocument($key,$target_file,$id){

		$data=array();
		if($key == 'police_verification_image'){
			$data=array(
				'police_verification_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}        		
		$this->db->where('id', $id);
		$update = $this->db->update('owner', $data);

		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}

	public function policeVerification($postdata,$id){
		extract($postdata);
		$data  = array('police_verification_number'=>$police_verification_number,
			'police-step'=>1,
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
		);
		$this->db->where('id', $id);
		$update = $this->db->update('owner', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	

	public function updateDocument($postdata,$id) {
		extract($postdata);
		$data = array('uid_number'=> isset($uid_number) ? $uid_number : '',
			'vid_number'=>isset($vid_number) ? $vid_number : '',
			'passport_number'=> isset($passport_number) ? $passport_number : '',
			'pan_number'=> isset($pan_number) ? $pan_number : '',			
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
			'police-step'=>1
		);
		$update = $this->db->where('id',$id)
		->update('owner', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	function updateDocumentImage($key,$target_file,$id){

		$data=array();
		if($key == 'uid_image'){
			$data=array(
				'uid_front_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		} 
		
		if($key == 'uid_image_back'){
			$data=array(
				'uid_back_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}   
		
		if($key == 'vid_image'){
			$data=array(
				'vid_front_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}

		if($key == 'passport_image'){
			$data=array(
				'passport_front_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}        
		if($key == 'pan_image'){
			$data=array(
				'pan_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}
		
		if($key == 'pan_image_back'){
			$data=array(
				'pan_image_back'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}

		$this->db->where('id', $id);
		$update = $this->db->update('owner', $data);

		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	public function updateVehicel($postdata) {
		extract($postdata);
		$data = array(
		    'registration_number'=> isset($registration_number) ? $registration_number : '',
			'engine_number	'=>isset($engine_number	) ? $engine_number : '',
			'chassis_number'=> isset($chassis_number) ? $chassis_number : '',
			'rc'=> isset($rc) ? $rc : '',
			'rc_expiry_date	'=>isset($rc_expiry_date) ? $rc_expiry_date : '',
			'is_insurance'=> isset($is_insurance) ? $is_insurance : '',
			'insurance_number'=> isset($insurance_number) ? $insurance_number : '',
			'insurance_expiry_date	'=>isset($insurance_expiry_date	) ? $insurance_expiry_date	 : '',
			'is_fitness'=> isset($is_fitness) ? $is_fitness : '',
			'fitness_number'=> isset($fitness_number) ? $fitness_number : '',
			'fitness_expiry_date'=> isset($fitness_expiry_date) ? $fitness_expiry_date : '',
			'is_puc'=> isset($is_puc) ? $is_puc : '',
			'puc_number	'=>isset($puc_number) ? $puc_number	 : '',
			'puc_expiry_date'=> isset($puc_expiry_date) ? $puc_expiry_date : '',
			'cab_type_id'=> isset($cab_type_id) ? $cab_type_id : '',
			'cab_type_name' => isset($cab_type_name) ? $cab_type_name : '',
			'cab_model_name'=> isset($cab_model_name) ? $cab_model_name : '',
			'owner_name	'=>isset($owner_name) ? $owner_name	 : '',
			'manufacture_year'=> isset($manufacture_year) ? $manufacture_year : '',
			'is_owner' => 'Yes',
			'owner_id' => isset($owner_id) ? $owner_id : '',
			'status' => 0,
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
		);
		$this->db->insert('cab', $data);
		$insert_id = $this->db->insert_id();
		if ($insert_id > 0) {
			return  $insert_id;
		} else {         
			return  false;
		}
	}
	
	function updateVehicelImage($key,$target_file,$id){
		$data=array();
		if($key == 'rc_front_image'){
			$data=array(
				'rc_front_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}        
		if($key == 'rc_back_image'){
			$data=array(
				'rc_back_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}

		if($key == 'insurance_image'){
			$data=array(
				'insurance_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}        
		if($key == 'fitness_image'){
			$data=array(
				'fitness_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}
		
		if($key == 'puc_image'){
			$data=array(
				'puc_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}
		
		if($key == 'owner_image'){
			$data=array(
				'owner_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}
		$update =  $this->db->where('id',$id)->update('cab', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}

	public function deleteDriver($id) {
		$this->db->where('id',$id);        
		$query = $this->db->delete('driver');
		if ($query) {
			return  true;
		} else {         
			return  false;
		}
	}
	
	public function getOwnerDetail($id) {        
		$this->db->where('id',$id)->where('driver_current_status','online');
		$query = $this->db->get('owner');
		if ($query->num_rows() > 0) {
			return  $query->row_array();
		} else {         
			return  false;
		}
	}
	
	public function getDriverDetail($id) {        
		$this->db->where('id',$id);
		$query = $this->db->get('driver');
		if ($query->num_rows() > 0) {
			return  $query->row_array();
		} else {         
			return  false;
		}
	}
	
	public function getCabCategory(){
	    $data = $this->db->query('SELECT id,name FROM `cab-category` WHERE parent_id = 0');
	    if($data->num_rows() > 0){
	        return $data->result_array();
	    }else{
	       return false; 
	    }
	}
	
	public function driverListing(){
	   $data =  $this->db->where('is_owner','Yes')->get('driver')->result_array();
	   if(!empty($data)){
	       return $data;
	   }else{
	     return false;
	   }
	}
	
	public function vehicleListing(){
	  $data = $this->db->where('is_owner','Yes')->get('cab')->result_array();
	  if(!empty($data)){
	      return $data;
	  }else{
	      return false;
	  }
	}
	
	#Owner Should be Add Driver Details
	public function saveBasicDetailDriver($postdata) {
		extract($postdata);
		$data = array(
		    'first_name'=>isset($first_name) ? $first_name : '',
			'last_name'=>isset($last_name) ? $last_name : '',
			'mobile'=> isset($mobile) ? $mobile : '',
			'email'=> isset($email) ? $email : '',
			'basic-step'=>1,
			'dob'=>isset($dob) ? date('Y-m-d',strtotime($dob)) : '',
			'gender'=>isset($gender) ? $gender : '',
			'is_owner' => 'Yes',
			'owner_id' => isset($owner_id) ? $owner_id : '',
			'driver_current_status' => 'offline',
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
			'created_at'=>date('Y-m-d h:i:s'),
			'created_by' => $this->session->userdata('user_id'),
		);
		$this->db->insert('driver', $data);
		$insert = $this->db->insert_id();
		if ($insert > 0) {
			return  $insert;
		} else {         
			return  false;
		}
	}
	
// 	public function mapDriverVehicle($postData){
// 	    extract($postData);
// 	    $new_arr = array(); 
// 	    foreach($alldriver as $key => $value){
// 	        $new_arr[$key]['driver_id'] = $value;
// 	    }
// 	    $new_arr1 = array();
// 	    foreach($new_arr as $key => $value){
// 	       foreach($shift_start_time as $key1 => $value1){
// 	        $new_arr1[$key] = $value;
// 	        $new_arr1[$key1]['start_time'] = $value1;
// 	       }
// 	    }
// 	    $new_arr2 = array();
// 	    foreach($new_arr1 as $key => $value){
// 	        foreach($shift_end_time as $key1 => $value1){
//     	        $new_arr2[$key] = $value;
//     	        $new_arr2[$key1]['end_time'] = $value1;
// 	        }
// 	    }
	    
// 	    foreach($new_arr2 as $key => $value){
//     	    $data = array(
//     	     'driver_id' => isset($value['driver_id']) ? $value['driver_id'] : '',
//     	     'cab_id' => isset($cab_id) ? $cab_id : '',
//     	     'shift_start_time' => isset($value['start_time']) ? $value['start_time'] : '',
//     	     'shift_end_time' => isset($value['end_time']) ? $value['end_time'] : ''
//     	   );
//     	   $this->db->insert('shift',$data);
// 	   }
// 	}
}
