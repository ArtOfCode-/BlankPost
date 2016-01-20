<?php
	
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	
	if(is_manager()) {
		$conn = get_db();
		if($result = mysqli_query($conn, "TRUNCATE TABLE `Users`;")) {
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