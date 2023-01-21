<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('type') != 'Superadmin')
			redirect('admin/Login');		
	}
	
	public function index()
	{
	    $date = date('Y-m-d');
	    $data['driver'] = $this->db->get('driver')->num_rows();
	    $data['ride_online'] = $this->db->where(['driver_current_status' => 'online', 'status' => 1])->get('driver')->num_rows();
	    $data['ride'] = $this->db->get('cab_ride')->num_rows();
	    $data['user'] = $this->db->get('users')->num_rows();
	    $data['today_ride'] = $this->db->query("SELECT * FROM `cab_ride` WHERE created_at LIKE '%".$date."%'")->num_rows();
	    $data['today_new_user'] = $this->db->query("SELECT * FROM `users` WHERE created_at LIKE '%".$date."%'")->num_rows();
		$total_income = $this->db->query("SELECT Sum(final_fare_amt) as total_income FROM `cab_ride` WHERE location_status = 2")->row_array();
	    $today_income = $this->db->query("SELECT Sum(final_fare_amt) as today_income FROM `cab_ride` WHERE location_status = 2 AND created_at LIKE '%".$date."%'")->row_array();
		$this->load->view('admin/dashboard',['data' => $data,'total_income' => $total_income, 'today_income' => $today_income]);
	}

	public function referral_master(){
		$data = $this->db->get('referral_master')->result_array();
		$this->load->view('admin/referral_master',['data' => $data]);
	}

	public function changeRefferalAmount(){
		$data = array('amount' => isset($_POST['amount']) ? $_POST['amount'] :'',);
		$this->db->where('id',$_POST['id'])->update('referral_master',$data);
		$this->session->set_flashdata('success','Well done! You have successfully updated amount');
		redirect('admin/Dashboard/referral_master');
	}
}
