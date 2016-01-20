<?php
	
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	
	$id = get_user_id();
	if($id === null) {
		http_response_code(400);
	}
	
	$conn = get_db();
	if($result = mysqli_query($conn, "DELETE FROM `Users` WHERE `UserId` = $id;")) {
		echo "success";
	}
	else {
		echo "failed";
	}
	
?>