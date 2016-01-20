<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(!is_manager()) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	$id = isset($_GET["id"]) ? $_GET["id"] : (isset($_POST["user-id"]) ? $_POST["user-id"] : null);
	if($id === null) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | Admin - Manage User</title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3>Change password for user #<?php echo $id; ?></h3>
			<hr/>
			<?php
				if(!isset($_POST["change-submit"])) {
					?>
					<form name="change-password" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
						<input type="hidden" name="user-id" value="<?php echo $id; ?>" />
						<label for="password">Password</label><br/><input type="password" name="password" /><br/>
						<label for="confirm">Confirm Password</label><br/><input type="password" name="confirm" /><br/>
						<input type="submit" name="change-submit" value="Change Password" />
					</form>
					<?php
				}
				else {
					$password = $_POST["password"];
					$confirm = $_POST["confirm"];
					if($password == $confirm) {
						$changed = change_password($id, $password);
						if($changed) {
							?>
							<p>Success! The password was changed.</p>
							<form name="change-password" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
								<input type="hidden" name="user-id" value="<?php echo $id; ?>" />
								<label for="password">Password</label><br/><input type="password" name="password" /><br/>
								<label for="confirm">Confirm Password</label><br/><input type="password" name="confirm" /><br/>
								<input type="submit" name="change-submit" value="Change Password" />
							</form>
							<?php
						}
						else {
							?>
							<p class="error">The password could not be changed due to a database error.</p>
							<form name="change-password" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
								<input type="hidden" name="user-id" value="<?php echo $id; ?>" />
								<label for="password">Password</label><br/><input type="password" name="password" /><br/>
								<label for="confirm">Confirm Password</label><br/><input type="password" name="confirm" /><br/>
								<input type="submit" name="change-submit" value="Change Password" />
							</form>
							<?php
						}
					}
					else {
						?>
						<p class="error">The passwords you provided don't match.</p>
						<form name="change-password" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
							<input type="hidden" name="user-id" value="<?php echo $id; ?>" />
							<label for="password">Password</label><br/><input type="password" name="password" /><br/>
							<label for="confirm">Confirm Password</label><br/><input type="password" name="confirm" /><br/>
							<input type="submit" name="change-submit" value="Change Password" />
						</form>
						<?php
					}
				}
			?>
			<hr/>
			<a class="small" href="/admin/users">Back to users index</a>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>