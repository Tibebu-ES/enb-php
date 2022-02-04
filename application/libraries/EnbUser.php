<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class EnbUser
{
    private $_fname;
    private $_lname;
    private $_uname;
    private $_role;
    private $_pword;



    public function __construct()
    {

    }

    //return a new user with default password -
    public static function makeUser($fname,$lname,$uname,$role){
    	$newUser = new EnbUser();

		$newUser->setFname($fname);
		$newUser->setLname($lname);
		$newUser->setUname($uname);
		$newUser->setRole($role);
		$newUser->setPword("12345678");

		return $newUser;
	}
    /**
     * @return mixed
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * @return mixed
     */
    public function getPword()
    {
        return $this->_pword;
    }
    /**
     * @return mixed
     */
    public function getLname()
    {

        return $this->_lname;
    }

    /**
     * @return mixed
     */
    public function getUname()
    {
        return $this->_uname;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->_role;
    }



    /**
     * @param mixed $fname
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * @param mixed $lname
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }


    /**
     * @param mixed $uname
     */
    public function setUname($uname)
    {
        $this->_uname = $uname;
    }

    /**
     * @param mixed $pword
     */
    public function setPword($pword)
    {
        $this->_pword = $pword;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->_role = $role;
    }

}




?>
