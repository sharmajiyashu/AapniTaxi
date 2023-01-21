<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Owner extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
		if($this->session->userdata('type') != 'Superadmin')
			redirect('admin/Login');	
			$this->load->model(array('OwnerModel','CityModel','DriverModel'));
	}
	
	#Basic Details Driver Validation
	public function basicDetailValidation($postData,$id='')
	{
		extract($_POST);
		$error = array();
		if (trim($first_name)== '') {
			$error['first_name'] = 'First Name can not be blank';
		}
		if (trim($last_name)== '') {
			$error['last_name'] = 'Last Name can not be blank';
		}
		if (trim($mobile)== '') {
			$error['mobile'] = 'Mobile can not be blank';
		}else{			
			$checkUniqueMobile = $this->OwnerModel->checkUniqueMobile($mobile,$id);		
			if ($checkUniqueMobile) {
				$error['mobile'] = 'Mobile Number already exist';	
			}	
		}		

		if (trim($dob)== '') {
			$error['dob'] = 'Date of Birth can not be blank';
		}
		if (trim($gender)== '') {
			$error['gender'] = 'Gender can not be blank';
		}
		return $error;
	}
	
	#Basic Details Driver Insert Table
	public function basicDetail($id=null)
	{
		$error = array();
		$driverData['data'] = $this->OwnerModel->getDriverDetail($id);
		$driverData['city'] = $this->CityModel->getAllActiveCity();
		if (isset($_POST) && !empty($_POST)) {				
			extract($_POST);
			$error = $this->basicDetailValidation($_POST,$id);			
			if (empty($error)) {				
				if ($id == '') {
					$save = $this->OwnerModel->saveBasicDetail($_POST);				
				}else{
					$update = $this->OwnerModel->updateBasicDetail($_POST,$id);	
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
                        			$save_document = $this->OwnerModel->updateProfilePhoto($key,$file_name,$save);
                        		}else{
                        			$save_document = $this->OwnerModel->updateProfilePhoto($key,$file_name,$id);
                        		}
                        	} else {
                        		$error_doc[$key] = 'Sorry, there was an error uploading your file.';
                        	}
                        }
                    }
                    if ($id == '') {
                    	$this->session->set_flashdata('success','Well done! You have successfully updated Basic Details.');
                    	redirect('admin/Owner/addOwner/'.$save);	
                    }else{
                    	$this->session->set_flashdata('success','Well done! You have successfully inserted Basic Details.');
                    	redirect('admin/Owner/addOwner/'.$id);	
                    }
                }else{
                	$error['basic-detail'] = 'Some error below';
                }
            }
            $driverData['error'] = $error;
            $this->load->view('admin/add-owner',$driverData);		
        }

    #Address Details Driver Insert Table
	public function addressDetail($id='')
    {	
    	$error = array();
    	$driverData['data'] = $this->OwnerModel->getDriverDetail($id);
    	$driverData['city'] = $this->CityModel->getAllActiveCity();
    	if (isset($_POST) && !empty($_POST)) {		
    		extract($_POST);
    		$error = array();
    		if (trim($present_address)== '') {
    			$error['present_address'] = 'Present Address can not be blank';
    		}
    		if (trim($permanent_address)== '') {
    			$error['permanent_address'] = 'Permanent Address can not be blank';
    		}
    		if (trim($city)== '') {
    			$error['city'] = 'City can not be blank';
    		}			
    		if (empty($error)) {

    			$update = $this->OwnerModel->addressDetail($_POST,$id);
    			if ($update) {					
    				$this->session->set_flashdata('success','Well done! You have successfully updated Step2 Driver.');
    				redirect('admin/Owner/addOwner/'.$update);	
    			}else{
    				$this->session->set_flashdata('error','Sorry! Some error occurred.');
    				redirect('admin/Owner/addOwner/'.$id);
    			}
    		}else{
    			$error['step2'] = 'Some error below';
    		}
    	}
    	$driverData['error'] = $error;
    	$this->load->view('admin/add-owner',$driverData);
    }
	
	#Driver Licence Driver Insert Table
	public function drivingLicence($id='')
	{	
    	$error = array();
    	$driverData['data'] = $this->OwnerModel->getDriverDetail($id);
    	$driverData['city'] = $this->CityModel->getAllActiveCity();
    	$error = array();
    	if (isset($_POST) && !empty($_POST)) {		
    		extract($_POST);             		
    		$update = $this->OwnerModel->drivingLicence($_POST,$id);	       		
    	}
    	$target_dir =  BASEPATH."../pubilc/driver/";
    	$error_doc = array();        	

    	if (trim($driving_licence_number)== '') {
    		$error['driving_licence_number'] = 'Driving Licence Number can not be blank';
    	}else{
    		$checkDlLicence = $this->OwnerModel->checkDlLicence($driving_licence_number,$id);
    		if($checkDlLicence){
    			$error['driving_licence_number'] = 'Driving Licence already exist';
    		}
    	}
    	if (trim($dl_expiry_date)== '') {
    		$error['dl_expiry_date'] = 'DL Expiry Date can not be blank';
    	}			
    	if (empty($error)) {
    		$update = $this->OwnerModel->drivingLicence($_POST,$id);
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
                    		$save_document = $this->OwnerModel->updatelicenceImage($key,$file_name,$id);
                    	} else {
                    		$error_doc[$key] = 'Sorry, there was an error uploading your file.';
                    	}
                    }
                }
                if ($update) {					
                	$this->session->set_flashdata('success','Well done! You have successfully updated Licence Details.');
                	redirect('admin/Owner/addOwner/'.$update);	
                }else{
                	$this->session->set_flashdata('error','Sorry! Some error occurred.');
                	redirect('admin/Owner/addOwner/'.$id);
                }
            }else{
            	$error['step3'] = 'Some error below';
            }
            $driverData['error'] = $error;
            $this->load->view('admin/add-owner',$driverData);
    }
	
	#Accident Details Driver Insert Table
    public function accidentDetail($id='')
    {
		$error = array();
		$driverData['data'] = $this->OwnerModel->getDriverDetail($id);
		$driverData['city'] = $this->CityModel->getAllActiveCity();
		if (isset($_POST) && !empty($_POST)) {		
			extract($_POST);
			$error = array();

			if (trim($met_accident)== '') {
				$error['met_accident'] = 'Met Accident can not be blank';
			}
			if (trim($is_criminal_case)== '') {
				$error['is_criminal_case'] = 'Is Criminal Case can not be blank';
			}
// 			if (trim($criminal_case_pending)== '') {
// 				$error['criminal_case_pending'] = 'Criminal Case Pending can not be blank';
// 			}

			if (empty($error)) {
				$update = $this->OwnerModel->accidentDetail($_POST,$id);
				if ($update) {					

					$this->session->set_flashdata('success','Well done! You have successfully updated Step4 Driver.');
					redirect('admin/Owner/addOwner/'.$update);	
				}else{
					$this->session->set_flashdata('error','Sorry! Some error occurred.');
					redirect('admin/Owner/addOwner/'.$id);
				}
			}else{
				$error['step4'] = 'Some error below';
			}
		}
		$driverData['error'] = $error;
		$this->load->view('admin/add-owner',$driverData);		
	}
	
	#Police Verification Driver Insert Table
	public function policeVerification($id='')
	{
		$error = array();
		$driverData['data'] = $this->OwnerModel->getDriverDetail($id);
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
						$save_document = $this->OwnerModel->updatePoliceDocument($key,$file_name,$id);						
					} else {
						$error_doc[$key] = 'Sorry, there was an error uploading your file.';
					}
				}
			}
			$update = $this->OwnerModel->policeVerification($_POST,$id);
			if ($update) {					
				$this->session->set_flashdata('success','Well done! You have successfully updated Police verification Details Driver.');
				redirect('admin/Owner/addOwner/'.$update);	
			}else{
				$this->session->set_flashdata('error','Sorry! Some error occurred.');
				redirect('admin/Owner/addOwner/'.$id);
			}

		}else{
			$error['step5'] = 'Some error below';
		}
			$driverData['error'] = $error;
			$this->load->view('admin/add-owner',$driverData);		
        }
    }
    
    #Document Details Driver Insert Table
    public function documentDetails($id='')
    {            
    	$error = array();
    	$driverData['data'] = $this->OwnerModel->getDriverDetail($id);
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

    			    $update = $this->OwnerModel->updateDocument($_POST,$id);
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
                        		$save_document = $this->OwnerModel->updateDocumentImage($key,$file_name,$id);						
                        	} else {
                        		$error_doc[$key] = 'Sorry, there was an error uploading your file.';
                        	}
                        }
                    }

                    $this->session->set_flashdata('success','Well done! You have successfully updated Documents Details.');
                    redirect('admin/Owner/addOwner/'.$update);	
                // image end

                }else{
                	$error['error-document'];
                }
            }
        }
        $driverData['error'] = $error;
        $this->load->view('admin/add-owner',$driverData);		
    }
	
	#Owner Show View File
	public function addOwner($id=null){
	    $driverData['city'] = $this->CityModel->getAllActiveCity();
		$driverData['data'] = $this->OwnerModel->getOwnerDetail($id);
		$this->load->view('admin/add-owner',$driverData);
	}
	
	#Get Fetched Data Cab Table
	public function vehicleList(){
	   $vehicleListing = $this->OwnerModel->vehicleListing();
	   $this->load->view('admin/ow-vehicle-list',['vehicleListing' => $vehicleListing ]);	
	}
	
	#Map-Driver-Vehicle Insert Table
	public function mappingDriverVehicle(){
	    $vehicleDetails = $this->db->select('id,cab_type_name')->where('is_owner','Yes')->get('cab')->result_array();
	    $driverListing =  $this->OwnerModel->driverListing();
	    $this->load->view('admin/map-driver-vehicle',['vehicleDetails' => $vehicleDetails,'driverListing' => $driverListing]);	
	}
	
	public function mapDriverVehicle(){
	    $vehicleDetails = $this->db->select('id,cab_type_name')->where('is_owner','Yes')->get('cab')->result_array();
	    $driverListing =  $this->OwnerModel->driverListing();
	    if(isset($_POST['submit'])){
          $id = $this->OwnerModel->mapDriverVehicle($_POST);
          if($id != ''){
            $this->session->set_flashdata('success','Well done! You have successfully assigned driver.');
            redirect('admin/Owner/mappingDriverVehicle');
          }else{
        	$this->session->set_flashdata('failure','You have unsuccessfully assigned driver.');
            redirect('admin/Owner/mappingDriverVehicle');	  
          }
        }else{
            $this->load->view('admin/map-driver-vehicle',['vehicleDetails' => $vehicleDetails,'driverListing' => $driverListing]);	
        }
	}
	
	#Vehicle Show View File
	public function addVehicle(){
	    $cab_category = $this->OwnerModel->getCabCategory();
	    $this->load->view('admin/add-vehicle',['cab_category' => $cab_category]);
	}
	
	#Save Vehicle Details cab Insert Table
	public function vehicelDetails($id='')
    {            	
        	$error = array();
        	$driverData['data'] = $this->OwnerModel->getDriverDetail($id);
        	$driverData['city'] = $this->CityModel->getAllActiveCity();
        	if (isset($_POST) && !empty($_POST)) {  
        		extract($_POST);
        		    if(trim($registration_number)== ''){
        		        $error['registration_number'] = 'Registration Number can not be blank';
        		    }
        		  //  if(trim($engine_number)== ''){
        		  //      $error['engine_number'] = ' Engine Number can not be blank';
        		  //  }
        		  //  if(trim($chassis_number)== ''){
        		  //      $error['chassis_number'] = 'Chassis Number can not be blank'; 
        		  //  }
        		    if(trim($rc)== ''){
        		        $error['rc'] = 'Registration Certification can not be blank';
        		    }
        		    if(trim($rc_expiry_date)== ''){
        		        $error['rc_expiry_date'] = 'RC Expiry Date can not be blank';
        		    }
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
        		    
        		    if(trim($manufacture_year)== ''){
                        $error['manufacture_year'] = 'Manufacture Year can not be blank';
        		    }
        			if (empty($error)) {
        				$update = $this->OwnerModel->updateVehicel($_POST);
	                    $this->session->set_flashdata('success','Well done! You have successfully updated Vechicel Details.');
	                    redirect('admin/Owner/vehicelDetails/?id='.$update);	
	                }else{
	                	$error['error-document'];
	                }
	            }
	        $driverData['error'] = $error;
	        $this->load->view('admin/add-vehicle',$driverData);		
	    }
	
	#Vehicle Documents Cab Insert Table
    public function vehicelDocumentImage($id='')
    {            	
    	$error = array();
    	$driverData['data'] = $this->OwnerModel->getDriverDetail($id);
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
				// if(isset($_FILES['fitness_image']) && $_FILES['fitness_image']['name'] != ''){
				// 	$documents['fitness_image'] = $_FILES['fitness_image'];
				// }
				if(isset($_FILES['puc_image']) && $_FILES['puc_image']['name'] != ''){
					$documents['puc_image'] = $_FILES['puc_image'];
				}
				// if(isset($_FILES['owner_image']) && $_FILES['owner_image']['name'] != ''){
				// 	$documents['owner_image'] = $_FILES['owner_image'];
				// }
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
                    		$save_document = $this->OwnerModel->updateVehicelImage($key,$file_name,$id);
                    	} else {
                    		$error_doc[$key] = 'Sorry, there was an error uploading your file.';
                    	}
                    }
                }
                $this->session->set_flashdata('success','Well done! You have successfully updated Vechicel Document.');
                redirect('admin/Owner/vehicelDetails/'.$id);	
            }else{
            	$error['error-document'];
            }
        }
        $driverData['error'] = $error;
        $this->load->view('admin/add-vehicle',$driverData);		
    }
	
	#Get Fetched Data Driver Table
	public function driverListing(){
	      $data =  $this->OwnerModel->driverListing();
	      $this->load->view('admin/ow-driver-list',['driverListing' => $data]);
	}
	    
	public function addDriver($id=null)
	{
		$driverData['city'] = $this->CityModel->getAllActiveCity();
// 		$driverData['data'] = $this->OwnerModel->getOwnerDetail($id);
		$driverData['data'] = $this->OwnerModel->getDriverDetail($id);

	    $driverData['cab_category'] = $this->OwnerModel->getCabCategory();
		$this->load->view('admin/ow-add-driver',$driverData);
	}
	
	public function basicDetailValidation_driver($postData,$id='')
	{
		extract($_POST);
		$error = array();
		if (trim($first_name)== '') {
			$error['first_name'] = 'First Name can not be blank';
		}
		if (trim($last_name)== '') {
			$error['last_name'] = 'Last Name can not be blank';
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
		if (trim($gender)== '') {
			$error['gender'] = 'Gender can not be blank';
		}
		return $error;
	}
	
	public function basicDetail_driver($id=null)
	{
		$error = array();
		$driverData['data'] = $this->DriverModel->getDriverDetail($id);
		$driverData['city'] = $this->CityModel->getAllActiveCity();
		if (isset($_POST) && !empty($_POST)) {				
			extract($_POST);
			$error = $this->basicDetailValidation($_POST,$id);			
			if (empty($error)) {				
				if ($id == '') {
					$save = $this->OwnerModel->saveBasicDetailDriver($_POST);				
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
                    	redirect('admin/Owner/addDriver/'.$save);	
                    }else{
                    	$this->session->set_flashdata('success','Well done! You have successfully inserted Basic Details.');
                    	redirect('admin/Owner/addDriver/'.$id);	
                    }
                }else{
                	$error['basic-detail'] = 'Some error below';
                }
            }
            $driverData['error'] = $error;
            $this->load->view('admin/ow-add-driver',$driverData);		
        }

	public function addressDetail_driver($id='')
    {	
        	$error = array();
        	$driverData['data'] = $this->DriverModel->getDriverDetail($id);
        	$driverData['city'] = $this->CityModel->getAllActiveCity();
        	if (isset($_POST) && !empty($_POST)) {		
        		extract($_POST);
        		$error = array();
        		if (trim($present_address)== '') {
        			$error['present_address'] = 'Present Address can not be blank';
        		}
        		if (trim($permanent_address)== '') {
        			$error['permanent_address'] = 'Permanent Address can not be blank';
        		}
        		if (trim($city)== '') {
        			$error['city'] = 'City can not be blank';
        		}			
        		if (empty($error)) {

        			$update = $this->DriverModel->addressDetail($_POST,$id);
        			if ($update) {					
        				$this->session->set_flashdata('success','Well done! You have successfully updated Step2 Driver.');
        				redirect('admin/Owner/addDriver/'.$update);	
        			}else{
        				$this->session->set_flashdata('error','Sorry! Some error occurred.');
        				redirect('admin/Owner/addDriver/'.$id);
        			}
        		}else{
        			$error['step2'] = 'Some error below';
        		}
        	}
        	$driverData['error'] = $error;
        	$this->load->view('admin/ow-add-driver',$driverData);
        }
		
	public function drivingLicence_driver($id='')
	{	
        	$error = array();
        	$driverData['data'] = $this->DriverModel->getDriverDetail($id);
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
        	if (trim($dl_expiry_date)== '') {
        		$error['dl_expiry_date'] = 'DL Expiry Date can not be blank';
        	}			
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
                    	redirect('admin/Owner/addDriver/'.$update);	
                    }else{
                    	$this->session->set_flashdata('error','Sorry! Some error occurred.');
                    	redirect('admin/Owner/addDriver/'.$id);
                    }
                }else{
                	$error['step3'] = 'Some error below';
                }
                $driverData['error'] = $error;
                $this->load->view('admin/ow-add-driver',$driverData);
        }
		
