<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?></title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<?php
				$posts = get_homepage_posts();
				foreach($posts as $post) {
					echo "<h3><a href='/posts/" . $post["id"] . "'>" . $post["title"] . "</a></h3>";
					echo strlen($post["text"]) < 1000 ? $post["text"] : substr($post["text"], 0, 1000) . "... "
						. "<a href='/posts/" . $post["id"] . "'>Read More</a>";
					echo "<hr/>";
					echo "<span class='post-details'>Posted by " . $post["author"] . ", <span class='date'>" . $post["date"] . "</span></span>";
				}
			?>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>