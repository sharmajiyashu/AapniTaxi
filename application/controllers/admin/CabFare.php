<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CabFare extends CI_Controller {

	
	public function __construct(){
		parent::__construct();

		if($this->session->userdata('type') != 'Superadmin')
			redirect('admin/Login');
		$this->load->model('CabFareModel');
	}
	
	public function add($id=null)
	{		
	    $getCabFareDetails = $this->CabFareModel->getAllCabFareEdit($id);
		$allState = $this->CabFareModel->getState();
		$getParentCategory = $this->CabFareModel->getParentCategory();

		$error = [];
		if (isset($_POST) && !empty($_POST)) {		
		    
		        extract($_POST);
		        if(empty($error)){
        			if ($id == '') {
        				$save = $this->CabFareModel->save($_POST);
        				if ($save) {
        					$this->session->set_flashdata('success','Well done ! You have successfully added the CabFarCalculated.');
        					redirect('admin/CabFare/cabFareListing');
        				}else{
        					$this->session->set_flashdata('error','Sorry! Some error occurred.');
        					redirect('admin/CabFare/cabFareListing');	
        				}
        			}else{
        				$update = $this->CabFareModel->update($_POST,$id);
        				if ($update) {					
        					$this->session->set_flashdata('success','Well done ! You have successfully updated the CabFarCalculated.');
        					redirect('admin/CabFare/cabFareListing');	
        				}
        				$this->session->set_flashdata('error','Sorry! Some error occurred.');
        				redirect('admin/CabFare/cabFareListing');
        			}
		        }
		        $categoryData['error'] = $error;
		}
		$this->load->view('admin/add-cab-fare',['allState' => $allState, 'allCabType' => $getParentCategory, 'data' => $getCabFareDetails]);
	}

	public function cabFareListing()
	{
		$allcategory['category'] = $this->CabFareModel->getAllCabFare();
		$this->load->view('admin/cab-fare-listing',$allcategory);
	}

	public function deleteCabFare($id=null)
	{
		$deletecategory= $this->CabFareModel->deleteCabFare($id);
		if ($deletecategory) {
			$this->session->set_flashdata('success','Well done ! You have successfully deleted the CabFare.');
			redirect('admin/CabFare/cabFareListing');	
		}else{
			$this->session->set_flashdata('error','Sorry! Some error occurred.');
			redirect('admin/CabFare/cabFareListing');	
		}
	}
	
	public function getCity(){
	    $id = $this->input->post('state_id');
	    $getData = $this->CabFareModel->getCity($id);
	    echo json_encode($getData); die;
	}
}
