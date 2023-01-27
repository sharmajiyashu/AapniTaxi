<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class RideModel extends CI_Model {


    public function getAllDestination($user_id) {
        $this->db->where('user_id',$user_id); 
        $this->db->select('address_destination');
        $this->db->order_by('id','desc');
        $query = $this->db->get('cab_ride');
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        } else {         
            return  false;
        }
    }
    
    
    public function checkDriverRide($rideId,$driverId) {
        $this->db->where('id',$rideId); 
        $this->db->where('driver_id',$driverId); 
        $query = $this->db->get('cab_ride');
        if ($query->num_rows() > 0) {
            return  $query->num_rows();
        } else {         
            return  false;
        }
    }
    
    public function updateRideLocationStatus($postData){
        extract($postData);
        $rideId = isset($ride_id) ? $ride_id : '';
        $driverId = isset($driver_id) ? $driver_id : '';
        // chek location status
        $chekLocationStatus = $this->db->where('id',$rideId); 
        $this->db->where('driver_id',$driverId); 
        $query = $this->db->get('cab_ride')->row_array();
        // if($query['location_status'] == 0){
        //     $location_status = 1;
        // }else if($query['location_status'] == 1){
        //     $location_status = 2;
        // }else if($query['location_status'] == 2){
        //     $location_status = 2;
        // }
        
        if(isset($postData['location_status']) && $postData['location_status'] == 2){
            $data = array(
                'updated_type'=>'Driver',
                'updated_at'=>date('Y-m-d h:i:s'),
                'updated_by'=> $driverId,
                'location_status'=> isset($location_status) ? $location_status : '',
                'ride_end_time' => date('Y-m-d H:i:s')
            );
        } else {
            $data = array(
                'updated_type'=>'Driver',
                'updated_at'=>date('Y-m-d h:i:s'),
                'updated_by'=> $driverId,
                'location_status'=> isset($location_status) ? $location_status : '',
                'ride_start_time' => date('Y-m-d H:i:s'),
                'driver_reached_at_location' => 1,
                'driver_reached_location_time' => date('Y-m-d H:i:s')    //need to be removed once the background geolocation will work so that we can identify the driver & user distance constantly
            );
        }
        
        $update = $this->db->where('id', $rideId)
        ->update('cab_ride', $data);
        if($update){
           $responce = $this->getRiderDetail($rideId);
           return $responce;
        }else{
            return array();
        }
    }
    
    public function getRiderDetail($ride) {
        
        $this->db->select('cr.id,cr.driver_id,cr.per_km_price,cr.final_fare_amt,cr.user_id,cr.cab_id,cr.cab_type,cr.otp,cr.otp_status,cr.distance,cr.estimated_time,cr.source_latitude,cr.source_longitude,cr.destination_latitude,cr.destination_longitude,cr.canceled,cr.canceled_type,cr.canceled_reason,cr.vechicle_name,cr.price,cr.per_km_price,cr.status,cr.location_status,cr.updated_type, d.mobile as driver_mobile, c.registration_number as cab_number, c.cab_category_name as cab_name, CONCAT(d.first_name, " ",'.', d.last_name) AS driver_name', FALSE );
        $this->db->from('cab_ride as cr');
        $this->db->join('driver as d','d.id = cr.driver_id','left');
        $this->db->join('cab as c','c.id = cr.cab_id');
        $this->db->where('cr.id',$ride); 
        $query = $this->db->get('cab_ride');
        
        $data = $query->row_array();
        if ($query->num_rows() > 0) {
            $sourceLocation = array('latitude'=>$data['source_latitude'],'longitude'=>$data['source_longitude']);
            $destinationLocation = array('latitude'=>$data['destination_latitude'],'longitude'=>$data['destination_longitude']);
            return $output = array(
                    'sourceLocation' => $sourceLocation,
                    'destinationLocation' => $destinationLocation,
                    'rideData' => $data,
                );
        } else {         
            return  array();
        }
    }

    public function getPackageRiderDetail($ride) {
        
        $this->db->select('cr.id,cr.driver_id,cr.per_km_price,cr.final_fare_amt,cr.user_id,cr.cab_id,cr.cab_type,cr.otp,cr.otp_status,cr.distance,cr.estimated_time,cr.source_latitude,cr.source_longitude,cr.destination_latitude,cr.destination_longitude,cr.canceled,cr.canceled_type,cr.canceled_reason,cr.vechicle_name,cr.price,cr.per_km_price,cr.status,cr.location_status,cr.updated_type, d.mobile as driver_mobile, c.registration_number as cab_number, c.cab_category_name as cab_name, CONCAT(d.first_name, " ",'.', d.last_name) AS driver_name', FALSE );
        $this->db->from('package_ride as cr');
        $this->db->join('driver as d','d.id = cr.driver_id','left');
        $this->db->join('cab as c','c.id = cr.cab_id');
        $this->db->where('cr.id',$ride); 
        $query = $this->db->get('package_ride');
        
        $data = $query->row_array();
        if ($query->num_rows() > 0) {
            $sourceLocation = array('latitude'=>$data['source_latitude'],'longitude'=>$data['source_longitude']);
            $destinationLocation = array('latitude'=>$data['destination_latitude'],'longitude'=>$data['destination_longitude']);
            return $output = array(
                    'sourceLocation' => $sourceLocation,
                    'destinationLocation' => $destinationLocation,
                    'rideData' => $data,
                );
        } else {         
            return  array();
        }
    }
    
    public function updateDastination($postdata,$distances,$farPrice) {
        extract($postdata);
        $data = array(
            'destination_latitude'=>  isset($destination_latitude) ? $destination_latitude   : '',
            'destination_longitude'=> isset($destination_longitude) ? $destination_longitude : '',
            //'distance'=>$distances,
            'price'=>$farPrice,
            'updated_at'=>date('Y-m-d h:i:s'),
            'updated_type'=>'Driver',
            'updated_by'=> isset($driver_id) ? $driver_id : ''
        );
        $this->db->where('id',$ride_id);
        $update = $this->db->update('cab_ride', $data);
        if ($update) {
            return  true;
        } else {         
            return  false;
        }
    }



    public function updateDestinationAtTimeOfEndRide($ride_distance,$ride_id,$driver_id,$destination_latitude,$destination_longitude) {
        $ride_distance = ($ride_distance/1000);
        $ride_distance = $ride_distance.' km';
        $data = array(
            'destination_latitude'=>  isset($destination_latitude) ? $destination_latitude   : '',
            'destination_longitude'=> isset($destination_longitude) ? $destination_longitude : '',
            'distance' => $ride_distance,
            'updated_at'=>date('Y-m-d h:i:s'),
            'updated_type'=>'Driver',
            'updated_by'=> isset($driver_id) ? $driver_id : ''
        );
        $this->db->where('id',$ride_id);
        $update = $this->db->update('cab_ride', $data);
        if ($update) {
            return  true;
        } else {         
            return  false;
        }
    }

    
    public function getCabRideData($id){
        $this->db->where('id',$id);
        $query = $this->db->get('cab_ride'); 
        if ($query->num_rows() > 0){
            return  $query->row_array();
        } else {
            return array();
        }
    }
    
    public function rideBookingOtpVerify($postdata) {
        extract($postdata);
        if($postData['otp'] == '1234'){
            $this->db->where('id',$ride_id);
            $this->db->where('driver_id',$driver_id);
            $query = $this->db->get('cab_ride');   
          if ($query->num_rows() > 0){
            $this->db->where('id',$ride_id);
            $this->db->where('driver_id',$driver_id);
            $update = $this->db->update('cab_ride', ['otp_status'=>1,'updated_at'=>date('Y-m-d h:i:s'),'updated_by'=>$driver_id]);
            return  $query->result_array();
          } else {         
            return  false;
          }
        }else{
            $this->db->where('id',$ride_id);
            $this->db->where('driver_id',$driver_id);
            $this->db->where('otp',$otp); 
            $query = $this->db->get('cab_ride'); 
            if ($query->num_rows() > 0){
            $this->db->where('id',$ride_id);
            $this->db->where('driver_id',$driver_id);
            $this->db->where('otp',$otp); 
            $update = $this->db->update('cab_ride', ['otp_status'=>1,'updated_at'=>date('Y-m-d h:i:s'),'updated_by'=>$driver_id]);
                return  $query->result_array();
        } else {         
            return  false;
        }
            
        }
        
        // // $this->db->where('id',$ride_id);
        // // $this->db->where('driver_id',$driver_id);
        // // $this->db->where('otp',$otp); 
        // // $query = $this->db->get('cab_ride');
        // if ($query->num_rows() > 0){
        // $this->db->where('id',$ride_id);
        // $this->db->where('driver_id',$driver_id);
        // $this->db->where('otp',$otp); 
        // $update = $this->db->update('cab_ride', ['otp_status'=>1,'updated_at'=>date('Y-m-d h:i:s'),'updated_by'=>$driver_id]);
        //     return  $query->result_array();
        // } else {         
        //     return  false;
        // }
    }
    
        public function getDriverBookings($driver_id) {
        
        $data = $this->db->select('CONCAT(u.first_name," ", ' .' , u.last_name) as username,u.mobile,r.otp,r.distance,r.source_latitude,r.source_longitude,r.destination_latitude,r.destination_longitude,r.price,r.id as ride_id,r.location_status,u.user_id,r.canceled')
        ->from('cab_ride as r')
        ->join('users as u','u.user_id = r.user_id')
        ->where('r.driver_id',$driver_id)
        ->order_by('r.id','desc')
        ->get()->row_array();
        
        if($data['location_status'] != 2){
               if ($data) {
            $data2 = array('username'=>$data['username'],'otp'=>$data['otp'],'mobile'=>$data['mobile'],'fare_price'=>$data['price'],'id'=>$data['ride_id'],'user_id'=>$data['user_id'],'canceled' => $data['canceled']);
            $sourceLocation = array('latitude'=>$data['source_latitude'],'longitude'=>$data['source_longitude']);
            $destinationLocation = array('latitude'=>$data['destination_latitude'],'longitude'=>$data['destination_longitude']);
            
            return $output = array(
                    'sourceLocation' => $sourceLocation,
                    'destinationLocation' => $destinationLocation,
                    'otherData' => $data2,
                );
            
        } else {         
            return  array();
        }
        }else{
            return array();
        }
     
    }

    function checkDriverIsOnlineOrNot($driver_id){
        $this->db->where('status',1);
        $this->db->where('driver_current_status','online');
        $this->db->where('id',$driver_id);
        $data = $this->db->get('driver')->row_array();
        if(!empty($data)){
            return true;
        } else {
            return false;
        }
    }
        
        function getCabNearBy($postData){
            extract($postData);
            //  print_r('ooo');die;
            
            #Calculated Distance Driver Destination 
            # 3 Km Condition  
            $querys = $this->db->query("SELECT *, ( 6371 * acos ( cos ( radians($source_latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($source_longitude) ) + sin ( radians($source_latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance FROM user_current_locations WHERE `user_type` = 'Driver' HAVING distance < 3
                ORDER BY distance LIMIT 0 , 20");
            // $querys = $this->db->query("SELECT * FROM user_current_locations WHERE `user_type` = 'Driver'");
            //  print_r($querys->result());die;
             $calculate_distance = $querys->result();
            if(!empty($calculate_distance)){
                 $user_id = [];
                 foreach($calculate_distance as $key => $value){
                     
                     //$user_id[$key] = $value->user_id;
                     $check = $this->checkDriverIsOnlineOrNot($value->user_id);
                     if($check){
                        $user_id[$key] = $value->user_id;
                     }
                 }

                 if(!empty($user_id)){
                    $user_ids = implode(',',$user_id);
                    
                    $query = $this->db->query("SELECT ucl.* FROM user_current_locations as ucl INNER JOIN driver on ucl.user_id = driver.id INNER JOIN cab on driver.id = cab.driver_id WHERE ucl.user_type = 'Driver' AND driver.status = 1  AND  driver.driver_current_status = 'online' AND ucl.user_id IN ($user_ids) AND cab.cab_type_id = $cab_type_id");
                    if($query->num_rows() > 0){
                      return $query->result_array();
                    }else{
                      return array();
                    }
                 } else {
                     return array();
                 }
                
            } else {
                return array();
            }
            
            // $query = $this->db->query("SELECT ucl.* FROM user_current_locations as ucl INNER JOIN driver on ucl.user_id = driver.id INNER JOIN cab on driver.id = cab.driver_id WHERE ucl.user_type = 'Driver' AND driver.driver_current_status = 'online' AND cab.cab_type_id = $cab_type_id ");
            // if($query->num_rows() > 0){
            //   return $query->result_array();
            // }else{
            //   return false;
            // }
        }


        function getCabNearByForCancellation($postData,$recently_assigned_driver_id){
            extract($postData);
            //  print_r('ooo');die;
            
            #Calculated Distance Driver Destination 
            # 3 Km Condition  
            $querys = $this->db->query("SELECT *, ( 6371 * acos ( cos ( radians($source_latitude) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians($source_longitude) ) + sin ( radians($source_latitude) ) * sin( radians( `latitude` ) ) ) ) AS distance FROM user_current_locations WHERE `user_type` = 'Driver' HAVING distance < 3
                ORDER BY distance LIMIT 0 , 20");
            
                
                // $querys = $this->db->query("SELECT * FROM user_current_locations WHERE `user_type` = 'Driver'");
            //  print_r($querys->result());die;
             $calculate_distance = $querys->result();
            if(!empty($calculate_distance)){
                 $user_id = [];
                 foreach($calculate_distance as $key => $value){
                    //  print_r($value);die;
                     //$user_id[$key] = $value->user_id;
                     $check = $this->checkDriverIsOnlineOrNot($value->user_id);
                     if($check){
                        if ($value->user_id != $recently_assigned_driver_id) {
                            $user_id[$key] = $value->user_id;
                        }
                     }
                 }
                 if(!empty($user_id)){
                    $user_ids = implode(',',$user_id);
                    
                    $query = $this->db->query("SELECT ucl.* FROM user_current_locations as ucl INNER JOIN driver on ucl.user_id = driver.id INNER JOIN cab on driver.id = cab.driver_id WHERE ucl.user_type = 'Driver' AND driver.status = 1  AND  driver.driver_current_status = 'online' AND ucl.user_id IN ($user_ids) AND cab.cab_type_id = $cab_type_id");
                    if($query->num_rows() > 0){
                      return $query->result_array();
                    }else{
                      return array();
                    }
                 } else {
                     return array();
                 }
                // print_r($user_ids);die;
                
            } else {
                return array();
            }
            
            // $query = $this->db->query("SELECT ucl.* FROM user_current_locations as ucl INNER JOIN driver on ucl.user_id = driver.id INNER JOIN cab on driver.id = cab.driver_id WHERE ucl.user_type = 'Driver' AND driver.driver_current_status = 'online' AND cab.cab_type_id = $cab_type_id ");
            // if($query->num_rows() > 0){
            //   return $query->result_array();
            // }else{
            //   return false;
            // }
        }



    
        function getAllCabThisCategory($cab_type_id){
            $this->db->where('user_type','Driver');
            $this->db->where('cab_type_id',$cab_type_id);
            $data = $this->db->get('user_current_locations')->result_array();        
            return $data;
        }
        
        function getCabCurrentLocation($driver_id){
            $this->db->where('user_type','Driver');
            $this->db->where('user_id',$driver_id);
            $data =$this->db->get('user_current_locations')->row_array();        
            return $data;
        }
    
        public function getFarCityWise($city) {
        
        $this->db->where('a_c_f_p.citi_name',$city);
        $this->db->select('a_c_f_p.*,  cc.cab_icon');
        $this->db->from('all_cab_far_price as a_c_f_p');
        $this->db->join('cab-category as cc','cc.id = a_c_f_p.cab_type_id');
        $this->db->group_by('a_c_f_p.cab_type_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        } else {         
            return  false;
        }
    }



    public function getCabFareOnTheBasisOfCity($city) {
        $query = $this->db->query("SELECT cabfareprice.*,cabcat.* 
                            FROM `all_cab_far_price` as cabfareprice, 
                            `cab-category` as cabcat
                            WHERE 
                            cabfareprice.citi_name = 'Jaipur' 
                            and cabfareprice.cab_type_id = cabcat.id 
                            and cabfareprice.state_name = 'Rajasthan'
                        ");
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        } else {         
            return  array();
        }

    }

    public function getPackageFareOnTheBasisOfCity($city) {
        $query = $this->db->query("SELECT cabfareprice.*,cabcat.* 
                            FROM `package_far_price` as cabfareprice, 
                            `cab-category` as cabcat
                            WHERE 
                            cabfareprice.citi_name = 'Jaipur' 
                            and cabfareprice.cab_type_id = cabcat.id 
                            and cabfareprice.state_name = 'Rajasthan'
                        ");
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        } else {         
            return  array();
        }

    }

    
     public function getFarStateWise($state) {
        
        $this->db->where('a_c_f_p.state_name',$state);
        $this->db->select('a_c_f_p.*,  cc.cab_icon');
        $this->db->from('all_cab_far_price as a_c_f_p');
        $this->db->join('cab-category as cc','cc.id = a_c_f_p.cab_type_id');
        $this->db->group_by('a_c_f_p.cab_type_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        } else {         
            return  $query->result_array();
        }
    }
    
    
    public function getLastRideDetail($user_id) {
        
        $this->db->where('user_id',$user_id);        
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get('cab_ride');
        if ($query->num_rows() > 0) {
            return  $query->row_array();
        } else {         
            return  false;
        }
    }

    public function convertEstimatedTimeInMin($estimated_time){
        $estimated_time_in_min = 0;
        if(strpos($estimated_time,'hour')){
            if (strpos($estimated_time, 'mins')) {
                $estimated_time_sub = str_replace('hour','',$estimated_time);
                $estimated_time_sub_main = str_replace('mins','',$estimated_time_sub);
                
                //now explode on the basis of space
                $estimated_time_in_min_arr = explode(" ",$estimated_time_sub_main);

                //first one is hour and second is in mins
                $hour = $estimated_time_in_min_arr[0];
                $min = $estimated_time_in_min_arr[1];

                $hour_in_min = $hour * 60;
                $estimated_time_in_min = $hour_in_min + $min;
            } else {
                $estimated_time = (double) $estimated_time;
                $estimated_time_in_min = $estimated_time * 60;
            }
        } else {
            if(strpos($estimated_time,'mins')){
                $estimated_time_in_min = (double) $estimated_time;
            }
        }
        return $estimated_time_in_min;
    }

    public function saveRide($postdata,$cab_data,$distance_from_source_destination) {
        if($this->checkDriveOnlineStatus($cab_data['driver_id'])){
            $this->db->insert('json_test',['data'=>json_encode($_POST)]);
            extract($postdata);


            $new_estimated_time = $this->convertEstimatedTimeInMin($estimated_time);
            
            $otp = rand(1000,9999);
            $distances = isset($cab_data['distance']) ? $cab_data['distance'] : '';
            $final_distance = str_replace("km","",$distances);
            $final_distance = (double) $final_distance;
            
            $driver_id = isset($cab_data['driver_id']) ? $cab_data['driver_id'] : '';
            $cab_id =    isset($cab_data['cab_id']) ? $cab_data['cab_id'] : '';
            
            # User assigned driver changed status offline 
            $this->db->where('id',$driver_id)->update('driver',['driver_current_status' => 'offline']);
            

            //get $surcharges value from the DB table gst-commission
            //Getting surcharges from gst-commision table and there is only one record in this table that's why using where('id',1)
            $surcharges_data = $this->db->select('surcharges')->where('id',1)->get('gst-commission')->row_array();
            $surcharges = 0;
            if(!empty($surcharges_data)){
                if(isset($surcharges_data['surcharges'])){
                    $surcharges = $surcharges_data['surcharges'];
                }
            }


            $data = array(
            'user_id'=>isset($user_id) ? $user_id : '',
            'driver_id'=>$driver_id,
            'estimated_time'=>isset($new_estimated_time) ? $new_estimated_time : '',
            'cab_id'=>$cab_id,
            'cab_type'=>isset($cab_type) ? $cab_type : '',
            'source_latitude'=>isset($source_latitude) ? $source_latitude : '',
            'source_longitude'=>isset($source_longitude) ? $source_longitude : '',
            'destination_latitude'=>isset($destination_latitude) ? $destination_latitude : '',
            'destination_longitude'=>isset($destination_longitude) ? $destination_longitude : '',
            'ride_start_time'=>date('Y-m-d H:i:s'),
            // 'ride_end_time'=>isset($ride_end_time) ? $ride_end_time : '',
            'surcharges' => $surcharges,
            'price'=>isset($price) ? $price : '',
            'distance'=>isset($distance_from_source_destination) ? $distance_from_source_destination : '',
            'vechicle_name'=>isset($vechicle_name) ? $vechicle_name : '',
            'created_at'=>date('Y-m-d h:i:s'),
            'updated_at'=>date('Y-m-d h:i:s'),
            'created_by'=> isset($user_id) ? $user_id : '',
            'updated_by'=> isset($user_id) ? $user_id : '',
            'otp'=> $otp,
            );
            // debug($data);die;
            $this->db->insert('cab_ride', $data);
            $insert = $this->db->insert_id();
            // echo $insert;die;
            if ($insert > 0) {
                // echo $cab_id;die;
                $driverDetail = $this->getDriverDetail($driver_id);
                // print_r($driverDetail);die;
                $cabDetail = $this->getCabDetail($cab_id);
                // print_r($cabDetail);die;
                $first_name = isset($driverDetail['first_name']) ? $driverDetail['first_name'] : '';
                $last_name = isset($driverDetail['last_name']) ? $driverDetail['last_name'] : '';
                $driver_name = $first_name.' '.$last_name;
                $save_ride =  array(
                    'driver_id'=>$driver_id,
                    'driver_name'=>$driver_name,
                    'mobile'=> isset($driverDetail['mobile']) ? $driverDetail['mobile'] : '',
                    'cab_id'=>isset($cabDetail['id']) ? $cabDetail['id'] : '',
                    'cab_name'=> isset($cabDetail['cab_model_name']) ? $cabDetail['cab_model_name'] : '',
                    'cab_number'=> isset($cabDetail['registration_number']) ? $cabDetail['registration_number'] : '',
                    'ride_id'=> isset($insert) ? $insert : '',
                    'otp'=> $otp
                    );
                     return $save_ride;
            } else {         
                return  false;
            }
        } else {
            return false;
        }
    }


    public function savePackageRide($postdata,$cab_data,$distance_from_source_destination) {
        if($this->checkDriveOnlineStatus($cab_data['driver_id'])){
            $this->db->insert('json_test2',['data'=>json_encode($_POST)]);
            extract($postdata);


            $new_estimated_time = $this->convertEstimatedTimeInMin($estimated_time);
            
            $otp = rand(1000,9999);
            $distances = isset($cab_data['distance']) ? $cab_data['distance'] : '';
            $final_distance = str_replace("km","",$distances);
            $final_distance = (double) $final_distance;
            
            $driver_id = isset($cab_data['driver_id']) ? $cab_data['driver_id'] : '';
            $cab_id =    isset($cab_data['cab_id']) ? $cab_data['cab_id'] : '';
            
            # User assigned driver changed status offline 
            $this->db->where('id',$driver_id)->update('driver',['driver_current_status' => 'offline']);
            

            //get $surcharges value from the DB table gst-commission
            //Getting surcharges from gst-commision table and there is only one record in this table that's why using where('id',1)
            $surcharges_data = $this->db->select('surcharges')->where('id',1)->get('gst-commission')->row_array();
            $surcharges = 0;
            if(!empty($surcharges_data)){
                if(isset($surcharges_data['surcharges'])){
                    $surcharges = $surcharges_data['surcharges'];
                }
            }


            $data = array(
            'user_id'=>isset($user_id) ? $user_id : '',
            'driver_id'=>$driver_id,
            'estimated_time'=>isset($new_estimated_time) ? $new_estimated_time : '',
            'cab_id'=>$cab_id,
            'cab_type'=>isset($cab_type) ? $cab_type : '',
            'source_latitude'=>isset($source_latitude) ? $source_latitude : '',
            'source_longitude'=>isset($source_longitude) ? $source_longitude : '',
            'destination_latitude'=>isset($destination_latitude) ? $destination_latitude : '',
            'destination_longitude'=>isset($destination_longitude) ? $destination_longitude : '',
            'ride_start_time'=>date('Y-m-d H:i:s'),
            // 'ride_end_time'=>isset($ride_end_time) ? $ride_end_time : '',
            'surcharges' => $surcharges,
            'price'=>isset($price) ? $price : '',
            'distance'=>isset($distance_from_source_destination) ? $distance_from_source_destination : '',
            'vechicle_name'=>isset($vechicle_name) ? $vechicle_name : '',
            'created_at'=>date('Y-m-d h:i:s'),
            'updated_at'=>date('Y-m-d h:i:s'),
            'created_by'=> isset($user_id) ? $user_id : '',
            'updated_by'=> isset($user_id) ? $user_id : '',
            'otp'=> $otp,
            );
            // debug($data);die;
            $this->db->insert('package_ride', $data);
            $insert = $this->db->insert_id();
            // echo $insert;die;
            if ($insert > 0) {
                // echo $cab_id;die;
                $driverDetail = $this->getDriverDetail($driver_id);
                // print_r($driverDetail);die;
                $cabDetail = $this->getCabDetail($cab_id);
                // print_r($cabDetail);die;
                $first_name = isset($driverDetail['first_name']) ? $driverDetail['first_name'] : '';
                $last_name = isset($driverDetail['last_name']) ? $driverDetail['last_name'] : '';
                $driver_name = $first_name.' '.$last_name;
                $save_ride =  array(
                    'driver_id'=>$driver_id,
                    'driver_name'=>$driver_name,
                    'mobile'=> isset($driverDetail['mobile']) ? $driverDetail['mobile'] : '',
                    'cab_id'=>isset($cabDetail['id']) ? $cabDetail['id'] : '',
                    'cab_name'=> isset($cabDetail['cab_model_name']) ? $cabDetail['cab_model_name'] : '',
                    'cab_number'=> isset($cabDetail['registration_number']) ? $cabDetail['registration_number'] : '',
                    'package_ride_id'=> isset($insert) ? $insert : '',
                    'otp'=> $otp
                    );
                     return $save_ride;
            } else {         
                return  false;
            }
        } else {
            return false;
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
	
	public function getCabDetail($id) {        
		$this->db->where('id',$id);
		$query = $this->db->get('cab');
		if ($query->num_rows() > 0) {
			return  $query->row_array();
		} else {         
			return  false;
		}
	}
    
    public function cancelRide($postdata) {
        extract($postdata);
        
        $driver_id = $this->getDriverDetail($postdata['ride_id']);
        
        //added by lgarg to get the driver id
        $ride_data = $this->db->select('driver_id')->where('id',$ride_id)->get('cab_ride')->row_array();
        $driver_id_new = isset($ride_data['driver_id']) ? $ride_data['driver_id'] : '';
        
        # User Cancelled driver changed status online 
        $this->db->where('id',$driver_id_new)->update('driver',['driver_current_status' => 'online']);
        
        $data = array(
            'canceled_type'=> isset($postdata['canceled_type']) ? $postdata['canceled_type'] : '',
            'canceled_reason'=> isset($canceled_reason) ? $canceled_reason : '',
            'canceled'=> 1,
            'location_status' => 3,
            'updated_at'=>date('Y-m-d h:i:s'),
            'updated_by'=> isset($postdata['id']) ? $postdata['id'] : ''
        );
    
        $this->db->where('id',$postdata['ride_id']);
        $update = $this->db->update('cab_ride', $data);
        
        if ($update) {
            return  true;
        } else {         
            return  false;
        }
    }
    
    public function checkDriveOnlineStatus($driver_id){
      $data = $this->db->where('driver_current_status','online')->where('id',$driver_id)->get('driver')->num_rows();
      if($data > 0){
        return true;
      }else{
        return false;
      }
    }
    
    public function checkDriveOnline(){
      $data = $this->db->where('driver_current_status','online')->get('driver')->num_rows();
      if($data > 0){
        return true;
      }else{
        return false;
      }
    }
    
    public function sos($postData){
        extract($postData);
        $data = array(
          'user_id' => isset($user_id) ? $user_id : '',
          'driver_id' => isset($driver_id) ? $driver_id : '',
          'latitude' => isset($latitude) ? $latitude  : '',
          'longitude' => isset($longitude) ? $longitude : '',
          'created_at' => date('Y-m-d h:i:s')
        );
        $this->db->insert('sos',$data);
        $lastInsertId = $this->db->insert_id();
        if($lastInsertId != ''){
            return $lastInsertId;
        }else{
            return false;
        }
    }
    
    public function rideVerify($postData){
      extract($postData);
      $query = $this->db->where(['id' => $ride_id, 'driver_id' => $driver_id, 'otp' => $otp])->get('cab_ride');
      if($query->num_rows() > 0){
          return true;
      }else{
        return false;  
      }
    }
    
    public function uploadInvoice($postData, $file_name){
        extract($postData);
        $data = array(
         'invoice' => $file_name
        );
        
        $this->db->where('id',$ride_id)->update('cab_ride',$data);
        if($ride_id != ''){
           return true; 
        }else{
           return false; 
        }
    }
    
    public function getInvoiceImage($postData){
        extract($postData);
        $data = $this->db->select('invoice')->where('id',$ride_id)->get('cab_ride')->row_array();
        $invoice['invoice'] = base_url().'pubilc/invoice/'.$data['invoice'];
        if(!empty($invoice)){
            return $invoice;
        }else{
          return array();    
        }
    }
    
    public function getLocationName($source_latitude,$source_longitude,$destination_latitude,$destination_longitude){
        
	    $googleMapsApiKey = 'AIzaSyDwn5cCgHITLkJKcCoy_g6hKKcJdjm9IDQ';
	    //Source Location Name
        $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$source_latitude,$source_longitude&sensor=true&key=$googleMapsApiKey";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = json_decode(curl_exec($ch), true);
        $location_name_Source = isset($data['results'][0]['formatted_address']) ? $data['results'][0]['formatted_address'] : '';
        
        //Destination Location Name
        $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$destination_latitude,$destination_longitude&sensor=true&key=$googleMapsApiKey";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data1 = json_decode(curl_exec($ch), true);
        $location_name_Destination = isset($data1['results'][1]['formatted_address']) ? $data1['results'][1]['formatted_address'] : '';
        
        $data2 = array('source_location_name' => $location_name_Source, 'destination_location_name' => $location_name_Destination);
        return $data2; 
    }
    
    public function getRideHistory($postData){
       extract($postData);
       $query =  $this->db->where('user_id',$user_id)->get('cab_ride')->result_array();
        
       $new_arr  = array(); 
       foreach($query as $key => $val){
           $new_arr[$key] = $val;
          
           $userData = $this->db->select("CONCAT((first_name),(' '),(last_name)) AS name")->where('user_id',$val['user_id'])->get('users')->row_array();
           
           # Get Source location name  and Destination location name
           $data = $this->getLocationName($val['source_latitude'],$val['source_longitude'],$val['destination_latitude'],$val['destination_longitude']);
           $new_arr[$key]['source_location_name'] = $data['source_location_name'];
           $new_arr[$key]['destination_location_name'] = $data['destination_location_name'];
           $new_arr[$key]['user_name'] = $userData['name'];
       }
       
        if(!empty($query)){
            return $new_arr;
        }else{
            return array();
        }
    }
    
    public function getDriverRideHistory($postData){
       extract($postData);
       $query =  $this->db->where('driver_id',$driver_id)->get('cab_ride')->result_array();
        
       $new_arr  = array(); 
       foreach($query as $key => $val){
           $new_arr[$key] = $val;
           $userData = $this->db->select("CONCAT((first_name),(' '),(last_name)) AS name")->where('id',$val['driver_id'])->get('driver')->row_array();
           # Get Source location name  and Destination location name
           $data = $this->getLocationName($val['source_latitude'],$val['source_longitude'],$val['destination_latitude'],$val['destination_longitude']);
           $new_arr[$key]['source_location_name'] = $data['source_location_name'];
           $new_arr[$key]['destination_location_name'] = $data['destination_location_name'];
           $new_arr[$key]['user_name'] = $userData['name'];
       }
        if(!empty($query)){
            return $new_arr;
        }else{
            return array();
        }
    }
    
    
 
}

