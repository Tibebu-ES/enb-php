<?php

class Add_Notice extends CI_Controller {

    // extends CI_Controller for CI 2.x users

    public $data = array();

    //EnbNotice obj - that holds the notice data which is required to be modified
	public $EnbNotice ;

	//label that indicates the activity/purpose - either ' Create New Notice = create' or 'Edit Notice= edit' - by default it is the former one
	public $purpose = "Create"; // shown on the add_notice view

    public function __construct() {

        //parent::Controller();
        parent::__construct();
        $this->load->helper('ckeditor_helper');
		$this->load->helper('security'); //for cleaning post values - prevent sql iinjection


        //Ckeditor's configuration
        $this->data['ckeditor'] = array(

            //ID of the textarea that will be replaced
            'id' => 'content',
            'path' => 'js/ckeditor',

            //Optionnal values
            'config' => array(
                'toolbar' => "Full", //Using the Full toolbar
                'width' => "550px", //Setting a custom width
                'height' => '100px', //Setting a custom height

            ),

            //Replacing styles from the "Styles tool"
            'styles' => array(

                //Creating a new style named "style 1"
                'style 1' => array (
                    'name' => 'Blue Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Blue',
                        'font-weight' => 'bold'
                    )
                ),

                //Creating a new style named "style 2"
                'style 2' => array (
                    'name' => 'Red Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Red',
                        'font-weight' => 'bold',
                        'text-decoration' => 'underline'
                    )
                )
            )
        );

        $this->data['ckeditor_2'] = array(

            //ID of the textarea that will be replaced
            'id' => 'content_2',
            'path' => 'js/ckeditor',

            //Optionnal values
            'config' => array(
                'width' => "100%", //Setting a custom width
                'height' => '100px', //Setting a custom height
                'toolbar' => array( //Setting a custom toolbar
                    array('Bold', 'Italic'),
                    array('Underline', 'Strike', 'FontSize'),
                    array('Smiley'),
                    '/'
                )
            ),

            //Replacing styles from the "Styles tool"
            'styles' => array(

                //Creating a new style named "style 1"
                'style 3' => array (
                    'name' => 'Green Title',
                    'element' => 'h3',
                    'styles' => array(
                        'color' => 'Green',
                        'font-weight' => 'bold'
                    )
                )

            )
        );

        //?? how to share a model
        $this->load->model("NM_model","nmmodel2");

		$this->load->library('CKEditor');
		$this->load->library('CKFinder');


		//Add Ckfinder to Ckeditor
		$this->ckfinder->SetupCKEditor($this->ckeditor,'../../assets/ckfinder/');

		//

		$this->EnbNotice = new EnbNotice();

    }

    public function index($uname)
    {

		$this->init($uname);
		$this->loadView();

    }

    public function loadView()
	{
		$this->load->view('header');
		$this->load->view('noticemanager/add_notice', $this->data);
		$this->load->view('footer');
	}

    /*
     * init the model - retrieve notices pulished by the user given
     */
    public function init($uname)
    {
        //init the model - loads the appropriate notice from the database
        $this->nmmodel2->init($uname);

        //$this->index();
    }

    //not complete

	/*
	 *   //add the newly created or edited notices to the database
	 *   if $purpose = "Create" - create new notice elseif itis Edit- then update the notice using provided $nid
	 *
	 */
    public function insertNotice($uname,$purpose,$nid)
    {
    	//initialize the model
		$this->init($uname);
        //get the content
		//prevent sql injection attack
        $title = $this->input->post('title',True); //enable xx filtering
		$sdate = $this->input->post('sdate',True);
        $edate = $this->input->post('edate',True);
        $cdate = date("Y-m-d");
        $publisher = $uname;
       // $contentSource = $_POST["selSource"];
		$noticeMsg =  $this->input->post('contentEditor_TA',True);
		//put the noticemsg inside html and body tag
		$noticeMsg = "<html><body>".$noticeMsg."</body></html>";

       //construct the enb_notice
		$noticeId = 0; //if the purpoe is create doesnt matter
		if($purpose=="Edit") //if the purpose is Edit -
			$noticeId = $nid;

		$newNotice = EnbNotice::makeNotice($noticeId,$title,$sdate,$edate,$cdate,$publisher,$noticeMsg);

		//check if the file content is set
		$files_name = array_filter($_FILES['noticeFile']['name']); // filter empty file names and paths, the array might contain empty strings.
		$filesNum = count($files_name);
		if($filesNum==0){
				//if no file is selected - then check the purpose
				if($purpose == "Edit"){
					//if the purpose is Edit - then get the old content
					$oldContentImgs = $this->nmmodel2->getNotice($nid)->getContentimgs();
					 foreach ($oldContentImgs as $ncId => $imgFile){
					 	$content = addslashes($imgFile);
					 	$newNotice->addContent($ncId,$content);
					 }

				}else{
					//if the purpose is create - then set empty content image
					//echo "Notice Content cant be empty try again";
					//return;
				}
			}else{ //whatever the purpose is - if the file selector is not empty- get the content
				//get the files to be uploaded
				$files_tmpName = array_filter($_FILES['noticeFile']['tmp_name']); // filter empty file names and paths, the array might contain empty strings.


				// Loop through each file
				for( $i=0 ; $i < $filesNum ; $i++ ) {

					//Get the temp file path
					$tmpFilePath = $files_tmpName[$i];

					//Make sure we have a file path
					if ($tmpFilePath != ""){
						//Setup our new file path
						$newFilePath =  $files_name[$i];

						//Upload the file into the temp dir
						if(move_uploaded_file($tmpFilePath, $newFilePath)) {
							//read and add the notice image content to the newNotice obj
							$file = fopen($newFilePath, "rb");
							$fcontent = fread($file, filesize($newFilePath));
							$content = addslashes($fcontent);
							$newNotice->addContent($i,$content);
							//remove the temp file
							unlink($newFilePath);

						}
					}
				}

			}


        //insert to the database - notice table
		//check the purpose
		if($purpose == "Edit")
			$result = $this->nmmodel2->updateNotice($newNotice);
		elseif ($purpose == "Create")
			$result = $this->nmmodel2->addNewNotice($newNotice);

		//var_dump($result); return;
		if($result != -1)
		{
			//if the new notice is inserted successfully
			//redirect to the nm - home view - while showing the newly created notice detail
			//var_dump($result);
			if($purpose == "Edit")
				$status = "Notice Edited Successfully";
			else
				$status = "New Notice Inserted Successfully";
			$uri = "/noticemanager/Notice_Manager/showNoticeDetail/$result/$uname/$status";
			redirect($uri);
		}else
		{
			//if the new notice is not inserted
			$status= "Error while creating the new notice";
			$uri = "/noticemanager/Notice_Manager/index/$uname/$status";
			redirect($uri);
		}

    }


	/*
	 * //update - edit notice
	 * prepare the given notice for modification
	 */
	public function editNotice($nid,$uname)
	{
		//init the model first
		$this->init($uname);

		//get the enbNotice obj to be edited- and set to the $EnbNotice attribute
		$this->EnbNotice = $this->nmmodel2->getNotice($nid);
		//change the Purpose indicator attr

		$this->purpose = "Edit";

		//load the viewss
		$this->loadView();

	}


}
