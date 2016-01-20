<?php
	$error_type = isset($_GET["type"]) ? $_GET["type"] : "";
	if($error_type == "") {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	$error_types = array("403", "404", "409", "500", "503");
	if(!in_array($error_type, $error_types)) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | <?php echo $error_type; ?></title>
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
				include($_SERVER["DOCUMENT_ROOT"] . "/../includes/error.$error_type.php");
			?>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>