<?php
	
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	
	unset($_SESSION["UserName"]);
	unset($_SESSION["UserAuthKey"]);
	unset($_SESSION["AuthLevel"]);
	
	session_destroy();
	session_start();
	
	header("Location: /");
	
?>