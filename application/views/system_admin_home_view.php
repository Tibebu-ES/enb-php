
<!--show alert - notification or- any operation status-->

<!--<h1> Welcome to the Notice manager view</h1>-->
<h4 class="alert alert-info">Welcome to the System Admin Page | <span id="statusLabel"> <?php echo $this->statusLabel?> </span></h4>
<div class="panel panel-success" >
	<div class="panel-heading">
		<a type="button" class=" btn btn-warning btn-xs" href="<?php echo base_url();?>index.php/Login/logout" ><span class="glyphicon glyphicon-log-out" ></span> Logout</a>
		<a type="button" class=" btn btn-warning btn-xs" id="cpwBut"  data-toggle="modal" data-target="#myModalCP" href="" ><span class="glyphicon glyphicon-plus" ></span> Change My Password</a>

	</div>
</div>

<!-- for showing the user view section-->
<div class="row" id="userDetail">
	<!-- here goes the list of users.-->
	<div class="col-md-4">
		<!-- panel for list of users  -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">
					List of Users |
					<a type="button" class=" pull-right btn btn-warning btn-xs" data-toggle="modal" data-target="#myModalAU" href="" ><span class="glyphicon glyphicon-plus" ></span> Add New User</a>
				</div>

			</div>
			<div class="panel-body">

				<!-- here goes the list of users-->
				<ul  class="list-group">
					<!-- iterate through users array-->
					<?php
					foreach ($this->samodel->getUsers() as $enbUser){
						$cls = "list-group-item";
						if($enbUser->getUname() == $this->samodel->getSelectedUser()->getUname())
							$cls="active list-group-item"; //make the selected notice listite active

						echo '<a class="'.$cls.'"'.' id="'.$enbUser->getUname().'"'
								.' href="'.base_url().'index.php/System_Admin/showUserDetail/'.$enbUser->getUname().'">'
								.$enbUser->getUname()
								.'</a>';

					}
					?>

				</ul>
			</div>
		</div> <!-- panel for list of users  end-->

	</div>

	<!-- here goes selected user detail display.-->
	<div class="col-md-8">
		<div class="panel panel-success">
			<div class="panel-heading">
				Selected User Detail
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>User Name</th>
						<th>Role</th>
						<th>Password</th>
					</tr>
					<tr>
						<td><?php echo $this->samodel->getSelectedUser()->getFname(); ?></td>
						<td><?php echo $this->samodel->getSelectedUser()->getLname();  ?></td>
						<td><?php echo $this->samodel->getSelectedUser()->getUname();  ?></td>
						<td><?php echo $this->samodel->getSelectedUser()->getRole();  ?></td>
						<td><?php echo $this->samodel->getSelectedUser()->getPword();  ?></td>
					</tr>
				</table>
			</div>

			<div class="panel-footer">
				<!-- if no notice is selected i.e when there is no notice cretaed yet - then the selectednotice id is -1 ---if so disable this buttons-->
				<a  <?php if($this->samodel->getSelectedUser() == null) echo 'disabled';?> type="button" class=" btn btn-warning btn-xs "  href="<?php echo base_url();?>index.php/System_Admin" ><span class="glyphicon glyphicon-pencil" ></span> Edit Selected User </a>
				<a <?php if($this->samodel->getSelectedUser() == null) echo 'disabled';?> type="button" class=" btn btn-warning btn-xs " onclick="deleteUser(<?php echo "'".base_url()."index.php/System_Admin/deleteUser/".$this->samodel->getSelectedUser()->getUname()."'" ?>)" href="#" ><span class="glyphicon glyphicon-remove"></span> Delete Selected User</a>
			</div>
		</div>




	</div>

</div><!-- userDetail - main div edn-->

