<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Log in - Registration Page</title>
	<link rel="stylesheet" type="text/css" href="/ci/assets/css/styles.css" />
</head>
<body>
	<div id="wrapper">
		<h1>Log in and Registration Page</h1>
		<!-- Registration left box -->
		<div id="registration_box" class="float_left">
			<h2>Register</h2>
			<form action="/ci/login/process_registration" method="post">
				<div class="<?php if(!empty($register['first_name'])) echo 'field_block'; ?>">
					<label for="first_name">First Name *</label><br/>
					<?php if(!empty($register['first_name'])){ echo "<p class='error_message'>{$register['first_name']}</p>"; } ?>
					<input type="text" name="first_name" id="first_name" placeholder="First Name" />
				</div>
				<div class="<?php if(!empty($register['last_name'])) echo 'field_block'; ?>">
					<label for="last_name">Last Name *</label><br/>
					<?php if(!empty($register['last_name'])){ echo "<p class='error_message'>{$register['last_name']}</p>"; } ?>
					<input type="text" name="last_name" id="last_name"placeholder="Last Name" />
				</div>
				<div class="<?php if(!empty($register['email'])) echo 'field_block'; ?>">
					<label for="email">Email Address *</label><br/>
					<?php if(!empty($register['email'])){ echo "<p class='error_message'>{$register['email']}</p>"; } ?>
					<input type="text" name="email" id="email" placeholder="Email" />
				</div>	
				<div class="<?php if(!empty($register['password'])) echo 'field_block'; ?>">
					<label for="password">Password *</label><br/>
					<?php if(!empty($register['password'])){ echo "<p class='error_message'>{$register['password']}</p>"; } ?>
					<input type="password" name="password" id="password" placeholder="Password" />
				</div>
				<div class="<?php if(!empty($register['confirm_password'])) echo 'field_block'; ?>">
					<label for="confirm_password">Confirm Password *</label><br/>
					<?php if(!empty($register['confirm_password'])){ echo "<p class='error_message'>{$register['confirm_password']}</p>"; } ?>
					<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" />
				</div>
				<input type="submit" value="Register" />
			</form>
		</div>
		<!-- Login right box -->
		<div id="login_box" class="float_right">
			<h2>Login</h2>
			<?php 
				if(!empty($login['login_error']))
				{
					echo "<p class='error_message'>{$login['login_error']}</p>";
				}	
			?>
			<form action="/ci/login/process_login" method="post">
				<div class="<?php if(!empty($login['email'])) echo 'field_block'; ?>">
					<label for="email">Email *</label><br/>
					<?php if(!empty($login['email'])){ echo "<p class='error_message'>{$login['email']}</p>"; } ?>
					<input type="text" name="email" id="email" placeholder="Email" />
				</div>
				<div class="<?php if(!empty($login['password'])) echo 'field_block'; ?>">
					<label for="password">Password *</label><br/>
					<?php if(!empty($login['password'])){ echo "<p class='error_message'>{$login['password']}</p>"; } ?>
					<input type="password" name="password" id="password" placeholder="Password" />
				</div>
				<input type="submit" value="Login" />
			</form>
		</div>
	</div>
</body>
</html>