<?php
	
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	
	if(is_admin_user()) {
		$conn = get_db();
		if($result = mysqli_query($conn, "TRUNCATE TABLE `Posts`;")) {
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