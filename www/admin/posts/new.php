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
			<h3>Write a new post</h3>
			<?php
				if(!isset($_POST["new-submit"])) {
					?>
					<form id="new-form" name="new-post-form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
						<input type="text" name="title" class="heading-input" /><br/>
						<hr/>
						<textarea id="post-body" name="post-body" rows="10" cols="100"></textarea><br/><br/>
						<input id="form-submit" type="submit" name="new-submit" value="Create" />
					</form>
					<?php
				}
				else {
					if(is_admin_user()) {
						$conn = get_db();
						$title = mysqli_real_escape_string($conn, $_POST["title"]);
						$body = mysqli_real_escape_string($conn, $_POST["post-body"]);
						$user = get_username();
						$sql = "INSERT INTO `Posts` VALUES (DEFAULT, '$title', '$body', DEFAULT, '$user', 1, NULL);";
						if($result = mysqli_query($conn, $sql)) {
							?>
							<p>Success! The post has been created.</p>
							<form id="new-form" name="new-post-form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
								<input type="text" name="title" class="heading-input" /><br/>
								<hr/>
								<textarea id="post-body" name="post-body" rows="10" cols="100"></textarea><br/><br/>
								<input id="form-submit" type="submit" name="new-submit" value="Create" />
							</form>
							<?php
						}
						else {
							write_log("mysqli", "/admin/posts/new: Insert query failed with MySQL error #" . mysqli_errno($conn) . ", '" . mysqli_error($conn) . "'.\r\nQuery string: " . $sql);
							?>
							<p><span class="error">The post was not created due to a database error.</span></p>
							<form id="new-form" name="new-post-form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
								<input type="text" name="title" class="heading-input" /><br/>
								<hr/>
								<textarea id="post-body" name="post-body" rows="10" cols="100"></textarea><br/><br/>
								<input id="form-submit" type="submit" name="new-submit" value="Create" />
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
			$("#new-form").on("submit", function(e) {
				if(!$(this).data("converted")) {
					e.preventDefault();
					var converter = new Showdown.converter();
					try {
						var converted = converter.makeHtml($("#post-body").val());
						console.log(converted);
						$("#post-body").val(converted);
						$(this).data("converted", "true");
						$("#new-form").trigger("submit");
					}
					catch(e) {
						$("#new-form").before("<span class='error'>Could not convert your post from Markdown.</span>");
					}
				}
			});
		});
	</script>
</body>
</html>