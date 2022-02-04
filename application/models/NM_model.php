<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class NM_model extends CI_Model {


    public $user; //holds user info
    public $notices; //array of notices -
	public $SelectedNotice;

    function __construct()
    {
        //call model constructor
        parent::__construct();
        $this->notices=  array();
        $this->SelectedNotice = new EnbNotice();

    }

    public function init($uname)
    {
        //initialize -- the user inf0 var and the notices list
        //fetch the data ---and set to the variables
        $this->user=$uname;
        $this->setNotices($this->user);
    }

    //retrieve notices published by the user from the database and set to the notices attribute
    public function setNotices($uname)
    {
    	//clear the array
		$this->notices = array();

        $this->db->where('publisher', $uname);
        $query = $this->db->get('enb_notice');
        foreach ($query->result() as $row){
            //create a notice class and push to the variable
            $title=$row->title;$sdate = $row->sDate; $edate = $row->eDate; $cdate = $row->cDate; $N_ID= $row->N_ID; $contentTxt = $row->contentTxt;
            $notice = EnbNotice::makeNotice($N_ID,$title,$sdate,$edate,$cdate,$uname,$contentTxt);

            //get the notice contents jpg file - to be done


            $this->db->where('N_ID', $N_ID);

            $query2 = $this->db->get('notice_content');
            foreach ($query2->result() as $row2){
                //construct the Notice_content array
                $ncid = $row2->NC_ID; $imgFile=$row2->imgFile;
                $notice->addContent($ncid,$imgFile);
            }

            //push
            array_push($this->notices,$notice);
        }

        //initially set selected notice set the first notice from the notice array as selected notice
		if(sizeof($this->notices)>0)
			$this->SelectedNotice = $this->notices[0];
		else //if the notice is empty - set empty enbnotice
			$this->SelectedNotice = new EnbNotice();
    }

	//return array of notices published by the $user
    public function getUserName()
    {
        return $this->user;
    }

    public function setUserName($uname)
    {
        $this->user=$uname;
    }

    //return array of notices - items are instance of ENB_NOTICE

	/**
	 * return array of notices - items are instance of EnbNotice
	 * @return array
	 */
    public function getNotices()
    {
        return $this->notices;
    }



    /**
     * Insert new notice to the Notice table
	 * return the notice id- if succeed or -1 if not
     */
    public function addNewNotice(EnbNotice $enb_notice)
    {

        //get the notice content
		//prevent sql injection attack - by escapeing - use active record methods
        //prepare the array
		$array = array('title'=>$enb_notice->getTitle(),'sDate'=>$enb_notice->getStartDate(),'eDate'=>$enb_notice->getEndDate(),'cDate'=>$enb_notice->getCreatedDate(),'publisher'=>$enb_notice->getPublisher(),'contentTxt'=>$enb_notice->getContentTxt());
       $this->db->set($array);
        //insert into the table
        if ($this->db->insert('enb_notice'))
        {
			$query = $this->db->query("select LAST_INSERT_ID()");

             //success - RETURN THE newly created notice id
			$row = $query->first_row('array');
			$noticeId = $row['LAST_INSERT_ID()'];
			//insert the notice_contentImgs
			$contentImgs = $enb_notice->getContentimgs(); //associative array, where the items key = NC_ID and value=imgFile
			foreach ($contentImgs as $key => $value){
				//prepare query
				//$this->db->set('imgFile',$value,False);
				//$this->db->set('N_ID',$noticeId,False);
				//$array = array('imgFile'=>$value,'N_ID'=>$noticeId);
				$sql = "INSERT INTO notice_content(imgFile,N_ID) values ('".$value."',".$noticeId.")";
				if($this->db->query($sql)){
					//continue
				}else
					return -1;
			}
			return $noticeId;
        }
        else
        {
           //failed
			return -1;
        }
        //insert the content - call the addcontent func
        //*/

    }

	/**
	 * try to update the given notice
	 * return the notice id- if succeed or -1 if not
	 */
    public function  updateNotice(EnbNotice $enb_notice){
    	if($this->deleteNotice($enb_notice->getId())){
    		return $this->addNewNotice($enb_notice);
		}else
			return -1;


	}

	/*
	 * remove enbnotice from the database
	 * return true if succeed - false if not
	 */
	public function deleteNotice($nid)
	{
		$sql = "DELETE FROM enb_notice WHERE N_ID =".$nid;
		if($this->db->query($sql))
		{
			return true;
		}else
			return false;

	}


	/*
	 * iterate through the notices array and return notice object with the given id
	 */
	public function getNotice($nid)
	{

		//iterate through the notices array and return notice object with the given id
		$noticeToReturn = null; //if no notice found
		foreach ($this->getNotices() as $notice){
			if($notice->getId() == $nid){
				$noticeToReturn = $notice;
				//check if the content is set- if not try to retrieve it from the database

				break;
			}
		}


		return $noticeToReturn;
	}

	public function setSelectedNotice(EnbNotice $enbnotice)
	{
		$this->SelectedNotice = $enbnotice;

	}

	public function getSelectedNotice()
	{
		return $this->SelectedNotice;
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

}
?>
