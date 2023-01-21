<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SOS extends CI_Controller {
	
	public function index(){
	  
		$allData = $this->db->query('SELECT sos.latitude, sos.longitude, CONCAT(users.first_name," ",users.last_name) as username, CONCAT(driver.first_name," ",driver.last_name) as drivername FROM ((sos INNER JOIN users ON sos.user_id = users.user_id) INNER JOIN driver ON sos.driver_id = driver.id) ORDER BY Date(sos.created_at) DESC ')->result_array();
		if(!empty($allData)){
			foreach($allData as $key => $val){
				
				$Uname = isset($val['username'])  ? $val['username'] : '';
				$Dname = isset($val['drivername'])  ? $val['drivername'] : '';

				$S_lat = $val['latitude'];
				$S_long = $val['longitude'];
				
				$data[$key] = $this->getLocationName($S_lat,$S_long,$Uname,$Dname);
			}
		  $this->load->view('admin/sos',['data' => $data]);
		}else{
		  $this->load->view('admin/sos');
		}  
	}
	
	
	public function getLocationName($S_lat,$S_long,$Uname,$Dname){
	        $googleMapsApiKey = 'AIzaSyDwn5cCgHITLkJKcCoy_g6hKKcJdjm9IDQ';
    	    
    	    //Source Location Name
            $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$S_lat,$S_long&sensor=true&key=$googleMapsApiKey";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $details_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = json_decode(curl_exec($ch), true);
            $location_name_Source = isset($data['results'][0]['formatted_address']) ? $data['results'][0]['formatted_address'] : '';
            
            $data2 = array('source_name' => $location_name_Source, 'username' => $Uname, 'drivername' => $Dname);
            return $data2;
	}
	
	

}
