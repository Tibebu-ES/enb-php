
<!--show alert - notification or- any operation status-->

<!--<h1> Welcome to the Notice manager view</h1>-->
<h4 class="alert alert-info">Welcome to the Notice Manager Page | <span id="statusLabel"> <?php echo $this->statusLabel?> </span></h4>
<div class="panel panel-success" >
    <div class="panel-heading">
        <a type="button" class=" btn btn-warning btn-xs" href="<?php echo base_url();?>index.php/Login/logout" ><span class="glyphicon glyphicon-log-out" ></span> Logout</a>
		<a type="button" class=" btn btn-warning btn-xs" id="cpwBut"  data-toggle="modal" data-target="#myModalCP" href="" ><span class="glyphicon glyphicon-plus" ></span> Change Password</a>

    </div>


</div>

<!-- for showing the notice view section-->
<div class="row">
	<!-- here goes the list of notices.-->
	<div class="col-md-5">
		<!-- panel for list of notices  -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">
					List of Notices : <a type="button" class=" pull-right btn btn-warning btn-xs" href="<?php echo base_url();?>index.php/noticemanager/Add_Notice/index/<?php echo $this->nmmodel->getUserName();?>" ><span class="glyphicon glyphicon-plus" ></span> Add New Notice</a>
				</div>
			</div>
			<div class="panel-body">

				<!-- here goes the list of notices-->
				<ul  class="list-group">
					<!-- iterate through notices array-->
					<?php
					foreach ($this->nmmodel->getNotices() as $enbNotice){
						$cls = "list-group-item";
						if($enbNotice->getId() == $this->nmmodel->getSelectedNotice()->getId())
							$cls="active list-group-item"; //make the selected notice listite active

						echo '<a class="'.$cls.'"'.' id="'.$enbNotice->getID().'"'
								.' href="'.base_url().'index.php/noticemanager/Notice_Manager/showNoticeDetail/'.$enbNotice->getID().'/'.$this->nmmodel->getUserName().'/|'.'">'
								.$enbNotice->getTitle()
								.'</a>';

					}
					?>

				</ul>
			</div>
		</div> <!-- panel for list of notices  end-->

	</div>

	<!-- here goes selected notice detail display.-->
	<div class="col-md-7">
		<div class="panel panel-success">
			<div class="panel-heading">
				<!-- if no notice is selected i.e when there is no notice cretaed yet - then the selectednotice id is -1 ---if so disable this buttons-->
				<a <?php if($this->nmmodel->getSelectedNotice()->getId() == -1) echo 'disabled';?> type="button" class=" btn btn-warning btn-xs "  href="<?php echo base_url();?>index.php/noticemanager/Add_Notice/editNotice/<?php echo $this->nmmodel->getSelectedNotice()->getId()."/".$this->nmmodel->getUserName();?>" ><span class="glyphicon glyphicon-pencil" ></span> Edit Selected Notice </a>
				<a <?php if($this->nmmodel->getSelectedNotice()->getId() == -1) echo 'disabled';?> type="button" class=" btn btn-warning btn-xs " onclick="deleteNotice(<?php echo "'".base_url()."index.php/noticemanager/Notice_Manager/deleteNotice/".$this->nmmodel->getSelectedNotice()->getId()."/".$this->nmmodel->getUserName()."'" ?>)" href="#" ><span class="glyphicon glyphicon-remove"></span> Delete Selected Notice</a>

			</div>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading">
				<!--here goes the selected notice detail-->
				<h4> Notice Title :</h4> <h4> <span id="noticeDetailInfo"><?php echo $this->nmmodel->getSelectedNotice()->getTitle(); ?></span> </h4>
				<h4> Notice Status : <span id="noticeDetailInfo"> <?php echo $this->nmmodel->getSelectedNotice()->getStatus();  ?> </span></h4>
				<h4> The Notice will be live from: <span id="noticeDetailInfo"> <?php echo $this->nmmodel->getSelectedNotice()->getStartDate()." - ".$this->nmmodel->getSelectedNotice()->getEndDate();  ?> </span></h4>

			</div>
			<div class="panel-body">
				<!--here goes the notice text content-->
				<div id="noticeMsgDiv">
					<?php echo $this->nmmodel->getSelectedNotice()->getContentTxt();?>
				</div>

			</div>
			<div class="panel-footer">
				<!--here goes the notice image content-->
				<div id="imagePreviewDiv">
					<!-- iterate through notice img contents array-->
					<?php
					$contentImgs = $this->nmmodel->getSelectedNotice()->getContentimgs(); //assoc array of images - key=contentId , value = image file
					foreach ($contentImgs as $ncId => $imgFile){
						//use scroll bar
						echo '<img class="img-thumbnail'.'" width='.'"200'.'" height='.'"100'.'" id='.'"'.$ncId.'"'
								.'src="data:image/jpg;base64,'.base64_encode($imgFile).'"/>';
					}

					?>

				</div>
			</div>
		</div>




	</div>

</div><!-- noticeDetail - main div edn-->

<!-- modal for changing password-->
<div id="myModalCP" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change <span id="loginStatus"><small> - your password.</small></span> </h4>
			</div>
			<div class="modal-body">
				<?php echo validation_errors(); ?>
				<?php echo form_open('noticemanager/Notice_Manager/changePassword','name="cpwForm"'); ?>
					<div class="input-group">
						<span class="input-group-addon">old password</span>
						<input name ="opw" type="password" class="form-control" placeholder="">
					</div><br>

					<div class="input-group">
						<span class="input-group-addon">New password</span>
						<input name ="npw" type="password" class="form-control">
					</div><br>
					<div class="input-group">
						<span class="input-group-addon">Confirm new password</span>
						<input name ="cnpw" type="password" class="form-control">
					</div>

				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default" onclick="document.cpwForm.submit()"> OK</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div><!--document.getElementById('radioHasStreamId')-->
</div>

