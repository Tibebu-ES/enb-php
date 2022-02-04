<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice_Manager extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	public $statusLabel;

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model("NM_model","nmmodel");


    }

    //funct to init the controller
    public function init($uname,$status)
    {
        //init the model
        $this->nmmodel->init($uname);
        //set the status - urldecode - incase it is urlencoded
		$this->statusLabel = urldecode($status);
    }
	public function index($uname,$status)
	{
		//init the model
		$this->init($uname,$status);

		$this->loadView();
	}

	public function loadView()
	{
		$this->load->view('header');
		$this->load->view('noticemanager/notice_manager_home_view');
		$this->load->view('footer');
	}

	public function showNoticeDetail($nid,$uname,$status)
	{
		//init the model
		$this->init($uname,$status);
		//set the selected notice and reload the view
		$selNotice = $this->nmmodel->getNotice($nid);
		//var_dump($selNotice);
		if($selNotice != null){
			$this->nmmodel->setSelectedNotice($selNotice);
		}

		$this->loadView();

	}

	public function deleteNotice($nid, $uname)
	{
		//init the model
		$this->init($uname," ");
		//check if no notice is selected --i.e if the id = -1

		//delete the notice
		if($this->nmmodel->deleteNotice($nid)){
			//if succeed - set the status label - 'Notice Removed Successfully'
			$status = "Notice Removed Successfully";
			//refresh the model - init again
			$this->init($uname,$status);
		}else{
			//if not succeed - set the status label - 'Error Deleting Notice -- Try again please'
			$status = "Error Deleting Notice -- Try again please";
			//refresh the model - init again
			$this->init($uname,$status);
		}

		//then load the view
		$this->loadView();

	}

	public function changePassword(){

		$this->load->library('form_validation');
        if ($this->form_validation->run('changePassword') == FALSE) //validation rule is in the config/form_validation.php file
		{
			//if there is form validation error - set the status ="Error Changing password" -then redirect to the current page -and show the modal

			$status = "Error: ".validation_errors()."Please try again";
			$uname =  $this->session->userdata('username');
			$this->index($uname,$status);

		}else{

			$opw = $this->input->post('opw',True); //true - enable xss filtering
			$npw = $this->input->post('npw',True);
			// - call the model function to change the password
			$uname =  $this->session->userdata('username');
			$res = $this->nmmodel->changePassword($uname,$opw,$npw);
			$status="";
			if($res)
				$status = "Password Changed Successfully";
			else
				$status = "Database Error - Password not changed, try again please";

			$this->index($uname,$status);

		}

	}








}
