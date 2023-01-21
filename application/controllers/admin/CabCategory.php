<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CabCategory extends CI_Controller {

	
	public function __construct(){
		parent::__construct();

		if($this->session->userdata('type') != 'Superadmin')
			redirect('admin/Login');
		$this->load->model('CabCategoryModel');
	}
	
	public function add($id=null)
	{		
	    $getCabFareDetails = $this->CabCategoryModel->getAllCabFareEdit($id);
		$getParentCategory = $this->CabCategoryModel->getParentCategory();

		$error = [];
		if (isset($_POST) && !empty($_POST)) {		
		    
		        extract($_POST);
		        if(empty($error)){
        			if ($id == '') {
        				$save = $this->CabCategoryModel->save($_POST);
        				if ($save) {
        					$this->session->set_flashdata('success','Well done ! You have successfully added the CabFarCalculated.');
        					redirect('admin/CabCategory/cabCategoryListing');
        				}else{
        					$this->session->set_flashdata('error','Sorry! Some error occurred.');
        					redirect('admin/CabCategory/cabCategoryListing');	
        				}
        			}else{
        				$update = $this->CabCategoryModel->update($_POST,$id);
        				if ($update) {					
        					$this->session->set_flashdata('success','Well done ! You have successfully updated the CabFarCalculated.');
        					redirect('admin/CabCategory/cabCategoryListing');	
        				}
        				$this->session->set_flashdata('error','Sorry! Some error occurred.');
        				redirect('admin/CabCategory/cabCategoryListing');
        			}
		        }
		        $categoryData['error'] = $error;
		}
		$this->load->view('admin/add-cab-category',['allState' => $allState, 'allCabType' => $getParentCategory, 'data' => $getCabFareDetails]);
	}

	public function cabCategoryListing()
	{
		$allcategory['category'] = $this->CabCategoryModel->getAllCabFare();
		$this->load->view('admin/cab-category-listing',$allcategory);
	}

	public function deleteCabCategory($id=null)
	{
		$deletecategory= $this->CabCategoryModel->deleteCabFare($id);
		if ($deletecategory) {
			$this->session->set_flashdata('success','Well done ! You have successfully deleted the CabFare.');
			redirect('admin/CabCategory/cabCategroyListing');	
		}else{
			$this->session->set_flashdata('error','Sorry! Some error occurred.');
			redirect('admin/CabCategory/cabCategroyListing');	
		}
	}
	
}
