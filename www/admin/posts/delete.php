<?php
	
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	
	$id = isset($_POST["id"]) ? $_POST["id"] : null;
	if($id === null) {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	
	if(is_admin_user()) {
		$conn = get_db();
		if($result = mysqli_query($conn, "DELETE FROM `Posts` WHERE `PostId` = $id;")) {
			echo "success";
		}
		else {
			echo "failed";
		}
	}
	else {
		http_response_code(404);
		header("Location: /error/404/not-found");
	}
	
?>