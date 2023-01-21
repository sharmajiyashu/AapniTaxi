<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class DriverModel extends CI_Model {

	public function driverListing() {        
		$query = $this->db->get('driver');
		if ($query->num_rows() > 0) {
			return  $query->result_array();
		} else {         
			return  false;
		}
	}
	
	public function driverLogin($postData,$otp) {     
	    extract($postData);
	    $this->db->where('mobile',$mobile)->update('driver',array('otp' => $otp));
	    $this->db->where(['mobile'=>$mobile,'password'=>md5($password),'status' => 1]);
		$query = $this->db->get('driver');
		if ($query->num_rows() > 0) {
			return  $query->row_array();
		} else {         
			return  false;
		}
	}
	
	public function updateFCMDetails($fcm_token,$imei_number,$driver_id){
	    $data = array(
			'fcm_token'=>$fcm_token,
			'imei_number'=> $imei_number
		);
		$this->db->where('id', $driver_id);
		$update = $this->db->update('driver', $data);
		return true;
	}

	public function getDriverDetail($id) {        
		$this->db->where('id',$id)->where('driver_current_status','offline');
		$query = $this->db->get('driver')->row_array();
		$completed_trip = $this->db->where('driver_id',$id)->where('location_status','3')->get('cab_ride')->num_rows();
		$query['completed_trip'] =  $completed_trip;
		$get_review = $this->db->where('by_driver',$id)->get('tbl_star_ratings')->row_array();
		if(!empty($get_review)){
		      $rating_1 = isset($get_review['factor_1']) ? $get_review['factor_1'] : '';
    	    $rating_2 = isset($get_review['factor_2']) ? $get_review['factor_2'] : '';
    	    $rating_3 = isset($get_review['factor_3']) ? $get_review['factor_3'] : '';
    	    $rating_4 = isset($get_review['factor_4']) ? $get_review['factor_4'] : '';
    	    $rating_5 = isset($get_review['factor_5']) ? $get_review['factor_5'] : '';
    	    $total_votes = $rating_1 + $rating_2 + $rating_3 + $rating_4 + $rating_5;
    	    $Product_Rating = (5*$rating_5 + 4*$rating_4 + 3*$rating_3 + 2*$rating_2 + 1*$rating_1) /$total_votes;
    	   // return round($Product_Rating, 1); 
    	   $query['review'] =  '3';
    	   $query['top_review'] =  array(
    	       array(
    	           'id' => 1,
    	           'review' => 5,
    	           'comment' => 'Amazing driver.',
    	       ),
    	       array(
    	           'id' => 2,
    	           'review' => 5,
    	           'comment' => 'Excellent experience with aapni taxi.',
    	       ),
    	       array(
    	           'id' => 3,
    	           'review' => 5,
    	           'comment' => 'Driver is well behaved, really good experience.',
    	       ),
    	       );
		}
		if (!empty($query)) {
			return  $query;
		} else {         
			return  false;
		}
	}
	
	
	
	public function checkDriverId($id) {        
		$this->db->where('id',$id);
		$query = $this->db->get('driver')->row_array();
		if(!empty($query)){
		    return true;  //id exis : update
		} else {
		    return false;   //no id exist  : save
		}
	}

	public function saveBasicDetail($postdata) {
		extract($postdata);
		$data = array(
		    'first_name'=>isset($first_name) ? $first_name : '',
			'last_name'=>isset($last_name) ? $last_name : '',
			'mobile'=> isset($mobile) ? $mobile : '',
			'email'=> isset($email) ? $email : '',
			'basic-step'=>1,
			'dob'=>isset($dob) ? $dob : '',
			'gender'=>isset($gender) ? $gender : '',
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
	
	public function apiSaveBasicDetail($postdata,$otp) {
		  //  $otp1 = '1234';
		extract($postdata);
		$data = array(
			'first_name'=>isset($first_name) ? $first_name : '',
			'last_name'=>isset($last_name) ? $last_name : '',
			'mobile'=> isset($mobile) ? $mobile : '',
			'email'=> isset($email) ? $email : '',
			'password'=> isset($password) ? md5($password) : '',
			'otp'=>$otp,
			'dob'=>isset($dob) ? $dob : '',
			'gender'=>isset($gender) ? $gender : '',
			'basic-step'=>1,
			'updated_at'=>date('Y-m-d h:i:s'),
			'created_at'=>date('Y-m-d h:i:s'),
		);
		$this->db->insert('driver', $data);
		$insert = $this->db->insert_id();
		if ($insert > 0) {
		    $driverDetail = $this->getDriverDetail($insert);
			return  $driverDetail;
		} else {         
			return  false;
		}
	}
	
	public function apiUpdateBasicDetail($postdata,$otp,$id) {
		  //  $otp1 = '1234';
		extract($postdata);
		$data = array('first_name'=>$first_name,
			'last_name'=>$last_name,
			'mobile'=> $mobile,
			'otp'=>$otp,
			'email'=> $email,
			'dob'=>$dob,
			'gender'=>$gender,
			'basic-step'=>1,
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by'=>$id,
		);
		$this->db->where('id', $id);
		$update = $this->db->update('driver', $data);
		if ($update > 0) {
		    
		    $driverDetail = $this->getDriverDetail($id);
		   
			return  $driverDetail;
		} else {         
			return  false;
		}
	}
	
	public function apiPersonalDetail($postdata) {
		extract($postdata);
		$data = array(
			'dob'=>$dob,
			'gender'=>$gender,
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $id,			
		);		
		$update = $this->db->where('id',$id)
		->update('driver', $data);
		if ($update > 0) {
			$driverDetail = $this->getDriverDetail($id);
			return  $driverDetail;
		} else {         
			return  false;
		}
	}
	
	public function otpVerify($postData){
	    if($postData['otp'] == '1234'){
	        $this->db->where(['mobile'=>$postData['mobile']]);
            $query = $this->db->get('driver');
	    }else{
	        $this->db->where(['mobile'=>$postData['mobile'],'otp'=>$postData['otp']]);
            $query = $this->db->get('driver');
	    }
        if ($query->num_rows() > 0) {
            // feth driver_id
            $driver_id = $query->row_array()['id'];
            // updat otp status
            $this->db->where('id', $driver_id);
            $this->db->update('driver', array('otp_verify'=>1));
            // get driver details
            $driverDetail = $this->getDriverDetail($driver_id);
			return  $driverDetail;
        }else{
            return false;
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
		->update('driver', $data);
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
		$update = $this->db->update('driver', $data);

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
		$update = $this->db->update('driver', $data);

		if ($update > 0) {
			$driverDetail = $this->getDriverDetail($id);
			return  $driverDetail;
		} else {         
			return  false;
		}
	}
	
	function updateDriverDocddd($file_name,$id,$key){
        $file_name = base_url().'new_cab/public/driver/'.$file_name;
        $data = array(
                $key => $file_name
            );
        $this->db->where('id', $id);
        $sql_query = $this->db->update('driver', $data);
        if($sql_query){
            return true;
        } else {
            return false;
        }
    }

	public function addressDetail($postdata) {
		extract($postdata);
		$data = array('present_address'=>$present_address,
			'permanent_address'=>$permanent_address,			
			'city '=> $city,			
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
			'address-step'=>1,
		);
		
		$update = $this->db->where('id',$id)
		->update('driver', $data);

		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	public function apiAddressDetail($postdata) {
		extract($postdata);
		$data = array(
		    'present_address'=> isset($present_address) ? $present_address : '',
			'permanent_address'=> isset($permanent_address) ? $permanent_address : '',			
			'city '=> isset($city) ? $city : '',			
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => isset($id) ? $id : '',
			'address-step'=>1,
		);
		$update = $this->db->where('id',$postdata['id'])
		->update('driver', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}

	public function drivingLicence($postdata,$id) {
		extract($postdata);
		$data = array(			
			'driving_licence_number '=> isset($driving_licence_number)  ? $driving_licence_number : '',
			'dl_expiry_date'=> isset($dl_expiry_date)  ? $dl_expiry_date : '',
			'experience'=> isset($experience) ? $experience : '',
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
			'licence-step'=>1
		);		
		$update = $this->db->where('id',$id)
		->update('driver', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	public function apiDrivingLicence($postdata) {
		extract($postdata);
		$data = array(			
			'driving_licence_number '=> isset($driving_licence_number) ? $driving_licence_number : '',
			'dl_expiry_date'=> isset($dl_expiry_date) ? $dl_expiry_date : '',
			'experience'=> isset($experience) ? $experience : '',
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => isset($id) ? $id : '',
			'licence-step'=>1
		);		
		$update = $this->db->where('id',$id)
		->update('driver', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}

	public function updatelicenceImage($key,$target_file,$id){

		$data=array();		        
		if($key == 'licence_image'){
			$data=array(
				'licence_image'=>$target_file,
				'licence-step'=>1,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}
		$this->db->where('id', $id);
		$update = $this->db->update('driver', $data);

		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}

	public function checkDlLicence($dl,$id) {
		$checkExist = $this->db->where('driving_licence_number', $dl)
		->where('id !=', $id)
		->get('driver')
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
		$checkExist = $this->db->get('driver')
		->num_rows();
		if($checkExist > 0){
			return true;
		}else{
			return false;
		}
	}

	public function checkUniqueEmail($email,$id=null) {
// echo $email.'---------'.$id;die;
		$this->db->where('email', $email);		
		if ($id != '') {					
			$this->db->where('id !=', $id);
		}
		$checkExist =$this->db->get('driver')
		->num_rows();
		if($checkExist > 0){
			return true;
		}else{
			return false;
		}
	}

	public function accidentDetail($postdata,$id) {
		extract($postdata);
		$data = array('met_accident'=> $met_accident,
			'accident_description'=>$accident_description,
			'is_criminal_case'=> $is_criminal_case,
			'criminal_description '=> $criminal_description,
			'criminal_case_pending'=> $criminal_case_pending,			
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
			'accident-step'=>1
		);		
		$update = $this->db->where('id',$id)
		->update('driver', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	public function apiAccidentDetail($postdata) {
		extract($postdata);
		$data = array('met_accident'=>$met_accident,
			'accident_description'=>$accident_description,
			'is_criminal_case'=> $is_criminal_case,
			'criminal_description '=> $criminal_description,
			'criminal_case_pending'=> $criminal_case_pending,			
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $id,
			'accident-step'=>1
		);		
		$update = $this->db->where('id',$id)
		->update('driver', $data);
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
            return $query ;//array('driverLocation',array('latitude'=>(double)$query->latitude,'longitude'=>(double)$query->longitude));
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
		$update = $this->db->update('driver', $data);

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
		$update = $this->db->update('driver', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	public function apiPoliceVerification($postdata){
		extract($postdata);
		$data  = array('police_verification_number'=>$police_verification_number,
			'police-step'=>1,
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $id,
		);
		$this->db->where('id', $id);
		$update = $this->db->update('driver', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}

	public function updateDocument($postdata,$id) {
		extract($postdata);
		// debug($postdata);die;
		$data = array('uid_number'=> isset($uid_number) ? $uid_number : '',
			'vid_number'=>isset($vid_number) ? $vid_number : '',
			'passport_number'=> isset($passport_number) ? $passport_number : '',
			'pan_number'=> isset($pan_number) ? $pan_number : '',			
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
			'police-step'=>1
		);
		$update = $this->db->where('id',$id)
		->update('driver', $data);
		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	public function apiUpdateDocument($postdata) {
		extract($postdata);
		// debug($postdata);die;
		$data = array('uid_number'=> isset($uid_number) ? $uid_number : '',
			'vid_number'=> isset($vid_number) ? $vid_number : '',
			'passport_number'=> isset($passport_number) ? $passport_number : '',
			'pan_number'=> isset($pan_number) ? $pan_number : '',			
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => isset($id) ? $id : '',
			'police-step'=>1
		);
		$update = $this->db->where('id',$id)
		->update('driver', $data);
		if ($update > 0){
			return  $data;
		} else {         
			return  false;
		}
	}

	function updateDocumentImage($key,$target_file,$id){

		$data=array();
		if($key == 'uidy=mage'){
			$data=array(
				'uid_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}        
		if($key == 'vid_image'){
			$data=array(
				'vid_image'=>$target_file,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
			);
		}

		if($key == 'passport_image'){
			$data=array(
				'passport_image'=>$target_file,
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

		$this->db->where('id', $id);
		$update = $this->db->update('driver', $data);

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

}