// 	public function accidentDetail_driver($id='')
// 	{
// 			$error = array();
// 			$driverData['data'] = $this->DriverModel->getDriverDetail($id);
// 			$driverData['city'] = $this->CityModel->getAllActiveCity();
// 			if (isset($_POST) && !empty($_POST)) {		
// 				extract($_POST);
// 				$error = array();
// 				if (trim($met_accident)== '') {
// 					$error['met_accident'] = 'Met Accident can not be blank';
// 				}
// 				if (trim($is_criminal_case)== '') {
// 					$error['is_criminal_case'] = 'Is Criminal Case can not be blank';
// 				}
// 				if (trim($criminal_case_pending)== '') {
// 					$error['criminal_case_pending'] = 'Criminal Case Pending can not be blank';
// 				}

// 				if (empty($error)) {
// 					$update = $this->DriverModel->accidentDetail($_POST,$id);
// 					if ($update) {					

// 						$this->session->set_flashdata('success','Well done! You have successfully updated Step4 Driver.');
// 						redirect('admin/Driver/addDriver/'.$update);	
// 					}else{
// 						$this->session->set_flashdata('error','Sorry! Some error occurred.');
// 						redirect('admin/Driver/addDriver/'.$id);
// 					}
// 				}else{
// 					$error['step4'] = 'Some error below';
// 				}
// 			}
// 			$driverData['error'] = $error;
// 			$this->load->view('admin/add-driver',$driverData);		
// 		}
		
