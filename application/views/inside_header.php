<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<link rel="stylesheet" type="text/css" href="/ci/assets/css/styles.css" />
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" />
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		
    		$('.delete').submit(function(){
    			var name = $(this).find('input[name="name"]').val();
    			var delete_confirm = confirm("Are you sure you would like to delete " + name + " from the system?");
    			if(delete_confirm == true)
				{
				  // continue with the delete
				}
				else
				{
					return false; //cancel delete function
				}
			});  		
    	});
    </script>
</head>
<body>
	<div id="wrapper">
		<div class="navbar">
		  <p class="navbar-text float_left">Test App</p>
		  <a class="navbar-brand" href="<?php echo $dashboard_link ?>">Dashboard</a>
		  <a href="/ci/users/edit" class="navbar-brand">Profile</a>
		  <a href="/ci/user/log_off" class="navbar-brand pull-right">Log off</a>
		</div>