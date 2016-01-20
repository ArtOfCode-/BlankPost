<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(!is_manager()) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | Admin - Users</title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3>User Management</h3>
			<a class="error admin-action" href="#" data-url="/admin/users/delete_all.php" data-request-type="POST" 
				data-desc="permanently delete all users and reset the database table (TRUNCATE)">Delete All</a> | 
			<a href="/admin/users/new">New</a>
			<hr/>
			<table class="sorted">
				<thead><tr>
					<td>User ID</td>
					<td>Username</td>
					<td>Email</td>
					<td>Auth Level</td>
				</tr></thead>
				<tbody>
					
				</tbody>
			</table>
			<br/><hr/><br/>
			<p><strong>A word on Auth Levels and user types</strong></p>
			<p>There are several types of user, all represented by a different Auth Level. The database type for an Auth Level is TINYINT(2), so no A.L. can be 
			over 99.</p>
			<p>The first type of user is a basic user. This is a user with an A.L. of 1 or 2, 1 being the default assigned when a user signs up. I have debated 
			adding a slightly raised user type at level 2. These users have accounts, but no access to the admin controls.</p>
			<p>Above that is an Editor, represented by an A.L. of between 3 and 10 inclusive. These users will have a link to the admin controls, and will be able
			to create and manage posts. <strong>Remember - this includes the <span class="error">Delete All</span> button.</strong></p>
			<p>Next level is a Manager, with an A.L. of between 11 and 20 inclusive. These users have everything an Editor has, <b>plus</b> they can manage and 
			create users. Again, remember that includes the <strong><span class="error">Delete All</span></strong> button for users <em>and</em> posts. Managers
            can also manage blocking and unblocking users by IP address.</p>
			<p>Finally, we have an Owner. These users have an A.L. of anything between 21 and 99 inclusive, and have full access to all the tools the site provides.
			That means they have all the tools a Manager has, and they can edit the site configuration.</p>
			<p><strong>Be careful - trust anyone you give power to.</strong></p>
		</div>
	</div>
	
	<script>
		var data = [
			<?php
				// What a horrible piece of code this is. Yes, I'm writing JavaScript in PHP.
				$users = array_reverse(get_paginated_users($page, 1000000), true);
				foreach($users as $user) {
					echo "[";
					echo '"' . str_replace('"', "'", $user["id"]) . '",';
					echo '"' . str_replace('"', "'", "<a href='/admin/users/manage/" . $user["id"] . "'>" . $user["name"] . "</a>") . '",';
					echo '"' . str_replace('"', "'", $user["email"]) . '",';
					echo '"' . str_replace('"', "'", $user["auth_level"]) . '",';
					echo "],";
				}
			?>
		];
	</script>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>