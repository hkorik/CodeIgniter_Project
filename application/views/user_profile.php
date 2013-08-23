		<div id="user_profile">
			<h3>Michoel Choi</h3>
			<ul>
				<li>Registered at: <?php  ?></li>
				<li>User ID: <?php  ?></li>
				<li>Email address: <?php  ?></li>
				<li>Description: <?php  ?></li>
			</ul>
			<div id="post_message">
				<!-- post message -->
				<form action="process.php" method="post">
					<h3>Post a message</h3>
					<input type="hidden" name="action" value="user_message" />
					<textarea name="message" id="message" rows=3 cols=140></textarea>
					<input class="btn green btn-default float_right" type="submit" value="Post" id="message_button"/>
				</form>
				<!-- display message -->
				<div class="clear"></div>
				<h4 class="float_left">Michael Choi wrote</h4>
				<p class="date float_right">January 5th 2013</p>
				<div class="clear" id="message_post">This is my message!<br/><br/></div>
			</div>
			<div id="post_comment" class="float_right">
				<!-- display comment -->
				<div class="clear"></div>
				<h4 class="float_left">Michael Choi wrote</h4>
				<p class="date float_right">January 5th 2013</p>
				<div class="clear float_right" id="comment_post">This is my comment!<br/><br/></div>
				<!-- post comment -->
				<form action="process.php" method="post">
					<input type="hidden" name="action" value="user_message" />
					<textarea class="float_right" name="message" id="comment" rows=3 cols=120></textarea>
					<input class="clear float_right btn green btn-default" type="submit" value="Post" id="message_button"/>
				</form>
			</div>
			<?php
				//var_dump($the_messages);
				if(isset($the_messages))
				{
					foreach ($the_messages as $message) 
					{
						echo "<h3>{$message['first_name']} {$message['last_name']} -  {$message['created_at']}</h3>";
						echo "<p class='messages'>{$message['message']}</p></br />";

						$comments = get_comments($message['id']);

						foreach ($comments as $comment) 
						{
							echo "<h3 id='comment_name'>{$comment['first_name']} {$comment['last_name']} -  {$comment['created_at']}</h3>";
							echo "<p id='comments'>{$comment['comment']}</p></br />";
						}
						
						echo "<form action='process.php' method='post' id='comment_form'>
							<h2>Post a comment</h2>
							<input type='hidden' name='action' value='comment' />
							<input type='hidden' name='message_id' value='{$message['id']}' />
							<textarea name='comment' id='comment' rows=5 cols=73></textarea>
							<input class='float_right' type='submit' value='Post a comment' id='comment_button' />
						</form><br/>";
					}
				}
				
			?>	
		</div>
	</div>
</body>
</html>