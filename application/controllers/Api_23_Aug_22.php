<?php

defined('BASEPATH') or exit('No direct script access allowed');
define('Success', 'Success');
define('Failure', 'Failure');

class Api extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model(array('Api_Model/Front_Model', 'Api_Model/User_Login_Model', 'Api_Model/UserModel', 'Api_Model/CabCategoryModel', 'Api_Model/RideModel', 'Api_Model/WalletModel', 'Api_Model/PackageModel', 'Api_Model/DriverModel', 'Api_Model/CityModel', 'Api_Model/CabModel','Api_Model/Payment_Gateway'));
    }

    public function index()
    {
        redirect('Dashboard');
    }

    // //#######JUST FOR TESTING SCANERIO

    // function saveUserCurrentLocation1() {
    //     $lat = $_GET['lat'];
    //     $long = $_GET['long'];
    //     $data = array(
    //         'city_id'=> 999,
    //         'cab_id' => 999,
    //         'cab_type_id' => 999,
    //         'latitude'=>$lat,
    //         'longitude'=>$long,
    //         'updated_at'=>date('Y-m-d h:i:s'),
    //         'updated_by'=> 999,
    //     );
    //     $this->db->where('user_id', 417);
    //     $update = $this->db->update('user_current_locations', $data);
    // }






    // //#######EOC















    public function updateUserEmail()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');

            $this->form_validation->set_rules('user_id', 'Id', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            if ($this->form_validation->run() == false) {
                $output = array(
                        'status' => Failure,
                        'message' => current($this->form_validation->error_array()),
                        'data' => array(),
                    );
                echo json_encode($output);
                die;
            }

            extract($_POST);
            $user_id = isset($user_id) ? $user_id : 0;
            $checkUserId = $this->db->where('user_id', $user_id)->get('users')->row();
            if (empty($checkUserId)) {
                $output = array(
                'status' => Failure,
                'message' => 'User Id not valid.',
                'data' => array(),
            );
                echo json_encode($output);
                die;
            }
            $email = isset($email) ? $email : '';
            $checkEmailUnique = $this->db->where('email', $email)->where('user_id !=', $user_id)->get('users')->num_rows();

            if ($checkEmailUnique > 0) {
                $output = array(
                'status' => Failure,
                'message' => 'Email already exist.',
                'data' => array(),
            );
                echo json_encode($output);
                die;
            }
            $data = array('email' => $email);
            $update = $this->db->where('user_id', $user_id)->update('users', $data);
            if ($update) {
                $headers = "From: " . strip_tags('pulkitmangal4@gmail.com') . "\r\n";
                $headers .= "Reply-To: ". strip_tags(''.$email.'') . "\r\n";
                $headers .= "CC: ".$email."\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $message = '<html lang="en">
		<head>
			<meta charset="utf-8">
			<meta content="width=device-width, initial-scale=1.0" name="viewport">
			<title>Ballbadminton: Forget password </title>
			<meta content="" name="description">
			<meta content="" name="keywords">
			<!-- Google Fonts -->
			<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
			<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
			<link href="assets/css/style.css" rel="stylesheet">
		</head>
		<body style="margin:0;padding:0;">
			<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
				<tr>
					<td align="center" style="padding:0;">
						<table role="presentation" style="width:700px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
							<tr>
								<td  >
  
								<div style="height: 60px; padding: 5px;justify-content: center; align-items: center; background:  #7258db;text-align: center;      
								">
								
								';

                $message .= '<img src="'.base_url().'assests/logo/logo.png" alt="" width="100" style="height:auto;display:block; float:left;" />      
	  <h4 style="color:white    ; text-align:center;">AAPNI TAXI </h4>
							  </div></td>
						  </tr>
						  <tr>
							<td style="padding:10px 0 0px 0;">';
                $message .= '<h6 style="padding-top: 0px;font-weight: 700;font-size: 18px; margin:10px 0;"> <span style="margin-left: 223px;">Dear <b>#' . $checkUserId->first_name . '#!</span></b><span style="display:block; margin-left: 9px;">
                             Thank you for registring with Apni Taxi app. Your account has successfully created.
                             </br></span></h6>';
                $message .= '<a style="background-color: #f8e467; border-radius:4px;	border: none;color: #000;padding: 15px 32pxtext-align: center;
                                  text-decoration: none;
                                  display: inline-block;
                                  font-size: 16px;
                                  margin: 10px auto;
                    			cursor: pointer;" href="https://play.google.com/store/apps/details?id=com.cabapp.aapnitaxi
                               " class="btn btn-success">Download App</a>
						  </td>
					    </tr>								 
					  </table>
				  </body>
			  </html>';
                $subject = 'Registration Completed Successfully!';
                //parent::_sendMail ($email,$email,$subject,$message);
            }
            $output = array(
                'status' => Success,
                'message' => 'Email update success.',
                'data' => [],
            );
        }
        echo json_encode($output);
        die;
    }


    public function checkRideStatus()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                $postData = $this->input->post();
                extract($_POST);
                // $ride_id
                //check ride status
                $location_status_data = $this->db->select('location_status')->where('id', $ride_id)->get('cab_ride')->row_array();
                $output = array(
                'status' => Success,
                'message' => '',
                'data' => $location_status_data,
            );
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }


    public function userRegister()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                $postData = $this->input->post();
                extract($_POST);
                if (isset($register_type) && $register_type == 'mobile') {
                    $output = $this->mobileRegister($_POST);
                } elseif (isset($register_type) && $register_type == 'facebook') {
                    $output = $this->facebookRegister($_POST);
                } elseif (isset($register_type) && $register_type == 'google') {
                    $output = $this->googleRegister($_POST);
                } elseif (isset($register_type) && $register_type == 'apple') {
                    $output = $this->appleRegister($_POST);
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Register Type can not be blank',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function mobileRegister($postData)
    {
        $checkExistDriverTbl = $this->DriverModel->checkUniqueMobile($postData['mobile']);
        if ($checkExistDriverTbl > 0) {
            $output = array(
            'status' => Failure,
            'message' => 'Your mobile number already registered for driver.Please choose another mobile number',
            'data' => array(),
        );
        } else {
            $otp = rand(1000, 9999);
            $message = "Your One Time Password for Login in Aapni Taxi app is ".$otp." <Dhatush Tech>.";
            $checkExist = $this->User_Login_Model->apiCheckMobileRegister($postData['mobile']);
            if (empty($checkExist)) {
                $validate = $this->User_Login_Model->saveUserMobile($postData['mobile'], $otp);
                if ($validate) {
                    parent::_sendOtp($message, $postData['mobile']);
                }
                $output = array(
                'status' => Success,
                'message' => 'sent otp for user Register',
                'data' => $validate,
            );
            } else {
                $validate = $this->User_Login_Model->updateOtp($postData['mobile'], $otp);
                if ($validate) {
                    parent::_sendOtp($message, $postData['mobile']);
                }
                $output = array(
                'status' => Success,
                'message' => 'sent otp for user Login',
                'data' => $checkExist,
            );
            }
        }
        return $output;
    }

    /**
     * Ibrahim Khan
     * 19-May-21
     * To register user in case of facebook signup
     * @request params
     * postData: facebook_id, first_name, last_name, profile_pic
     *
     * */
    public function facebookRegister($postData)
    {
        $checkFacebookExist = $this->User_Login_Model->apiCheckFacebookRegister($postData['facebook_id']);
        if (empty($checkFacebookExist)) {
            $validate = $this->User_Login_Model->saveUserFacebook($_POST);
            $image_encoded_string = $postData['profile_pic'];
            $image_decoded = base64_decode($image_encoded_string);
            //upload profile pic on server
            if (isset($image_decoded) && !empty($image_decoded)) {
                //upload file on server
                parent::updateProfilePic($image_decoded, $image_encoded_string, $validate['user_id']);
            }
            $output = array(
                'status' => Success,
                'message' => 'user Register Successfully',
                'data' => $validate,
            );
        } else {
            $output = array(
                'status' => Success,
                'message' => 'user Login Successfully',
                'data' => $checkFacebookExist,
            );
        }
        return $output;
    }

    /**
     * Ibrahim Khan
     * 19-May-21
     * To register user in case of gmail signup
     * @request params
     * postData: google_id,email, first_name, last_name,
     *
     * */
    public function googleRegister($postData)
    {
        try {
            $checkGoogleExist = $this->User_Login_Model->apiCheckGoogleRegister($postData['google_id']);
            if (empty($checkGoogleExist)) {
                $validate = $this->User_Login_Model->saveUserGoogle($_POST);
                //   if(isset($postData['profile_pic']) && !is_null($postData['profile_pic'])){
                //     $image_encoded_string = $postData['profile_pic'];
                //     $image_decoded = base64_decode($image_encoded_string);
                //     //upload profile pic on server
                //     if (isset($image_decoded) && !empty($image_decoded)) {
                //         //upload file on server
                //         parent::updateProfilePic($image_decoded, $image_encoded_string, $validate['user_id']);
                //     }
                //   }
                $output = array(
                'status' => Success,
                'message' => 'user Register Successfully',
                'data' => $validate,
            );
            } else {
                $output = array(
                'status' => Success,
                'message' => 'user Login Successfully',
                'data' => $checkGoogleExist,
            );
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        return $output;
    }




    public function appleRegister($postData)
    {
        try {
            //$checkAppleExist = $this->User_Login_Model->apiCheckAppleRegister($postData['google_id']);
            if (true) {
                $validate = $this->User_Login_Model->saveUserApple($_POST);
                $output = array(
                'status' => Success,
                'message' => 'user Register Successfully',
                'data' => $validate,
            );
            } else {
                $output = array(
                'status' => Success,
                'message' => 'user Login Successfully',
                'data' => $checkGoogleExist,
            );
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        return $output;
    }

    public function otpVerify()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                $postData = $this->input->post();
                $validate = $this->User_Login_Model->otpVerify($postData);
                if (!empty($validate)) {
                    $output = array(
                    'status' => Success,
                    'message' => 'otp verify successfully',
                    'data' => $validate,
                );
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'wrong otp',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function driverLogin()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                $otp = rand(1000, 9999);
                $postData = $this->input->post();

                $check_status =  $this->db->where('mobile', $postData['mobile'])->where('status', 1)->get('driver')->num_rows();

                if ($check_status > 0) {
                    $validate = $this->DriverModel->driverLogin($postData, $otp);
                    if (!empty($validate)) {
                        if ($validate['police-step'] == 1) {
                            $message = "Your One Time Password for Login in Aapni Taxi app is ".$otp." <Dhatush Tech>.";
                            parent::_sendOtp($message, $_POST['mobile']);
                            $output = array(
                        'status' => Success,
                        'message' => 'login successfully',
                        'data' => $validate,
                    );
                        } else {
                            $output = array(
                        'status' => Failure,
                        'message' => 'Your account not verify. Please submit all documents. If already submited all documents wait for admin action or call admin',
                        'data' => array(),
                    );
                        }
                    } else {
                        $output = array(
                    'status' => Failure,
                    'message' => 'username and password not match',
                    'data' => array(),
                );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Your account is not active yet. Kindly contact us on (+91) 9983266446',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }


    public function getCity()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $city = $this->CityModel->getAllActiveCity();
            if (!empty($city)) {
                $final_arr = array();
                $main_final_arr = array();
                foreach ($city as $key => $val) {
                    $final_arr['itemName'] = $val['name'];
                    $main_final_arr[] = $final_arr;
                }
            }
            if (!empty($main_final_arr)) {
                $output = array(
                    'status' => Success,
                    'message' => 'City fetch successfully',
                    'data' => $main_final_arr,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function getCabType1()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'GET') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                $city = $this->CabCategoryModel->getAllCabType();
                if (!empty($city)) {
                    $final_arr = array();
                    $main_final_arr = array();
                    foreach ($city as $key => $val) {
                        $final_arr['id'] = $val['id'];
                        $final_arr['itemName'] = $val['name'];
                        $main_final_arr[] = $final_arr;
                    }
                }

                if (!empty($main_final_arr)) {
                    $output = array(
                    'status' => Success,
                    'message' => 'Cab Type fetch successfully',
                    'data' => $main_final_arr,
                );
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Something wrong',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getCabCategory1()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'GET') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                $id = $_GET['id'];
                $city = $this->CabCategoryModel->apiGetAllCabCategory($id);
                if (!empty($city)) {
                    $final_arr = array();
                    $main_final_arr = array();
                    foreach ($city as $key => $val) {
                        $final_arr['id'] = $val['id'];
                        $final_arr['itemName'] = $val['name'];
                        $main_final_arr[] = $final_arr;
                    }
                }

                if (!empty($main_final_arr)) {
                    $output = array(
                    'status' => Success,
                    'message' => 'Cab Category fetch successfully',
                    'data' => $main_final_arr,
                );
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Something wrong',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function changePassword()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $validate = $this->User_Login_Model->changePassword($postData);
            if (!empty($validate)) {
                $output = array(
                    'status' => Success,
                    'message' => 'password change successfully',
                    'data' => $validate,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'wrong old password',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function test()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            extract($_POST);
            if (isset($distance) && $distance < 3) {
                $far = array();
                $far['to_wheeler'] = 25;
                $far['go'] = 61;
                $far['sedan'] = 108;
                $far['suv'] = 147;
                $far['auto'] = 28;
            } elseif (isset($distance) && $distance < 5) {
                $far['to_wheeler'] = 45;
                $far['go'] = 81;
                $far['sedan'] = 97;
                $far['suv'] = 167;
                $far['auto'] = 38;
            } elseif (isset($distance) && $distance <= 10) {
                $far['to_wheeler'] = 75;
                $far['go'] = 108;
                $far['sedan'] = 119;
                $far['suv'] = 197;
                $far['auto'] = 75;
            } elseif (isset($distance) && $distance > 10) {
                $far['to_wheeler'] = $distance * 3;
                $far['go'] = $distance * 7;
                $far['sedan'] = $distance * 8;
                $far['suv'] = $distance * 10;
                $far['auto'] = $distance * 3.5;
            }

            $output = array(
                'status' => 200,
                'message' => Success,
                'data' => $far,
            );
        }
        echo json_encode($output);
        die;
    }

    public function callCalculateFareForAllCategories($source_latitude = null, $source_longitude = null, $distance = null)
    {
        try {
            $far = array();
            // User Locations Lat and Long
            $source_lati = isset($source_latitude) ? $source_latitude : '';
            $source_long = isset($source_longitude) ? $source_longitude : '';

            $cityState = $this->getCityNameStateNameByLatitudeLongitude($source_lati, $source_long);
            if (!empty($cityState)) {
                if (farStateWiseOrCityWise == 'City') {
                    $farAmt = $this->RideModel->getFarCityWise($cityState['city']);
                } else {
                    $farAmt = $this->RideModel->getFarStateWise($cityState['state']);
                }
                if (isset($farAmt) && !empty($farAmt)) {
                    $distance = str_replace("km", "", $distance);
                    $distance = (float) $distance;
                    if (isset($distance) && $distance <= 5) {
                        if (isset($farAmt)) {
                            $data = $this->farCalculateUnderFiveKm($farAmt, $distance, $source_lati, $source_long);
                        }
                    } else {
                        $data = $this->farCalculateUpperFiveKm($farAmt, $distance, $source_lati, $source_long);
                    }
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'Sorry! we are not available in the city',
                        'data' => array(),
                    );
                }
                $data2 = array_values($data);
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Sorry! we are not available in the city',
                    'data' => array(),
                );
            }
        } catch (\Throwable $e) {
            $output = array(
                'status' => Failure,
                'message' => $e->getMessage() . ' on line ' . $e->getLine(),
                'data' => array(),
            );
        }
        if (isset($data2) && !empty($data2)) {
            return $data2;
        } else {
            return array();
        }
    }


    //End Ride API Call
    public function addCalculateFareForCurrentCab()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                extract($_POST);

                $id = (isset($ride_id) && $ride_id != '') ? $ride_id : '';
                $new_updated_total_distance = $distance;

                //get data from cab_ride table
                $cab_ride_data = $this->RideModel->getCabRideData($id);
                $vehicle_type = $cab_ride_data['vechicle_name'];
                $source_lat = $cab_ride_data['source_latitude'];
                $source_long = $cab_ride_data['source_longitude'];
                $driver_id = $cab_ride_data['driver_id'];

                # User assigned driver changed status online
                $this->db->where('id', $driver_id)->update('driver', ['driver_current_status' => 'online']);

                //$final_fare: call calculateFareForAllCategories function : try to create duplicate function
                $data_aa =  $this->callCalculateFareForAllCategories($source_lat, $source_long, $new_updated_total_distance);
                $final_price = 0;
                foreach ($data_aa as $key => $val) {
                    //   print_r($val);die;
                    if ($val['vehicle_name'] === $vehicle_type) {
                        $final_price = $val['finalPrice'];
                    }
                }

                $riderDetail = $this->RideModel->getRiderDetail($id);
                if (isset($riderDetail['rideData']) && count($riderDetail['rideData']) > 0) {
                    $per_km_price = $riderDetail['rideData']['per_km_price'];
                    $extraDistance = ((int)$distance + (int)$riderDetail['rideData']['distance']);
                    $extraPrice = ((int)$distance * (int)$per_km_price); //die;
                    $totalFarAmount = ((int)$riderDetail['rideData']['price'] + (int)$extraPrice);
                    $updateDestination = $this->RideModel->updateDastination($_POST, $extraDistance, $totalFarAmount);
                    $updatedRiderDetail = $this->RideModel->getRiderDetail($ride_id);

                    // Updated by lgarg on 30-july-22 for the final fare of the ride
                    //Get Commission data in gst data
                    $getdata  = $this->db->get('gst-commission')->row_array();

                    $promotion_amt = 0;
                    $commission_amt = ($final_price * (float)$getdata['commission'])/100;
                    $gst_amt = ($final_price * (float)$getdata['gst'])/ 100;
                    $subtotal_amt = $final_price;
                    $before_tax_amt = $final_price;

                    $final_fare_amt =  ($final_price + $commission_amt + $gst_amt);  // SUM
                    $final_fare_amt = $final_fare_amt - $promotion_amt;

                    $updateData = array(
                   'commission_amt' => $commission_amt,
                   'gst_amt' => $gst_amt,
                   'subtotal_fare_amt' => $subtotal_amt,
                   'before_tax_amt' => $before_tax_amt,
                   'promotion_amt' => $promotion_amt,
                   'final_fare_amt' => $final_fare_amt
                 );

                    $this->db->where('id', $ride_id)->update('cab_ride', $updateData);

                    $updatedRiderDetail['rideData']['price'] =  number_format($final_fare_amt, 2, '.', '');

                    //now update data (commission, subtotal, gst, final_fare) in cab_ride table
                    //END

                    if ($updatedRiderDetail) {
                        $output = array(
                        'status' => 200,
                        'message' => Success,
                        'data' => $updatedRiderDetail,
                    );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Sorry! something wrong',
                        'data' => array(),
                    );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Sorry! Ride id not valid',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function calculateFareForAllCategories()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                extract($_POST);
                $far = array();
                // User Locations Lat and Long
                $source_lati = isset($source_latitude) ? $source_latitude : '';
                $source_long = isset($source_longitude) ? $source_longitude : '';

                $check_already_user = $this->db->where('user_id', $user_id)->where('user_type', 'User')->get('user_current_locations')->num_rows();
                if ($check_already_user > 0) {
                    $this->db->where('user_id', $user_id)->where('user_type', 'User')->update('user_current_locations', ['latitude' => $source_lati, 'longitude' => $source_long, 'user_type' => 'User']);
                } else {
                    $this->db->insert('user_current_locations', ['latitude' => $source_lati, 'longitude' => $source_long, 'user_type' => 'User', 'user_id' => $user_id]);
                }

                $cityState = $this->getCityNameStateNameByLatitudeLongitude($source_lati, $source_long);
                if (!empty($cityState)) {
                    if (farStateWiseOrCityWise == 'City') {
                        $farAmt = $this->RideModel->getFarCityWise($cityState['city']);
                    } else {
                        $farAmt = $this->RideModel->getFarStateWise($cityState['state']);
                    }
                    if (isset($farAmt) && !empty($farAmt)) {
                        $distance = str_replace("km", "", $distance);
                        $distance = (float) $distance;
                        if (isset($distance) && $distance <= 5) {
                            if (isset($farAmt)) {
                                $data = $this->farCalculateUnderFiveKm($farAmt, $distance, $source_lati, $source_long);
                            }
                        } else {
                            $data = $this->farCalculateUpperFiveKm($farAmt, $distance, $source_lati, $source_long);
                        }
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Sorry! we are not available in the city',
                        'data' => array(),
                    );
                    }
                    if (isset($data) && !empty($data)) {
                        $data2 = array_values($data);
                        //fare

                        //calculate gst taxes
                        //update
                        foreach ($data2 as $key => $val) {
                            $new_arr[$key] = $val;
                            $getdata  = $this->db->get('gst-commission')->row_array();
                            $promotion_amt = 0;
                            $commission_amt = ($val['finalPrice'] * (float)$getdata['commission'])/100;
                            $gst_amt = ($val['finalPrice'] * (float)$getdata['gst'])/ 100;

                            $final_fare_amt =  ($val['finalPrice'] + $commission_amt + $gst_amt);  // SUM
                            $final_fare_amt =  $final_fare_amt - $promotion_amt;

                            $data2[$key]['finalPrice'] = number_format($final_fare_amt, 2, '.', '');
                        }

                        if (isset($data2) && !empty($data2)) {
                            $output = array(
                            'status' => Success,
                            'message' => Success,
                            'data' => $data2,
                        );
                        }
                    } else {
                        $output = array(
                            'status' => Success,
                            'message' => 'Sorry! something went wrong.',
                            'data' => array(),
                        );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Sorry! we are not available in the city',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }



    #Get FinalCalculateFareUser
    #End Ride User
    public function calculateFareUser()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                    'status' => Failure,
                    'message' => 'Bad request.',
                    'data' => array(),
                );
            } else {
                extract($_POST);
                $far = array();

                $s_lat = isset($source_latitude) ? $source_latitude : '';
                $s_lng = isset($source_longitude) ? $source_longitude : '';

                $d_lat = isset($destination_latitude) ? $destination_latitude : '';
                $d_lng = isset($destination_longitude) ? $destination_longitude : '';

                $new_updated_total_distance = $this->calculateCabDistance($s_lat, $s_lng, $d_lat, $d_lng);

                $id = (isset($ride_id) && $ride_id != '') ? $ride_id : '';

                //get data from cab_ride table
                $cab_ride_data = $this->RideModel->getCabRideData($id);
                $vehicle_type = $cab_ride_data['vechicle_name'];
                $source_lat = $cab_ride_data['source_latitude'];
                $source_long = $cab_ride_data['source_longitude'];
                $driver_id = $cab_ride_data['driver_id'];

                # User assigned driver changed status online
                $this->db->where('id', $driver_id)->update('driver', ['driver_current_status' => 'online']);
                $data_aa =  $this->callCalculateFareForAllCategories($source_lat, $source_long, $new_updated_total_distance);
                $final_price = 0;
                foreach ($data_aa as $key => $val) {
                    if ($val['vehicle_name'] === $vehicle_type) {
                        $final_price = $val['finalPrice'];
                    }
                }
                $riderDetail = $this->RideModel->getRiderDetail($id);
                if (isset($riderDetail['rideData']) && count($riderDetail['rideData']) > 0) {
                    $per_km_price = $riderDetail['rideData']['per_km_price'];
                    $extraDistance = ((int)$new_updated_total_distance + (int)$riderDetail['rideData']['distance']);
                    $extraPrice = ((int)$new_updated_total_distance * (int)$per_km_price); //die;
                    $totalFarAmount = ((int)$riderDetail['rideData']['price'] + (int)$extraPrice);
                    $updateDestination = $this->RideModel->updateDastination($_POST, $extraDistance, $totalFarAmount);
                    $updatedRiderDetail = $this->RideModel->getRiderDetail($ride_id);

                    //Get Commission data in gst data
                    $getdata  = $this->db->get('gst-commission')->row_array();
                    $promotion_amt = 0;
                    $commission_amt = ($final_price * (float)$getdata['commission'])/100;
                    $gst_amt = ($final_price * (float)$getdata['gst'])/ 100;
                    $subtotal_amt = $final_price;
                    $before_tax_amt = $final_price;
                    $final_fare_amt =  ($final_price + $commission_amt + $gst_amt);  // SUM
                    $final_fare_amt = $final_fare_amt - $promotion_amt;
                    $updateData = array(
                       'commission_amt' => $commission_amt,
                       'gst_amt' => $gst_amt,
                       'subtotal_fare_amt' => $subtotal_amt,
                       'before_tax_amt' => $before_tax_amt,
                       'promotion_amt' => $promotion_amt,
                       'final_fare_amt' => $final_fare_amt
                     );
                    $this->db->where('id', $ride_id)->update('cab_ride', $updateData);
                    $updatedRiderDetail['rideData']['price'] =  number_format($final_fare_amt, 2, '.', '');
                    if ($updatedRiderDetail) {
                        $output = array(
                            'status' => 200,
                            'message' => Success,
                            'data' => $updatedRiderDetail,
                        );
                    } else {
                        $output = array(
                            'status' => Failure,
                            'message' => 'Sorry! something wrong',
                            'data' => array(),
                        );
                    }
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'Sorry! Ride id not valid',
                        'data' => array(),
                    );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
                'status' => Failure,
                'message' => $e->getMessage() . ' on line ' . $e->getLine(),
                'data' => array(),
            );
        }
        echo json_encode($output);
        die;
    }

    # Calculated Cab Distance
    public function calculateCabDistance($s_lat, $s_lng, $d_lat, $d_lng)
    {
        $googleMapsApiKey = 'AIzaSyDRqF4mB5Q-bYhqRxw5qqSc4xrgYMKEvpM';
        $details_url = "https://maps.googleapis.com/maps/api/directions/json?origin=$s_lat,$s_lng&destination=$d_lat,$d_lng&key=$googleMapsApiKey";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = json_decode(curl_exec($ch), true);
        $distance = isset($data['routes'][0]['legs'][0]['distance']['text']) ? $data['routes'][0]['legs'][0]['distance']['text'] : '';
        $distance = str_replace('m', '', $distance); //string
        $distance = str_replace('km', '', $distance); //string
        $distance = (int) $distance;
        return $distance;
    }


    public function distanceTimeCalculate($s_lat, $s_lng, $d_lat, $d_lng)
    {
        // $googleMapsApiKey = 'AIzaSyBenoD58B6RL45gA0rtL1pUuxplFnhrV20';
        $googleMapsApiKey = 'AIzaSyDRqF4mB5Q-bYhqRxw5qqSc4xrgYMKEvpM';
        $details_url = "https://maps.googleapis.com/maps/api/directions/json?origin=$s_lat,$s_lng&destination=$d_lat,$d_lng&key=$googleMapsApiKey";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = json_decode(curl_exec($ch), true);
        return $duration = isset($data['routes'][0]['legs'][0]['duration']['text']) ? $data['routes'][0]['legs'][0]['duration']['text'] : '';
    }

    public function farCalculateUnderFiveKm($farAmt, $distance, $source_lati, $source_long)
    {
        foreach ($farAmt as $key => $value) {
            $cab_type_id = $value['cab_type_id'];
            $vehicle_category = $value['vehicle_category'];
            $vehicle_type = $value['vehicle_type'];
            $vehicle_name = $value['vehicle_name'];
            $icon = $value['cab_icon'];
            $farPrice = $value['minimum_fare'];
            $is_applicable_night = $value['is_applicable_night'];
            $night_charges = $value['night_charges'];
            $is_strike = $value['is_strike'];
            $strike_charge = $value['strike_charge'];
            $cab_icon = 'https://www.aapnitaxi.com/pubilc/cab/cab_icon/' . $icon;
            // get wheeler type 2 wheeler or 3 or 4 or 6
            $getAllCabThisCab = $this->RideModel->getAllCabThisCategory($vehicle_category);
            // source latitude longtude array
            $source_lat_s_log = array('source_latitude' => $source_lati, 'source_longitude' => $source_long);
            $allCabDistance = $this->calculateAllCabDistance($getAllCabThisCab, $source_lat_s_log);
            $final_arr = array();
            if (!empty($allCabDistance)) {
                foreach ($allCabDistance as $key1 => $data) {
                    $distance = trim(explode('km', $data['distance'])[0]);
                    $allCabDistance[$key1]['distance'] = $distance;
                }
            }
            usort($allCabDistance, function ($a, $b) {
                return $a['distance'] <=> $b['distance'];
            });
            $min_distance = isset($allCabDistance[0]['driver_id']) ? $allCabDistance[0]['driver_id'] : '';
            $cabData = $this->RideModel->getCabCurrentLocation($min_distance);
            // get driver live location
            $driver_latitude = isset($cabData['latitude']) ? $cabData['latitude'] : '';
            $driver_longitude = isset($cabData['longitude']) ? $cabData['longitude'] : '';
            $aproxTimeMinsHours = $this->distanceTimeCalculate($driver_latitude, $driver_longitude, $source_lati, $source_long);
            $aproxTime = date('Y-m-d H:i:s', strtotime('+' . $aproxTimeMinsHours)); //die;
            $singleVehicle = array('vehicle_category' => $vehicle_category,
                'cab_type_id' => $cab_type_id,
                'vehicle_name' => $vehicle_name,
                'vehicle_type' => $vehicle_type,
                'cab_icon' => $cab_icon,
                'farPrice' => number_format($farPrice, 2, '.', ''),
                'is_applicable_night' => $is_applicable_night,
                'night_charges' => $night_charges,
                'is_strike' => $is_strike,
                'strike_charge' => $strike_charge,
                'per_km_price' => $value['fare_after_5_km'],
                'aprox_time' => $aproxTime
            );
            // get time 24 format hour only
            $time = date('H');
            if ($time >= 10 or $time <= 5) {
                if ($is_applicable_night == 'Yes') {
                    $night_charge = $value['night_charges'];
                } else {
                    $night_charge = 0;
                }
            } else {
                $night_charge = 0;
            }
            if ($value['is_strike'] == 'Yes') {
                $strikeCharge = $strike_charge;
            } else {
                $strikeCharge = 0;
            }
            $finalPrice = $farPrice + $strikeCharge + $night_charge;

            $finalPrices = isset($finalPrice) ? number_format($finalPrice, 2, '.', '') : 0;
            $singleVehicle['finalPrice'] = $finalPrices;
            $finalArr = $singleVehicle;
            $data2[$key] = $finalArr;
        }
        return $data2;
    }


    public function farCalculateUpperFiveKm($farAmt, $distance, $source_lati, $source_long)
    {
        foreach ($farAmt as $key => $value) {
            $input_distance = $distance;
            $input_distance = str_replace('m', '', $distance);
            $input_distance = str_replace('km', '', $distance);
            $input_distance = (float) $input_distance;

            $cab_type_id = $value['cab_type_id'];
            $vehicle_category = $value['vehicle_category'];
            $vehicle_type = $value['vehicle_type'];
            $vehicle_name = $value['vehicle_name'];
            $icon = $value['cab_icon'];
            $farPrices = $value['minimum_fare'];
            $is_applicable_night = $value['is_applicable_night'];
            $night_charges = $value['night_charges'];
            $is_strike = $value['is_strike'];
            $strike_charge = $value['strike_charge'];
            $cab_icon = 'https://www.aapnitaxi.com/pubilc/cab/cab_icon/' . $icon;
            // get wheeler type 2 wheeler or 3 or 4 or 6
            $getAllCabThisCab = $this->RideModel->getAllCabThisCategory($vehicle_category);
            // source latitude longtude array
            $source_lat_s_log = array('source_latitude' => $source_lati, 'source_longitude' => $source_long);
            $allCabDistance = $this->calculateAllCabDistance($getAllCabThisCab, $source_lat_s_log);
            $final_arr = array();


            if (!empty($allCabDistance)) {
                foreach ($allCabDistance as $key1 => $data) {
                    //$distance = trim(explode('km', $data['distance'])[0]);
                    $allCabDistance[$key1]['distance'] = trim(explode('km', $data['distance'])[0]);
                }
            }
            usort($allCabDistance, function ($a, $b) {
                return $a['distance'] <=> $b['distance'];
            });
            $min_distance = isset($allCabDistance[0]['driver_id']) ? $allCabDistance[0]['driver_id'] : '';
            $cabData = $this->RideModel->getCabCurrentLocation($min_distance);
            // get driver live location
            $driver_latitude = isset($cabData['latitude']) ? $cabData['latitude'] : '';
            $driver_longitude = isset($cabData['longitude']) ? $cabData['longitude'] : '';
            $aproxTimeMinsHours = $this->distanceTimeCalculate($driver_latitude, $driver_longitude, $source_lati, $source_long);
            $aproxTime = date('Y-m-d H:i:s', strtotime('+' . $aproxTimeMinsHours)); //die;
            $distances = (float) $input_distance - 5;
            // print_r($distances);die;
            $farAmt = $distances * $value['fare_after_5_km'];
            $farPrice = $farPrices + $farAmt;
            // print_r($farAmt);die;

            $singleVehicle = array(
                'cab_type_id' => $cab_type_id,
                'vehicle_category' => $vehicle_category,
                'vehicle_name' => $vehicle_name,
                'vehicle_type' => $vehicle_type,
                'cab_icon' => $cab_icon,
                'farPrice' => number_format($farPrice, 2, '.', ''),
                'is_applicable_night' => $is_applicable_night,
                'night_charges' => $night_charges,
                'is_strike' => $is_strike,
                'strike_charge' => $strike_charge,
                'per_km_price' => $value['fare_after_5_km'],
                'aprox_time' => $aproxTime
            );

            // get time 24 format hour only
            $time = date('H');
            if ($time >= 10 or $time <= 5) {
                if ($is_applicable_night == 'Yes') {
                    $night_charge = $value['night_charges'];
                } else {
                    $night_charge = 0;
                }
            } else {
                $night_charge = 0;
            }
            if ($value['is_strike'] == 'Yes') {
                $strikeCharge = $strike_charge;
            } else {
                $strikeCharge = 0;
            }
            $finalPrice = $farPrice + $strikeCharge + $night_charge;
            $finalPrices = isset($finalPrice) ? number_format($finalPrice, 2, '.', '') : 0;
            $singleVehicle['finalPrice'] = $finalPrices;
            $finalArr = $singleVehicle;
            $data2[$key] = $finalArr;
        }
        return $data2;
    }

    public function bookRide()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $this->db->insert('json_test', array('data' => json_encode($_POST)));
            $date = date('Y-m-d');
            # Check Driver Will be Online or Not.
            $driverOnline = $this->RideModel->checkDriveOnline();
            if ($driverOnline) {
                # Get Driver Near By.
                # If the user has stucked the bike, then the driver will also be the bike.
                $cabData = $this->RideModel->getCabNearBy($_POST);

                if (!empty($cabData)) {
                    $cancledcab = $this->db->select('cab_id')->where(['user_id' => $_POST['user_id'], 'canceled' => 1, 'canceled_type' => 'Driver'])->where('DATE(created_at)', $date)->get('cab_ride')->row();
                    $cancledcabid  = $cancledcab->cab_id ?? 0;
                    $cabData2 = [];
                    foreach ($cabData as $key => $val):
                        if ($val['cab_id'] == $cancledcabid):
                            unset($val[$key]); else:
                                $cabData2[$key] = $val;
                            endif;
                    endforeach;
                    // print_r($cabData2);die;
                    # Get All Cab Under 20Km Radius In Lal Kothi

                    $desination_latitude = isset($_POST['destination_latitude']) ? $_POST['destination_latitude'] : '';
                    $destination_longitude = isset($_POST['destination_longitude']) ? $_POST['destination_longitude'] : '';

                    $UnderDriverTwentyKm = $this->calculateAllCabDistanceUnderTwentyKm($cabData, $desination_latitude, $destination_longitude);
                    // print_r($UnderDriverTwentyKm);die;
                    if (!empty($UnderDriverTwentyKm)) {
                        // echo "dd";die;
                        # Get All Cab Distance Calculate
                        #Old Code
                        // $data = $this->calculateAllCabDistance($cabData, $_POST);

                        #New Code  Written By Pulkit Mangal (15-7-2022)
                        $data = $this->calculateAllCabDistance($cabData, $_POST);
                        // print_r($data);die;
                        $distance = array_column($data, 'distance');
                        $min_distance = $data[array_search(min($distance), $distance)];
                        // print_r($min_distance);die;
                        $cabAndDriverdata = $this->RideModel->saveRide($_POST, $min_distance);
                        $output = array(
                            'status' => Success,
                            'message' => 'cab booked successfully',
                            'data' => $cabAndDriverdata,
                        );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Sorry! Unable to find driver.Kindly Contact on (+91) 9983266446',
                        'data' => array(),
                    );
                    }
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'Driver not found',
                'data' => array(),
               );
                }
            } else {
                $output = array(
                'status' => Failure,
                'message' => 'Sorry! Unable to find driver.Kindly Contact on ',
                'data' => "(+91) 9983266446",
            );
            }
        }
        echo json_encode($output);
        die;
    }




    //in case of cancellation
    public function searchRide($data, $recently_assigned_driver_id)
    {
        $_POST = $data;
        // $cabData = $this->RideModel->getCabNearBy($_POST);
        $cabData = $this->RideModel->getCabNearByForCancellation($_POST, $recently_assigned_driver_id);

        // print_r($cabData);die;

        //added by lgarg: added a check if user found a driver OR not
        $user_ride_data = $this->db->where(['user_id' => $_POST['user_id'], 'location_status' => 0])->get('cab_ride')->row_array();
        if (empty($user_ride_data)) {
            $date = date('Y-m-d');
            if (!empty($cabData)) {
                $cancledcab = $this->db->select('cab_id')->where(['user_id' => $_POST['user_id'], 'canceled' => 1, 'canceled_type' => 'Driver'])->where('DATE(created_at)', $date)->get('cab_ride')->row();
                $cancledcabid  = $cancledcab->cab_id ?? 0;
                $cabData2 = [];
                foreach ($cabData as $key => $val):
                    if ($val['cab_id'] == $cancledcabid):
                        unset($val[$key]); else:
                            $cabData2[$key] = $val;
                        endif;
                endforeach;
                # Get All Cab Under 20Km Radius In Lal Kothi

                $desination_latitude = isset($_POST['destination_latitude']) ? $_POST['destination_latitude'] : '';
                $destination_longitude = isset($_POST['destination_longitude']) ? $_POST['destination_longitude'] : '';

                $UnderDriverTwentyKm = $this->calculateAllCabDistanceUnderTwentyKm($cabData, $desination_latitude, $destination_longitude);
                // print_r($UnderDriverTwentyKm);die;
                if (!empty($UnderDriverTwentyKm)) {
                    // echo "dd";die;
                    # Get All Cab Distance Calculate
                    #Old Code
                    // $data = $this->calculateAllCabDistance($cabData, $_POST);

                    #New Code  Written By Pulkit Mangal (15-7-2022)
                    $data = $this->calculateAllCabDistance($cabData, $_POST);
                    // print_r($data);die;
                    $distance = array_column($data, 'distance');
                    $min_distance = $data[array_search(min($distance), $distance)];
                    // print_r($min_distance);die;
                    $cabAndDriverdata = $this->RideModel->saveRide($_POST, $min_distance);
                    $output = array(
                            'status' => Success,
                            'message' => 'cab booked successfully',
                            'data' => $cabAndDriverdata,
                        );
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'Sorry! Unable to find driver.Kindly Contact on (+91) 9983266446',
                        'data' => array(),
                    );
                }
            } else {
                $output = array(
                'status' => Failure,
                'message' => 'Driver not found',
                'data' => array(),
               );
            }
        } else {
            //cab already assigned to user: leave it
            $output = array(
                'status' => Success,
                'message' => 'Driver already assigned.',
                'data' => $user_ride_data,
               );
        }

        //   print_r($output);die;
        return $output;
    }



    public function bookRideAgain()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $recently_assigned_driver_id = $_POST['recently_assigned_driver_id'];
            $cabData = $this->RideModel->getCabNearByForCancellation($_POST, $recently_assigned_driver_id);
            

            $user_ride_data = $this->db->where(['user_id' => $_POST['user_id'], 'location_status' => 0])->get('cab_ride')->row_array();
            if (empty($user_ride_data)) {
                $date = date('Y-m-d');
                if (!empty($cabData)) {
                    $cancledcab = $this->db->select('cab_id')->where(['user_id' => $_POST['user_id'], 'canceled' => 1, 'canceled_type' => 'Driver'])->where('DATE(created_at)', $date)->get('cab_ride')->row();
                    $cancledcabid  = $cancledcab->cab_id ?? 0;
                    $cabData2 = [];
                    foreach ($cabData as $key => $val):
                        if ($val['cab_id'] == $cancledcabid):
                            unset($val[$key]); else:
                                $cabData2[$key] = $val;
                            endif;
                    endforeach;
                    // print_r($cabData2);die;
                    # Get All Cab Under 20Km Radius In Lal Kothi

                    $desination_latitude = isset($_POST['destination_latitude']) ? $_POST['destination_latitude'] : '';
                    $destination_longitude = isset($_POST['destination_longitude']) ? $_POST['destination_longitude'] : '';

                    $UnderDriverTwentyKm = $this->calculateAllCabDistanceUnderTwentyKm($cabData, $desination_latitude, $destination_longitude);
                    // print_r($UnderDriverTwentyKm);die;
                    if (!empty($UnderDriverTwentyKm)) {
                        // echo "dd";die;
                        # Get All Cab Distance Calculate
                        #Old Code
                        // $data = $this->calculateAllCabDistance($cabData, $_POST);

                        #New Code  Written By Pulkit Mangal (15-7-2022)
                        $data = $this->calculateAllCabDistance($cabData, $_POST);
                        // print_r($data);die;
                        $distance = array_column($data, 'distance');
                        $min_distance = $data[array_search(min($distance), $distance)];
                        // print_r($min_distance);die;
                        $cabAndDriverdata = $this->RideModel->saveRide($_POST, $min_distance);
                        $output = array(
                            'status' => Success,
                            'message' => 'cab booked successfully',
                            'data' => $cabAndDriverdata,
                        );
                    } else {
                        $output = array(
                            'status' => Failure,
                            'message' => 'Sorry! Unable to find driver.Kindly Contact on (+91) 9983266446',
                            'data' => array(),
                        );
                    }
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'Driver not found',
                        'data' => array(),
                    );
                }
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Sorry! Unable to find driver.Kindly Contact on ',
                    'data' => "(+91) 9983266446",
                );
            }
        }
        echo json_encode($output);
        die;
    }




    //EOC



    public function getalluser()
    {
        return $data = $this->db->get('users')->result_array();
    }

    public function getDriverDetail1()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $city = $this->DriverModel->getDriverDetail($_GET['id']);
            if (!empty($city)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Driver Details fetch successfully',
                    //'image_link' => base_url().'public/driver/',
                    'data' => $city,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }








    public function getDriverBookings()
    {
        $this->load->library('form_validation');
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $data = $this->RideModel->getDriverBookings($_POST['driver_id']);
            if (!empty($data)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Ride Details fetch successfully',
                    'data' => $data,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function rideBookingOtpVerify()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $validate = $this->RideModel->rideBookingOtpVerify($postData);
            if (!empty($validate)) {
                $output = array(
                    'status' => Success,
                    'message' => 'otp verify successfully',
                    'data' => array(),
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'wrong otp',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }


    public function updateRideLocationStatus()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            extract($postData);
            $driverId = isset($driver_id) ? $driver_id : '';
            $rideId = isset($ride_id) ? $ride_id : '';
            $rideData = $this->RideModel->checkDriverRide($rideId, $driverId);
            if ($rideData > 0) {
                $validate = $this->RideModel->updateRideLocationStatus($postData);
                if (!empty($validate)) {
                    $output = array(
                        'status' => Success,
                        'message' => 'location status update successfully',
                        'data' => $validate,
                    );
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'something wrong',
                        'data' => array(),
                    );
                }
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Ride detail not found ',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }


    public function getRiderDetail2()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $ride_id_new = $_POST['id'];
            //check cancelation of ride by driver
            // $ride_id = '';
            // $ride_data = $this->db->select()->where('id', $_POST['id'])->where('canceled_type', 'Driver')->where('location_status', 3)->get('cab_ride')->row_array();
            // if (!empty($ride_data)) {
            //     //get cab_ride data
            //     $ride_data = $this->db->where('id', $_POST['id'])->get('cab_ride')->row_array();
            //     $ride_data_arr = [];

            //     $recently_assigned_driver_id = $ride_data['driver_id'];

            //     $ride_data_arr['user_id'] = $ride_data['user_id'];
            //     $ride_data_arr['estimated_time'] = $ride_data['estimated_time'];
            //     $ride_data_arr['cab_type'] = $ride_data['cab_type'];
            //     $ride_data_arr['source_latitude'] = $ride_data['source_latitude'];
            //     $ride_data_arr['source_longitude'] = $ride_data['source_longitude'];
            //     $ride_data_arr['destination_latitude'] = $ride_data['destination_latitude'];
            //     $ride_data_arr['destination_longitude'] = $ride_data['destination_longitude'];
            //     $ride_data_arr['price'] = $ride_data['price'];
            //     $ride_data_arr['distance'] = $ride_data['distance'];
            //     $ride_data_arr['vechicle_name'] = $ride_data['vechicle_name'];
            //     $ride_data_arr['cab_type_id'] = 1;

            //     $search_ride_data = $this->searchRide($ride_data_arr, $recently_assigned_driver_id);
            //     if ($search_ride_data['status'] != 'Failure') {
            //         if (isset($search_ride_data['data']['ride_id'])) {
            //             $ride_id = $search_ride_data['data']['ride_id'];
            //         } else {
            //             $ride_id = '';
            //         }
            //     } else {
            //         $ride_id = '';
            //     }
            // }
            // print_r($ride_id_new);die;

            // if (!empty($ride_id)) {
            //     $city = $this->RideModel->getRiderDetail($ride_id);
            // } else {
                $city = $this->RideModel->getRiderDetail($ride_id_new);
            // }

            if (!empty($city)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Ride Details fetch successfully',
                    'data' => $city,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function getUserCurrentLocation()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            extract($_POST);
            $id = isset($id) ? $id : '';
            $type = isset($type) ? $type : '';
            if ($type == 'Driver') {
                $data = $this->DriverModel->getDriverCurrentLocation($id);
            } elseif ($type == 'User') {
                $data = $this->UserModel->getUserLocation($id);
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'please sent valid user type',
                    'data' => array(),
                );
            }
            if (isset($type) && $type == 'Driver' || $type == 'User') {
                if (isset($data) && !empty($data)) {
                    $output = array(
                        'status' => Success,
                        'message' => $type . ' Current Location fetch successfully',
                        'driverLocation' => $data,
                    );
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'Something wrong',
                        'data' => array(),
                    );
                }
            }
        }
        echo json_encode($output);
        die;
    }

    public function getCabDetail()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $city = $this->CabModel->getCabDetailByDriverId($_GET['driver_id']);
            if (!empty($city)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Cab Details fetch successfully',
                    'data' => $city,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }


    // function calculateCabDistanceForDriver($source_latitude, $source_longitude,$destination_latitude,$destination_longitude) {
    //     # Lokesh Sir Send Code
    //     $data = [];
    //     $data2 = [];

    //     # User Location Source and Destination
    //     $s_lat = $source_latitude;
    //     $s_lng = $source_longitude;
    //     $d_lat = $destination_latitude;
    //     $d_lng = $destination_longitude;
    //     $googleMapsApiKey = 'AIzaSyDRqF4mB5Q-bYhqRxw5qqSc4xrgYMKEvpM';
    //     $details_url = "https://maps.googleapis.com/maps/api/directions/json?origin=$s_lat,$s_lng&destination=$d_lat,$d_lng&key=$googleMapsApiKey";
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $details_url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     $data = json_decode(curl_exec($ch), true);
    //     $distance = isset($data['routes'][0]['legs'][0]['distance']['text']) ? $data['routes'][0]['legs'][0]['distance']['text'] : '';
    //     return $distance;
    // }

    public function calculateAllCabDistance($cabData, $postData)
    {
        # Lokesh Sir Send Code
        $data = [];
        $data2 = [];

        foreach ($cabData as $key => $val) {

            # User Location Source and Destination
            $s_lat = $postData['source_latitude'];
            $s_lng = $postData['source_longitude'];
            $d_lat = $val['latitude'];
            $d_lng = $val['longitude'];
            $googleMapsApiKey = 'AIzaSyDRqF4mB5Q-bYhqRxw5qqSc4xrgYMKEvpM';
            $details_url = "https://maps.googleapis.com/maps/api/directions/json?origin=$s_lat,$s_lng&destination=$d_lat,$d_lng&key=$googleMapsApiKey";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $details_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = json_decode(curl_exec($ch), true);
            $distance = isset($data['routes'][0]['legs'][0]['distance']['text']) ? $data['routes'][0]['legs'][0]['distance']['text'] : '';
            $data2[$key] = array('cab_id' => $val['cab_id'], 'distance' => $distance, 'driver_id' => $val['user_id']);
        }
        return $data2;
    }

    public function calculateAllCabDistanceUnderTwentyKm($cabData, $desination_latitude, $destination_longitude)
    {
        $data = [];
        $data2 = [];

        # Lal Kothi
        # Lat : 26.889441
        # Long: 75.798866

        $Lat = 26.889441;
        $Long = 75.798866;
        foreach ($cabData as $key => $val) {
            $s_lat = $Lat;
            $s_lng = $Long;
            $d_lat = $desination_latitude;
            $d_lng = $destination_longitude;
            $googleMapsApiKey = 'AIzaSyDRqF4mB5Q-bYhqRxw5qqSc4xrgYMKEvpM';
            $details_url = "https://maps.googleapis.com/maps/api/directions/json?origin=$s_lat,$s_lng&destination=$d_lat,$d_lng&key=$googleMapsApiKey";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $details_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = json_decode(curl_exec($ch), true);
            $distance = isset($data['routes'][0]['legs'][0]['distance']['text']) ? $data['routes'][0]['legs'][0]['distance']['text'] : '';
            $distance = str_replace('m', '', $distance); //string
            $distance = str_replace('km', '', $distance); //string
            $distance = (int) $distance;
            if ($distance <= 20) {
                $data2[$key] = array(
                  'id' => $val['id'],
                  'cab_id' => $val['cab_id'],
                  'distance' => $distance,
                  'user_id' => $val['user_id'],
                  'city_id' => 0,
                  'cab_type_id' => $val['cab_type_id'],
                  'latitude' => $val['latitude'],
                  'longitude' => $val['longitude'],
                  'user_type' => $val['user_type'],
                  'created_at' => $val['created_at'],
                  'updated_at' => $val['updated_at'],
                  'created_by' =>$val['created_by'],
                  'updated_by' => $val['updated_by'],
                );
            }
        }
        return $data2;
    }

    public function getUserDetails()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $validate = $this->User_Login_Model->getUserDetails($_GET['user_id']);
            if (!empty($validate)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Success',
                    'data' => $validate,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'invalid user id',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function saveUserFavoritePalace()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $validate = $this->UserModel->saveUserFavoritePalace($postData);
            if (!empty($validate)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Success',
                    'data' => $validate,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function getVehicleType()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $validate = $this->CabCategoryModel->getVehicleType();
            if (!empty($validate)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Success',
                    'data' => $validate,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'data not found',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function confirmRide()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $validate = $this->RideModel->saveRide($postData);
            if (!empty($validate)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Success',
                    'data' => $validate,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'data not found',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function cancelRide()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            extract($_POST);
            if (!empty($ride_id) && $ride_id != '' && $ride_id != 'null' && trim($ride_id) != '') {
                $update = $this->RideModel->cancelRide($_POST);


                if ($update) {
                    $output = array(
                        'status' => Success,
                        'message' => 'ride cancel successfully',
                        'data' => array(),
                    );
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'something wrong',
                        'data' => array(),
                    );
                }
            } else {
                $output = array(
                        'status' => Success,
                        'message' => 'ride cancel successfully',
                        'data' => array(),
                    );
            }
        }
        echo json_encode($output);
        die;
    }

    public function getAllDestination()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $data = $this->RideModel->getAllDestination($_GET['user_id']);
            if (!empty($data)) {
                $output = array(
                    'status' => Success,
                    'message' => 'data fetch successfully',
                    'data' => $data,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'data not found',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function sendPackage()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            extract($_POST);
            $validate = $this->PackageModel->savePackage($_POST);
            if (!empty($validate)) {
                $output = array(
                    'status' => Success,
                    'message' => 'send package successfully',
                    'data' => $validate,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function cancelPackage()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            extract($_POST);
            $update = $this->PackageModel->cancelPackage($_POST);
            if ($update) {
                $output = array(
                    'status' => Success,
                    'message' => 'Package cancel successfully',
                    'data' => $update,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function getLastRideDetail()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $validate = $this->RideModel->getLastRideDetail($_GET['user_id']);
            if (!empty($validate)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Success',
                    'data' => $validate,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'data not found',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function addWalletAmount()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            extract($_POST);
            $checkExist = $this->WalletModel->checkWalletExist($user_id);
            if ($checkExist > 0) {
                $update = $this->WalletModel->updateWalletAmount($_POST);
                $output = array(
                    'status' => Success,
                    'message' => 'update wallet amount successfully',
                    'data' => $update,
                );
            } else {
                $save = $this->WalletModel->saveWalletAmount($_POST);
                $output = array(
                    'status' => Success,
                    'message' => 'save wallet amount successfully',
                    'data' => $save,
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function getWalletAmount()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $wallet = $this->WalletModel->getWalletAmount($_GET['user_id']);
            if (!empty($wallet)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Success',
                    'data' => $wallet,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'data not found',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function getWalletHistory()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $wallet = $this->WalletModel->getWalletHistory($_GET['user_id']);
            if (!empty($wallet)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Success',
                    'data' => $wallet,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'data not found',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function updateProfile()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            extract($_POST);
            $checkExistDriverTbl = $this->DriverModel->checkUniqueMobile($mobile);
            if ($checkExistDriverTbl > 0) {
                $output = array(
                'status' => Failure,
                'message' => 'Your mobile number already registered for driver.Please choose another mobile number',
                'data' => array(),
            );
            } else {
                $validate = $this->User_Login_Model->updateProfile($_POST);
                if (!empty($validate)) {
                    $output = array(
                        'status' => Success,
                        'message' => 'update profile successfully',
                        'data' => $validate,
                    );
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'something wrong',
                        'data' => array(),
                    );
                }
            }
        }
        echo json_encode($output);
        die;
    }

    public function getCab()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $cabType = $this->CabCategoryModel->getCab();
            if (!empty($cabType)) {
                $output = array(
                    'status' => Success,
                    'message' => 'get cab data fetch successfully',
                    'data' => $cabType,
                );
            } else {
                $output = array(
                    'status' => Success,
                    'message' => 'Sorry! data not found',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function getHomeScreenDetails()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            //$cabType = $this->CabCategoryModel->getCab();
            $cabType = $this->CabCategoryModel->getCab2();
            $new_array = array();
            if (!empty($cabType)) {
                foreach ($cabType as $key => $cab) {
                    $new_array[$key]['title'] = $cab['cab_type'];
                    $new_array[$key]['coordinates']['latitude'] = (float) $cab['latitude'];
                    // $new_array[$key]['coordinates']['latitude'] = (float) '26.79959390584872';
                    $new_array[$key]['coordinates']['longitude'] = (float) $cab['longitude'];
                    //  $new_array[$key]['coordinates']['longitude'] = (float) '75.81163340792509';
                }
            }
            $userData = $this->User_Login_Model->getUserDetails($_POST['user_id']);
            $first_name = isset($userData['first_name']) ? $userData['first_name'] : '';
            $last_name = isset($userData['last_name']) ? $userData['last_name'] : '';
            $username = $first_name . ' ' . $last_name;
            $favorite_palace = $this->UserModel->getUserFavoritePalace($_POST['user_id']);

            $data = array('username' => $username,
                'cabType' => $new_array,
                'userFavoritePalace' => $favorite_palace
            );
            $output = array(
                'status' => Success,
                'message' => 'data fetch successfully',
                'data' => $data,
            );
        }
        echo json_encode($output);
        die;
    }

    public function getUserFavoritePalace()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $favorite_palace = $this->UserModel->getUserFavoritePalace($_POST['user_id']);
            $output = array(
                'status' => Success,
                'message' => 'data fetch successfully',
                'data' => $favorite_palace,
            );
        }
        echo json_encode($output);
        die;
    }

    //Added by lgarg on 08-08-22
    public function checkDriverOnlineStatus()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $driver_id = $_POST['id'];
            $driver_data = $this->db->select('driver_current_status')->where('id', $driver_id)->get('driver')->row_array();
            if (!empty($driver_data)) {
                $output = array(
                    'status' => Success,
                    'message' => '',
                    'data' => $driver_data,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Driver not Found',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }


    //Added by lgarg on 08-08-22
    public function paymentCollectedFromDriver()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $ride_id = $_POST['ride_id'];
            $this->db->where('id', $ride_id);
            $this->db->update('cab_ride', ['payment_collected_from_driver' => 1]);


            //change status in table payment_history in case of cash
            //   $this->db->where('cab_ride_id',$ride_id);
            //   $this->db->update('payment_history',['status' => 'TXN_SUCCESS']);
            //EOC


            $output = array(
                'status' => Success,
                'message' => 'Ride payment collected',
                'data' => true,
            );
        }
        echo json_encode($output);
        die;
    }


    //Added by lgarg on 08-08-22
    public function checkEndRideStatus()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $ride_id = $_POST['ride_id'];
            $ride_data = $this->db->select('location_status')->where('id', $ride_id)->where('location_status', 2)->get('cab_ride')->row_array();
            if (!empty($ride_data)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Ride Ended',
                    'data' => $ride_data,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Ride Data not Found',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }





    public function saveUserCurrentLocation()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                $this->load->helper(array('form', 'url'));
                $this->load->library('form_validation');

                $this->form_validation->set_rules('id', 'Id', 'required');
                $this->form_validation->set_rules('type', 'Type', 'required');
                $this->form_validation->set_rules('longitude', 'Longitude', 'required');
                $this->form_validation->set_rules('latitude', 'Latitude', 'required');

                if ($this->form_validation->run() == false) {
                    $output = array(
                'status' => Failure,
                'message' => current($this->form_validation->error_array()),
                'data' => array(),
            );
                    echo json_encode($output);
                    die;
                }

                if ($_POST['type'] == 'Driver') {
                    $this->db->where(['id' => $_POST['id']]);
                    $query = $this->db->get('driver');
                    if ($query->num_rows() > 0) {
                        //echo 'drive found';die;
                        // return  $query->num_rows();
                    } else {
                        $output = array(
                'status' => Failure,
                'message' => 'Sorry! driver id not found',
                'data' => array(),
            );
                        echo json_encode($output);
                        die;
                    }
                } elseif ($_POST['type'] == 'User') {
                    $this->db->where(['id' => $_POST['id']]);
                    $query = $this->db->get('users');
                    if ($query->num_rows() > 0) {
                        // return  $query->num_rows();
                    } else {
                        $output = array(
                'status' => Failure,
                'message' => 'Sorry! User id not found',
                'data' => array(),
            );
                        echo json_encode($output);
                        die;
                    }
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'Sorry! Please specify User Type',
                'data' => array(),
            );
                    echo json_encode($output);
                    die;
                }



                $checkExist = $this->UserModel->checkCurrentLocation($_POST);
                $this->load->helper('file');
                // $data = json_encode($_POST);
                // write_file(APPPATH.'../pubilc/log.php', $data);

                //write_file(APPPATH.'../pubilc/log.txt', "<br/>");

                // print_r($checkExist);die;

                // if ($_POST['id'] == 20) {
                //     $output = array(
                //         'status' => Success,
                //         'message' => 'Current Location Saved Successfully',
                //         'data' => array(),
                //     );
                // } else {
                if ($checkExist > 0) {
                    // echo "in";die;
                    $update = $this->UserModel->updateUserCurrentLocation($_POST);
                    $output = array(
                        'status' => Success,
                        'message' => 'Current Location Updated Successfully',
                        'data' => array(),
                    );
                } else {
                    $insertData = $this->UserModel->saveUserCurrentLocation($_POST);
                    $output = array(
                        'status' => Success,
                        'message' => 'Current Location Saved Successfully',
                        'data' => array(),
                    );
                }
                //}
            }
        } catch (\Throwable $e) {
            $output = array(
                'status' => Failure,
                'message' => $e->getMessage(). 'On '.$e->getLine(),
                'data' => array(),
            );
        }

        //Added by lgarg
        $output['active_ride'] = false;
        $output['ongoing_ride'] = false;
        //$output['trip_end'] = false;

        if ($_POST['type'] == 'Driver') {
            $driver_id = $_POST['id'];
            $location_status_arr = [0,1];
            $active_ride_data = $this->db->where_in('location_status', $location_status_arr)->where('canceled !=', 1)->where('driver_id', $driver_id)->get('cab_ride')->row_array();

            if (!empty($active_ride_data)) {
                if ($active_ride_data['location_status'] == 1) {
                    $output['ongoing_ride'] = true;
                }

                if (!empty($active_ride_data)) {
                    $output['active_ride'] = true;
                }
            }
        }


        $output['trip_end'] = false;
        if ($_POST['type'] == 'Driver') {
            $driver_id = $_POST['id'];
            $location_status_arr = [2];
            $completed_ride_data = $this->db->where_in('location_status', $location_status_arr)->where('canceled !=', 1)->where('payment_collected_from_driver', 0)->where('driver_id', $driver_id)->get('cab_ride')->row_array();

            if (!empty($completed_ride_data)) {
                if ($completed_ride_data['location_status'] == 2) {
                    $output['trip_end'] = true;
                }
            }
        }

        // //Added by lgarg
        // $is_nearby_user = 0;
        // if($_POST['type'] == 'Driver'){
        //     // print_r($_POST['id']);die;
        //     //get active ride of that driver
        //     $active_ride_data = $this->db->where('location_status',0)->where('driver_id',$_POST['id'])->get('cab_ride')->row_array();

        //     //$active_ride_data = $this->db->where('location_status',0)->where('driver_id',$_POST['id'])->get('cab_ride')->row_array();
        //     //print_r($active_ride_data);die;
        //     if(!empty($active_ride_data)){
        //         $source_lat = $active_ride_data['source_latitude'];
        //         $source_long = $active_ride_data['source_longitude'];
        //         $current_lat = $_POST['latitude'];
        //         $current_long = $_POST['longitude'];

        //         $distance = $this->calculateCabDistanceForDriver($source_lat, $source_long,$current_lat,$current_long);
        //         if(strpos($distance,"m")){
        //             $distance = (double) str_replace("m","",$distance);
        //             if($distance > 0 && $distance <= 10)
        //             $is_nearby_user = 1;
        //         }
        //     }
        //     //get distance
        //     // calculateAllCabDistance
        // }

        echo json_encode($output);
        die;
    }

    //Update Online to offline driver
    public function offlineDriver()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $driver_id =  $this->input->post('driver_id');
            $current_status = $this->input->post('current_status');
            $this->db->where('id', $driver_id);
            $this->db->update('driver', ['driver_current_status' => $current_status]);

            if (!empty($driver_id)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Driver Offline Successfully',
                    'data' => array('current_status' => $current_status),
                );
            } else {
                $output = array(
                'status' => Failure,
                'message' => 'Invalid Driver Id',
                'data' => array(),
             );
            }
        }
        echo json_encode($output);
        die;
    }

    //Update Online to offline driver
    public function onlineDriver()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                $driver_id =  $this->input->post('driver_id');
                $current_status = $this->input->post('current_status');

                //If the driver banking exists return true
                $check_details  = $this->db->where('driver_id', $driver_id)->get('bank_details')->num_rows();

                if ($check_details > 0) {
                    $this->db->where('id', $driver_id)->update('driver', ['driver_current_status' => $current_status]);

                    if (!empty($driver_id)) {
                        $output = array(
                    'status' => Success,
                    'message' => 'Driver Online Successfully',
                    'data' => array('current_status' => $current_status),
                );
                    } else {
                        $output = array(
                'status' => Failure,
                'message' => 'Invalid Driver Id',
                'data' => array(),
             );
                    }
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'Please complete your bank details.',
                'data' => array(),
            );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getaddress($lat, $lng)
    {
        $googleMapsApiKey = 'AIzaSyDRqF4mB5Q-bYhqRxw5qqSc4xrgYMKEvpM';
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . ',' . $lng . "&key=" . $googleMapsApiKey . "&sensor=false";
        $json = @file_get_contents($url);
        // print_r($json);
        // die;
        $data = json_decode($json);
        $status = $data->status;
        if ($status == "OK") {
            return $data->results[0]->formatted_address;
        } else {
            return false;
        }
    }

    public function getlocation()
    {
        $lat = $_POST['latitude'];
        $lng = $_POST['longitude'];
        $address = $this->getaddress($lat, $lng);
        if ($address) {
            echo $address;
        } else {
            echo "Not found";
        }
    }


    public function getCityNameStateNameByLatitudeLongitude($lat = null, $long = null)
    {
        $googleMapsApiKey = 'AIzaSyDRqF4mB5Q-bYhqRxw5qqSc4xrgYMKEvpM';
        $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . ',' . $long . "&key=" . $googleMapsApiKey . "&sensor=false";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $loc = json_decode(curl_exec($ch), true);

        if (!empty($loc['error_message'])) {
            $city = 'Jaipur';
            $state = 'Rajasthan';
            return $location = array('city' => $city, 'state' => $state);
        } else {
            $location = '';
            if (count($loc['results']) != 0) {
                $city = '';
                $state = '';
                foreach ($loc['results'][0]['address_components'] as $addressComponent) {
                    if (in_array('locality', $addressComponent['types'])) {
                        $city = $addressComponent['short_name'];
                    }
                    if (in_array('administrative_area_level_1', $addressComponent['types'])) {
                        $state = $addressComponent['long_name'];
                    }
                }
                $location = array('city' => $city, 'state' => $state);
            }
            return $location;
        }
    }

    public function getDistance($s_lat = null, $s_lng = null, $d_lat = null, $d_lng = null)
    {
        // $s_lat = '26.822134';
        // $s_lng = '75.774353';
        // $d_lat = '26.917605';
        // $d_lng = '75.816796';
        $googleMapsApiKey = 'AIzaSyDRqF4mB5Q-bYhqRxw5qqSc4xrgYMKEvpM';
        $details_url = "https://maps.googleapis.com/maps/api/directions/json?origin=$s_lat,$s_lng&destination=$d_lat,$d_lng&key=$googleMapsApiKey";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = json_decode(curl_exec($ch), true);
        return $data['routes'][0]['legs'][0]['distance']['text'];
    }

    // save driver base details
    public function saveDriverBasicDetail()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $id = (isset($postData['id']) && $postData['id'] != '') ? $postData['id'] : '';
            $checkUniqueMobile = $this->DriverModel->checkUniqueMobile($postData['mobile'], $id);
            if ($checkUniqueMobile) {
                $output = array(
                    'status' => Failure,
                    'message' => 'Mobile already exist.',
                    'data' => array(),
                );
            } else {
                $otp = rand(1000, 9999);
                if ($id == '') {
                    $data = $this->DriverModel->apiSaveBasicDetail($_POST, $otp);
                } else {
                    //check the $id of the driver
                    $driver_id_exists = $this->DriverModel->checkDriverId($id);
                    if ($driver_id_exists) {
                        $data = $this->DriverModel->apiUpdateBasicDetail($_POST, $otp, $id);
                    } else {
                        $data = $this->DriverModel->apiSaveBasicDetail($_POST, $otp);
                    }
                }

                if ($data) {
                    // sent otp
                    $message = "Your One Time Password for Login in Aapni Taxi app is ".$otp." <Dhatush Tech>.";
                    parent::_sendOtp($message, $_POST['mobile']);
                    $output = array(
                        'status' => Success,
                        'message' => 'sent otp for Driver Register',
                        'data' => $data,
                    );
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'something wrong.',
                        'data' => array(),
                    );
                }
            }
        }
        echo json_encode($output);
        die;
    }

    public function uploadDoc()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            if ($postData['type'] == 'Driver') {
                $update = $this->uploadDriverFile($postData);
            } elseif ($postData['type'] == 'Cab') {
                $update = $this->uploadCabFile($postData);
            } elseif ($postData['type'] == 'User') {
                $update = $this->uploadUserFile($postData);
            } else {
                $update = '';
            }
            if ($update) {
                $output = array(
                    'status' => Success,
                    'message' => 'Document Uploaded Successfully',
                    'data' => array(),
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something went wrong. Kindly try again later.',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }


    public function uploadUserProfile()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            if (!isset($postData['id']) || $postData['id'] != '') {
                $data =  $this->uploadUserProfilePic($postData);
                if ($data) {
                    $output = array(
                        'status' => Success,
                        'message' => 'User profile pic upload successfully',
                        'data' => array(),
                    );
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'User profile pic upload unsuccessfully',
                        'data' => array(),
                    );
                }
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'User ID can not be blank',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function uploadUserProfilePic($postData)
    {
        $target_dir = BASEPATH . "../pubilc/userProfile/";
        $error_doc = array();
        $documents = array();
        if (isset($_FILES['docname']) && $_FILES['docname']['name'] != '') {
            $documents['profile_pic'] = $_FILES['docname'];
        }
        foreach ($documents as $key => $val) {
            $random_string = rand(100, 999);
            $cur_datetime = time();
            $unique_name = $postData['id']."".$random_string . "" . $cur_datetime;
            $file_name_arr = $val["name"];
            $file_name = $unique_name . '_' . $file_name_arr;
            $target_file = $target_dir . basename($file_name);
            $target_file_arr[] = $target_file;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $error_doc[$key] = 'Sorry, only JPG, JPEG, PNG  files are allowed.';
                return false;
            } else {
                print_r($file_name);
                die;
                if (move_uploaded_file($val["tmp_name"], $target_file)) {
                    $data=array(
                        $key=>$file_name,
                        'updated_at'=>date('Y-m-d h:i:s'),
                        'updated_by' => $postData['id'],
                    );
                    if (empty($data)) {
                        return false;
                    }
                    $this->db->where('user_id', $postData['id']);
                    $update = $this->db->update('users', $data);
                    if ($update > 0) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    $error_doc[$key] = 'Sorry, there was an error uploading your file.';
                }
            }
        }
        return true;
    }

    public function uploadDriverFile($postData)
    {
        // echo BASEPATH;die;
        // print_r($postData);die;

        $doc_name = $postData['docname'];

        $target_dir = BASEPATH . "../pubilc/driver/";
        $error_doc = array();
        $documents = array();
        if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
            $documents['file'] = $_FILES['file'];
        }
        foreach ($documents as $key => $val) {
            $random_string = rand(100, 999);
            $cur_datetime = time();
            $unique_name = $postData['id']."_".$random_string . "_" . $cur_datetime;
            $file_name_arr = $val["name"];

            $file_name = $unique_name . '_' . $file_name_arr;

            $target_file = $target_dir . basename($file_name);
            $target_file_arr[] = $target_file;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf") {
                $error_doc[$key] = 'Sorry, only JPG, JPEG, PNG & PDF files are allowed.';
                return false;
            } else {
                if (move_uploaded_file($val["tmp_name"], $target_file)) {
                    $save_document = $this->DriverModel->updateDriverDoc($postData['docname'], $file_name, $postData['id']);
                } else {
                    $error_doc[$key] = 'Sorry, there was an error uploading your file.';
                }
            }
        }
        return true;
    }

    public function uploadCabFile($postData)
    {
        $target_dir = BASEPATH . "../pubilc/driver/";
        $error_doc = array();
        $documents = array();
        if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
            $documents['file'] = $_FILES['file'];
        }
        foreach ($documents as $key => $val) {
            $random_string = rand(1000, 9999);
            $cur_datetime = time();
            $unique_name = $random_string . "_" . $cur_datetime;
            $file_name_arr = $val["name"];
            $file_name = $unique_name . '_' . $file_name_arr;
            $target_file = $target_dir . basename($file_name);
            $target_file_arr[] = $target_file;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf") {
                $error_doc[$key] = 'Sorry, only JPG, JPEG, PNG & PDF files are allowed.';
                return false;
            } else {
                if (move_uploaded_file($val["tmp_name"], $target_file)) {
                    $save_document = $this->CabModel->updateCabDoc($postData['docname'], $file_name, $postData['id']);
                } else {
                    $error_doc[$key] = 'Sorry, there was an error uploading your file.';
                }
            }
        }
        return true;
    }

    public function uploadUserFile($postData)
    {
        // $target_dirs = BASEPATH . "../pubilc/driver/";
        // if (!file_exists($target_dirs)) {
        //     mkdir($target_dirs, 0777, true);
        // }
        $target_dir = BASEPATH . "../pubilc/driver/";
        $error_doc = array();
        $documents = array();
        if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
            $documents['file'] = $_FILES['file'];
        }
        foreach ($documents as $key => $val) {
            $random_string = rand(1000, 9999);
            $cur_datetime = time();
            $unique_name = $random_string . "_" . $cur_datetime;
            $file_name_arr = $val["name"];
            $file_name = $unique_name . '_' . $file_name_arr;
            $target_file = $target_dir . basename($file_name);
            $target_file_arr[] = $target_file;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf") {
                $error_doc[$key] = 'Sorry, only JPG, JPEG, PNG & PDF files are allowed.';
                return false;
            } else {
                if (move_uploaded_file($val["tmp_name"], $target_file)) {
                    $save_document = $this->User_Login_Model->updateUserDoc($postData['docname'], $file_name, $postData['id']);
                } else {
                    $error_doc[$key] = 'Sorry, there was an error uploading your file.';
                }
            }
        }
        return true;
    }

    public function driverPersonalDetail()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $data = $this->DriverModel->apiPersonalDetail($_POST);
            $output = array(
                'status' => Success,
                'message' => 'personal detail save successfully',
                'data' => $data,
            );
        }
        echo json_encode($output);
        die;
    }

    public function driverPersonalDetail2()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $data = $this->DriverModel->apiPersonalDetail($_POST);
            // upload document
            $image_encoded_string = isset($postData['profile_pic']) ? $postData['profile_pic'] : '';
            $image_decoded = base64_decode($image_encoded_string);
            //upload profile pic on server
            if (isset($image_decoded) && !empty($image_decoded)) {
                //upload file on server
                foreach ($postData as $key => $row) {
                    if ($key == 'profile_pic') {
                        parent::updateDriverDoc($image_decoded, $image_encoded_string, $postData['id'], $key);
                    }
                }
            }
            $output = array(
                'status' => Success,
                'message' => 'personal detail save successfully',
                'data' => $data,
            );
        }
        echo json_encode($output);
        die;
    }

    // driver otp verify
    public function driverOtpVerify()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $validate = $this->DriverModel->otpVerify($postData);
            if (!empty($validate)) {
                $output = array(
                    'status' => Success,
                    'message' => 'OTP Verified',
                    'data' => $validate,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Sorry!! Wrong OTP',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function driverAddressDetail()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $update = $this->DriverModel->apiAddressDetail($postData);
            if (!empty($update)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Address Updated Successfully',
                    'data' => $update,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something went wrong. Kindly try again later.',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function driverDrivingLicence()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            //lgarg: check unique driving licence number
            $update = $this->DriverModel->apiDrivingLicence($postData);
            if (!empty($update)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Driving Licence Details Updated Successfully',
                    'data' => $update,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something went wrong. Kindly try again later.',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function driverAccidentDetail()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $update = $this->DriverModel->apiAccidentDetail($postData);
            if (!empty($update)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Accident Details Updated Successfully',
                    'data' => $update,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something went wrong. Kindly try again later.',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function driverPoliceVerification()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $update = $this->DriverModel->apiPoliceVerification($postData);
            if (!empty($update)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Police Verification Details updated successfully',
                    'data' => $update,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something went wrong. Kindly try again later.',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }


    //Added by lgarg on 08-08-22
    public function checkOfflinePaymentStatus()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $ride_id = $_POST['ride_id'];
            $ride_data = $this->db->select('payment_collected_from_driver')->where('id', $ride_id)->get('cab_ride')->row_array();
            $output = array(
                'status' => Success,
                'message' => '',
                'data' => $ride_data,
            );
        }
        echo json_encode($output);
        die;
    }

    public function driverUpdateDocument()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            //lgarg: check unique DL number & UID number
            $update = $this->DriverModel->apiUpdateDocument($postData);
            if (!empty($update)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Document detail update successfully',
                    'data' => $update,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function saveCabDetail2()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $postData = $this->input->post();
            $data = $this->CabModel->apiSaveCabDetail($postData);
            if (!empty($data)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Cab detail save successfully',
                    'data' => $data,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function saveCabDetail()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                extract($_POST);
                $postData = $this->input->post();
                $id = isset($cab_id) ? $cab_id : '';
                $checkUniqeRegistrationNumber = $this->CabModel->checkUniqeVehicleNumber($registration_number, $id);
                // $checkUniqeEngineNumber = $this->CabModel->checkUniqeEngineNumber($engine_number, $id);
                // $checkUniqeChassisNumber = $this->CabModel->checkUniqeChassisNumber($chassis_number, $id);
                // $checkUniqeInsuranceNumber = $this->CabModel->checkUniqeInsuranceNumber($insurance_number, $id);
                // $checkUniqeFitnessNumber = $this->CabModel->checkUniqeFitnessNumber($fitness_number, $id);
                // $checkUniqePucNumber = $this->CabModel->checkUniqePucNumber($puc_number, $id);
                if ($checkUniqeRegistrationNumber > 0) {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Registration Number already exist.',
                    'data' => array(),
                );
                }

                // else if ($checkUniqeEngineNumber > 0) {
                //     $output = array(
                //         'status' => Failure,
                //         'message' => 'Engine Number already exist.',
                //         'data' => array(),
                //     );
                // } else if ($checkUniqeChassisNumber > 0) {
                //     $output = array(
                //         'status' => Failure,
                //         'message' => 'Chassis Number already exist.',
                //         'data' => array(),
                //     );
                // } else if ($checkUniqeInsuranceNumber > 0) {
                //     $output = array(
                //         'status' => Failure,
                //         'message' => 'Insurance Number already exist.',
                //         'data' => array(),
                //     );
                // } else if ($checkUniqeFitnessNumber > 0) {
                //     $output = array(
                //         'status' => Failure,
                //         'message' => 'Fitness Number already exist.',
                //         'data' => array(),
                //     );
                // else if ($checkUniqePucNumber > 0) {
                //     $output = array(
                //         'status' => Failure,
                //         'message' => 'Permitted Number already exist.',
                //         'data' => array(),
                //     );
                // }

                else {
                    // print_r($id);die;
                    if (isset($id) && $id != '' && $id != 0) {
                        $data = $this->CabModel->apiUpdateCabDetail($postData);
                    } else {
                        $data = $this->CabModel->apiSaveCabDetail($postData);
                    }
                    // print_r($data);die;
                    if (!empty($data)) {
                        $output = array(
                        'status' => Success,
                        'message' => 'Cab detail save successfully',
                        'data' => $data,
                    );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'something wrong',
                        'data' => array(),
                    );
                    }
                }
            }
        } catch (\Throwable $e) {
            $output = array(
                'status' => Failure,
                'message' => $e->getMessage() . ' on line ' . $e->getLine(),
                'data' => array(),
            );
        }
        echo json_encode($output);
        die;
    }

    public function saveFcmToken()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            extract($_POST);
            $postData = $this->input->post();
            $fcm_token = $postData['fcm_token'];
            $imei_number = $postData['imei_number'];
            $user_id = $postData['user_id'];
            $data = $this->DriverModel->updateFCMDetails($fcm_token, $imei_number, $user_id);

            if ($data) {
                $output = array(
                    'status' => Success,
                    'message' => 'Token saved successfully',
                    'data' => array(),
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function saveUserFcmToken()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            extract($_POST);
            $postData = $this->input->post();
            $fcm_token = $postData['fcm_token'];
            $imei_number = $postData['imei_number'];
            $user_id = $postData['user_id'];
            $data = $this->User_Login_Model->updateFCMDetails($fcm_token, $imei_number, $user_id);
            if ($data) {
                $output = array(
                    'status' => Success,
                    'message' => 'Token saved successfully',
                    'data' => array(),
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }


    public function saveUserPaymentInfo()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            extract($_POST);
            $postData = $this->input->post();
            $user_id = $postData['user_id'];
            $name =    $postData['name'];
            $email =   $postData['email'];
            $ride_id =   $postData['ride_id'];
            $contact = $postData['contact'];
            $description = $postData['description'];
            $payment_amount = $postData['payment_amount'];
            $data = $this->Payment_Gateway->saveUserPaymentInfo($user_id, $name, $email, $contact, $description, $payment_amount, $ride_id);
            if ($data) {
                $output = array(
                    'status' => Success,
                    'message' => 'Payment details saved successfully',
                    'data' => array('payment_id' => $data),
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function PayNow()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            extract($_POST);
            $postData = $this->input->post();
            $data = $this->Payment_Gateway->PayNow($postData);
            if ($data) {
                $output = array(
                    'status' => Success,
                    'message' => 'Payment successfully',
                    'data' => array(),
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    public function sos()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST)) {
                    $data =  $this->RideModel->sos($_POST);
                    if ($data) {
                        $output = array(
                  'status' => 'Success',
                  'message' => 'Send Notification',
                  'data' => array()
                );
                    } else {
                        $output = array(
                  'status' => 'Failure',
                  'message' => 'Failed Send Notification',
                  'data' => array()
                );
                    }
                } else {
                    $output = array(
                  'status' => 'Failure',
                  'message' => 'Data Not Found',
                  'data' => array()
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function DriverWalletAmount()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST['driver_id'])) {
                    $data = array(
                  'wallet_amount' => '100',
                  'compnay_number' => '7979798586'
                  );
                    if ($data) {
                        $output = array(
                  'status' => 'Success',
                  'message' => 'Data Fetched success',
                  'data' => $data
                );
                    } else {
                        $output = array(
                  'status' => 'Failure',
                  'message' => 'Data Not Found',
                  'data' => array()
                );
                    }
                } else {
                    $output = array(
                  'status' => 'Failure',
                  'message' => 'Required driver id',
                  'data' => array()
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getDriverTransaction()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST['driver_id'])) {
                    $data = $this->db->where('user_id', $_POST['driver_id'])->get('wallet_history')->result_array();
                    if ($data) {
                        $output = array(
                  'status' => 'Success',
                  'message' => 'Data Fetched success',
                  'data' => $data
                );
                    } else {
                        $output = array(
                  'status' => 'Failure',
                  'message' => 'Data Not Found',
                  'data' => array()
                );
                    }
                } else {
                    $output = array(
                  'status' => 'Failure',
                  'message' => 'Required driver id',
                  'data' => array()
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getTransactionDetail()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST['tranaction_id'])) {
                    $data = $this->db->where('id', $_POST['tranaction_id'])->get('wallet_history')->row_array();
                    if ($data) {
                        $output = array(
                  'status' => 'Success',
                  'message' => 'Data Fetched success',
                  'data' => $data
                );
                    } else {
                        $output = array(
                  'status' => 'Failure',
                  'message' => 'Data Not Found',
                  'data' => array()
                );
                    }
                } else {
                    $output = array(
                  'status' => 'Failure',
                  'message' => 'Required tranaction id',
                  'data' => array()
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getDriverEarning()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST['driver_id'])) {
                    $data = $this->db->select_sum('payment_amount')->where('driver_id', $_POST['driver_id'])->get('payment_history')->row_array();
                    $data2 = array(
                    'earning' => $data['payment_amount'],
                    'trips' => '15',
                    'points' => '10',
                    // 'online' => '7 min ago',
                    'balance' => '2000'
                    );
                    if ($data) {
                        $output = array(
                  'status' => 'Success',
                  'message' => 'Data Fetched success',
                  'data' => $data2
                );
                    } else {
                        $output = array(
                  'status' => 'Failure',
                  'message' => 'Data Not Found',
                  'data' => array()
                );
                    }
                } else {
                    $output = array(
                  'status' => 'Failure',
                  'message' => 'Required driver id',
                  'data' => array()
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function addPaymentMethod()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                extract($_POST);
                if ($user_id  != '' && $ride_id != '') {
                    $data = array(
                'cab_ride_id' => isset($ride_id) ? $ride_id : '',
                'user_id' => isset($user_id) ? $user_id : '',
                'type_name' => isset($payment_type) ? $payment_type : '',
                'created_at' => date('Y-m-d h:i:s')
              );
                    $this->db->insert('payment_type', $data);
                    $lastID = $this->db->insert_id();
                    $this->db->where('id', $ride_id)->update('cab_ride', array('payment_type_id'=> $lastID, 'payment_type_name' => $payment_type));
                    if ($lastID != '') {
                        $output = array(
                    'status' => Success,
                    'message' => 'Payment method successfully',
                    'data' => array(),
                );
                    }
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'payment method unsuccessfully',
                'data' => array(),
               );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function driverReview()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST)) {
                    extract($_POST);

                    $data = array(
                     'cab_ride_id' => isset($ride_id) ? $ride_id : '',
                     'by_user' => isset($user_id) ? $user_id : '',
                     'to_driver' => isset($driver_id) ? $driver_id : '',
                     'rating' => isset($rating) ? $rating : '',
                     'comment' => isset($comment) ? $comment : '',
                     'created_at' => date('Y-m-d h:i:s')
                  );
                    $this->db->insert('rating_driver', $data);
                    $LastID = $this->db->insert_id();
                    if ($LastID != '') {
                        $output = array(
                        'status' => Success,
                        'message' => 'Thanku For Review',
                        'data' => array(),
                    );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Review not be insert',
                        'data' => array(),
                    );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Invalid Data',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function userReview()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST)) {
                    extract($_POST);
                    $cab = $this->db->select('driver_id')->where('id', $ride_id)->get('cab_ride')->row_array();
                    $data = array(
                     'cab_ride_id' => isset($ride_id) ? $ride_id : '',
                     'to_user' => isset($user_id) ? $user_id : '',
                     'by_driver' => isset($cab['driver_id']) ? $cab['driver_id'] : '',
                     'rating' => isset($rating) ? $rating : '',
                     'comment' => isset($comment) ? $comment : '',
                     'created_at' => date('Y-m-d h:i:s')
                  );
                    $this->db->insert('rating_user', $data);
                    $LastID = $this->db->insert_id();
                    if ($LastID != '') {
                        $output = array(
                        'status' => Success,
                        'message' => 'Thanku For Review',
                        'data' => array(),
                    );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Review not be insert',
                        'data' => array(),
                    );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Invalid Data',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getUserReview()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST)) {
                    extract($_POST);
                    $data = $this->db->query('SELECT ROUND(AVG(rating),1) as review FROM rating_user WHERE to_user ='.$user_id)->result_array();
                    if (!empty($data)) {
                        $output = array(
                        'status' => Success,
                        'message' => 'Get Fetched Data',
                        'data' => $data,
                    );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Invalid Rating User Data',
                        'data' => array(),
                    );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Invalid Data',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getDriverReview()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST)) {
                    extract($_POST);
                    $data = $this->db->query('SELECT ROUND(AVG(rating),1) as review FROM rating_driver WHERE to_driver ='.$driver_id)->result_array();
                    if (!empty($data)) {
                        $output = array(
                        'status' => Success,
                        'message' => 'Get Fetched Data',
                        'data' => $data,
                    );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Invalid Rating Driver Data',
                        'data' => array(),
                    );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Invalid Data',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function checkPaymentMethod()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST)) {
                    extract($_POST);
                    $data  = $this->db->select('type_name as type')->where('cab_ride_id', $ride_id)->get('payment_type')->row_array();
                    if (!empty($data)) {
                        $output = array(
                        'status' => Success,
                        'message' => 'Successfully',
                        'data' => $data,
                    );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Invalid data',
                        'data' => array(),
                    );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Invalid Data',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }


    //Cash Payment
    public function payWithCash()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST)) {
                    extract($_POST);
                    $cab = $this->db->where('id', $ride_id)->get('cab_ride')->row_array();
                    //$txn_id = $ride_id.time().uniqid(mt_rand(),true);  //removed by lgarg
                    $data = array(
                      'cab_ride_id' => isset($ride_id) ? $ride_id : '',
                      'user_id' => isset($user_id) ? $user_id : '',
                      'driver_id' => isset($cab['driver_id']) ? $cab['driver_id'] : '',
                      'payment_amount' => isset($cab['price']) ? $cab['price'] : '',   //price is not correct saving for payment history table
                      'payment_mode' => 'Cash',
                      'txn_id' => '',
                      'txn_date' => date('Y-m-d h:i:s'),
                      'status' => isset($status) ? $status : '',
                      'created_at' => date('Y-m-d h:i:s'),
                      'updated_at'=> date('Y-m-d h:i:s'),
                    );
                    $this->db->insert('payment_history', $data);
                    $LastID = $this->db->insert_id();


                    //Added By Pulkit Mangal (10-08-2022)
                    $dta = $this->db->where(['user_id' => $cab['driver_id'], 'type' => 'Driver'])->get('wallet');
                    if ($dta->num_rows() > 0) {
                        $wallet_amt = $dta->row_array();
                        $new_wallet_amt = $wallet_amt['wallet_amount'] + $cab['final_fare_amt'];
                        $new_due_wallet_amt = $wallet_amt['due_amount'] + ($cab['commission_amt'] + $cab['gst_amt']);

                        $this->db->where(['user_id' => $cab['driver_id'], 'type' => 'Driver'])->update('wallet', ['wallet_amount' => $new_wallet_amt,'due_amt' => $new_due_wallet_amt, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]);

                        $this->db->insert('wallet_history', ['user_id' => $cab['driver_id'], 'wallet_amount' => $new_wallet_amt, 'transaction_type' => 'cr', 'type' => 'Driver', 'created_at' => date('Y-m-d h:i:s')]);
                    } else {
                        $new_due_wallet_amt = $cab['commission_amt'] + $cab['gst_amt'];

                        $this->db->insert('wallet', ['user_id' => $cab['driver_id'], 'type' => 'Driver','wallet_amount' => $cab['final_fare_amt'], 'due_amt' => $new_due_wallet_amt, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]);

                        $this->db->insert('wallet_history', ['user_id' => $cab['driver_id'], 'wallet_amount' => $cab['final_fare_amt'], 'transaction_type' => 'cr', 'type' => 'Driver', 'created_at' => date('Y-m-d h:i:s')]);
                    }

                    if ($LastID != '') {
                        $output = array(
                        'status' => Success,
                        'message' => 'Successfully',
                        'data' => array(),
                    );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Invalid data',
                        'data' => array(),
                    );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Invalid Data',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    //Driver Received Payment By User
    public function driverCollectedPaymentUser()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST)) {
                    extract($_POST);
                    $data = array(
                      'status' => isset($status) ? $status : '',
                      'updated_at' => date('Y-m-d h:i:s')
                    );
                    $this->db->where('cab_ride_id', $ride_id)->update('payment_history', $data);
                    if ($ride_id != '') {
                        $output = array(
                        'status' => Success,
                        'message' => 'Driver collected payment by user',
                        'data' => array(),
                    );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Invalid data',
                        'data' => array(),
                    );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Invalid Data',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getReviewComment()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $data = array(
                array('id'=>1 , 'title' => 'Terrible'),
                array('id'=>2 , 'title' => 'Bad'),
                array('id'=>3 , 'title' => 'Good'),
                array('id'=>4 , 'title' => 'Very Good'),
                array('id'=>4 , 'title' => 'Amazing'),
                );
            if (!empty($data)) {
                $output = array(
                    'status' => Success,
                    'message' => 'Data fetch successfully',
                    'data' => $data,
                );
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }

    # Delete Account User
    public function accountDelete()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (!empty($_POST)) {
                    extract($_POST);
                    if ($user_id != '' && $user_id != 0) {

                        #Get Data User
                        $data = $this->db->where('user_id', $user_id)->get('users')->row_array();

                        # Save Records Delete User
                        $this->db->insert('account_delete', ['user_id' => $user_id, 'title' => $title, 'reason' => $reason, 'type' => 'USER', 'data_user' => json_encode($data)]);

                        # Save Records Delete User
                        $this->db->where('user_id', $user_id)->delete('users');

                        $output = array(
                    'status' => Success,
                    'message' => 'Successfully Account Delete User',
                    'data' => array(),
                );
                    } else {
                        $output = array(
                    'status' => Failure,
                    'message' => 'Invalid User ID',
                    'data' => array(),
                );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Invalid Data',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function usersSourceLoactionForLiveTracking()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'GET') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (isset($_GET)) {
                    extract($_GET);
                    $query = $this->db->query("SELECT latitude as userLat, longitude as userLong FROM `user_current_locations` WHERE user_id = ".$user_id." AND user_type = 'User'");
                    if ($query->num_rows() > 0) {
                        $output = array(
                        'status' => Success,
                        'message' => 'Get Fetched User Location',
                        'data' => $query->result_array(),
                    );
                    } else {
                        $output = array(
                    'status' => Failure,
                    'message' => 'Data Not Found',
                    'data' => array(),
                );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Invalid Data',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function resendOTP()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (isset($_POST)) {
                    extract($_POST);
                    if ($mobile != '') {
                        $otp = rand(1000, 9999);
                        $this->db->where('mobile', $mobile)->update('driver', array('otp' => $otp));
                        $message = "Your One Time Password for Login in Aapni Taxi app is ".$otp." <Dhatush Tech>.";
                        parent::_sendOtp($message, $mobile);
                        $output = array(
                        'status' => Success,
                        'message' => 'OTP Resend Successfully',
                        'data' => array(),
                    );
                    } else {
                        $output = array(
                    'status' => Failure,
                    'message' => 'OTP Resend Unsuccessfully',
                    'data' => array(),
                );
                    }
                } else {
                    $output = array(
                    'status' => Failure,
                    'message' => 'Invalid Data',
                    'data' => array(),
                );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function bankTypeDetails()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'GET') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                $dta = $this->db->select('id, bank_name')->get('bank_master')->result_array();
                if (!empty($dta)) {
                    $output = array(
                'status' => Success,
                'message' => 'Get Fetched Data',
                'data' => $dta,
            );
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'Invalid Data',
                'data' => array(),
            );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function saveBankDriverDetails()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (isset($_POST)) {
                    extract($_POST);
                    $this->db->insert('bank_details', ['bank_account_no' => $bank_account_no, 'ifsc_code' => $ifsc_code, 'bank_holder_name' => $bank_holder_name, 'driver_id' => $driver_id, 'bank_type_id' => $bank_type_id, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]);
                    $last_id = $this->db->insert_id();
                    if ($last_id != '') {
                        $output = array(
                    'status' => Success,
                    'message' => 'Save Bank Driver Details Successfully',
                    'data' => array(),
                );
                    } else {
                        $output = array(
                    'status' => Failure,
                    'message' => 'Save Bank Driver Details Unsuccessfully',
                    'data' => $dta,
                );
                    }
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'Invalid Data',
                'data' => array(),
            );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getBankDriverDetails()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'GET') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (isset($_GET)) {
                    extract($_GET);
                    $data = $this->db->query('SELECT bank_master.bank_name,bank_details.* FROM `bank_details` INNER JOIN bank_master on bank_details.bank_type_id = bank_master.id WHERE bank_details.driver_id ='.$driver_id)->row_array();
                    if (!empty($data)) {
                        $output = array(
                    'status' => Success,
                    'message' => 'Get Fetched Bank Driver Details Successfully',
                    'data' => $data,
                );
                    } else {
                        $output = array(
                    'status' => Failure,
                    'message' => 'Get Fetched Bank Driver Details Unsuccessfully',
                    'data' => $dta,
                );
                    }
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'Invalid Data',
                'data' => array(),
            );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function rideVerify()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (isset($_POST)) {
                    $data = $this->RideModel->rideVerify($_POST);
                    if ($data) {
                        $output = array(
                    'status' => Success,
                    'message' => "Let's earn for you",
                    'data' => array(),
                );
                    } else {
                        $output = array(
                    'status' => Failure,
                    'message' => 'Otp does not match',
                    'data' => array(),
                );
                    }
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'Invalid Data',
                'data' => array(),
            );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function uploadInvoice()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (isset($_POST)) {
                    $image  = $_POST['image'];
                    define('UPLOAD_DIR', 'pubilc/invoice/');
                    $image_arr = array();
                    $image_parts = explode(";base64,", $image);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $imgname =  uniqid() . '.'.$image_type;
                    $file = UPLOAD_DIR.$imgname;
                    $image_arr = $file;
                    file_put_contents($file, $image_base64);

                    $save_document = $this->RideModel->uploadInvoice($_POST, $imgname);
                    if ($save_document) {
                        $output = array(
                'status' => Success,
                'message' => 'Upload invoice in successfully',
                'data' => array(),
            );
                    } else {
                        $output = array(
                'status' => Failure,
                'message' => 'Sorry, there was an error uploading your file.',
                'data' => array(),
            );
                    }
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'Invalid Data',
                'data' => array(),
            );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getInvoiceImage()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'GET') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (isset($_GET)) {
                    $data = $this->RideModel->getInvoiceImage($_GET);
                    if (!empty($data)) {
                        $output = array(
                    'status' => Success,
                    'message' => 'Get fetched invoice image',
                    'data' => $data,
                );
                    } else {
                        $output = array(
                    'status' => Failure,
                    'message' => 'Something error',
                    'data' => array(),
                );
                    }
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'Invalid Data',
                'data' => array(),
            );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    public function getRideHistory()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'GET') {
                $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
            } else {
                if (isset($_GET)) {
                    $data =  $this->RideModel->getRideHistory($_GET);
                    if (!empty($data)) {
                        $output = array(
                    'status' => Success,
                    'message' => 'Get fetched ride history',
                    'data' => $data,
                );
                    } else {
                        $output = array(
                    'status' => Failure,
                    'message' => 'Data not found',
                    'data' => array(),
                );
                    }
                } else {
                    $output = array(
                'status' => Failure,
                'message' => 'Invalid Data',
                'data' => array(),
            );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
            'status' => Failure,
            'message' => $e->getMessage() . ' on line ' . $e->getLine(),
            'data' => array(),
        );
        }
        echo json_encode($output);
        die;
    }

    //Push Notification User
    //After assign of the cab driver, user should get notified for the booking.
    public function pushNotification()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                    'status' => 'Failure',
                    'message' => 'Bad request',
                    'data' => array(),
                );
            } else {
                $fcm_token = isset($_POST['fcm_token']) ? $_POST['fcm_token'] : '';
                $message = isset($_POST['message']) ? $_POST['message'] : '';
                // if(strpos($_POST['message'],"m")){

                // }
                if (!empty($fcm_token)) {

                    //API URL of FCM
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    if ($_POST['type'] === 'User') {
                        /*api_key available in:
                        Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
                        $api_key = 'AAAA9p2td6E:APA91bFWuAgTxsyDzz4BhmMekFowRpvr-6lB_YByxIYs-D7rNhOvhlmGIjNdfwQn-nrmYu8NIqsQboioowJOchHNqm0WfKP79OKnY0JuimBygK57H88jzDqnmIzj1JRJdlqK82dPIgxl';
                    } else {
                        $api_key = 'AAAAnEs5SoI:APA91bEqHaBvfhJxjogSvxSBioTtchyQKNsl_e-GjSt-xusYiSI9G-DjYEtXC_2OtSA5TSDhB4xAOfBhXXdTrdYMpQPsadnmaQVfjJfXW6DX6WkXF_3lT2ewjuSv3QnkFJFP10A0Wb0z';
                    }
                    $fields = array(
                        'registration_ids' => array(
                            $fcm_token
                        ),
                        'notification' => array(
                            "body" => $message
                        )
                    );

                    //header includes Content type and api key
                    $headers = array(
                        'Content-Type:application/json',
                        'Authorization:key='.$api_key
                    );

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    $result = curl_exec($ch);
                    $dta = json_decode($result, true);

                    $output = array(
                        'status' => 'Success',
                        'message' => 'Success notification',
                        'data' => $dta,
                    );

                    if ($result === false) {
                        die('FCM Send Error: ' . curl_error($ch));
                    }
                    curl_close($ch);
                } else {
                    $output = array(
                        'status' => 'Failure',
                        'message' => 'Invalid Data',
                        'data' => array(),
                    );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
                'status' => Failure,
                'message' => $e->getMessage() . ' on line ' . $e->getLine(),
                'data' => array(),
            );
        }
        echo json_encode($output);
        die;
    }


    public function pushNotificationWithCustomSound()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                    'status' => 'Failure',
                    'message' => 'Bad request',
                    'data' => array(),
                );
            } else {
                $fcm_token = isset($_POST['fcm_token']) ? $_POST['fcm_token'] : '';
                $message = isset($_POST['message']) ? $_POST['message'] : '';
                // if(strpos($_POST['message'],"m")){

                // }
                if (!empty($fcm_token)) {

                    //API URL of FCM
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    if ($_POST['type'] === 'User') {
                        /*api_key available in:
                        Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
                        $api_key = 'AAAA9p2td6E:APA91bFWuAgTxsyDzz4BhmMekFowRpvr-6lB_YByxIYs-D7rNhOvhlmGIjNdfwQn-nrmYu8NIqsQboioowJOchHNqm0WfKP79OKnY0JuimBygK57H88jzDqnmIzj1JRJdlqK82dPIgxl';
                    } else {
                        $api_key = 'AAAAnEs5SoI:APA91bEqHaBvfhJxjogSvxSBioTtchyQKNsl_e-GjSt-xusYiSI9G-DjYEtXC_2OtSA5TSDhB4xAOfBhXXdTrdYMpQPsadnmaQVfjJfXW6DX6WkXF_3lT2ewjuSv3QnkFJFP10A0Wb0z';
                    }
                    $fields = array(
                        'registration_ids' => array(
                            $fcm_token
                        ),
                        'notification' => array(
                            "body" => $message,
                            "title" => $_POST['title'],
                            "sound" => "my_sound.wav",
                            "android_channel_id" => "aapnitaxidriver"
                        )
                    );

                    //header includes Content type and api key
                    $headers = array(
                        'Content-Type:application/json',
                        'Authorization:key='.$api_key
                    );

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    $result = curl_exec($ch);
                    $dta = json_decode($result, true);

                    $output = array(
                        'status' => 'Success',
                        'message' => 'Success notification',
                        'data' => $dta,
                    );

                    if ($result === false) {
                        die('FCM Send Error: ' . curl_error($ch));
                    }
                    curl_close($ch);
                } else {
                    $output = array(
                        'status' => 'Failure',
                        'message' => 'Invalid Data',
                        'data' => array(),
                    );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
                'status' => Failure,
                'message' => $e->getMessage() . ' on line ' . $e->getLine(),
                'data' => array(),
            );
        }
        echo json_encode($output);
        die;
    }





    # Created Forget Password API
    public function forgetPasswordDriver()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                    'status' => 'Failure',
                    'message' => 'Bad request',
                    'data' => array(),
                );
            } else {
                extract($_POST);

                $checkMobile = $this->DriverModel->checkUniqueMobile($mobile);

                if ($checkMobile > 0) {
                    $otp = rand(1000, 9999);
                    $message = "Your One Time Password for Login in Aapni Taxi app is ".$otp." <Dhatush Tech>.";
                    $this->db->where('mobile', $mobile)->update('driver', array('otp' => $otp));
                    parent::_sendOtp($message, $mobile);
                    $output = array(
                        'status' => Success,
                        'message' => 'Otp sent for changing password',
                        'data' => array(),
                    );
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'Mobile number does not exists',
                        'data' => array(),
                    );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
                'status' => Failure,
                'message' => $e->getMessage() . ' on line ' . $e->getLine(),
                'data' => array(),
            );
        }
        echo json_encode($output);
        die;
    }

    #Change Password Driver
    public function changePasswordDriver()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'POST') {
                $output = array(
                    'status' => 'Failure',
                    'message' => 'Bad request',
                    'data' => array(),
                );
            } else {
                extract($_POST);
                if (!empty($mobile) && !empty($password)) {
                    $this->db->where('mobile', $mobile)->update('driver', array('password' => md5($password), 'password_show' => $password));
                    $output = array(
                        'status' => Success,
                        'message' => 'Your password has been changed',
                        'data' => array(),
                    );
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'Invalid Data',
                        'data' => array(),
                    );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
                'status' => Failure,
                'message' => $e->getMessage() . ' on line ' . $e->getLine(),
                'data' => array(),
            );
        }
        echo json_encode($output);
        die;
    }


    public function driverRideHistory()
    {
        try {
            $method = $this->input->server('REQUEST_METHOD');
            if ($method != 'GET') {
                $output = array(
                    'status' => 'Failure',
                    'message' => 'Bad request',
                    'data' => array(),
                );
            } else {
                extract($_GET);
                if (!empty($driver_id)) {
                    $data = $this->RideModel->getDriverRideHistory($_GET);
                    if (!empty($data)) {
                        $output = array(
                        'status' => Success,
                        'message' => 'Get fetched driver ride history',
                        'data' => $data,
                    );
                    } else {
                        $output = array(
                        'status' => Failure,
                        'message' => 'Invalid data',
                        'data' => array(),
                    );
                    }
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'Invalid driver id',
                        'data' => array(),
                    );
                }
            }
        } catch (\Throwable $e) {
            $output = array(
                'status' => Failure,
                'message' => $e->getMessage() . ' on line ' . $e->getLine(),
                'data' => array(),
            );
        }
        echo json_encode($output);
        die;
    }





    // ########################################################################################################################


    //NEW APIs From 22-Aug-2022

    /*
    * get FCM token On the basis of driver_id & user_id
    */
    public function getFcmToken()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                'status' => Failure,
                'message' => 'Bad request.',
                'data' => array(),
            );
        } else {
            $data = array();
            if($_GET['type'] == 'Driver'){
                $data = $this->db->where('id',$_GET['id'])->get('driver')->row_array();
            } else if($_GET['type'] == 'User'){
                $data = $this->db->where('user_id',$_GET['id'])->get('users')->row_array();
            }
            $fcm_token = '';
            if(!empty($data)){
                $fcm_token = $data['fcm_token'];
                if($fcm_token != ''){
                    $output = array(
                        'status' => Success,
                        'message' => 'FCM Token',
                        'data' => $fcm_token,
                    );
                } else {
                    $output = array(
                        'status' => Failure,
                        'message' => 'Something wrong',
                        'data' => array(),
                    );
                }
            } else {
                $output = array(
                    'status' => Failure,
                    'message' => 'Something wrong',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }









}

