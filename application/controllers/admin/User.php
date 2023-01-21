<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('UserModel');
	}

	public function index()
	{
	    $data['userListing'] = $this->db->order_by('created_at','Desc')->get('users')->result_array();
		$this->load->view('admin/list-users',$data);
	}
	
	public function viewUser($id){
        $getData['getData'] = $this->db->query('Select * from users Where user_id ='.$id)->row_array();
        $getData['wallet'] = $this->db->where(['user_id' => $id, 'type' => 'User', 'status' => 'Active'])->get('wallet')->row_array();
        $getData['cancelled'] = $this->db->where(['user_id' => $id, 'location_status' => 3])->get('cab_ride')->num_rows();
        $getData['trip'] = $this->db->where(['user_id' => $id])->get('cab_ride')->num_rows();
        $getData['rating'] = $this->db->query('SELECT AVG(rating) as rating FROM `rating_user` WHERE to_user ='.$id)->row_array();
        $data = $this->db->query('SELECT cab_ride.id,cab_ride.source_latitude,cab_ride.source_longitude,cab_ride.destination_latitude,cab_ride.destination_longitude, cab_ride.created_at,cab_ride.invoice, CONCAT(users.first_name," ",users.last_name) as username, CONCAT(driver.first_name," ",driver.last_name) as drivername FROM ((cab_ride INNER JOIN users ON cab_ride.user_id = users.user_id) INNER JOIN driver ON cab_ride.driver_id = driver.id) WHERE cab_ride.user_id ='.$id)->result_array();
        $getData['data'] = $this->UserModel->getLocationName($data);
        $this->load->view('admin/view-user',$getData);
    }
    
    public function changeStatusUser($id,$status){
      if($status === 'Active'){
        $status = '0';  
      }else{
        $status = '1';    
      }
      $this->db->where('user_id',$id)->update('users',array('status' => $status));
      redirect('admin/User/');
    }
    
	public function invoice($invoice){
	   $this->load->view('admin/invoice',array('invoice' => $invoice));
	}
	
	public function addMoneyToWallet(){
	  $amount = $_POST['amount'];
	  $user_id = $_POST['user_id'];
	  $dta = $this->db->where(['user_id' => $user_id, 'type' => 'User'])->get('wallet');
	  if($dta->num_rows() > 0){
	      $wallet_amt = $dta->row_array();
	      $new_wallet_amt = $wallet_amt['wallet_amount'] + $amount;
	      $this->db->where(['user_id' => $user_id, 'type' => 'User'])->update('wallet',['wallet_amount' => $new_wallet_amt, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]);
	      if($amount > 0){
	          $transaction_type = 'cr';
	      }else{
	         $transaction_type = 'dr'; 
	      }
	      $this->db->insert('wallet_history',['user_id' => $user_id, 'wallet_amount' => $new_wallet_amt, 'transaction_type' => $transaction_type, 'type' => 'User', 'created_at' => date('Y-m-d h:i:s')]);
	      redirect('admin/User/viewUser/'.$user_id);
	  }else{
	     $this->db->insert('wallet',['wallet_amount' => $amount, 'user_id' => $user_id, 'type' => 'User', 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]);
	     if($amount > 0){
	          $transaction_type = 'cr';
	     }else{
	         $transaction_type = 'dr'; 
	     }
	     $this->db->insert('wallet_history',['user_id' => $user_id, 'wallet_amount' => $amount, 'transaction_type' => $transaction_type, 'type' => 'User', 'created_at' => date('Y-m-d h:i:s')]);
	     redirect('admin/User/viewUser/'.$user_id);
	  }
	}

}