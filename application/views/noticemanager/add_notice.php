

<div class="">
    <h4 class="alert alert-info"> <?php  if($this->purpose == "Create") echo "Create New Notice"; else echo "Edit Notice"?></h4>
    <form name="addNoticeFrm" method="post" action="<?php echo base_url(); ?>index.php/noticemanager/Add_Notice/insertNotice/<?php echo $this->nmmodel2->getUserName()."/".$this->purpose."/".$this->EnbNotice->getId(); ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-3 col-lg-12">
                <div class="form-group">
                    <label>Title:[Maximum of 100 characters]</label>
                    <input type="text" maxlength="100" value="<?php echo $this->EnbNotice->getTitle();?>" name="title" placeholder="Title" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 col-lg-4">
                <div class="form-group">
                    <label>Start Date:</label>
                    <input name="sdate" type="date" class="form-control" value="<?php echo $this->EnbNotice->getStartDate();?>">
                </div>
            </div>
            <div class="col-sm-3 col-lg-4">
                <div class="form-group">
                    <label>End Date:</label>
                    <input name="edate" type="date" class="form-control" value="<?php echo $this->EnbNotice->getEndDate();?>">
                </div>
            </div>

        </div>


        <div id="contentEditorDiv" class="row "> <!-- initially hidden - since initialy the Content Source is selected to be external-->
            <div class="col-sm-3 col-lg-12">
                <div class="form-group">
                    <label>Insert notice message: </label>
                    <?php echo $this->ckeditor->editor("contentEditor_TA","contentEditor",$this->EnbNotice->getContentTxt()); ?>
                </div>
            </div>
        </div>

		<div id="contentSelectorDiv" class="row">
			<div class="col-sm-3 col-lg-12">
				<div class="form-group">
					<label>upload notice images: </label>
					<input id="uploadNoticeFile"  size="4" accept="image/jpeg, image/png" type="file" name="noticeFile[]" multiple onchange="loadFile(event)" />
				</div>
			</div>
			<div class="col-lg-12" id="imagePreviewDiv">
				<!-- preview the notice image to be replaced or  selected images -->

				<!-- iterate through notice img contents array-->
				<?php
				$contentImgs = $this->EnbNotice->getContentimgs(); //assoc array of images - key=contentId , value = image file
				foreach ($contentImgs as $ncId => $imgFile){
					//use scroll bar
					echo '<img class="img-thumbnail'.'" width='.'"200'.'" height='.'"100'.'" id='.'"'.$ncId.'"'
							.'src="data:image/jpg;base64,'.base64_encode($imgFile).'"/>';
				}

				?>

			</div>

		</div>

        <div class="row">
            <div class="col-sm-3 col-lg-12">
                <div class="form-group">
                    <a type="button" class=" btn btn-warning " href="<?php echo base_url(); ?>index.php/noticemanager/Notice_Manager/index/<?php echo $this->nmmodel2->getUserName()."/|"; ?>" >Back</a>

                        <input type="submit" name="submitBtn" value="<?php echo $this->purpose ?>" class="btn btn-success">
                </div>
            </div>
        </div>
    </form>

</div>
