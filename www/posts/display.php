<?php
	$post_id = isset($_GET["id"]) ? $_GET["id"] : "";
	if($post_id == "") {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	$post = get_single_post($post_id);
	if($post === null) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | <?php echo $post["title"]; ?></title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<div id="article-container" itemscope itemtype="http://schema.org/Article" data-post-id="<?php echo $post_id; ?>">
				<?php
					echo "<h3><a itemprop='url' href='/posts/" . $post["id"] . "'><span itemprop='name'><span itemprop='headline'>" . $post["title"] . "</span></span></a></h3>";
					echo "<span itemprop='articleBody'>" . $post["text"] . "</span>";
					echo "<hr/>";
					echo "<span class='post-details'>Posted by <span itemprop='author' itemscope itemtype='http://schema.org/Person'><span itemprop='name'>" . $post["author"] . "</span></span>, <span itemprop='datePublished' content='" . $post["date"] . "' class='date'>" . $post["date"] . "</span></span>";
					echo "<span itemprop='image' content='" . "http://" . $_SERVER["SERVER_NAME"] . get_config_value("site", "avatar_path") . "'></span>";
				?>
			</div>
			<br/>
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.comments.php"); ?>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>