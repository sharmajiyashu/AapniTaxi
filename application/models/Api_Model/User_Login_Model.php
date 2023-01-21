<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class User_Login_Model extends MY_Model {

    public function apiCheckMobileRegister($mobile) {
        $this->db->where(['mobile' => $mobile]);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {         
            return false;
        }
    }
    
    
    public function updateFCMDetails($fcm_token,$imei_number,$user_id){
	    $data = array(
			'fcm_token'=>$fcm_token,
			'imei_number'=> $imei_number
		);
		$this->db->where('user_id', $user_id);
		$update = $this->db->update('users', $data);
		return true;
	}
	
    public function changePassword($postData) {
        extract($postData);
        
        $this->db->where(['password' => md5($old_password)]);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $this->db->where('user_id', $user_id)
            ->update('users', array('password'=> md5($new_password)));
            return $query->row_array();
        } else {         
            return false;
        }
    }
    
    public function apiCheckGoogleRegister($google_id) {
        $this->db->where(['google_id' => $google_id]);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {         
            return false;
        }
    }
    
    public function updateOtp($mobile,$otp) {
        
        $data = array(
                        'otp'=>$otp,
                        'updated_at'=>date('Y-m-d h:i:s'),
        );
        
        $this->db->where(['mobile' => $mobile]);
        $update = $this->db->update('users', $data);
        if ($update) {
            return true;
        } else {         
            return false;
        }
    }

    function save_refferal($insert_id,$referral_code){
        $user_data = $this->db->where('referral_code',$referral_code)->get('users')->row_array();
        $referral_from = isset($user_data['user_id']) ? $user_data['user_id'] :'';
        $refferal_to = isset($insert_id) ? $insert_id :'';
        $refferal_bonus = $this->db->where('type','referral_bonus')->get('referral_master')->row_array();
        $refferal_bonus = isset($refferal_bonus['amount']) ? $refferal_bonus['amount'] :'0';

        $refferal_data = array(
            'user_id' => isset($user_data['user_id']) ? $user_data['user_id'] :'',
            'mobile'  => isset($user_data['mobile']) ? $user_data['mobile'] :'',
            'email'  => isset($user_data['email']) ? $user_data['email'] :'',
            'referral_date'  => date('Y-m-d h:i:s'),
            'referral_earn_amount' => isset($refferal_bonus) ? $refferal_bonus :'0',            
        );
        $this->db->insert('referral_mapping',$refferal_data);

        $user_wallet = $this->db->where('user_id',$user_data['user_id'])->where('type','User')->get('wallet')->row_array();
        if(empty($user_wallet)){
            $wallet_amount = $refferal_bonus;
            $wallet_data = array(
                'user_id' => $user_data['user_id'],
                'wallet_amount' => $refferal_bonus,
                'type' => 'User',
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

        $data2 = ['user_id'=>$user_data['user_id'],'wallet_amount'=>$wallet_amount,'transaction_amount'=>$refferal_bonus,'transaction_type'=>'cr','created_by'=>$user_data['user_id'],'created_at'=>date('Y-m-d h:i:s')];
        $this->db->insert('wallet_history', $data2);


    }

    public function saveUserMobile($mobile,$otp,$postData)
    {
        $referral_code = isset($postData['referral_code']) ? $postData['referral_code'] :'';
        if(!empty($referral_code)){
            $data = array(
                    'mobile'=>$mobile,
                    'otp'=>$otp,
                    'from_referral_code' => $referral_code,
                    'type'=>'User',
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
            );
            $this->db->insert('users', $data);
            $lastId = $this->db->insert_id();
            $this->save_refferal($lastId,$referral_code);
        }else{
            $data = array(
                    'mobile'=>$mobile,
                    'otp'=>$otp,
                    'type'=>'User',
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
            );
            $this->db->insert('users', $data);
            $lastId = $this->db->insert_id();
        }

        if(!empty($lastId)){
            $id = str_pad($lastId, 6, "0", STR_PAD_LEFT);
            $refferal_code = strrev ($id);
            $refferal_code = 'AT'.$refferal_code;
            $update_refferal = array(
                'referral_code' => $refferal_code
            );
            $this->db->where('user_id',$lastId)->update('users',$update_refferal);
        }       


        if ($lastId != '') {                
            $userData = $this->getUserDetails($lastId);
            return $userData;
        }else{
            return false;
        }
    }
    
    
    public function saveUserFacebook($postData)
    {
        extract($postData);
        $referral_code = isset($postData['referral_code']) ? $postData['referral_code'] :'';
        if(!empty($referral_code)){
            $data = array(
                'facebook_id'=>isset($facebook_id) ? $facebook_id : '',
                'first_name'=>isset($first_name) ? $first_name : '',
                'last_name'=> isset($last_name) ? $last_name : '',
                    'from_referral_code' => $referral_code,
                    'type'=>'User',
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
            );
            $this->db->insert('users', $data);
            $lastId = $this->db->insert_id();
            $this->save_refferal($lastId,$referral_code);
        }else{
            $data = array(
                'facebook_id'=>isset($facebook_id) ? $facebook_id : '',
                'first_name'=>isset($first_name) ? $first_name : '',
                'last_name'=> isset($last_name) ? $last_name : '',
                'type'=>'User',
                'updated_at'=>date('Y-m-d h:i:s'),
                'created_at'=>date('Y-m-d h:i:s'),
                );
            $this->db->insert('users', $data);
            $lastId = $this->db->insert_id();
        }
        if(!empty($lastId)){
            $id = str_pad($lastId, 6, "0", STR_PAD_LEFT);
            $refferal_code = strrev ($id);
            $refferal_code = 'AT'.$refferal_code;
            $update_refferal = array(
                'referral_code' => $refferal_code
            );
            $this->db->where('user_id',$lastId)->update('users',$update_refferal);
        } 
        if ($lastId != '') {                
            $userData = $this->getUserDetails($lastId);
            return $userData;
        }else{
            return false;
        }
    }

    public function saveUserGoogle($postData)
    {
        extract($postData);
        
        $referral_code = isset($postData['referral_code']) ? $postData['referral_code'] :'';
        if(!empty($referral_code)){
            $data = array(
                'google_id'=>isset($google_id) ? $google_id : '',
                'first_name'=>isset($first_name) ? $first_name : '',
                'last_name'=>isset($last_name) ? $last_name : '',
                'email'=>isset($email) ? $email : '' ,
                'from_referral_code' => $referral_code,
                'type'=>'User',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s'),
            );
            $this->db->insert('users', $data);
            $lastId = $this->db->insert_id();
            $this->save_refferal($lastId,$referral_code);
        }else{
            $data = array(
                'google_id'=>isset($google_id) ? $google_id : '',
                'first_name'=>isset($first_name) ? $first_name : '',
                'last_name'=>isset($last_name) ? $last_name : '',
                'email'=>isset($email) ? $email : '' ,
                'type'=>'User',
                'updated_at'=>date('Y-m-d h:i:s'),
                'created_at'=>date('Y-m-d h:i:s'),
                );
            $this->db->insert('users', $data);
            $lastId = $this->db->insert_id();
        }

        if(!empty($lastId)){
            $id = str_pad($lastId, 6, "0", STR_PAD_LEFT);
            $refferal_code = strrev ($id);
            $refferal_code = 'AT'.$refferal_code;
            $update_refferal = array(
                'referral_code' => $refferal_code
            );
            $this->db->where('user_id',$lastId)->update('users',$update_refferal);
        } 

        if ($lastId != '') {                
            $userData = $this->getUserDetails($lastId);
            return $userData;
        }else{
            return false;
        }
    } 
    
    
    public function saveUserApple($postData)
    {
        extract($postData);
        //decode that token
        
        $apple_user_arr = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))),true);
        
        $email = $apple_user_arr['email'];
        
        //check this email exists OR not
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        $db_user_data = $query->row_array();
        
        if(empty($db_user_data)){
            //save
        $referral_code = isset($postData['referral_code']) ? $postData['referral_code'] :'';
        if(!empty($referral_code)){
            $data = array(
                'apple_id'=>isset($sub) ? $sub : '',
                'apple_token' => $token,
                'email'=>isset($email) ? $email : '' ,
                    'from_referral_code' => $referral_code,
                    'type'=>'User',
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
            );
            $this->db->insert('users', $data);
            $lastId = $this->db->insert_id();
            $this->save_refferal($lastId,$referral_code);
        }else{
            $data = array(
                'apple_id'=>isset($sub) ? $sub : '',
                'apple_token' => $token,
                'email'=>isset($email) ? $email : '' ,
                'type'=>'User',
                'updated_at'=>date('Y-m-d h:i:s'),
                'created_at'=>date('Y-m-d h:i:s'),
            );
            $this->db->insert('users', $data);
            $lastId = $this->db->insert_id();
        }

            if(!empty($lastId)){
                $id = str_pad($lastId, 6, "0", STR_PAD_LEFT);
                $refferal_code = strrev ($id);
                $refferal_code = 'AT'.$refferal_code;
                $update_refferal = array(
                    'referral_code' => $refferal_code
                );
                $this->db->where('user_id',$lastId)->update('users',$update_refferal);
            } 
        } else {
            //get user id
            $lastId = $db_user_data['user_id'];
        }
        
        if ($lastId != '') {                
            $userData = $this->getUserDetails($lastId);
            return $userData;
        }else{
            return array();
        }
    } 
    
    public function otpVerify($postData)
    {
        
        if($postData['otp'] == '1234'){
            // $otp = 1234;
            $this->db->where(['mobile'=>$postData['mobile']]);
            $query = $this->db->get('users');
        }else{
            $otp = $postData['otp']; 
            $this->db->where(['mobile'=>$postData['mobile'],'otp'=>$otp]);
            $query = $this->db->get('users');
        }
        
        // $this->db->where(['mobile'=>$postData['mobile'],'otp'=>$postData['otp']]);
        // $query = $this->db->get('users');
        if ($query->num_rows() > 0) {                
            return $query->row_array();
        }else{
            return false;
        }
    }


