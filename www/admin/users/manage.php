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
	$user = get_user_details($id);
	if($user === null) {
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
			<h3>User <?php echo $user["name"]; ?></h3>
			<div>
				<a href="#" class="error admin-action" data-request-type="POST" data-url="/admin/users/delete.php" data-id="<?php echo $id; ?>" 
					data-desc="permanently delete this user from the database">Delete</a> | 
				<a href="/admin/users/change-password/<?php echo $id; ?>">Change Password</a>
			</div>
			<hr/>
			<?php
				if(!isset($_POST["user-id"])) {
					?>
					<form name="update-user" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
						<input type="hidden" name="user-id" value="<?php echo $id; ?>" />
						<label for="uid">ID</label><br/><input disabled type="number" name="uid" value="<?php echo $user["id"]; ?>" /><br/>
						<label for="username">Username</label><br/><input type="text" name="username" value="<?php echo $user["name"]; ?>" /><br/>
						<label for="email">Email</label><br/><input type="email" name="email" value="<?php echo $user["email"]; ?>" /><br/>
						<label for="auth-level">Auth level</label><br/><input <?php echo intval(get_auth_level($id)) >= intval($_SESSION["AuthLevel"]) ? "disabled " : ""; ?>type="number" name="auth-level" value="<?php echo $user["auth_level"]; ?>" /><br/>
						<input type="submit" name="update-submit" value="Update User" />
					</form>
					<?php
				}
				else {
					$conn = get_db();
					$username = mysqli_real_escape_string($conn, $_POST["username"]);
					$email = mysqli_real_escape_string($conn, $_POST["email"]);
                    $auth = get_auth_level($id);
					if(intval($_SESSION["AuthLevel"]) > intval(get_auth_level($id)) && intval($_SESSION["AuthLevel"]) > intval($_POST["auth-level"])) {
                        $auth = mysqli_real_escape_string($conn, $_POST["auth-level"]);
                    }
					if($result = mysqli_query($conn, "UPDATE `Users` SET `UserName` = '$username', `Email` = '$email', `AuthLevel` = $auth WHERE `UserId` = $id LIMIT 1;")) {
                        $user = get_user_details($id);
						?>
						<p>Success! The user's details have been updated.</p>
						<form name="update-user" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
							<input type="hidden" name="user-id" value="<?php echo $id; ?>" />
							<label for="uid">ID</label><br/><input disabled type="number" name="uid" value="<?php echo $user["id"]; ?>" /><br/>
							<label for="username">Username</label><br/><input type="text" name="username" value="<?php echo $user["name"]; ?>" /><br/>
							<label for="email">Email</label><br/><input type="email" name="email" value="<?php echo $user["email"]; ?>" /><br/>
							<label for="auth-level">Auth level</label><br/><input <?php echo intval(get_auth_level($id)) >= intval($_SESSION["AuthLevel"]) ? "disabled " : ""; ?>type="number" name="auth-level" value="<?php echo $user["auth_level"]; ?>" /><br/>
							<input type="submit" name="update-submit" value="Update User" />
						</form>
						<?php
					}
					else {
						?>
						<p><span class="error">The user was not updated due to a database error.</span></p>
						<form name="update-user" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
							<input type="hidden" name="user-id" value="<?php echo $id; ?>" />
							<label for="uid">ID</label><br/><input disabled type="number" name="uid" value="<?php echo $user["id"]; ?>" /><br/>
							<label for="username">Username</label><br/><input type="text" name="username" value="<?php echo $user["name"]; ?>" /><br/>
							<label for="email">Email</label><br/><input type="email" name="email" value="<?php echo $user["email"]; ?>" /><br/>
							<label for="auth-level">Auth level</label><br/><input <?php echo intval(get_auth_level($id)) >= intval($_SESSION["AuthLevel"]) ? "disabled " : ""; ?>type="number" name="auth-level" value="<?php echo $user["auth_level"]; ?>" /><br/>
							<input type="submit" name="update-submit" value="Update User" />
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