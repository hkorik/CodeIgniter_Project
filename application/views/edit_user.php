		<div id="edit_info" class="float_left">	
			<h2>Edit user #1</h2>
			<form action="/ci/user/process_edit_user_info" method="post">
			  <fieldset class="border">
			  	<legend>Edit Information</legend>
			    <div class="form-group<?php if(!empty($edit_errors['email'])) echo ' field_block'; ?>">
			      <label for="email">Email address:</label>
			      <?php if(!empty($edit_errors['email'])){ echo "{$edit_errors['email']}"; } ?>
			      <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
			    </div>
		        <div class="form-group<?php if(!empty($edit_errors['first_name'])) echo ' field_block'; ?>">
			      <label for="first_name">First Name:</label>
			      <?php if(!empty($edit_errors['first_name'])){ echo "{$edit_errors['first_name']}"; } ?>
			      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name">
			    </div>
		        <div class="form-group<?php if(!empty($edit_errors['last_name'])) echo ' field_block'; ?>">
			      <label for="last_name">Last Name:</label>
			      <?php if(!empty($edit_errors['last_name'])){ echo "{$edit_errors['last_name']}"; } ?>
			      <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name">
			    </div>
			     <div class="form-group">
			     	User Level:
			       <select class="form-control">
					  <option>Normal</option>
					  <option>Admin</option>
					</select>
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Save">
			  </fieldset>
			</form>
		</div>
		<div id="edit_user_pw" class="float_right">
			<a class="btn blue btn-default float_right" href="<?php echo $dashboard_link ?>">Return to Dashboard</a>
			<form action="/ci/user/process_edit_user_pw" method="post">
			  <fieldset class="border float_right">
			  	<legend>Change Password</legend>
			    <div class="form-group<?php if(!empty($edit_errors['password'])) echo ' field_block'; ?>">
			      <label for="password">Password:</label>
			      <?php if(!empty($edit_errors['password'])){ echo "{$edit_errors['password']}"; } ?>
			      <input type="text" class="form-control" name="password" id="password" placeholder="Enter email">
			    </div>
		        <div class="form-group<?php if(!empty($edit_errors['confirm_password'])) echo ' field_block'; ?>">
			      <label for="confirm_password">Confirm Password:</label>
			      <?php if(!empty($edit_errors['confirm_password'])){ echo "{$edit_errors['confirm_password']}"; } ?>
			      <input type="text" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter First Name">
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Update Password">
			  </fieldset>
			</form>
		</div>
	</div>
</body>
</html>