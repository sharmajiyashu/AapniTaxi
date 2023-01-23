<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
		if($this->session->userdata('type') != 'Superadmin')
			redirect('admin/Login');	
		
		$this->load->model(array('DriverModel','CityModel','OwnerModel'));
	}
	
	public function addDriver($id=null)
	{
		$driverData['city'] = $this->CityModel->getAllActiveCity();
		$driverData['data'] = $this->DriverModel->getDriverDetails($id);
	    //$driverData['cab_category'] = $this->OwnerModel->getCabCategory();
	    $driverData['vdata'] = $this->DriverModel->getVehicleDetail($id);
		
		$this->load->view('admin/add-driver',$driverData);
	}
	
	public function basicDetailValidation($postData,$id='')
	{
		extract($_POST);
		// debug($_POST);die;
		$error = array();

		
		if(!empty($referral_code)){
			$check_refferal = $this->db->where('referral_code',$referral_code)->get('driver')->num_rows();
			if($check_refferal == 0){
				$error['referral_code'] = 'Invalid referral code';
			}
		}
		

		if (trim($first_name)== '') {
			$error['first_name'] = 'First Name can not be blank';
		}
		if (trim($last_name)== '') {
			$error['last_name'] = 'Last Name can not be blank';
		}
// 		if (trim($email)== '') {
// 			$error['email'] = 'E-Mail can not be blank';
// 		}
		if(!empty($email)){
			$checkUniqueEmail = $this->DriverModel->checkUniqueEmail($email,$id);
			if ($checkUniqueEmail) {
				$error['email'] = 'E-Mail already exist';
			}			
		}
		if (trim($mobile)== '') {
			$error['mobile'] = 'Mobile can not be blank';
		}else{			
			$checkUniqueMobile = $this->DriverModel->checkUniqueMobile($mobile,$id);		
			if ($checkUniqueMobile) {
				$error['mobile'] = 'Mobile Number already exist';	
			}	
		}		

		if (trim($dob)== '') {
			$error['dob'] = 'Date of Birth can not be blank';
		}
		if (trim($password)== '') {
			$error['password'] = 'Password can not be blank';
		}
		if (trim($gender)== '') {
			$error['gender'] = 'Gender can not be blank';
		}
		return $error;
	}
	
	public function basicDetail($id=null)
	{
		$error = array();
		$driverData['data'] = $this->DriverModel->getDriverDetails($id);
		$driverData['city'] = $this->CityModel->getAllActiveCity();
		$driverData['vdata'] = $this->DriverModel->getVehicleDetail($id);
		if (isset($_POST) && !empty($_POST)) {				
			extract($_POST);
			$error = $this->basicDetailValidation($_POST,$id);			
			if (empty($error)) {				
				if ($id == '') {
					// print_r($_POST);die;
					$save = $this->DriverModel->saveBasicDetail($_POST);				
				}else{
					$update = $this->DriverModel->updateBasicDetail($_POST,$id);	
				}
				$target_dir =  BASEPATH."../pubilc/driver/";
				$error_doc = array();
				$documents = array();			
				if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name'] != ''){
					$documents['profile_pic'] = $_FILES['profile_pic'];
				}
				foreach($documents as $key=>$val){
					$random_string = rand(1000,9999);
					$cur_datetime = time();
                        $unique_name = $random_string; 
                        $file_name_arr = $val["name"];
                        $file_name = $unique_name.'_'.$file_name_arr;
                        $target_file = $target_dir . basename($file_name);
                        $target_file_arr[] = $target_file;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" ) {
                        	$error_doc[$key] = 'Sorry, only JPG, JPEG, PNG & PDF files are allowed.';
                        } else {
                        	if (move_uploaded_file($val["tmp_name"], $target_file)) {
                        		if ($id == '') {
                        			$save_document = $this->DriverModel->updateProfilePhoto($key,$file_name,$save);
                        		}else{
                        			$save_document = $this->DriverModel->updateProfilePhoto($key,$file_name,$id);
                        		}
                        	} else {
                        		$error_doc[$key] = 'Sorry, there was an error uploading your file.';
                        	}
                        }
                    }
                    if ($id == '') {
                    	$this->session->set_flashdata('success','Well done! You have successfully updated Basic Details.');
                    	redirect('admin/Driver/addDriver/'.$save);	
                    }else{
                    	$this->session->set_flashdata('success','Well done! You have successfully inserted Basic Details.');
                    	redirect('admin/Driver/addDriver/'.$id);	
                    }
                }else{
                	$error['basic-detail'] = 'Some error below';
                }
            }
            $driverData['error'] = $error;
            $this->load->view('admin/add-driver',$driverData);		
        }

		public function addressDetail($id='')
        {	
        	$error = array();
        	$driverData['data'] = $this->DriverModel->getDriverDetails($id);
        	$driverData['city'] = $this->CityModel->getAllActiveCity();
        	if (isset($_POST) && !empty($_POST)) {		
        		extract($_POST);
        		$error = array();
        // 		if (trim($present_address)== '') {
        // 			$error['present_address'] = 'Present Address can not be blank';
        // 		}
        		if (trim($permanent_address)== '') {
        			$error['permanent_address'] = 'Permanent Address can not be blank';
        		}
        // 		if (trim($city)== '') {
        // 			$error['city'] = 'City can not be blank';
        // 		}			
        		if (empty($error)) {

        			$update = $this->DriverModel->addressDetail($_POST,$id);
        			if ($update) {					
        				$this->session->set_flashdata('success','Well done! You have successfully updated Step2 Driver.');
        				redirect('admin/Driver/addDriver/'.$update);	
        			}else{
        				$this->session->set_flashdata('error','Sorry! Some error occurred.');
        				redirect('admin/Driver/addDriver/'.$id);
        			}
        		}else{
        			$error['step2'] = 'Some error below';
        		}
        	}
        	$driverData['error'] = $error;
        	$this->load->view('admin/add-driver',$driverData);
        }
		
		 public function drivingLicence($id='')
		 {	
        	$error = array();
        	$driverData['data'] = $this->DriverModel->getDriverDetails($id);
        	$driverData['city'] = $this->CityModel->getAllActiveCity();
        	$error = array();
        	if (isset($_POST) && !empty($_POST)) {		
        		extract($_POST);             		
        		$update = $this->DriverModel->drivingLicence($_POST,$id);	       		
        	}
        	$target_dir =  BASEPATH."../pubilc/driver/";
        	$error_doc = array();        	

        	if (trim($driving_licence_number)== '') {
        		$error['driving_licence_number'] = 'Driving Licence Number can not be blank';
        	}else{
        		$checkDlLicence = $this->DriverModel->checkDlLicence($driving_licence_number,$id);
        		if($checkDlLicence){
        			$error['driving_licence_number'] = 'Driving Licence already exist';
        		}
        	}
        // 	if (trim($dl_expiry_date)== '') {
        // 		$error['dl_expiry_date'] = 'DL Expiry Date can not be blank';
        // 	}			
        	if (empty($error)) {
        		$update = $this->DriverModel->drivingLicence($_POST,$id);
        		$documents = array();			
        		if(isset($_FILES['licence_front_image']) && $_FILES['licence_front_image']['name'] != ''){
        			$documents['licence_front_image'] = $_FILES['licence_front_image'];
        		}
        		if(isset($_FILES['licence_back_image']) && $_FILES['licence_back_image']['name'] != ''){
        			$documents['licence_back_image'] = $_FILES['licence_back_image'];
        		}
        		foreach($documents as $key=>$val){
        			$random_string = rand(1000,9999);
        			$cur_datetime = time();
                        $unique_name = $random_string; 
                        $file_name_arr = $val["name"];
                        $file_name = $unique_name.'_'.$file_name_arr;
                        $target_file = $target_dir . basename($file_name);
                        $target_file_arr[] = $target_file;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" ) {
                        	$error_doc[$key] = 'Sorry, only JPG, JPEG, PNG & PDF files are allowed.';
                        } else {
                        	if (move_uploaded_file($val["tmp_name"], $target_file)) {
                        		
                        		$save_document = $this->DriverModel->updatelicenceImage($key,$file_name,$id);
                        	} else {
                        		$error_doc[$key] = 'Sorry, there was an error uploading your file.';
                        	}
                        }
                    }
                    if ($update) {					
                    	$this->session->set_flashdata('success','Well done! You have successfully updated Licence Details.');
                    	redirect('admin/Driver/addDriver/'.$update);	
                    }else{
                    	$this->session->set_flashdata('error','Sorry! Some error occurred.');
                    	redirect('admin/Driver/addDriver/'.$id);
                    }
                }else{
                	$error['step3'] = 'Some error below';
                }
                $driverData['error'] = $error;
                $this->load->view('admin/add-driver',$driverData);
        }
		
	    public function accidentDetail($id='')
	    {
			$error = array();
			$driverData['data'] = $this->DriverModel->getDriverDetails($id);
			$driverData['city'] = $this->CityModel->getAllActiveCity();
			if (isset($_POST) && !empty($_POST)) {		
				extract($_POST);
				$error = array();

				// if (trim($met_accident)== '') {
				// 	$error['met_accident'] = 'Met Accident can not be blank';
				// }
				// if (trim($is_criminal_case)== '') {
				// 	$error['is_criminal_case'] = 'Is Criminal Case can not be blank';
				// }
				// if (trim($criminal_case_pending)== '') {
				// 	$error['criminal_case_pending'] = 'Criminal Case Pending can not be blank';
				// }

				if (empty($error)) {
					$update = $this->DriverModel->accidentDetail($_POST,$id);
					if ($update) {					

						$this->session->set_flashdata('success','Well done! You have successfully updated Step4 Driver.');
						redirect('admin/Driver/addDriver/'.$update);	
					}else{
						$this->session->set_flashdata('error','Sorry! Some error occurred.');
						redirect('admin/Driver/addDriver/'.$id);
					}
				}else{
					$error['step4'] = 'Some error below';
				}
			}
			$driverData['error'] = $error;
			$this->load->view('admin/add-driver',$driverData);		
		}
		
		public function policeVerification($id='')
		{
			$error = array();
			$driverData['data'] = $this->DriverModel->getDriverDetails($id);
			$driverData['city'] = $this->CityModel->getAllActiveCity();
			if (isset($_POST) && !empty($_POST)) {		
				extract($_POST);
				$error = array();			
				if (empty($error)) {
					$target_dir =  BASEPATH."../pubilc/driver/";
					$error_doc = array();
					$documents = array();			
					if(isset($_FILES['police_verification_image']) && $_FILES['police_verification_image']['name'] != ''){
						$documents['police_verification_image'] = $_FILES['police_verification_image'];
					}
					foreach($documents as $key=>$val){
						$random_string = rand(1000,9999);
						$cur_datetime = time();
					$unique_name = $random_string;
					$file_name_arr = $val["name"];
					$file_name = $unique_name.'.'.$file_name_arr;
					$target_file = $target_dir . basename($file_name);
					$target_file_arr[] = $target_file;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" ) {
						$error_doc[$key] = 'Sorry, only JPG, JPEG, PNG & PDF files are allowed.';
					} else {
						if (move_uploaded_file($val["tmp_name"], $target_file)) {
							$save_document = $this->DriverModel->updatePoliceDocument($key,$file_name,$id);						
						} else {
							$error_doc[$key] = 'Sorry, there was an error uploading your file.';
						}
					}
				}
				$update = $this->DriverModel->policeVerification($_POST,$id);
				if ($update) {					
					$this->session->set_flashdata('success','Well done! You have successfully updated Police verification Details Driver.');
					redirect('admin/Driver/addDriver/'.$update);	
				}else{
					$this->session->set_flashdata('error','Sorry! Some error occurred.');
					redirect('admin/Driver/addDriver/'.$id);
				}

			}else{
				$error['step5'] = 'Some error below';
			}
				$driverData['error'] = $error;
				$this->load->view('admin/add-driver',$driverData);		
            }
        }
        public function documentDetails($id='')
        {            
        	$error = array();
        	$driverData['data'] = $this->DriverModel->getDriverDetails($id);
        	$driverData['city'] = $this->CityModel->getAllActiveCity();
        	if (isset($_POST) && !empty($_POST)) {        		
        		extract($_POST);
        		if ($id != '') {	
						// upload image			
        			if (trim($uid_number)== '') {
        				$error['uid_number'] = 'Aadhar Number can not be blank';
        			}
        // 			if (trim($vid_number)== '') {
        // 				$error['vid_number'] = 'Voter Id Number can not be blank';
        // 			}
        			if (trim($pan_number)== '') {
        				$error['pan_number'] = 'Pan Number can not be blank';
        			}
        			if (empty($error)) {

        			    $update = $this->DriverModel->updateDocument($_POST,$id);
        				$target_dir =  BASEPATH."../pubilc/driver/";
        				$error_doc = array();
        				$documents = array();			
        				if(isset($_FILES['uid_image']) && $_FILES['uid_image']['name'] != ''){
        					$documents['uid_image'] = $_FILES['uid_image'];
        				}
        				
        				if(isset($_FILES['uid_image_back']) && $_FILES['uid_image_back']['name'] != ''){
        					$documents['uid_image_back'] = $_FILES['uid_image_back'];
        				}
        				// if(isset($_FILES['vid_image']) && $_FILES['vid_image']['name'] != ''){
        				// 	$documents['vid_image'] = $_FILES['vid_image'];
        				// }
        				// if(isset($_FILES['passport_image']) && $_FILES['passport_image']['name'] != ''){
        				// 	$documents['passport_image'] = $_FILES['passport_image'];
        				// }
        				if(isset($_FILES['pan_image']) && $_FILES['pan_image']['name'] != ''){
        					$documents['pan_image'] = $_FILES['pan_image'];
        				}
        				
        				if(isset($_FILES['pan_image_back']) && $_FILES['pan_image_back']['name'] != ''){
        					$documents['pan_image_back'] = $_FILES['pan_image_back'];
        				}

        				foreach($documents as $key=>$val){
        					$random_string = rand(1000,9999);
        					$cur_datetime = time();
	                        $unique_name = $random_string; 
	                        $file_name_arr = $val["name"];
	                        $file_name = $unique_name.'.'.$file_name_arr;
	                        $target_file = $target_dir . basename($file_name);
	                        $target_file_arr[] = $target_file;
	                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" ) {
	                        	$error_doc[$key] = 'Sorry, only JPG, JPEG, PNG & PDF files are allowed.';
	                        } else {
	                        	if (move_uploaded_file($val["tmp_name"], $target_file)) {
	                        		$save_document = $this->DriverModel->updateDocumentImage($key,$file_name,$id);						
	                        	} else {
	                        		$error_doc[$key] = 'Sorry, there was an error uploading your file.';
	                        	}
	                        }
	                    }

	                    $this->session->set_flashdata('success','Well done! You have successfully updated Documents Details.');
	                    redirect('admin/Driver/addDriver/'.$update);	
                    // image end

	                }
	            }
	        }
	        $driverData['error'] = $error;
	        $this->load->view('admin/add-driver',$driverData);		
	    }
	    
	    public function vehicelDetails($id='')
        {            	
        	$error = array();
        	$driverData['data'] = $this->DriverModel->getDriverDetails($id);
        	$driverData['city'] = $this->CityModel->getAllActiveCity();
        	if (isset($_POST) && !empty($_POST)) {        		
        		extract($_POST);
        		if ($id != '') {
        		    
        		  //  if(trim($registration_number)== ''){
        		  //      $error['registration_number'] = 'Registration Number can not be blank';
        		  //  }
        		  //  if(trim($engine_number)== ''){
        		  //      $error['engine_number'] = ' Engine Number can not be blank';
        		  //  }
        		  //  if(trim($chassis_number)== ''){
        		  //      $error['chassis_number'] = 'Chassis Number can not be blank'; 
        		  //  }
        		  //  if(trim($rc)== ''){
        		  //      $error['rc'] = 'Registration Certification can not be blank';
        		  //  }
        		  //  if(trim($rc_expiry_date)== ''){
        		  //      $error['rc_expiry_date'] = 'RC Expiry Date can not be blank';
        		  //  }
        		  //  if(trim($insurance_number)== ''){
        		  //      $error['insurance_number'] = 'Insurance Number can not be blank';
        		  //  }
        		  //  if(trim($insurance_expiry_date)== ''){
        		  //     $error['insurance_expiry_date'] = 'Insurance Expiry Date can not be blank'; 
        		  //  }
        		  //  if(trim($fitness_number)== ''){
        		  //     $error['fitness_number'] = 'Fitness Number can not be blank';
        		  //  }
        		    
        		  //  if(trim($fitness_expiry_date)== ''){
        		  //      $error['fitness_expiry_date'] = 'Fitness Exipry Date can not be blank';
        		  //  }
        		    
        		  //  if(trim($puc_number)== ''){
        		  //      $error['puc_number'] = 'PUC Number can not be blank';
        		  //  }
        		    
        		  //  if(trim($puc_expiry_date)== ''){
            //             $error['puc_expiry_date'] = 'PUC Expiry Date can not be blank';
        		  //  }
        		    
        		  //  if(trim($manufacture_year)== ''){
            //             $error['manufacture_year'] = 'Manufacture Year can not be blank';
        		  //  }
        		  
        			if (empty($error)) {
        				$update = $this->DriverModel->updateVehicle($_POST,$id);
	                    $this->session->set_flashdata('success','Well done! You have successfully updated Vechicel Details.');
	                    redirect('admin/Driver/addDriver/'.$update);	
	                }
	               // else{
	               // 	$error['error-document'];
	               // }
	            }
	        }
	        $driverData['error'] = $error;
	        $this->load->view('admin/add-driver',$driverData);		
	    }
	    
	   
	    public function vehicelDocumentImage($id='')
        {            	
        	$error = array();
        	$driverData['data'] = $this->DriverModel->getDriverDetails($id);
        	$driverData['city'] = $this->CityModel->getAllActiveCity();
            if ($id != '') {	
    			if (empty($error)) {
    				$target_dir =  BASEPATH."../pubilc/driver/";
    				$error_doc = array();
    				$documents = array();			
    				if(isset($_FILES['rc_front_image']) && $_FILES['rc_front_image']['name'] != ''){
    					$documents['rc_front_image'] = $_FILES['rc_front_image'];
    				}
    				if(isset($_FILES['rc_back_image']) && $_FILES['rc_back_image']['name'] != ''){
    					$documents['rc_back_image'] = $_FILES['rc_back_image'];
    				}
    				if(isset($_FILES['insurance_image']) && $_FILES['insurance_image']['name'] != ''){
    					$documents['insurance_image'] = $_FILES['insurance_image'];
    				}
    				if(isset($_FILES['fitness_image']) && $_FILES['fitness_image']['name'] != ''){
    					$documents['fitness_image'] = $_FILES['fitness_image'];
    				}
    				if(isset($_FILES['puc_image']) && $_FILES['puc_image']['name'] != ''){
    					$documents['puc_image'] = $_FILES['puc_image'];
    				}
    				if(isset($_FILES['owner_image']) && $_FILES['owner_image']['name'] != ''){
    					$documents['owner_image'] = $_FILES['owner_image'];
    				}
    				
    				if(isset($_FILES['permitted_image_b']) && $_FILES['permitted_image_b']['name'] != ''){
    					$documents['permitted_image_b'] = $_FILES['permitted_image_b'];
    				}
    				foreach($documents as $key=>$val){
    					$random_string = rand(1000,9999);
    					$cur_datetime = time();
                        $unique_name = $random_string; 
                        $file_name_arr = $val["name"];
                        $file_name = $unique_name.'.'.$file_name_arr;
                        $target_file = $target_dir . basename($file_name);
                        $target_file_arr[] = $target_file;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" ) {
                        	$error_doc[$key] = 'Sorry, only JPG, JPEG, PNG & PDF files are allowed.';
                        } else {
                        	if (move_uploaded_file($val["tmp_name"], $target_file)) {
                        		$save_document = $this->DriverModel->updateVehicelImage($key,$file_name,$id);
                        	} else {
                        		$error_doc[$key] = 'Sorry, there was an error uploading your file.';
                        	}
                        }
                    }
                    $this->session->set_flashdata('success','Well done! You have successfully updated Vechicel Document.');
                    redirect('admin/Driver/addDriver/'.$id);	
                }else{
                	$error['error-document'];
                }
	        }
	        $driverData['error'] = $error;
	        $this->load->view('admin/add-driver',$driverData);		
	    }
		
	public function driverListing()
	{
		$data['driverListing'] = $this->DriverModel->driverListing();		
		$this->load->view('admin/driver-listing',$data);
	}
	
	public function deleteDriver($id=null)
	{
		$deleteDriver= $this->DriverModel->deleteDriver($id);
		if ($deleteDriver) {
			$this->session->set_flashdata('success','Well done! You have successfully deleted the Driver.');
			redirect('admin/Driver/driverListing');	
		}else{
			$this->session->set_flashdata('error','Sorry! Some error occurred.');
			redirect('admin/Driver/driverListing');	
		}		
	}
	
	public function DriverDashboard($id=null){
	    
	    $total_income = $this->db->select_sum("price")->where('canceled !=','1')->where('driver_id',$id)->get('cab_ride')->row_array();
	    $total_cancelled = $this->db->where('canceled','1')->where('driver_id',$id)->get('cab_ride')->num_rows();
	    $total_trip = $this->db->where('driver_id',$id)->get('cab_ride')->num_rows();
	    $dirver_detail = $this->db->where('id',$id)->get('driver')->row_array();
	    $this->load->view('admin/view-driver-dashboard',['total_income'=> $total_income['price'],'total_cancelled' => $total_cancelled,'total_trip' => $total_trip,'name'=>$dirver_detail['first_name'], ]);
	}
	
	public function getCabCategories(){
	   $id = $_POST['id'];
	   $data =  $this->db->where('parent_id',$id)->get('cab-category')->result_array();
	   echo json_encode($data); die;
	}
	
	public function viewDriver($id){
        $getData['getData'] = $this->db->query('Select * from driver Where id ='.$id)->row_array();
        $getData['wallet'] = $this->db->where(['user_id' => $id, 'type' => 'Driver', 'status' => 'Active'])->get('wallet')->row_array();
        $getData['cancelled'] = $this->db->where(['driver_id' => $id, 'canceled' => 1])->get('cab_ride')->num_rows();
        $getData['trip'] = $this->db->where(['driver_id' => $id, 'location_status' => 2])->get('cab_ride')->num_rows();
        $getData['rating'] = $this->db->query('SELECT AVG(rating) as rating FROM `rating_user` WHERE by_driver ='.$id)->row_array();
        $this->load->view('admin/ow-view-driver',$getData);
    }
    
    public function changeStatusDriver($id,$status){
      if($status === 'Active'){
        $status = '0';  
      }else{
        $status = '1';    
      }
      $this->db->where('id',$id)->update('driver',array('status' => $status));
      redirect('admin/Driver/driverListing');
    }
    
    public function addMoneyToWallet(){
	  $amount = $_POST['amount'];
	  $driver_id = $_POST['driver_id'];
	  $dta = $this->db->where(['user_id' => $driver_id, 'type' => 'Driver'])->get('wallet');
	  if($dta->num_rows() > 0){
	      $wallet_amt = $dta->row_array();
	      $new_wallet_amt = $wallet_amt['wallet_amount'] + $amount;
	      $this->db->where(['user_id' => $driver_id, 'type' => 'Driver'])->update('wallet',['wallet_amount' => $new_wallet_amt, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]);
	      if($amount > 0){
	          $transaction_type = 'cr';
	      }else{
	         $transaction_type = 'dr'; 
	      }
	      $this->db->insert('wallet_history',['user_id' => $driver_id, 'wallet_amount' => $new_wallet_amt, 'transaction_type' => $transaction_type, 'type' => 'Driver', 'created_at' => date('Y-m-d h:i:s')]);
	      redirect('admin/Driver/viewDriver/'.$driver_id);
	  }else{
	     $this->db->insert('wallet',['wallet_amount' => $amount, 'user_id' => $driver_id, 'type' => 'Driver', 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]);
	     if($amount > 0){
	          $transaction_type = 'cr';
	     }else{
	         $transaction_type = 'dr'; 
	     }
	     $this->db->insert('wallet_history',['user_id' => $driver_id, 'wallet_amount' => $amount, 'transaction_type' => $transaction_type, 'type' => 'Driver', 'created_at' => date('Y-m-d h:i:s')]);
	     redirect('admin/Driver/viewDriver/'.$driver_id);
	  }
	}
	
	public function exportDriver(){
         $file_name = 'export'.date('Ymd').'.csv'; 
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$file_name"); 
         header("Content-Type: application/csv;");
         // get data 
     
         // file creation 
        $file = fopen('php://output', 'w');
        $header =array(
          'First_name',
          'Last_name',
          'Dob',
          'Mobile',
          'Email',
          'Gender',
          'Present_address',
          'Permanent_address',
          'Aadhar number',
          'Pan number',
          'Driving licence number',
          'Dl expiry date',
          'Aadhar Front Image',
          'Aadhar Back Image',
          'Pan Card Image',
          'Licence Front Image',
          'Licence Back Image',
          'Profile Pic Image',
          'Created at',
        );
    
        $data = $this->db->select('first_name,last_name,dob,mobile,email,gender,present_address,permanent_address,uid_number,pan_number,driving_licence_number,dl_expiry_date,uid_front_image,uid_back_image,pan_image,licence_front_image,licence_back_image,profile_pic,created_at')->get('driver')->result_array();
        fputcsv($file, $header);
        foreach($data as $userdata){
           fputcsv($file,$userdata);
        }
        fclose($file); 
        exit; 
    }
	
	public function exportDriverOnline(){
         $file_name = 'online-driver'.date('Ymd').'.csv'; 
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$file_name"); 
         header("Content-Type: application/csv;");
         // get data 
     
         // file creation 
        $file = fopen('php://output', 'w');
        $header =array(
          'First_name',
          'Last_name',
          'Dob',
          'Mobile',
          'Email',
          'Gender',
          'Present_address',
          'Permanent_address',
          'Aadhar number',
          'Pan number',
          'Driving licence number',
          'Dl expiry date',
          'Aadhar Front Image',
          'Aadhar Back Image',
          'Pan Card Image',
          'Licence Front Image',
          'Licence Back Image',
          'Profile Pic Image',
          'Created at',
        );
        $data = $this->db->select('first_name,last_name,dob,mobile,email,gender,present_address,permanent_address,uid_number,pan_number,driving_licence_number,dl_expiry_date,uid_front_image,uid_back_image,pan_image,licence_front_image,licence_back_image,profile_pic,created_at')->where(['driver_current_status' => 'online', 'status' => 1])->get('driver')->result_array();
        fputcsv($file, $header);
        foreach($data as $userdata){
           fputcsv($file,$userdata);
        }
        fclose($file); 
        exit; 
    }
	
	// public function onlineDriver(){
	//  $data =  $this->db->where(['driver_current_status' => 'online', 'status' => 1])->get('driver')->result_array();
	//  if(!empty($data)){
	// 	foreach($data as $key => $val){
	// 		$data[$key] = $val;
	// 		$CL_Driver = $this->db->where(['user_id' => $val['id'], 'user_type' => 'Driver'])->get('user_current_locations')->row_array();
	
	// 		$data[$key]['latitude'] = isset($CL_Driver['latitude']) ? $CL_Driver['latitude'] : '';
	// 		$data[$key]['longitude'] = isset($CL_Driver['longitude']) ? $CL_Driver['longitude'] : '';
	// 	}
	//  }
	//  $this->load->view('admin/online-drivers-list',['driverListing' => $data]);
	// }

	public function onlineDriver(){
		$data =  $this->db->where(['driver_current_status' => 'online', 'status' => 1])->get('driver')->result_array();
		if(!empty($data)){
		   foreach($data as $key => $val){
			   $data[$key] = $val;
			   $CL_Driver = $this->db->where(['user_id' => $val['id'], 'user_type' => 'Driver'])->get('user_current_locations')->row_array();
			   $category_name = $this->db->where('driver_id',$val['id'])->get('cab')->row_array();
	   
			   $data[$key]['latitude'] = isset($CL_Driver['latitude']) ? $CL_Driver['latitude'] : '';
			   $data[$key]['longitude'] = isset($CL_Driver['longitude']) ? $CL_Driver['longitude'] : '';
			   $data[$key]['category_name'] = isset($category_name['cab_type_name']) ? $category_name['cab_type_name'] : '';
		   }
		}
		$this->load->view('admin/online-drivers-list',['driverListing' => $data]);
	}
	
	public function getLocationName(){
		    
			$S_lat = $_POST['latitude'];
			$S_lang = $_POST['longitude'];
			
	        $googleMapsApiKey = 'AIzaSyDwn5cCgHITLkJKcCoy_g6hKKcJdjm9IDQ';
    	    //Source Location Name
            $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$S_lat,$S_lang&sensor=true&key=$googleMapsApiKey";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $details_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = json_decode(curl_exec($ch), true);
            $location_name_source = isset($data['results'][0]['formatted_address']) ? $data['results'][0]['formatted_address'] : '';
            echo json_encode($location_name_source); die;
	}
	
	
}
