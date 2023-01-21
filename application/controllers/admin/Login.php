<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('AdminLoginModel');		
	}

	public function index()
	{
		
	    if(isset($_POST['login_submit'])){
		    $data = $this->AdminLoginModel->adminLogin($_POST);
		    if (!empty($data)) {
				$this->session->set_userdata($data);				
				$this->session->set_flashdata('success','Well done! You successfully login ');
				redirect('admin/Dashboard');
			}else{				
				$this->session->set_flashdata('error','Sorry! wrong credential');
				redirect('admin/Login');
			}
        }else{
		  $this->load->view('admin/login');
        }			
	}
	
	public function forgotPassword(){
		$this->load->view('admin/forgot_password');
	}
	
	public function logout(){
	   	$this->session->sess_destroy();
		redirect('admin/Login');   
	}
	

}
