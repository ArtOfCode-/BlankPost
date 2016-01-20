<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(!is_manager()) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | Admin - Users</title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3>Manage Blocked Users</h3>
            <hr/>
            <table class="sorted">
                <thead><tr>
                    <td>Block ID</td>
                    <td>IP Address</td>
                    <td>Reason</td>
                    <td>Unblock</td>
                </tr></thead>
                <tbody></tbody>
            </table>
		</div>
	</div>
	
	<script>
		var data = [
			<?php
				// What a horrible piece of code this is. Yes, I'm writing JavaScript in PHP.
				$blocked = get_blocked_users();
                foreach($blocked as $block) {
                    echo "[";
                    echo "'" . $block["id"] . "',";
                    echo "'" . $block["ip"] . "',";
                    echo "'" . str_replace("'", "\\'", $block["reason"]) . "',";
                    echo "'<a href=\'#\' class=\'error admin-action\' data-url=\'/admin/users/unblock_user.php\' data-request-type=\'POST\' data-desc=\'unblock this IP address\' data-id=\'" . $block["id"] . "\'>Unblock</a>'";
                    echo "],";
                }
			?>
		];
	</script>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>