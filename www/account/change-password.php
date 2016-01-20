<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	
	if(!is_logged_in()) {
		http_response_code(307);
		header("Location: /login");
	}
	
	$id = get_user_id();
	$user = get_user_details($id);
	if($user === null) {
		http_response_code(409);
		header("Location: /error/409/no-user");
	}
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
			<h3>Change Password</h3>
			<?php
				if(isset($_POST["change-pw-submit"])) {
					$old_pw = isset($_POST["old-password"]) && $_POST["old-password"] != "" ? $_POST["old-password"] : null;
					$new_pw = isset($_POST["new-password"]) && $_POST["new-password"] != ""  ? $_POST["new-password"] : null;
					$confirm = isset($_POST["confirm"]) && $_POST["confirm"] != ""  ? $_POST["confirm"] : null;
					if($old_pw && $new_pw && $confirm) {
						if($new_pw != $confirm) {
							echo '<p class="error">Your new passwords do not match.</p>';
						}
						else {
							$valid_old = validate_credentials($user["email"], $old_pw);
							if($valid_old === false) {
								echo '<p class="error">You entered an invalid old password.</p>';
							}
							else {
								$changed = change_password($id, $new_pw);
								if($changed) {
									echo '<p>Success! Your password has been changed.</p>';
								}
								else {
									echo '<p class="error">Your password could not be changed due to a database error.</p>';
								}
							}
						}
					}
					else {
						echo '<p class="error">You must provide a value for every field.</p>';
					}
				}
			?>
			<form name="change-password" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
				<label for="old-password">Current Password</label><br/>
				<input type="password" name="old-password" /><br/>
				<label for="new-password">New Password</label><br/>
				<input type="password" name="new-password" /><br/>
				<label for="confirm">Confirm New Password</label><br/>
				<input type="password" name="confirm" /><br/>
				<input type="submit" name="change-pw-submit" value="Change" />
			</form>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>