<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class MY_Controller extends CI_Controller {



  function __construct() {
    parent::__construct();

    date_default_timezone_set('Asia/Calcutta'); 

  }

  

  public function _saveActivity($username,$inserted_user_id,$comment,$url,$package_name,$package_id){
    
    date_default_timezone_set('Asia/Calcutta'); 
    $date = date("Y-m-d H:i:s");
    
    $this->db->insert('activity', array('username'=>$username,'user_id'=>$inserted_user_id,'comment' =>$comment,'url'=>$url,'package_name' => $package_name,'package_id' =>$package_id,'added_date'=>$date));
    
  }
  
  public function _saveNotification($inserted_user_id,$p_uid,$text){
    
    $date = date("Y-m-d H:i:s");
    
    $this->db->insert('notification', array(
      'from_user_id'=>$inserted_user_id,
      'to_user_id'=>$p_uid,
      'text'=>$text,
      'added_date'=>$date,
    ));
    
  }
  
  public function _sendOtp($message,$mobileNo)
  {
            $message = urlencode($message);
            $route = "4";
            $curl = curl_init();
            
              curl_setopt_array($curl, array(
              //CURLOPT_URL => "http://dlt.fastsmsindia.com/messages/sendSmsApi?username=aapnitaxi&password=123456&drout=3&senderid=DHTUSH&intity_id=1701164509221584965&template_id=1707164786342114229&numbers=".$mobileNo."&language=en&message=.$message.",
              
              CURLOPT_URL => "https://smsxpert.in/api/pushsms?user=aapnitaxi&authkey=92r9pfyZKpiM&sender=DHTUSH&mobile=".$mobileNo."&text=".$message."&entityid=1701164509221584965&templateid=1707164786342114229",
              
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
            ));
            
            
             $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            // echo $response;die;
            if ($response == 'Invalid mobile number.') {
              return 'Invalid';
            }else{
            return true;
        }
    }

  public function _sendOtp2($message,$mobileNo)
  {

    //Your authentication key
    $authKey = "37511AGq1htrdyWW6218bc17P30";
//Multiple mobiles numbers separated by comma
    $mobileNumber = $mobileNo;
//Sender ID,While using route4 sender id should be 6 characters long.
    $senderId = "DHTUSH";
//Your message to send, Add URL encoding here.
    $message = urlencode($message);
//Define route 
    $route = "default";
//Prepare you post parameters
    $postData = array(
      'authkey' => $authKey,
      'mobiles' => $mobileNumber,
      'message' => $message,
      'sender' => $senderId,
      'route' => $route
    );
//API URL
    $url="http://sms.premad.in/api/sendhttp.php";
// init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $postData
    //,CURLOPT_FOLLOWLOCATION => true
    ));
//Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//get response
    $output = curl_exec($ch);
//Print error if any
    if(curl_errno($ch))
    {
      echo 'error:' . curl_error($ch);
    }
    curl_close($ch);
    // echo $output;

  }


//     public function _sendMail($from,$to,$subject,$body){
//         $this->load->library('email');
//         $config = array();
//         $config['protocol'] = 'smtp';
//         $config['smtp_host'] = 'mail.mydreamindia.org';
//         $config['smtp_user'] = 'info@mydreamindia.org';
//         $config['smtp_pass'] = '123456';
  
//         $config['smtp_port'] = 587;
  
//         $this->email->initialize($config);
  
//         $this->email->set_mailtype("html");


//         $this->email->from("info@mydreamindia.org");
//         $this->email->to($to);
//         $this->email->subject($subject);    
//         $this->email->message($body);
//         //$send = $this->email->send();
//         //return $send;
  
//          if($this->email->send()){
//             //this is to check if email is sent
// return true;
//         }else{
//             //else error
//             show_error($this->email->print_debugger());
//         }
//     }


//   public function _sendMail($from,$to,$subject,$body){
//     // $this->load->library('email');
//     // $config = array();
//     // $config['protocol'] = 'smtp';
//     // $config['smtp_host'] = 'mail.aapnitaxi.com';
//     // $config['smtp_user'] = 'info@aapnitaxi.com';
//     // $config['smtp_pass'] = '12345678';
//     // $config['smtp_port'] = 587;
    
//     // $this->email->initialize($config);
//     // $this->email->set_mailtype("html");
//     // $this->email->from("pulkitmangal4@gmail.com");
//     // $this->email->to($to);
//     // $this->email->subject($subject);    
//     // $this->email->message($body);
//     // if($this->email->send()){
//     //   return true;
//     // }else{
//     //   show_error($this->email->print_debugger());
//     // }
//   }
  
    /**
     * Lokesh Garg
     * 20-May-2021
     * Function to upload file on server
     * @Request Params:
     * 
     * */
    public function updateProfilePic($image_decoded,$image_encoded_string,$user_id){
      $this->load->model('User_Login_Model');
      $target_dir =  BASEPATH."../pubilc/user/user_profile/";
      $image_info = getimagesize($image_encoded_string);
      $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");
      $random_string = rand(1000,9999);
      $file_name = $random_string.'_'.time().'.'.$extension;
      $target_file = $target_dir . basename($file_name);
      if (file_put_contents($target_file,$image_decoded)) {
        $update_profile_pic = $this->User_Login_Model->updateProfilePic($file_name,$user_id);
      }
    }
    
    public function updateDriverDoc($image_decoded,$image_encoded_string,$user_id,$key){
        // echo $image_decoded.'<br>';die;
        // echo $image_encoded_string.'<br>';
        // echo $user_id.'<br>';
        // echo $key.'<br>';die;
      
        // $base64 = "data:image/png;base64,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";

//  $image_info = getimagesize($image_encoded_string);//die;

//  $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");
// // echo 'ddd';
// echo $extension;die;
        // $encoded_string = "....";
// $imgdata = base64_decode($image_encoded_string);

// $f = finfo_open();

// echo $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);die;


      
    //     $buffer = file_get_contents($image_encoded_string);
    // $finfo = new finfo(FILEINFO_MIME_TYPE);
    // echo $finfo->buffer($buffer);die;

      $this->load->model('DriverModel');
      
      $target_dir =  BASEPATH."../pubilc/driver/";
        $image_info = getimagesize($image_encoded_string);//die;
        $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");//die;
        $random_string = rand(1000,9999);
        $file_name = $random_string.'_'.time().'.'.$extension;
        $target_file = $target_dir . basename($file_name);
        
        if (file_put_contents($target_file,$image_decoded)) {
          $update_profile_pic = $this->DriverModel->updateDriverDoc($file_name,$user_id,$key);
        }
        
      }
    }