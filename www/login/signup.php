<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	if(is_logged_in()) {
		header("Location: /account");
	}
	function print_signup_form() {
		echo '<form name="signup" action="signup.php" method="POST">'
			. '<label for="email">Email</label><br/><input type="email" name="email" /><br/>'
			. '<label for="username">Username</label><br/><input type="text" name="username" /><br/>'
			. '<label for="password">Password</label><br/><input type="password" name="password" /><br/>'
			. '<label for="password-confirm">Confirm password</label><br/><input type="password" name="password-confirm" /><br/>'
			. '<input type="submit" name="signup-submit" value="Sign Up" />';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?> | Sign Up</title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3>Sign Up</h3>
			<h4>Fill in the fields below and click Sign Up to create yourself an account on the site.</h4>
			<?php
				if(!isset($_POST["signup-submit"])) {
					print_signup_form();
				}
				else {
					$email = isset($_POST["email"]) ? $_POST["email"] : null;
					$username = isset($_POST["username"]) ? $_POST["username"] : null;
					$password = isset($_POST["password"]) ? $_POST["password"] : null;
					$confirm = isset($_POST["password-confirm"]) ? $_POST["password-confirm"] : null;
					if($email == null || $username == null || $password == null || $confirm == null) {
						echo '<span class="error">Please fill in all the fields.</span>';
						print_signup_form();
					}
					else {
						if($password == $confirm) {
							$created = create_user($email, $username, $password);
							if($created === true) {
								echo '<p>Success! Your account has been created, and you can now <a href="/login">log in</a>.</p>';
							}
							else if($created === 1) {
								echo '<span class="error">The email address you provided is already in use.</span>';
								print_signup_form();
							}
							else if($created === 2) {
								echo '<span class="error">Your account was not created due to a database error. Try again, and if the problem persists, <a href="/contact">contact me</a>.</span>';
								print_signup_form();
							}
							else {
								echo '<span class="error">Congratulations! You\'re in a tiny group of people who\'ve managed to break the website. Something went wrong, and I don\'t know what. Try again, and if the problem persists, <a href="/contact">contact me</a>.</span>';
								print_signup_form();
							}
						}
						else {
							echo '<span class="error">Passwords do not match.</span>';
							print_signup_form();
						}
					}
				}
			?>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>