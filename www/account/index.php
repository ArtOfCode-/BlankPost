<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	
	if(!is_logged_in()) {
		http_response_code(302);
		header("Location: /login");
	}
	
	$id = get_user_id();
	$user = get_user_details($id);
	if($user === null) {
		http_response_code(404);
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
			<h3>Welcome, <?php echo $user["name"]; ?></h3>
			<div>
				<a class="error admin-action" href="#" data-url="/account/delete" data-request-type="POST" data-desc="permanently delete your user account">Delete Account</a> | 
				<a href="/account/change-password">Change Password</a>
			</div>
			<hr/>
			<?php
				if(isset($_POST["update-submit"])) {
					$username = isset($_POST["username"]) && $_POST["username"] != "" ? $_POST["username"] : null;
					$email = isset($_POST["email"]) && $_POST["email"] != "" ? $_POST["email"] : null;
					if($username && $email) {
						$conn = get_db();
						$username = mysqli_real_escape_string($conn, $username);
						$email = mysqli_real_escape_string($conn, $email);
						if($result = mysqli_query($conn, "UPDATE `Users` SET `UserName` = '$username', `Email` = '$email' WHERE `UserId` = $id LIMIT 1;")) {
							echo '<p>Success! Your details were updated.</p>';
						}
						else {
							echo '<p class="error">Your details could not be updated due to a database error.</p>';
						}
					}
					else {
						echo '<p class="error">You must fill in a username and email address.</p>';
					}
				}
			?>
			<form name="update" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
				<label for="username">Your Username</label><br/>
				<input type="text" name="username" value="<?php echo $user["name"]; ?>" /><br/>
				<label for="email">Your Email Address</label><br/>
				<input type="email" name="email" value="<?php echo $user["email"]; ?>"/><br/>
				<input type="submit" name="update-submit" value="Update Details" />
			</form>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>