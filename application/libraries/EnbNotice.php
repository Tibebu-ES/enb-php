<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class EnbNotice
{

	private $_title;
	private $_startDate;
	private $_endDate;
	private $_createdDate;
	private $_publisher;
	private $_contentTxt; //text
	private $_id;
	private $_contentImgs; //assoc array of images - key=contentId , value = image file

	public function __construct()
	{
		$this->_id =-1; //
		$this->_contentImgs = array();
	}

	public static function makeNotice($id,$title,$sdate,$edate,$cdate,$publisher,$contentTxt)
	{

		$NewNotice = new EnbNotice();
		$NewNotice->setId($id);
		$NewNotice->setTitle($title);
		$NewNotice->setStartDate($sdate);
		$NewNotice->setEndDate($edate);
		$NewNotice->setCreatedDate($cdate);
		$NewNotice->setPublisher($publisher);
		$NewNotice->setContentTxt($contentTxt);

		return $NewNotice;

	}
	/**
	 * @param array $contents
	 */
	public function setContentimgs($contents)
	{
		$this->_contentImgs = $contents;
	}

	/**
	 * @return assoc array
	 */
	public function getContentimgs()
	{
		return $this->_contentImgs;
	}



	public function addContent($key,$value)
	{
		$this->_contentImgs[$key]=$value;

	}
	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->_id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->_id;
	}

	/**
	 * @return mixed
	 */
	public function getCreatedDate()
	{
		return $this->_createdDate;
	}

	/**
	 * @return mixed
	 */
	public function getEndDate()
	{
		return $this->_endDate;
	}

	/**
	 * @return mixed
	 */
	public function getPublisher()
	{
		return $this->_publisher;
	}

	/**
	 * @return mixed
	 */
	public function getStartDate()
	{
		return $this->_startDate;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->_title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title)
	{
		$this->_title = $title;
	}

	/**
	 * @param mixed $createdDate
	 */
	public function setCreatedDate($createdDate)
	{
		$this->_createdDate = $createdDate;
	}

	/**
	 * @param mixed $endDate
	 */
	public function setEndDate($endDate)
	{
		$this->_endDate = $endDate;
	}

	/**
	 * @param mixed $publisher
	 */
	public function setPublisher($publisher)
	{
		$this->_publisher = $publisher;
	}

	/**
	 * @param mixed $startDate
	 */
	public function setStartDate($startDate)
	{
		$this->_startDate = $startDate;
	}


	///
	public function setContentTxt($content)
	{
		$this->_contentTxt = $content;
	}

	public function getContentTxt()
	{
		return $this->_contentTxt;
	}

	/*
	 * return the status fo the notice Waiting | Live | Inactive
	 */
	public function getStatus()
	{
		//get today
		$today = date("Y-m-d");
		$sdate = $this->getStartDate();
		$edate =  $this->getEndDate();

		if($today < $sdate)
			return "Waiting";
		elseif ($today <= $edate)
			return "Live";
		else
			return "Inactive";
	}

}
?>