// 	public function policeVerification_driver($id='')
// 	{
// 			$error = array();
// 			$driverData['data'] = $this->DriverModel->getDriverDetail($id);
// 			$driverData['city'] = $this->CityModel->getAllActiveCity();
// 			if (isset($_POST) && !empty($_POST)) {		
// 				extract($_POST);
// 				$error = array();			
// 				if (empty($error)) {
// 					$target_dir =  BASEPATH."../pubilc/driver/";
// 					$error_doc = array();
// 					$documents = array();			
// 					if(isset($_FILES['police_verification_image']) && $_FILES['police_verification_image']['name'] != ''){
// 						$documents['police_verification_image'] = $_FILES['police_verification_image'];
// 					}
// 					foreach($documents as $key=>$val){
// 						$random_string = rand(1000,9999);
// 						$cur_datetime = time();
// 					$unique_name = $random_string;
// 					$file_name_arr = $val["name"];
// 					$file_name = $unique_name.'.'.$file_name_arr;
// 					$target_file = $target_dir . basename($file_name);
// 					$target_file_arr[] = $target_file;
// 					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// 					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" ) {
// 						$error_doc[$key] = 'Sorry, only JPG, JPEG, PNG & PDF files are allowed.';
// 					} else {
// 						if (move_uploaded_file($val["tmp_name"], $target_file)) {
// 							$save_document = $this->DriverModel->updatePoliceDocument($key,$file_name,$id);						
// 						} else {
// 							$error_doc[$key] = 'Sorry, there was an error uploading your file.';
// 						}
// 					}
// 				}
// 				$update = $this->DriverModel->policeVerification($_POST,$id);
// 				if ($update) {					
// 					$this->session->set_flashdata('success','Well done! You have successfully updated Police verification Details Driver.');
// 					redirect('admin/Driver/addDriver/'.$update);	
// 				}else{
// 					$this->session->set_flashdata('error','Sorry! Some error occurred.');
// 					redirect('admin/Driver/addDriver/'.$id);
// 				}
// 			}else{
// 				$error['step5'] = 'Some error below';
// 			}
// 				$driverData['error'] = $error;
// 				$this->load->view('admin/add-driver',$driverData);		
//             }
//         }
        
    public function documentDetails_driver($id='')
    {            
        	$error = array();
        	$driverData['data'] = $this->DriverModel->getDriverDetail($id);
        	$driverData['city'] = $this->CityModel->getAllActiveCity();
        	if (isset($_POST) && !empty($_POST)) {        		
        		extract($_POST);
        		if ($id != '') {	
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
	                    redirect('admin/Owner/addDriver/'.$update);	
	                }else{
	                	$error['error-document'];
	                }
	            }
	        }
	        $driverData['error'] = $error;
	        $this->load->view('admin/ow-add-driver',$driverData);		
        }
        
    public function viewDriver($id){
        $getData = $this->db->query('Select * from driver Where id ='.$id)->row_array();
        $this->load->view('admin/ow-view-driver',['getData' => $getData]);
    }
    
    public function viewVehicle($id){
        $getData = $this->db->query('Select * from cab Where id ='.$id)->row_array();
        $this->load->view('admin/ow-view-vehicle',['getData' => $getData]);
    }
    
    public function ownerList(){
        $getOwner = $this->db->get('owner')->result_array();
        $this->load->view('admin/owner-listing',['ownerListing' => $getOwner]);
    }
    
    public function sos(){
        $this->load->view('admin/sos');
    }
    
    public function viewOwner($id=null){
        $driver = $this->db->where('is_owner','Yes')->where('owner_id',$id)->get('driver')->result_array();
        $vehicle = $this->db->where('is_owner','Yes')->where('owner_id',$id)->get('cab')->result_array();
        $today_driver = $this->db->where('is_owner','Yes')->where('created_at',date('Y-m-d'))->get('driver')->num_rows();
        $total_cab = $this->db->where('is_owner','Yes')->get('cab')->num_rows();
        $today_cab = $this->db->where('is_owner','Yes')->where('created_at',date('Y-m-d'))->get('cab')->num_rows();
        $this->load->view('admin/view-owner',['driver' => $driver ,'vehicle' => $vehicle , 'today_driver' => $today_driver, 'total_cab' => $total_cab, 'today_cab' => $today_cab]);
    }
}