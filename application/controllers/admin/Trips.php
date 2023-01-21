<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trips extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function activeTrips(){
	   $allData = $this->db->query('SELECT cab_ride.id,cab_ride.source_latitude,cab_ride.source_longitude,cab_ride.destination_latitude,cab_ride.destination_longitude, cab_ride.created_at, CONCAT(users.first_name," ",users.last_name) as username, CONCAT(driver.first_name," ",driver.last_name) as drivername FROM ((cab_ride INNER JOIN users ON cab_ride.user_id = users.user_id) INNER JOIN driver ON cab_ride.driver_id = driver.id) WHERE cab_ride.location_status IN (0,1) ORDER BY Date(cab_ride.created_at) DESC')->result_array();
	   if(!empty($allData)){
	    foreach($allData as $key => $val){
	        $Uname = isset($val['username'])  ? $val['username'] : '';
	        $Dname = isset($val['drivername'])  ? $val['drivername'] : '';
	        $created_at = isset($val['created_at']) ? $val['created_at'] : '';

	        //Source Location Name
    	    $S_lat = $val['source_latitude'];
            $S_long = $val['source_longitude'];
            
            //Destination Location Name
            $D_lat = $val['destination_latitude'];
            $D_long = $val['destination_longitude']; 
            
            $data[$key] = $this->getLocationName($S_lat,$S_long,$D_lat,$D_long,$Uname,$Dname,$created_at);
	    }
	     $this->load->view('admin/active-trips',['data' => $data]); 
	   }else{
	      $this->load->view('admin/active-trips'); 
	   }
	}
	
	public function completedTrips(){
	  $allData = $this->db->query('SELECT cab_ride.id,cab_ride.source_latitude,cab_ride.source_longitude,cab_ride.destination_latitude,cab_ride.destination_longitude, cab_ride.created_at, CONCAT(users.first_name," ",users.last_name) as username, CONCAT(driver.first_name," ",driver.last_name) as drivername FROM ((cab_ride
        INNER JOIN users ON cab_ride.user_id = users.user_id)
        INNER JOIN driver ON cab_ride.driver_id = driver.id) WHERE cab_ride.location_status = 2 ORDER BY Date(cab_ride.created_at) DESC')->result_array();
    
    if(!empty($allData)){
	    foreach($allData as $key => $val){
	        $Uname = isset($val['username'])  ? $val['username'] : '';
	        $Dname = isset($val['drivername'])  ? $val['drivername'] : '';
	        $created_at = isset($val['created_at']) ? $val['created_at'] : '';

	        //Source Location Name
    	    $S_lat = $val['source_latitude'];
            $S_long = $val['source_longitude'];
            
            //Destination Location Name
            $D_lat = $val['destination_latitude'];
            $D_long = $val['destination_longitude']; 
            
            $data[$key] = $this->getLocationName($S_lat,$S_long,$D_lat,$D_long,$Uname,$Dname,$created_at);
	    }
	     $this->load->view('admin/completed-trips',['data' => $data]); 
	   }else{
	       $this->load->view('admin/completed-trips'); 
	   }
	}
	
	public function cancelledTrips(){
	 $allData = $this->db->query('SELECT cab_ride.id,cab_ride.source_latitude,cab_ride.source_longitude,cab_ride.destination_latitude,cab_ride.destination_longitude, cab_ride.created_at, CONCAT(users.first_name," ",users.last_name) as username, CONCAT(driver.first_name," ",driver.last_name) as drivername FROM ((cab_ride INNER JOIN users ON cab_ride.user_id = users.user_id) INNER JOIN driver ON cab_ride.driver_id = driver.id) WHERE cab_ride.canceled = 1 ORDER BY Date(cab_ride.created_at) DESC ')->result_array();
    
    if(!empty($allData)){
	    foreach($allData as $key => $val){
	        
	        $Uname = isset($val['username'])  ? $val['username'] : '';
	        $Dname = isset($val['drivername'])  ? $val['drivername'] : '';
	        $created_at = isset($val['created_at']) ? $val['created_at'] : '';

	        //Source Location Name
    	    $S_lat = $val['source_latitude'];
            $S_long = $val['source_longitude'];
            
            //Destination Location Name
            $D_lat = $val['destination_latitude'];
            $D_long = $val['destination_longitude']; 
            
            $data[$key] = $this->getLocationName($S_lat,$S_long,$D_lat,$D_long,$Uname,$Dname,$created_at);
	    }
	    

	    $this->load->view('admin/cancelled-trips',['data' => $data]); 
	   }else{
	      $this->load->view('admin/cancelled-trips'); 
	   }
	}
	
	public function getLocationName($S_lat,$S_long,$D_lat,$D_long,$Uname,$Dname,$created_at){
	        $googleMapsApiKey = 'AIzaSyDwn5cCgHITLkJKcCoy_g6hKKcJdjm9IDQ';
    	    
    	    //Source Location Name
            $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$S_lat,$S_long&sensor=true&key=$googleMapsApiKey";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $details_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = json_decode(curl_exec($ch), true);
            $location_name_Source = isset($data['results'][0]['formatted_address']) ? $data['results'][0]['formatted_address'] : '';
            
            
            //Destination Location Name
            $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$D_lat,$D_long&sensor=true&key=$googleMapsApiKey";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $details_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data1 = json_decode(curl_exec($ch), true);
            $location_name_Destination = isset($data1['results'][1]['formatted_address']) ? $data1['results'][1]['formatted_address'] : '';
            
            $data2 = array('source_name' => $location_name_Source, 'destination_name' => $location_name_Destination, 'username' => $Uname, 'drivername' => $Dname, 'created_at' => $created_at);
            return $data2;
	}

}
