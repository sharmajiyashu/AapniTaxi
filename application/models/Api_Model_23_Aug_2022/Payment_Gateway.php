<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Payment_Gateway extends MY_Model {

        public function saveUserPaymentInfo($user_id,$name,$email,$contact,$description,$payment_amount,$ride_id) {
            
            //get driver id from cab_ride id
            $ride_data = $this->db->select('driver_id')->where('id',$ride_id)->get('cab_ride')->row_array();
            $driver_id = isset($ride_data['driver_id']) ? $ride_data['driver_id'] : '';
            //EOC
            
        $data = array(  
            'user_id'=>$user_id,
            'name'=>isset($name) ? $name : '',
            'email'=> isset($email) ? $email : '',
            'driver_id' => isset($driver_id) ? $driver_id : 0,
            'cab_ride_id' => isset($ride_id) ? $ride_id : 0,
            'contact'=> isset($contact) ? $contact : '',
            'payment_amount'=> isset($payment_amount) ? ($payment_amount/100) : '',
            'description'=> isset($description) ? $description : '',
            'status' => 'Pending',
            'created_at'=> date('Y-m-d h:i:s'),
            'updated_at'=> date('Y-m-d h:i:s'),
        );
        $this->db->insert('payment_history', $data);
        $save = $this->db->insert_id();
        if ($save > 0) {
            return  $save;
        } else {         
            return  false;
        }
    }
    
    public function PayNow($postData) {
        extract($postData);
        $id = isset($postData['payment_id']) ? $postData['payment_id'] : '';
        $razor_pay_id = $postData['razorpay_payment_id'];
        
        
        //get razor pay transaction id details
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.razorpay.com/v1/payments/'.$razor_pay_id,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic cnpwX2xpdmVfa2RQMDkzOGtLRnlHS1M6MGFwcVdHSHNwczRmRmp2OVRvQTlUcXE1'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        $razor_pay_transaction_detail_data_arr = json_decode($response,true);
        if($razor_pay_transaction_detail_data_arr['status'] == 'authorized'){
           $postData['status_code'] = 200; 
        } 
        
        if($postData['status_code'] == 200){
            $data = array(  
                'txn_id'=> isset($postData['razorpay_payment_id']) ? $postData['razorpay_payment_id'] : '',
                'payment_mode' => isset($postData['payment_method']) ? $postData['payment_method'] : '',
                'status' =>  'TXN_SUCCESS',
                'payment_responce' => $response,
                'txn_date'=>   date('Y-m-d h:i:s'),
                'created_at'=> date('Y-m-d h:i:s'),
                'updated_at'=> date('Y-m-d h:i:s'),
            );
            $this->db->where('id',$id)->update('payment_history', $data);
        } else {
            $data = array(  
                'txn_id'=> isset($postData['razorpay_payment_id']) ? $postData['razorpay_payment_id'] : '',
                'payment_mode' => isset($postData['payment_method']) ? $postData['payment_method'] : '',
                'status' =>  'TXN_FAILURE',
                'payment_responce' => '',
                'txn_date'=>   date('Y-m-d h:i:s'),
                'created_at'=> date('Y-m-d h:i:s'),
                'updated_at'=> date('Y-m-d h:i:s'),
            );
            $this->db->where('id',$id)->update('payment_history', $data); 
        }
        if ($id > 0) {
            return  $id;
        } else {         
            return  false;
        }
    }
}
