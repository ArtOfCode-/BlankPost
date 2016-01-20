<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(!is_admin_user()) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | Admin - Posts</title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3>Posts on the Site</h3>
			<a class="error admin-action" href="#" data-url="/admin/posts/delete_all.php" data-request-type="POST" 
				data-desc="permanently delete all posts and reset the database table (TRUNCATE)">Delete All</a> | 
			<a href="/admin/posts/new">New</a>
			<hr/>
			<table class="sorted">
				<thead><tr>
					<td>Post ID</td>
					<td>Title</td>
					<td>Author</td>
					<td>Date</td>
				</tr></thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>
	
	<script>
		var data = [
			<?php
				// What a horrible piece of code this is. Yes, I'm writing JavaScript in PHP.
				$posts = array_reverse(get_paginated_posts($page, 1000000), true);
				foreach($posts as $post) {
					echo "[";
					echo '"' . str_replace('"', "'", $post["id"]) . '",';
					echo '"' . str_replace('"', "'", "<a href='/admin/posts/manage/" . $post["id"] . "'>" . $post["title"] . "</a>") . '",';
					echo '"' . str_replace('"', "'", $post["author"]) . '",';
					echo '"' . str_replace('"', "'", $post["date"]) . '",';
					echo "],";
				}
			?>
		];
	</script>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>