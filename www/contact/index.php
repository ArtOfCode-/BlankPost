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
			<h3>Get in touch</h3>
			<p>You can get in touch with me in a number of ways and places. In order of preference:
			<ul>
				<li>Send me an email: <a href="mailto:hello@artofcode.co.uk">hello@artofcode.co.uk</a></li>
				<li>Jump into a <a href="http://chat.stackexchange.com/">Stack Exchange chatroom</a></li>
				<li>You can probably find another email address from <a href="https://github.com/ArtOfCode-">GitHub</a>, if you know where to look</li>
			</ul></p>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>