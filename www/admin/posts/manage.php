<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(!is_admin_user()) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	$id = isset($_GET["id"]) ? $_GET["id"] : null;
	if($id === null) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	$post = get_single_post($id);
	if($post === null) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | Admin - Manage Post</title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3><?php echo $post["title"]; ?></h3>
			<div>
				<a href="#" class="error admin-action" data-request-type="POST" data-url="/admin/posts/delete.php" data-id="<?php echo $id; ?>" 
					data-desc="permanently delete this post from the database">Delete</a> |
				<a href="/admin/posts/edit/<?php echo $post["id"]; ?>">Edit</a>
			</div>
			<hr/>
			<?php echo $post["text"]; ?>
			<hr/>
			<?php
				echo "<span class='post-details'>Posted by " . $post["author"] . ", <span class='date'>" . $post["date"] . "</span></span>";
			?>
			<hr/>
			<a class="small" href="/admin/posts">Back to posts index</a>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>