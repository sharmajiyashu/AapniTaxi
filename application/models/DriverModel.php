<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class DriverModel extends CI_Model {

	public function driverListing() {        
		$query = $this->db->query('SELECT * FROM `driver` WHERE is_owner != "Yes"  ORDER BY created_at DESC');
		if ($query->num_rows() > 0) {
			return  $query->result_array();
		} else {         
			return  false;
		}
	}
	
	public function driverLogin($postData) {        
	    $this->db->where(['mobile'=>$postData['mobile'],'password'=>md5($postData['password'])]);
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
	
	public function getDriverDetails($id) {        
		$this->db->where('id',$id);
		$query = $this->db->get('driver');
		if ($query->num_rows() > 0) {
			return  $query->row_array();
		} else {         
			return  false;
		}
	}

	public function getDriverDetail($id) {        
		$this->db->where('id',$id)->where('driver_current_status','online');
		$query = $this->db->get('driver');
		if ($query->num_rows() > 0) {
			return  $query->row_array();
		} else {         
			return  false;
		}
	}
	
	public function getVehicleDetail($id) {        
        $query = $this->db->where('driver_id',$id)->get('cab');		
        if ($query->num_rows() > 0) {
			return  $query->row_array();
		} else {         
			return  false;
		}
	}


	function save_driver_refferal($insert_id,$referral_code){
        $user_data = $this->db->where('referral_code',$referral_code)->get('driver')->row_array();
        $referral_from = isset($user_data['user_id']) ? $user_data['user_id'] :'';
        $refferal_to = isset($insert_id) ? $insert_id :'';
        $refferal_bonus = $this->db->where('type','driver_referral_bonus')->get('referral_master')->row_array();
        $refferal_bonus = isset($refferal_bonus['amount']) ? $refferal_bonus['amount'] :'0';

        $refferal_data = array(
            'driver_id' => isset($user_data['id']) ? $user_data['id'] :'',
            'mobile'  => isset($user_data['mobile']) ? $user_data['mobile'] :'',
            'email'  => isset($user_data['email']) ? $user_data['email'] :'',
			'type' => 'driver',
			'referral_to' => isset($insert_id) ? $insert_id :'',
            'referral_date'  => date('Y-m-d h:i:s'),
            'referral_earn_amount' => isset($refferal_bonus) ? $refferal_bonus :'0',            
        );
        $this->db->insert('referral_mapping',$refferal_data);

        $user_wallet = $this->db->where('user_id',$user_data['id'])->where('type','Driver')->get('wallet')->row_array();
        if(empty($user_wallet)){
            $wallet_amount = $refferal_bonus;
            $wallet_data = array(
                'user_id' => $user_data['id'],
                'wallet_amount' => $refferal_bonus,
                'type' => 'Driver',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            );
            $this->db->insert('wallet',$wallet_data);
        }else{
            $wallet_amount = $refferal_bonus + $user_wallet['wallet_amount'];
            $wallet_data = array(
                'wallet_amount' => $refferal_bonus + $user_wallet['wallet_amount'],
                'updated_at' => date('Y-m-d h:i:s'),
            );
            $this->db->where('wallet_id',$user_wallet['wallet_id'])->update('wallet',$wallet_data);
        }

        $data2 = ['user_id'=>$user_data['id'],'wallet_amount'=>$wallet_amount,'transaction_amount'=>$refferal_bonus,'transaction_type'=>'cr','type' => 'Driver','created_by'=>$user_data['id'],'created_at'=>date('Y-m-d h:i:s')];
        $this->db->insert('wallet_history', $data2);


    }


	public function saveBasicDetail($postdata) {
		extract($postdata);

		$referral_code = isset($postdata['referral_code']) ? $postdata['referral_code'] :'';
		if(!empty($referral_code)){
			$data = array(
				'first_name'=>isset($first_name) ? $first_name : '',
				'last_name'=>isset($last_name) ? $last_name : '',
				'mobile'=> isset($mobile) ? $mobile : '',
				'email'=> isset($email) ? $email : '',
				'from_referral_code' => $referral_code,
				'basic-step'=>1,
				'dob'=>isset($dob) ? date('Y-m-d',strtotime($dob)) : '',
				'password'=> isset($password) ? md5($password) : '',
				'password_show' => isset($password) ? $password : '',
				'gender'=>isset($gender) ? $gender : '',
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
				'created_at'=>date('Y-m-d h:i:s'),
				'created_by' => $this->session->userdata('user_id'),
			);
			$this->db->insert('driver', $data);
			$insert = $this->db->insert_id();
			$this->save_driver_refferal($insert,$referral_code);
		}else{
			$data = array(
				'first_name'=>isset($first_name) ? $first_name : '',
				'last_name'=>isset($last_name) ? $last_name : '',
				'mobile'=> isset($mobile) ? $mobile : '',
				'email'=> isset($email) ? $email : '',
				'basic-step'=>1,
				'dob'=>isset($dob) ? date('Y-m-d',strtotime($dob)) : '',
				'password'=> isset($password) ? md5($password) : '',
				'password_show' => isset($password) ? $password : '',
				'gender'=>isset($gender) ? $gender : '',
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $this->session->userdata('user_id'),
				'created_at'=>date('Y-m-d h:i:s'),
				'created_by' => $this->session->userdata('user_id'),
			);
			$this->db->insert('driver', $data);
			$insert = $this->db->insert_id();
		}

		if(!empty($insert)){
            $id = str_pad($insert, 6, "0", STR_PAD_LEFT);
            $refferal_code = strrev ($id);
            $refferal_code = 'ATD'.$refferal_code;
            $update_refferal = array(
                'referral_code' => $refferal_code
            );
            $this->db->where('id',$insert)->update('driver',$update_refferal);
        } 
		
		if ($insert > 0) {
			return  $insert;
		} else {         
			return  false;
		}
	}
	
	public function apiSaveBasicDetail($postdata,$otp) {
		extract($postdata);
		$data = array('first_name'=>$first_name,
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
        
        $this->db->where(['mobile'=>$postData['mobile'],'otp'=>$postData['otp']]);
        $query = $this->db->get('driver');
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
        $file_name = base_url().'public/driver/'.$file_name;
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
		->update('driver', $data);

		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	public function apiAddressDetail($postdata) {
		extract($postdata);
		$data = array('present_address'=>$present_address,
			'permanent_address'=>$permanent_address,			
			'city '=> $city,			
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $id,
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
			'driving_licence_number '=> isset($driving_licence_number) ? $driving_licence_number : '',
			'dl_expiry_date'=> date('Y-m-d',strtotime($dl_expiry_date)),
			'experience'=> isset($experience) ? $experience :'',
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
			'driving_licence_number '=> $driving_licence_number,
			'dl_expiry_date'=> $dl_expiry_date,
			'experience'=> $experience,
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $id,
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
		$update = $this->db->update('driver', $data);

		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}
	
	public function updateVehicle($postdata,$id) {
		extract($postdata);
		$cab_type_name = $this->db->select('name')->where('id',$cab_type_id)->get('cab-category')->row_array();
		$data = array('driver_id' => isset($id) ? $id : '',
		    'registration_number'=> isset($registration_number) ? $registration_number : '',
			'engine_number	'=>isset($engine_number	) ? $engine_number : 'null',
			'chassis_number'=> isset($chassis_number) ? $chassis_number : 'null',
			'rc'=> isset($rc) ? $rc : 'null',
			'rc_expiry_date	'=>isset($rc_expiry_date) ? $rc_expiry_date : 'null',
			'is_insurance'=> isset($is_insurance) ? $is_insurance : 'Yes',
			'insurance_number'=> isset($insurance_number) ? $insurance_number : 'null',
			'insurance_expiry_date	'=>isset($insurance_expiry_date	) ? $insurance_expiry_date	 : 'null',
			'is_fitness'=> isset($is_fitness) ? $is_fitness : 'Yes',
			'fitness_number'=> isset($fitness_number) ? $fitness_number : 'null',
			'fitness_expiry_date'=> isset($fitness_expiry_date) ? $fitness_expiry_date : 'null',
			'is_puc'=> isset($is_puc) ? $is_puc : 'Yes',
			'puc_number	'=>isset($puc_number) ? $puc_number	 : 'null',
			'puc_expiry_date'=> isset($puc_expiry_date) ? $puc_expiry_date : 'null',
			'cab_type_id'=> isset($cab_type_id) ? $cab_type_id : 'null',
			'cab_type_name' => isset($cab_type_name['name']) ? $cab_type_name['name'] : 'null',
			'cab_model_name'=> isset($cab_model_name) ? $cab_model_name : 'null',
			'owner_name	'=>isset($owner_name) ? $owner_name	 : 'null',
			'manufacture_year'=> isset($manufacture_year) ? $manufacture_year : 'null',
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
		);
		$getdata = $this->db->where('driver_id',$id)->get('cab')->row_array();
		if(empty($getdata)){
		    $this->db->insert('cab', $data);
    		$insert_id = $this->db->insert_id();
    		if ($insert_id > 0) {
    			return  $id;
    		} else {         
    			return  false;
    		}
		}else{
		    $data2 = array(
		    'registration_number'=> isset($registration_number) ? $registration_number : '',
			'engine_number	'=>isset($engine_number	) ? $engine_number : 'null',
			'chassis_number'=> isset($chassis_number) ? $chassis_number : 'null',
			'rc'=> isset($rc) ? $rc : 'null',
			'rc_expiry_date	'=>isset($rc_expiry_date) ? $rc_expiry_date : 'null',
			'is_insurance'=> isset($is_insurance) ? $is_insurance : 'Yes',
			'insurance_number'=> isset($insurance_number) ? $insurance_number : 'null',
			'insurance_expiry_date	'=>isset($insurance_expiry_date	) ? $insurance_expiry_date	 : 'null',
			'is_fitness'=> isset($is_fitness) ? $is_fitness : 'Yes',
			'fitness_number'=> isset($fitness_number) ? $fitness_number : 'null',
			'fitness_expiry_date'=> isset($fitness_expiry_date) ? $fitness_expiry_date : 'null',
			'is_puc'=> isset($is_puc) ? $is_puc : 'Yes',
			'puc_number	'=>isset($puc_number) ? $puc_number	 : 'null',
			'puc_expiry_date'=> isset($puc_expiry_date) ? $puc_expiry_date : 'null',
			'cab_type_id'=> isset($cab_type_id) ? $cab_type_id : 'null',
			'cab_type_name' => isset($cab_type_name['name']) ? $cab_type_name['name'] : 'null',
			'cab_model_name'=> isset($cab_model_name) ? $cab_model_name : 'null',
			'owner_name	'=>isset($owner_name) ? $owner_name	 : 'null',
			'manufacture_year'=> isset($manufacture_year) ? $manufacture_year : 'null',
			'updated_at'=>date('Y-m-d h:i:s'),
			'updated_by' => $this->session->userdata('user_id'),
		);
		    $this->db->where('driver_id',$id)->update('cab',$data2);
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
		
		if($key == 'permitted_image_b'){
			$data=array(
				'permitted_image_b'=>$target_file,
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
		
		$update =  $this->db->where('driver_id',$id)->update('cab', $data);

		if ($update > 0) {
			return  $id;
		} else {         
			return  false;
		}
	}

	public function deleteDriver($id) {
	    $this->db->where('driver_id',$id);        
		$this->db->delete('cab');
	    
		$this->db->where('id',$id);        
		$query = $this->db->delete('driver');
		
		if ($query) {
			return  true;
		} else {         
			return  false;
		}
	}

}
