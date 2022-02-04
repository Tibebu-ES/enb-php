<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('security');

	}

	public function index()
	{
		//check session - if the user is logged in already
		if($this->session->has_userdata('username')){
			$name = $this->session->userdata('username');
			$role = $this->session->userdata('role');
			if($role == EnbConstants::$ENB_USER_ROLE_SYSTEM_ADMIN){
				redirect("/System_Admin/index/|");
			}else{
				redirect("/noticemanager/Notice_Manager/index/$name/|");
			}
		}else{
			$this->load->view('header');
			$this->load->view('login_form');
			$this->load->view('footer');
		}



		
	}

	public function submit()
	{
		$this->load->library('form_validation');

        if ($this->form_validation->run('login') == FALSE) //validation rule is in the config/form_validation.php file
            {
                 $this->load->view('header');
	             $this->load->view('login_form');
		         $this->load->view('footer');
           }
          else
           {
           		$uname=$this->input->post('username',True);//receiving username field value in $uname variable
				$password=$this->input->post('password',True);//receiving password field value in $password variable
				$auth_result = $this->authenticate($uname,$password);
           		if( $auth_result== false)
           		{
           			$this->load->view('header');
	             	$this->load->view('login_form');
		         	$this->load->view('footer');
		         	//set error messgae
           		}
           		elseif ($auth_result == EnbConstants::$ENB_USER_ROLE_SYSTEM_ADMIN) {
           			#if the user is system administrator - redirect to the sa controler - pass the username
					//set session
					$newdata = array(
						'username'  => $uname,
						'role' => $auth_result
					);
					$this->session->set_userdata($newdata);

           			redirect("/System_Admin/index/|");
           			
           		}
           		elseif($auth_result == EnbConstants::$ENB_USER_ROLE_NOTICE_MANAGER)
           		{
					//set session
					$newdata = array(
						'username'  => $uname,
						'role' => $auth_result
					);
					$this->session->set_userdata($newdata);
           			# if the user is nm r
           			redirect("/noticemanager/Notice_Manager/index/$uname/|");
           			
           		}
                 
           }        
	
	}

	//return the user role, otherwise it returns false
	public function authenticate($un,$pw)
	{
		//fetch enb_users data
		$this->db->where(EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_USERNAME, $un);
		$this->db->where(EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_PASSWORD, $pw);
		$query = $this->db->get(EnbConstants::$ENB_DATABASE_TABLE_USER);
		if($query->num_rows() == 1)
		{
			//get the user role and return the user role
			$row = $query->row();
			$role = $row->role;
			return $role;
		}else{
			return false;
		}
	}

	public function logout(){
		//clear the userdata session and redirect to the Login page
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('role');

		redirect("Login");
	}

}
