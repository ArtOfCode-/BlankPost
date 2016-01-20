<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(!is_manager()) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | Admin - Create User</title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3>New User</h3>
			<hr/>
			<?php
				if(!isset($_POST["new-submit"])) {
					?>
					<form name="update-user" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
						<label for="username">Username</label><br/><input type="text" name="username" /><br/>
						<label for="email">Email</label><br/><input type="email" name="email" /><br/>
						<label for="password">Password</label><br/><input type="password" name="password" /><br/>
						<label for="auth-level">Auth level</label><br/>
						<span class="small"><strong>Auth levels: </strong> Editor: 3; Manager: 11; Owner: 21</span><br/>
						<input type="number" name="auth-level" value="1" /><br/>
						<input type="submit" name="new-submit" value="Create User" />
					</form>
					<?php
				}
				else {
					$conn = get_db();
					$username = mysqli_real_escape_string($conn, $_POST["username"]);
					$email = mysqli_real_escape_string($conn, $_POST["email"]);
					$password = $_POST["password"];
					$auth = mysqli_real_escape_string($conn, $_POST["auth-level"]);
					$created = create_user($email, $username, $password, $auth);
					if($created === true) {
						?>
						<p>Success! The user has been created. You can now <a href="/admin/users/">manage their account</a>.</p>
						<form name="update-user" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
							<label for="username">Username</label><br/><input type="text" name="username" /><br/>
							<label for="email">Email</label><br/><input type="email" name="email" /><br/>
							<label for="password">Password</label><br/><input type="password" name="password" /><br/>
							<label for="auth-level">Auth level</label><br/><input type="number" name="auth-level" /><br/>
							<input type="submit" name="new-submit" value="Create User" />
						</form>
						<?php
					}
					else if($created === 1) {
						?>
						<p><span class="error">The user could not be created because the email address is already taken.</span></p>
						<form name="update-user" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
							<label for="username">Username</label><br/><input type="text" name="username" value="<?php echo $username; ?>" /><br/>
							<label for="email">Email</label><br/><input type="email" name="email" /><br/>
							<label for="password">Password</label><br/><input type="password" name="password" /><br/>
							<label for="auth-level">Auth level</label><br/><input type="number" name="auth-level" value="<?php echo $auth; ?>" /><br/>
							<input type="submit" name="new-submit" value="Create User" />
						</form>
						<?php
					}
					else {
						?>
						<p><span class="error">The user could not be created because of a database error.</span></p>
						<form name="update-user" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
							<label for="username">Username</label><br/><input type="text" name="username" value="<?php echo $username; ?>" /><br/>
							<label for="email">Email</label><br/><input type="email" name="email" value="<?php echo $email; ?>" /><br/>
							<label for="password">Password</label><br/><input type="password" name="password" /><br/>
							<label for="auth-level">Auth level</label><br/><input type="number" name="auth-level" value="<?php echo $auth; ?>" /><br/>
							<input type="submit" name="new-submit" value="Create User" />
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