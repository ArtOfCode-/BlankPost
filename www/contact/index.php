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
			<p>You can get in touch using any of the links below.</p>
            <ul>
                <?php if(get_config_value("links", "email")) { ?>
                    <li>Email: <a href="mailto:<?php echo get_config_value("links", "email"); ?>"><?php echo get_config_value("links", "email"); ?></a></li>
                <?php } if(get_config_value("links", "stack")) { ?>
                    <li><a href="<?php echo get_config_value("links", "stack"); ?>">Stack Exchange</a></li>
                <?php } if(get_config_value("links", "github")) { ?>
                    <li><a href="<?php echo get_config_value("links", "github"); ?>">GitHub</a></li>
                <?php } if(get_config_value("links", "fb")) { ?>
                    <li><a href="<?php echo get_config_value("links", "fb"); ?>">Facebook</a></li>
                <?php } if(get_config_value("links", "twitter")) { ?>
                    <li><a href="<?php echo get_config_value("links", "twitter"); ?>">Twitter</a></li>
                <?php } ?>
            </ul>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>