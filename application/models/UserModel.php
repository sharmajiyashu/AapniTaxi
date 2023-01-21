<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class UserModel extends CI_Model {
    
   public function getLocationName($postData){
            
           foreach($postData as $key => $val){
	        $googleMapsApiKey = 'AIzaSyDwn5cCgHITLkJKcCoy_g6hKKcJdjm9IDQ';
    	    //Source Location Name
            $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$val['source_latitude'].",".$val['source_longitude']."&sensor=true&key=$googleMapsApiKey";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $details_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = json_decode(curl_exec($ch), true);
            $location_name_Source = isset($data['results'][0]['formatted_address']) ? $data['results'][0]['formatted_address'] : '';
            
            //Destination Location Name
            $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$val['destination_latitude'].",".$val['destination_longitude']."&sensor=true&key=$googleMapsApiKey";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $details_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data1 = json_decode(curl_exec($ch), true);
            $location_name_Destination = isset($data1['results'][1]['formatted_address']) ? $data1['results'][1]['formatted_address'] : '';
            
            $data2[] = array('source_name' => $location_name_Source, 'destination_name' => $location_name_Destination, 'username' => $val['username'], 'drivername' => $val['drivername'], 'created_at' => $val['created_at'],'invoice' => $val['invoice']);
           }
            if(!empty($data2)){
              return $data2;     
            }else{
              return array();
            }
	}
 

}