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
			<h3>Block Users</h3>
            <hr/>
            <?php
                if(!isset($_POST["block_form_submit"])) {
                    ?>
                    <form name="block_form" action="block.php" method="POST">
                        <label for="ip-address">IP Address</label><br/><input type="text" name="ip-address" /><br/>
                        <label for="reason">Reason</label><br/><input type="text" name="reason" /><br/>
                        <input type="submit" name="block_form_submit" value="Block" />
                    </form>
                    <?php
                }
                else {
                    if(isset($_POST["ip-address"]) && $_POST["ip-address"] != "" &&
                       isset($_POST["reason"]) && $_POST["reason"] != "") {
                        if(add_block($_POST["ip-address"], $_POST["reason"])) {
                            echo "<p>Success! The IP address has been blocked.</p>";
                        }
                        else {
                            echo "<p class='error'>The IP address could not be blocked due to a database error.</p>";
                        }
                    }
                    else {
                        ?>
                        <form name="block_form" action="block.php" method="POST">
                            <label for="ip-address">IP Address</label><br/><input type="text" name="ip-address" /><br/>
                            <label for="reason">Reason</label><br/><input type="text" name="reason" /><br/>
                            <input type="submit" name="block_form_submit" value="Block" />
                        </form>
                        <?php
                    }
                }
            ?>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>