<!-- for showing/adding/selecting - system/display setting -->
<div class="panel panel-success">
	<div class="panel-heading">
		<?php echo form_open('System_Admin/selectSystemPreference',array('name'=>'selSysSetForm','class'=>'form-inline')); ?>
			<div class="input-group">
				<span class="input-group-addon">Select Preference</span>
				<select name ="selectPreference"  class="form-control" onchange="document.selSysSetForm.submit()" >
					<option <?php $sp= $this->samodel->getSelectedPreferenceName(); if($sp == 'default') echo 'selected'; ?> value="default"> Default</option>
					<option <?php $sp= $this->samodel->getSelectedPreferenceName(); if($sp == 'custom') echo 'selected'; ?> value="custom"> Custom</option>
				</select>
			</div>
		</form>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-bordered">
			<tr>
				<th>Preference</th>
				<th>Min Notice Show Time(sec)</th>
				<th>Notice Image Show Time(sec)</th>
				<th>Notice Reload Time(sec)</th>
				<th>Active</th>
			</tr>
			<tr>
				<td> Default</td>
				<td><?php $ss= $this->samodel->getSystemSettings();echo $ss['default'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_SHOW_TIME]?></td>
				<td><?php $ss= $this->samodel->getSystemSettings();echo $ss['default'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_IMAGE_SHOW_TIME]?></td>
				<td><?php $ss= $this->samodel->getSystemSettings();echo $ss['default'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICES_RELOAD_TIME]?></td>
				<td><?php $ss= $this->samodel->getSystemSettings();echo $ss['default'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_ACTIVE]?></td>
			</tr>
			<tr>
				<td>Custom</td>
				<td><?php $ss= $this->samodel->getSystemSettings();echo $ss['custom'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_SHOW_TIME]?></td>
				<td><?php $ss= $this->samodel->getSystemSettings();echo $ss['custom'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_IMAGE_SHOW_TIME]?></td>
				<td><?php $ss= $this->samodel->getSystemSettings();echo $ss['custom'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICES_RELOAD_TIME]?></td>
				<td><?php $ss= $this->samodel->getSystemSettings();echo $ss['custom'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_ACTIVE]?></td>
			</tr>
		</table>
	</div>
	<div class=" panel-footer">
		<!--form to add new display setting-->
		<?php echo validation_errors(); ?>
		<?php echo form_open('System_Admin/editCustomPreference',array('name'=>'assForm','class'=>'form-inline')); ?>
		<div class="input-group">
			<input name ="nst" type="number" class="form-control" minlength="0" placeholder="Notice Show Time (sec)" value="<?php $ss= $this->samodel->getSystemSettings();echo $ss['custom'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_SHOW_TIME]?>">
		</div>
		<div class="input-group">
			<input name ="nist" type="number" class="form-control" minlength="0" placeholder="Notice Image Show Time (sec)" value="<?php $ss= $this->samodel->getSystemSettings();echo $ss['custom'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICE_IMAGE_SHOW_TIME]?>">
		</div>
		<div class="input-group">
			<input name ="nrt" type="number" class="form-control" minlength="0" placeholder="Notices Reload Time (sec)" value="<?php $ss= $this->samodel->getSystemSettings();echo $ss['custom'][EnbConstants::$ENB_DATABASE_TABLE_SYSTEM_SETTING_COLUMN_NOTICES_RELOAD_TIME]?>">
		</div>
		<button type="submit" class="btn btn-warning"  ><span class="glyphicon glyphicon-edit" ></span> Edit Custom Preference</button>

		</form>
	</div>
</div> <!-- panel ends-->

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
				<?php echo form_open('System_Admin/changePassword','name="cpwForm"'); ?>
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

<!-- modal for adding new user-->
<div id="myModalAU" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add <span id="loginStatus"><small> - New User.</small></span> </h4>
			</div>
			<div class="modal-body">
				<?php echo validation_errors(); ?>
				<?php echo form_open('System_Admin/addNewUser','name="auForm"'); ?>
				<div class="input-group">
					<span class="input-group-addon">First Name</span>
					<input name ="fname" type="text" class="form-control" placeholder="">
				</div><br>

				<div class="input-group">
					<span class="input-group-addon">Last Name</span>
					<input name ="lname" type="text" class="form-control">
				</div><br>
				<div class="input-group">
					<span class="input-group-addon">User Name</span>
					<input name ="uname" type="text" class="form-control">
				</div><br>
				<div class="input-group">
					<span class="input-group-addon">Role</span>
					<select name ="role"  class="form-control">
						<option > <?php echo EnbConstants::$ENB_USER_ROLE_NOTICE_MANAGER?></option>
						<option <?php if($this->session->userdata('username') != 'root') echo 'hidden disabled'?> > <?php echo EnbConstants::$ENB_USER_ROLE_SYSTEM_ADMIN?></option>
					</select>
				</div>

				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default" onclick="document.auForm.submit()"> OK</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div><!--document.getElementById('radioHasStreamId')-->
</div>
