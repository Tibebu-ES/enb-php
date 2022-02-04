<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Admin extends CI_Controller {

	public $statusLabel;

	public function index($statusLabel)
	{
		$this->statusLabel = urldecode($statusLabel);
		$this->loadView();
	}

	public function loadView(){
		$this->load->view('header');
		$this->load->view('system_admin_home_view');
		$this->load->view('footer');
	}

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->model("SA_model","samodel");
	}



	public function showUserDetail($uname){
		//set the selected user and reload the view
		$selUser = $this->samodel->getEnbUser($uname);
		if($selUser != null){
			$this->samodel->setSelectedUser($selUser);
		}

		$this->loadView();
	}

	public function changePassword(){
		$this->load->library('form_validation');
		if ($this->form_validation->run('changePassword') == FALSE) //validation rule is in the config/form_validation.php file
		{
			//if there is form validation error - set the status ="Error Changing password" -then redirect to the current page -and show the modal
			$status = "Error: ".validation_errors()."Please try again";
			$this->index($status);

		}else{

			$opw = $this->input->post('opw',True); //true - enable xss filtering
			$npw = $this->input->post('npw',True);
			// - call the model function to change the password
			$uname =  $this->session->userdata('username');
			$res = $this->samodel->changePassword($uname,$opw,$npw);
			$status="";
			if($res)
				$status = "Password Changed Successfully";
			else
				$status = "Database Error - Password not changed, try again please";

			$this->index($status);

		}
	}

	public function addNewUser(){
		$this->load->library('form_validation');
		if ($this->form_validation->run('signup') == FALSE) //validation rule is in the config/form_validation.php file
		{
			//if there is form validation error - set the status ="Error Changing password" -then redirect to the current page -and show the modal
			$status = "Error: ".validation_errors()."Please try again";
			$this->index($status);

		}else{

			$fname = $this->input->post('fname',True); //true - enable xss filtering
			$lname = $this->input->post('lname',True);
			$uname = $this->input->post('uname',True);
			$role = $this->input->post('role',True);

			$enbUser = EnbUser::makeUser($fname,$lname,$uname,$role);

			// - call the model function to add new user
			$res = $this->samodel->addNewUser($enbUser);
			$status="";
			if($res)
				$status = "New User Added Successfully";
			else
				$status = "Database Error - , try again please";

			//reload the page
			redirect("/System_Admin/index/$status");

		}
	}

	public function deleteUser($uname)
	{
		$status="";
		//delete the user
		if($this->samodel->deleteUser($uname)){
			//if succeed - set the status label - 'User Removed Successfully'
			$status = "User Removed Successfully";
		}else{
			//if not succeed - set the status label - 'Error Deleting User -- Try again please'
			$status = "Error Deleting User -- Try again please";
		}

		//redirect to the home page- sothat the model get refreshed
		redirect("/System_Admin/index/$status");

	}

	public function editCustomPreference(){
		$this->load->library('form_validation');
		if($this->form_validation->run('editpreference') == FALSE){
			$status = "Error: ".validation_errors()."Please try again";
			$this->index($status);
		}
		else
		{
			$nts = $this->input->post('nst',true);
			$nist =$this->input->post('nist',true);
			$nrt = $this->input->post('nrt',true);

			//call samodel function to update the custom preference - row
			$result = $this->samodel->updateCustomPreference($nts,$nist,$nrt);
			if($result){
				//if succeeded -
				$status = "Custom System Preference Updated!";
				$this->index($status);
			}else{
				//if not succeeded
				$status = "Error: Custom System Preference Not Updated try again!";
				$this->index($status);
			}
		}
	}

	//select system preference
	public function selectSystemPreference(){
		//get the seleccted system preference name
		$selPrefName = $this->input->post('selectPreference');
		//before going to the model - if it already the selected one
		if($this->samodel->getSelectedPreferenceName() == $selPrefName){
			//just go the home oage
			$this->index("|");
		}else{
			//call the samodel function to update the database & reload its data
			$result = $this->samodel->setSelectedPreference($this->samodel->getSelectedPreferenceName(),$selPrefName);
			if($result)
				$status = "The ".$selPrefName." System Preference is selected!";
			else
				$status = "Error Changing the System Preference";

			$this->index($status);

		}
	}

}
