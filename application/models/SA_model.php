<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SA_model extends CI_Model
{
	private $users; //array of EnbUser
    private $selectedUser;
    private $systemSettings; // array of system setting
	function __construct()
	{
		//call model constructor
		parent::__construct();
		//retrieve the users
		$this->users = array();
		$this->setUsers($this->retrieveUsers());
		//initialy set the first notice as the selected User
		if(sizeof($this->users)>0)
			$this->setSelectedUser($this->users[0]);
		else //if no user is selected - i.e when there is no user created yet - set selectedusere null value
			$this->setSelectedUser(null);

		//retrieve the system settings
		$this->retrieveSystemSettings();
	}

	//retrieve and set system settings
	public function retrieveSystemSettings(){
		$query = $this->db->get(EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING);
		foreach ($query->result() as $row){
			$this->systemSettings[$row->{EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NAME}]=array(
			EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_SHOW_TIME => $row->{EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_SHOW_TIME},
				EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_SHOW_TIME => $row->{EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_SHOW_TIME},
				EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_IMAGE_SHOW_TIME => $row->{EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_IMAGE_SHOW_TIME},
				EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICES_RELOAD_TIME => $row->{EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICES_RELOAD_TIME},
				EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_ACTIVE => $row->{EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_ACTIVE}
			);
		}
	}

	//return multidimensional array = systemSettings['name']['variable'] - e.gsystemSettings['default']['noticeshowtime']
	public function getSystemSettings(){
		return $this->systemSettings;
	}

	//return the selected/active preference name - i.e default or custom
	public function getSelectedPreferenceName(){
		$selecctedPref = "";
		if($this->systemSettings!=null){
			if($this->systemSettings['default'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_ACTIVE] == 'yes')
				$selecctedPref = 'default';
			else
				$selecctedPref = 'custom';
		}
		return $selecctedPref;
	}

	//change selected preference and update its data - takes the previous selected pref and the newly selected pref name
	public function setSelectedPreference($oldPrefName,$newPrefName){
		$result = false;
		//first make the oldpref active col = no
		$data2Update = array(EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_ACTIVE => 'no');
		$this->db->where(EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NAME,$oldPrefName);
		if($this->db->update(EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING,$data2Update)){
			//then make the selected preference - active col yes
			$data2Update = array(EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_ACTIVE => 'yes');
			$this->db->where(EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NAME,$newPrefName);
			if($this->db->update(EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING,$data2Update)){
				$result = true;
				//reload the data
				$this->retrieveSystemSettings();
			}

		}

		return $result;
	}
	//update the custom preference - in system_setting table
	// return true if succeeded or false if failed
	public function updateCustomPreference($nst,$nist,$nrt){
		$result = false; //
		$data = array(EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_SHOW_TIME =>$nst,
			EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_IMAGE_SHOW_TIME => $nist,
			EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICES_RELOAD_TIME => $nrt,
			EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_ACTIVE => 'no');
		$this->db->where(EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NAME,'custom');
		if($this->db->update(EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING,$data)){
			$result = true;
			//update the system setting array
			$this->retrieveSystemSettings();
		}

		return $result;
	}

	public function setSelectedUser(EnbUser $enbUser){
		$this->selectedUser = $enbUser;
	}

	public function getSelectedUser(){
		return $this->selectedUser;
	}



	//this is for the root user -
	public function getUsers(){
		return $this->users;
	}

	public function setUsers($users){
		$this->users = $users;
	}

	/**
	 * @return array
	 * return only notice manager users - if the user is just systemadmin
	 * if the user is root user - return all users
	 */
	private function retrieveUsers(){

		$EnbUsersArray = array();
		if($this->session->userdata('username') != 'root' && $this->session->userdata('role') == EnbConstants::$ENB_USER_ROLE_SYSTEM_ADMIN)
			$this->db->where(EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_ROLE,EnbConstants::$ENB_USER_ROLE_NOTICE_MANAGER);//set condition

		//exclude the user itself
		$this->db->where(EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_USERNAME.'!=',$this->session->userdata('username'));
		$query = $this->db->get(EnbConstants::$ENB_DATABASE_TABLE_USER);

		foreach ($query->result() as $row){
			//create a user class and push to the variable
			$fnameColName = EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_FIRSTNAME;
			$fname=$row->$fnameColName;
			$lnameColName = EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_LASTNAME;
			$lname=$row->$lnameColName;
			$unameColName = EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_USERNAME;
			$uname=$row->$unameColName;
			$roleColName = EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_ROLE;
			$role=$row->$roleColName;
			$pwordColName = EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_PASSWORD;
			$pword=$row->$pwordColName;

			$EnbUser = EnbUser::makeUser($fname,$lname,$uname,$role);
			$EnbUser->setPword($pword);

			//push
			array_push($EnbUsersArray,$EnbUser);
		}

		return $EnbUsersArray;
	}

	public function getEnbUser($uname){
		//iterate through the notices array and return notice object with the given id
		$userToReturn = null; //if no notice found
		foreach ($this->getUsers() as $user){
			if($user->getUname() == $uname){
				$userToReturn = $user;
				break;
			}
		}

		return $userToReturn;
	}

	//change the user password
	public function changePassword($uname,$opw,$npw){
		$data = array(EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_PASSWORD=>$npw);
		$condition = array(EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_USERNAME=>$uname,EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_PASSWORD=>$opw); // where uname={$uname} && pword = {$opw}
		$this->db->where($condition);
		if($this->db->update(EnbConstants::$ENB_DATABASE_TABLE_USER,$data)){
			//if succeded return true
			return true;
		}else
			return false;
	}

	/**
	 * Insert new user to the enb_user table
	 * return the username- if succeed or -1 if not
	 */
	public function addNewUser(EnbUser $enbuser){
		//prevent sql injection attack - by escapeing - use active record methods
		//prepare the array
		$array = array(EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_FIRSTNAME => $enbuser->getFname(),EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_LASTNAME=>$enbuser->getLname(),EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_USERNAME=>$enbuser->getUname(),EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_ROLE=>$enbuser->getRole(),EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_PASSWORD=>$enbuser->getPword());
		$this->db->set($array);
		//insert into the table
		if ($this->db->insert(EnbConstants::$ENB_DATABASE_TABLE_USER))
		{
			//if succeeded return the user name
			return $enbuser->getUname();
		}
		else
		{
			//failed
			return -1;
		}
		//insert the content - call the addcontent func
		//*/

	}

	/*
	 * remove user from the database
	 * return true if succeed - false if not
	 */
	public function deleteUser($uname)
	{
		$this->db->where(EnbConstants::$ENB_DATABASE_TABLE_USER_COLUMN_USERNAME,$uname);

		if($this->db->delete(EnbConstants::$ENB_DATABASE_TABLE_USER))
		{
			return true;
		}else
			return false;

	}

}
