		<div id="edit_profile" class="float_left">	
			<h2>Edit Profile</h2>
			<div id="success_message"><?php if(!empty($update_success['info_message'])){ echo "<p class='success_message'>{$update_success['info_message']}</p>"; } ?></div>
			<form action="/ci/user/process_edit_profile_info" method="post">
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
			    <input class="btn green btn-default float_right" type="submit" value="Save">
			  </fieldset>
			</form>
		</div>
		<div id="edit_profile_pw" class="float_right">
			<div id="success_message"><?php if(!empty($update_success['pw_message'])){ echo "<p class='success_message'>{$update_success['pw_message']}</p>"; } ?></div>
			<form action="/ci/user/process_edit_profile_pw" method="post">
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
			      <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter Confirm password">
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Update Password">
			  </fieldset>
			</form>
		</div>
		<div id="description" class="clear">
			<div id="success_message"><?php if(!empty($update_success['description_message'])){ echo "<p class='success_message'>{$update_success['description_message']}</p>"; } ?></div>
			<form action="/ci/user/process_edit_profile_description" method="post">
			  <fieldset class="border">
			  	<legend>Edit Description</legend>
			  	<div class="<?php if(!empty($edit_errors['description'])) echo ' description_field_block'; ?>">
					<?php if(!empty($edit_errors['description'])){ echo "{$edit_errors['description']}"; } ?>
					<textarea class="float_right" name="description" id="description_text" rows=4 cols=130></textarea>
				</div>
					<input class="clear float_right btn green btn-default" type="submit" value="Save" id="description_button"/>
			  </fieldset>
			</form>
		</div>
	</div>
</body>
</html>