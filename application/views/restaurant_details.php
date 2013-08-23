<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="restaurants, finder, good food" />
	<meta name="description" content="Find the restaurant best catered to your needs, in a fast way!" />
	<title><?php echo $title ?></title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-wip/css/bootstrap.min.css">	
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc2/css/bootstrap-glyphicons.css">
	<link rel="stylesheet" type="text/css" href="/ci/assets/css/styles.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="/ci/assets/js/cycle.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			
			$('#user_form').submit(function(){
                var form = $(this);
                $.post(
                    form.attr('action'),
                    form.serialize(),
                    function(data){
                        $('#users_list').html(data);
                    },
                     'json');
               return false;
            });

		});
	</script>
</head>
<body class="shattered_background">
<div id="wrapper_restaurant">
  	<div id="left_details" class="float_left">
  		<!-- Restaurant detailed page - left restaurant details - top section -->
	  	<div id="restaurant_details" class="float_left">
	  		<?php

	  			echo $detailed;

	  		?>
	  	</div>
	  	<div class="modal fade" id="rate">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">360 Restaurant & Lounge</h4>
		      </div>
		      <div class="modal-body" id="ratings">
		        <ul>
		  			<li>Service: <span class="glyphicon glyphicon-star"></span></li>
		  			<li>Ambiance: <span class="glyphicon glyphicon-star"></span></li>
		  			<li>Food Quality: <span class="glyphicon glyphicon-star"></span></li>
		  			<li>Affordability: <span class="stars glyphicon glyphicon-star"></span></li>
		  		</ul>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default float_left" data-dismiss="modal">Close</button>
		        <form action="" method="post">
		        	<div class="input-group col-lg-4 float_left">
					  <span class="input-group-addon required"></span>
					  <input type="text" class="form-control input-sm" placeholder="Name">
					</div>
					<div class="input-group col-lg-4">
					  <span class="input-group-addon required"></span>
					  <input type="email" class="form-control input-sm" placeholder="Email">
					</div>
					<input class="btn btn-primary" type="submit" name="rating" value="RATE">
				</form>
		      </div>
		    </div><!-- end of modal-content -->
		  </div><!-- end of modal-dialog -->
		</div><!-- end of modal -->
		<h3 class="clear float_left">Reviews</h3>
	  	<!-- Restaurant detailed page - left restaurant details - rating section -->
	  	<div id="reviews" class="clear float_left">	
	  		<ul>
	  			<li>Category: <a href="#">Italian</a></li>
	  			<li>Service: <span class="glyphicon glyphicon-star"></span></li>
	  			<li>Ambiance: <span class="glyphicon glyphicon-star"></span></li>
	  			<li>Food Quality: <span class="glyphicon glyphicon-star"></span></li>
	  			<li>Affordability: <span class="stars glyphicon glyphicon-star"></span></li>
	  		</ul>
	  		<h3>Share your thoughts/comments</h3>
	  		<form class="rate_form">
	  			<div class="input-group col-lg-4 float_left">
				  <span class="input-group-addon required"></span>
				  <input type="text" class="form-control input-sm" placeholder="Name">
				</div>
				<div class="input-group col-lg-4 float_left clear">
				  <span class="input-group-addon required"></span>
				  <input type="email" class="form-control input-sm" placeholder="Email">
				</div>
				<div class="input-group col-lg-4 float_left clear">
					<label>Title:<input type="text" class="input-sm title" name="title"></label>
				</div>
				<textarea class="float_left clear" id="comment" cols="80" rows="4" placeholder="Write a comment"></textarea>
				<input class="float_left clear btn btn-success" id="button" type="submit" name="comment" value="Post a comment">
	  		</form>
	  	</div>
	  	<!-- Restaurant detailed page - left restaurant details - display comment section -->
		<div id="comments" class="clear float_left">		
			<div class="comment">
				<p>Hershy Korik</p>
				<p><a href="">email@email.com</a></p>
				<p>So this will be the place for the comments. It will look like this, or something like this. So I hope this is enough text to fill in the space to be able to work with it.</p>
			</div>
			<div class="comment">
				<p>Hershy Korik</p>
				<p><a href="">email@email.com</a></p>
				<p>So this will be the place for the comments. It will look like this, or something like this. So I hope this is enough text to fill in the space to be able to work with it.</p>
			</div>
		</div><!-- end of comments -->
	</div><!-- end of left side details -->
	<!-- Restaurant detailed page - similar restaurants info -->
  	<div id="right_list" class="float_right">
  		<div id="search_bar">
  			<form id="form" action="" method="post">
				<input class="clear_left text_field" type="search" results="0" name="restaurant name" placeholder="Search">
				<div id="checkbox" class="checkbox-inline">
					<label class="checkbox-inline checkbox float_left" id="affordability"><input type="checkbox" class="big-checkbox" id="affordability" name="1" value="checked"> Affordability</label>
					<label class="checkbox-inline checkbox float_left" id="ambiance"><input type="checkbox" class="big-checkbox" id="ambiance" name="2" value="checked"> Ambiance</label>
					<label class="checkbox-inline checkbox float_left" id="quality"><input type="checkbox" class="big-checkbox" id="quality" name="3" value="checked"> Food Quality</label>
					<label class="checkbox-inline checkbox float_left" id="service"><input type="checkbox" class="big-checkbox" id="service" name="4" value="checked"> Service</label>
				</div>	
			</form>
  		</div>
		<?php

			echo $list;

		?>
	</div><!-- end of right_list div-->
	<div class="clear"></div>
  </div><!-- end of wrapper div -->
</body>
</html>