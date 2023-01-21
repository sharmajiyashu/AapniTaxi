<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {


	public function index()
	{
		$this->load->view('index');
	}
	public function about()
	{
		$this->load->view('about');
	}
	
	public function terms()
	{
		$this->load->view('terms');
	}
	
	public function contact()
	{
		$this->load->view('contact');
	}
	
	public function policy()
	{
		$this->load->view('policy');
	}
	
	 public function registerUser(){
	 $data = array(
		 'name' => isset($_POST['name']) ? $_POST['name'] : '',
		 'email' => isset($_POST['email']) ? $_POST['email'] : '',
		 'contact' => isset($_POST['contact']) ? $_POST['contact'] : '',
		 'password' => isset($_POST['password']) ? md5($_POST['password']) : ''
	  );
	  $data = $this->db->insert('user',$data);
	  $insert_id = $this->db->insert_id();
	  if(!empty($insert_id)){
		redirect('Dashboard');
	  }
	}
}
?>
