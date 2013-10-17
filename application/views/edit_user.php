		<div id="edit_info" class="float_left">	
			<h2>Edit user <?php if(!empty($edit_users_info->id)){ echo $edit_users_info->id; } ?></h2>
			<div id="success_message"><?php if(!empty($update_success['info_message'])){ echo "<p class='success_message'>{$update_success['info_message']}</p>"; } ?></div>
			<div id="success_message"><?php if(!empty($update_success['pw_message'])){ echo "<p class='success_message'>{$update_success['pw_message']}</p>"; } ?></div>
			<form action="/ci/user/process_edit_user_info" method="post">
			  <input type="hidden" name="id" value="<?php if(!empty($edit_users_info->id)){ echo $edit_users_info->id; } ?>">
			  <fieldset class="border">
			  	<legend>Edit Information</legend>
			    <div class="form-group<?php if(!empty($edit_errors['email'])) echo ' field_block'; ?>">
			      <label for="email">Email address:</label>
			      <?php if(!empty($edit_errors['email'])){ echo "{$edit_errors['email']}"; } ?>
			      <input type="text" class="form-control" name="email" id="email" placeholder="<?php if(!empty($edit_users_info->email)){ echo $edit_users_info->email; } ?>">
			    </div>
		        <div class="form-group<?php if(!empty($edit_errors['first_name'])) echo ' field_block'; ?>">
			      <label for="first_name">First Name:</label>
			      <?php if(!empty($edit_errors['first_name'])){ echo "{$edit_errors['first_name']}"; } ?>
			      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php if(!empty($edit_users_info->first_name)){ echo $edit_users_info->first_name; } ?>">
			    </div>
		        <div class="form-group<?php if(!empty($edit_errors['last_name'])) echo ' field_block'; ?>">
			      <label for="last_name">Last Name:</label>
			      <?php if(!empty($edit_errors['last_name'])){ echo "{$edit_errors['last_name']}"; } ?>
			      <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php if(!empty($edit_users_info->last_name)){ echo $edit_users_info->last_name; } ?>">
			    </div>
			    <div class="form-group">
			     	User Level:
			        <select name="user_level" class="form-control">
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
			  <input type="hidden" name="id" value="<?php if(!empty($edit_users_info->id)){ echo $edit_users_info->id; } ?>">
			  <fieldset class="border float_right">
			  	<legend>Change Password</legend>
			    <div class="form-group<?php if(!empty($edit_errors['password'])) echo ' field_block'; ?>">
			      <label for="password">Password:</label>
			      <?php if(!empty($edit_errors['password'])){ echo "{$edit_errors['password']}"; } ?>
			      <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
			    </div>
		        <div class="form-group<?php if(!empty($edit_errors['confirm_password'])) echo ' field_block'; ?>">
			      <label for="confirm_password">Confirm Password:</label>
			      <?php if(!empty($edit_errors['confirm_password'])){ echo "{$edit_errors['confirm_password']}"; } ?>
			      <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Update Password">
			  </fieldset>
			</form>
		</div>
	</div>
</body>
</html>