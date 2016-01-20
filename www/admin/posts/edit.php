<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(!is_admin_user()) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	$id = isset($_GET["id"]) ? $_GET["id"] : (isset($_POST["post-id"]) ? $_POST["post-id"] : null);
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
			<h3>Editing post #<?php echo $id; ?></h3>
			<?php
				if(!isset($_POST["edit-submit"])) {
					?>
					<form id="edit-form" name="edit-form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
						<input type="hidden" name="post-id" value="<?php echo $id; ?>" />
						<input type="text" name="title" class="heading-input" value="<?php echo $post["title"]; ?>" /><br/>
						<hr/>
						<textarea id="post-body" name="post-body" rows="10" cols="100"><?php echo $post["text"]; ?></textarea><br/><br/>
						<input type="submit" name="edit-submit" value="Update" />
					</form>
					<?php
				}
				else {
					if(is_admin_user()) {
						$conn = get_db();
						$title = mysqli_real_escape_string($conn, $_POST["title"]);
						$body = mysqli_real_escape_string($conn, $_POST["post-body"]);
						$id = mysqli_real_escape_string($conn, $_POST["post-id"]);
						if($result = mysqli_query($conn, "UPDATE `Posts` SET `PostTitle` = '$title', `PostBody` = '$body' WHERE `PostId` = $id;")) {
							$post = get_single_post($id);
							?>
							<p>Success! The post has been updated.</p>
							<form id="edit-form" name="edit-form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
								<input type="hidden" name="post-id" value="<?php echo $id; ?>" />
								<input type="text" name="title" class="heading-input" value="<?php echo $post["title"]; ?>" /><br/>
								<hr/>
								<textarea id="post-body" name="post-body" rows="10" cols="100"><?php echo $post["text"]; ?></textarea><br/><br/>
								<input type="submit" name="edit-submit" value="Update" />
							</form>
							<?php
						}
						else {
							write_log("mysqli", "/admin/posts/edit/{x}: Update query failed with MySQL error #" . mysqli_errno($conn) . ", '" . mysqli_error($conn) . "'.");
							?>
							<p><span class="error">The post was not updated due to a database error.</span></p>
							<form id="edit-form" name="edit-form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
								<input type="hidden" name="post-id" value="<?php echo $id; ?>" />
								<input type="text" name="title" class="heading-input" value="<?php echo $post["title"]; ?>" /><br/>
								<hr/>
								<textarea id="post-body" name="post-body" rows="10" cols="100"><?php echo $post["text"]; ?></textarea><br/><br/>
								<input type="submit" name="edit-submit" value="Update" />
							</form>
							<?php
						}
					}
				}
			?>
			<hr/>
			<a class="small" href="/admin/posts">Back to posts index</a>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
	<script src="/res/js/markdown.js"></script>
	<script>
		$(function() {
			$("#edit-form").on("submit", function(e) {
				if(!$(this).data("converted")) {
					e.preventDefault();
					var converter = new Showdown.converter();
					try {
						var converted = converter.makeHtml($("#post-body").val());
						console.log(converted);
						$("#post-body").val(converted);
						$(this).data("converted", "true");
						$("#edit-form").trigger("submit");
					}
					catch(e) {
						$("#edit-form").before("<span class='error'>Could not convert your post from Markdown.</span>");
					}
				}
			});
		});
	</script>
</body>
</html>