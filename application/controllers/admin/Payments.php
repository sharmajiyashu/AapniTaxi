<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('type') != 'Superadmin')
			redirect('admin/Login');
	}
	
	public function listPayments(){
	    $data = $this->db->query('SELECT cab.cab_type_id,cab_ride.final_fare_amt as total_balance, cab_ride.commission_amt as commission, cab_ride.gst_amt as gst,payment_history.status,payment_history.created_at ,CONCAT(users.first_name," ",users.last_name) as username, CONCAT(driver.first_name," ",driver.last_name) as drivername FROM ((cab_ride INNER JOIN users ON cab_ride.user_id = users.user_id) INNER JOIN payment_history on cab_ride.id = payment_history.cab_ride_id INNER JOIN cab ON cab_ride.cab_id = cab.id INNER JOIN driver ON cab_ride.driver_id = driver.id)')->result_array();
        foreach($data as $key => $val){
            $data[$key] = $val;
            $payment_amt = $this->db->select('minimum_fare')->where('cab_type_id',$val['cab_type_id'])->get('all_cab_far_price')->row_array();
            $data[$key]['payment_amount'] = isset($payment_amt['minimum_fare']) ? $payment_amt['minimum_fare'] : '';
        }
     
	    $this->load->view('admin/list-payment',['data' => $data]);
	}
}