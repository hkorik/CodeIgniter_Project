		<div class="outside_form">	
			<h2>Sign in</h2>
			<form action="/ci/user/process_signin" method="post">
			  <fieldset>
			    <div class="form-group<?php if(!empty($signin_errors['email'])) echo ' field_block'; ?>">
			      <?php if(!empty($signin_errors['signin_error'])){ echo "<p>{$signin_errors['signin_error']}</p>"; } ?>
			      <label for="email">Email address:</label>
			      <?php if(!empty($signin_errors['email'])){ echo "{$signin_errors['email']}"; } ?>
			      <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
			    </div>
			    <div class="form-group<?php if(!empty($signin_errors['password'])) echo ' field_block'; ?>">
			      <label for="password">Password:</label>
			      <?php if(!empty($signin_errors['password'])){ echo "{$signin_errors['password']}"; } ?>
			      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
			    </div>
			    <input class="btn green btn-default float_right" type="submit" value="Sign In">
			  </fieldset>
			</form>
			<a class="float_right" href="/ci/user/register">Don't have an account? Register.</a>
		</div>	
	</div>
</body>
</html>