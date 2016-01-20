<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(is_logged_in()) {
		header("Location: /account");
	}
	function print_login_form() {
		echo '<form name="login-form" action="index.php" method="POST">'
				. '<label for="email">Email</label><br/><input type="email" name="email" /><br/>'
				. '<label for="password">Password</label><br/><input type="password" name="password" /><br/>'
				. '<input type="submit" name="login-submit" value="Login" />'
			. '</form>';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | Login</title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3>Login</h3>
			<h4>Enter your details in the fields below and click Login.</h4>
			<p>No account? <a href="/login/signup">Sign up.</a></p>
			<?php
				if(!isset($_POST["login-submit"])) {
					print_login_form();
				}
				else {
					$email = isset($_POST["email"]) ? $_POST["email"] : null;
					$password = isset($_POST["password"]) ? $_POST["password"] : null;
					if($email == null || $password == null) {
						echo '<span class="error">Please fill in all the fields.</span>';
						print_login_form();
					}
					else {
						$user = validate_credentials($email, $password);
						if(!$user) {
							echo '<span class="error">Incorrect email/password combination.</span>';
							print_login_form();
						}
						else {
							session_destroy();
							session_start();
							$_SESSION["UserAuthKey"] = hash("sha256", $email . date("dmYHis"));
							$_SESSION["UserName"] = $user["username"];
							$_SESSION["AuthLevel"] = $user["auth_level"];
							$_SESSION["UserId"] = $user["id"];
							header("Location: /");
						}
					}
				}
			?>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>