<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(!is_owner()) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | Admin - Configuration</title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3>Site Configuration</h3>
			<p>Below is the site configuration file. You can freely edit this to change things about the site, but be careful.</p>
			<?php
				$path = $_SERVER["DOCUMENT_ROOT"] . "/../includes/site_config.ini";
				if(!isset($_POST["config-submit"])) {
					?>
					<form name="config" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
						<textarea name="config-file" rows="10" cols="100"><?php echo file_get_contents($path); ?></textarea><br/><br/>
						<input type="submit" name="config-submit" value="Update Config" />
					</form>
					<?php
				}
				else {
					$config = $_POST["config-file"];
					$written = file_put_contents($path, $config);
					if($written) {
						?>
						<p>Success! Your edits were written to the config file.</p>
						<form name="config" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
							<textarea name="config-file"><?php echo file_get_contents($path); ?></textarea><br/><br/>
							<input type="submit" name="config-submit" value="Update Config" />
						</form>
						<?php
					}
					else {
						?>
						<p><span class="error">Your edits were not written to the file due to an error.</span> However, they have been recovered and are still in the text field below.</p>
						<form name="config" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
							<textarea name="config-file"><?php echo $config; ?></textarea><br/><br/>
							<input type="submit" name="config-submit" value="Update Config" />
						</form>
						<?php
					}
				}
			?>
			<hr/>
			<a class="small" href="/admin">Back to admin index</a>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>