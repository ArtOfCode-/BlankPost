<?php

	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	
	$conn = get_db();
	
	$post_id = isset($_POST["parent"]) && $_POST["parent"] !== "" ?  $_POST["parent"] : null;
	
	if($post_id === null) {
		http_response_code(400);
		echo "The request did not POST a valid parent post ID.";
		exit(0);
	}
	
	$post_id = mysqli_real_escape_string($conn, $post_id);
	
	if($result = mysqli_query($conn, "SELECT `PostBody`, `CreationDate`, `CreationUser` FROM `Posts` WHERE `PostTypeId` = 2 AND `ParentId` = $post_id;")) {
		$comments = array();
		while($row = $result->fetch_assoc()) {
			array_push($comments, array("text" => $row["PostBody"], "author" => $row["CreationUser"], "date" => $row["CreationDate"]));
		}
		echo json_encode($comments);
	}
	else {
		write_log("mysqli", "/posts/comments/get: MySQLi Query failed with error #" . mysqli_errno($conn) . ": '" . mysqli_error($conn) . "'.");
		http_response_code(500);
		exit(1);
	}

?>