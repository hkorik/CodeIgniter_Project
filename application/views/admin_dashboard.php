	<div id="admin_dashboard">
		<h3 class="float_left">Manage Users</h3>
		<a class="btn blue btn-default float_right" href="/ci/user/new_user">Add new</a>
		<table class="table table-striped table-bordered">
			<thead class="dark_grey">
				<th>ID</th>
				<th>Name</th>
				<th>email</th>
				<th>created_at</th>
				<th>user_level</th>
				<th>actions</th>
			</thead>
			<tbody>
				<?php

					foreach ($user_rows as $row) 
					{
						echo "<tr>";

							echo "<td>{$row['id']}</td>";
							echo "<td>{$row['first_name']} {$row['last_name']}</td>";
							echo "<td>{$row['email']}</td>";
							echo "<td>{$row['created_at']}</td>";
							if($row['user_level'] != '9')
							{
								$row['user_level'] = 'normal';
								echo "<td>{$row['user_level']}</td>";
							}
							else
							{
								$row['user_level'] = 'admin';
								echo "<td>{$row['user_level']}</td>";
							}
							echo "<td class='last_td'><a href='/ci/user/edit_user'>edit</a><a href=''>remove</a></td>";

						echo "</tr>";
					}


				?>
					
			</tbody>
		</table>
	</div>
</body>
</html>