<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(!is_admin_user()) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | Admin</title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3>Welcome, <?php echo $_SESSION["UserName"]; ?></h3>
			<h4>What would you like to do now?</h4>
			<ul>
				<?php if(is_editor()) { ?>
				<li><a href="/admin/posts">Manage posts</a></li>
				<li><a href="/admin/posts/new">Create a new post</a></li>
				<?php } if(is_manager()) { ?>
				<li><a href="/admin/users">Manage users</a></li>
				<li><a href="/admin/users/new">Create a new user</a></li>
                <li><a href="/admin/users/block">Block users</a></li>
                <li><a href="/admin/users/unblock">Unblock users</a></li>
				<?php } if(is_owner()) { ?>
				<li><a href="/admin/config">Control site configuration</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>