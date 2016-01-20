<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
    $blocked_user = get_blocked_user($_SERVER["REMOTE_ADDR"]);
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
			<h3 class="error">Site Access Suspended</h3>
            <p>Your IP address has been suspended from accessing the site. This may be temporary or permanent. Your IP
            address is listed below, along with a short reason explaining why you have been blocked.</p>
            <p>
                <ul>
                    <li><strong>IP Address:</strong> <?php echo $blocked_user["ip"]; ?></li>
                    <li><strong>Reason:</strong> <?php echo $blocked_user["reason"]; ?></li>
                </ul>
            </p>
            <p>If you believe this is an error or otherwise unwarranted, please get in contact with me by email: 
            <span><script>document.write("hello@artofcode.co.uk");</script></span>.</p>
            <p>If the pattern of behaviour detailed in the reason, that led to this suspension of access, continues, I
            may issue a permanent 403 block, rather than this explanation page.</p>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>