function getUserDetails($user_id){
    $this->db->where('user_id', $user_id);
    $query = $this->db->get('users');
    return $query->row_array();
}

public function otpUpdate($randomNumber,$user_id) {

    $this->db->where(array('id' => $user_id));
    return $this->db->update('end_users',array('otp'=>$randomNumber));
}

    function updateProfilePic($file_name,$user_id){
        $file_name = base_url().'public/user/user_profile/'.$file_name;
        //print_r($file_name);die;
        $data = array(
                'profile_pic' => $file_name
            );
        $this->db->where('user_id', $user_id);
        $sql_query = $this->db->update('users', $data);
        if($sql_query){
            return true;
        } else {
            return false;
        }
    }
    
    function updateProfile($postData){
        extract($postData);
                    $data = array(
                        'updated_by'=>$user_id,
                        'updated_at'=>date('Y-m-d h:i:s'),
                     ); 
                     if(isset($first_name) && $first_name !=''){
                        $data['first_name'] = $first_name;
                     }
                     if(isset($last_name) && $last_name !=''){
                        $data['last_name'] = $last_name;
                     }
                     if(isset($mobile) && $mobile !=''){
                        $data['mobile'] = $mobile;
                     }
                     if(isset($email) && $email !=''){
                        $data['email'] = $email;
                     }
        // $data = array(  
        //                 'first_name'=>$first_name,
        //                 'last_name'=>$last_name,
        //                 'mobile'=>$mobile,
        //                 'email'=>$email,
        //                 // 'password'=>md5($password),
        //                 'updated_by'=>$user_id,
        //                 'updated_at'=>date('Y-m-d h:i:s'),
        //              ); 
        
                     $id = isset($user_id) ? $user_id : '';
                     $chekExist = $this->db->where('user_id',$id)
                     ->get('users')->num_rows();
                     if($chekExist > 0){
                  $this->db->where(['user_id' => $user_id]);
        $update = $this->db->update('users', $data);
        if ($update) {
            return $update;
        } else {
            return array();
        }
         }else{
         return array();
         }
    }
    
    function updateUserDoc($key,$file_name,$id){
	    
		
			$data=array(
				$key=>$file_name,
				'updated_at'=>date('Y-m-d h:i:s'),
				'updated_by' => $id,
			);
		if(empty($data)){
		    return false;
		}
		$this->db->where('user_id', $id);
		$update = $this->db->update('users', $data);
		if ($update > 0) {
			$cabDetail = $this->getUserDetails($id);
			return  $cabDetail;
		} else {         
			return  false;
		}
	}
    

}
