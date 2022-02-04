





	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="panel panel-default">
				 <div class="panel-heading">
					<div class="panel-title">
						Login
					</div>
				 </div>
				 <div class="panel-body">
					<?php echo validation_errors(); ?>
					<?php echo form_open('login/submit','id="loginForm"'); ?>
						<div class="input-group">
							 <span class="input-group-addon">Username</span>
							 <input id ="uName" name="username" type="text" class="form-control" value="<?php echo set_value('username'); ?>" placeholder="">
					   </div><br>

					   <div class="input-group">
						 <span class="input-group-addon">Password</span>
						 <input id ="pWord" name="password" type="password" class="form-control">
					   </div><br>
					   <button type="submit" class="btn btn-default"  >Login</button>
					</form>
				 </div>
			</div>
		</div>
		<div class="col-md-3"></div>
	 </div>

