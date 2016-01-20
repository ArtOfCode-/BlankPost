<?php

	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	
	$conn = get_db();
	
	$post_id = isset($_POST["parent"]) && $_POST["parent"] !== "" ?  $_POST["parent"] : null;
	$text = isset($_POST["text"]) && $_POST["text"] !== "" ? $_POST["text"] : null;
	
	if($post_id === null) {
		http_response_code(400);
		echo "The request did not POST a valid parent ID.";
		exit(0);
	}
	if($text === null) {
		http_response_code(400);
		echo "The request did not provide any comment text.";
		exit(0);
	}
	
	$user = is_logged_in() ? get_username() : null;
	
	if($user === null) {
		http_response_code(400);
		echo "You are not logged in, so you cannot post comments.";
		exit(0);
	}
	
	$post_id = mysqli_real_escape_string($conn, $post_id);
	$text = mysqli_real_escape_string($conn, $text);
	$user = mysqli_real_escape_string($conn, $user);
	
	if($success = mysqli_query($conn, "INSERT INTO `Posts` VALUES (DEFAULT, NULL, '$text', DEFAULT, '$user', 2, $post_id);")) {
		echo "ok";
	}
	else {
		http_response_code(500);
		echo "There was a server error while attempting to post your comment.";
		write_log("mysqli", "/posts/comments/add: MySQLi Query failed with error #" . mysqli_errno($conn) . ": '" . mysqli_error($conn) . "'.");
	}
	
?>