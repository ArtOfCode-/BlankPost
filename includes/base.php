<?php

    /**
     * BLANKPOST — Base Library
     *
     * Author: ArtOfCode
     * Copyright (c) 2016, ArtOfCode
     *
     * Licensed under the MIT license: http://opensource.org/licenses/MIT
     *
     * Version: 1.7.22
     */

	session_start();
	
	function endsWith($haystack, $needle) {
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}
	
	if(endsWith($_SERVER["REQUEST_URI"], ".js") || endsWith($_SERVER["REQUEST_URI"], ".css") ||
		endsWith($_SERVER["REQUEST_URI"], ".png") || endsWith($_SERVER["REQUEST_URI"], ".jpg")) {
		header("Cache-Control: max-age=2419200");
		header("ETag: " . md5(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/" . $_SERVER["REQUEST_URI"])));
	}

	function get_config() {
		return parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/../includes/site_config.ini", true);
	}
	
	function write_log($log_name, $message) {
		return file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/../logs/" . $log_name . ".log", file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/../logs/" . $log_name . ".log") . $message . "\n");
	}
	
	$_CONFIG = get_config();
	
	if($_CONFIG["site"]["MAINTENANCE"] && $_SERVER["REQUEST_URI"] != "/error/503/maintenance") {
		if(strpos($_SERVER["REQUEST_URI"], "/login") === false 
		&& strpos($_SERVER["REQUEST_URI"], "/admin") === false
		&& strpos($_SERVER["REQUEST_URI"], "/res") === false) {
			header("Location: /error/503/maintenance");
		}
	}
	
	function get_config_value($section, $key) {
		global $_CONFIG;
		return isset($_CONFIG[$section][$key]) ? $_CONFIG[$section][$key] : null;
	}
	
	function get_db() {
		global $_CONFIG;
        write_log("access", $_SERVER["SERVER_PROTOCOL"] . " " . $_SERVER["REQUEST_METHOD"] . " " . $_SERVER["REQUEST_URI"] . " from '" . $_SERVER["REMOTE_ADDR"] . "'@'" . $_SERVER["REMOTE_HOST"] . "'; forwarded for '" . (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : "")  . "'");
		$conn = mysqli_connect($_CONFIG["database"]["HOST"], $_CONFIG["database"]["USER"], $_CONFIG["database"]["PASS"], $_CONFIG["database"]["NAME"]);
        if($conn) {
            return $conn;
        }
        else {
            // Always redirect to the fallback error page, because the standard version also needs a DB connect.
            http_response_code(500);
            header("Location: /500.php");
        }
	}
    
    $DB_CONN = get_db();
	
	// Post controls
	
	function get_homepage_posts() {
		global $_CONFIG;
		return get_paginated_posts(1, $_CONFIG["posts"]["homepage_posts"]);
	}
	
	function get_paginated_posts($page, $pagesize = null) {
		global $_CONFIG;
		global $DB_CONN;
        $conn = $DB_CONN;
		
		if($pagesize == null) {
			$pagesize = $_CONFIG["posts"]["paginated_posts"];
		}
		
		// $page can be fed in from a query string ?page= parameter, so escape it to avoid SQL injection
		$page = mysqli_real_escape_string($conn, $page);
		
		// Calculate offset: i.e. page 1 would be 0 offset so the first set of posts in index format.
		$offset = ($page - 1) * $pagesize;
		$query = "SELECT `PostId`, `PostTitle`, `PostBody`, `CreationDate`, `CreationUser` FROM `Posts` WHERE `PostTypeId` = 1 ORDER BY `CreationDate` DESC LIMIT $pagesize OFFSET $offset;";
		
		if($results = mysqli_query($conn, $query)) {
			$posts = array();
			while($row = $results->fetch_assoc()) {
				array_push($posts, array("id" => $row["PostId"], "title" => $row["PostTitle"], "text" => $row["PostBody"], "author" => $row["CreationUser"], "date" => $row["CreationDate"]));
			}
			return $posts;
		}
		else {
			write_log("mysqli", "get_paginated_posts: MySQLi Query failed with error #" . mysqli_errno($conn) . ": '" . mysqli_error($conn) . "'.");
			return false;
		}
	}
	
	function get_max_page() {
		global $_CONFIG;
		global $DB_CONN;
        $conn = $DB_CONN;
		if($result = mysqli_query($conn, "SELECT COUNT(DISTINCT(`PostId`)) AS `PostCount` FROM `Posts` WHERE `PostTypeId` = 1;")) {
			$row = $result->fetch_assoc();
			return ceil($row["PostCount"] / $_CONFIG["posts"]["paginated_posts"]);
		}
		else {
			return "unknown";
		}
	}
	
	function get_single_post($post_id) {
		global $DB_CONN;
        $conn = $DB_CONN;
		
		// Escaped because even though .htaccess only redirects when the param is a number, it's entirely
		// possible to visit the page directly.
		$post_id = mysqli_real_escape_string($conn, $post_id);
		
		if($result = mysqli_query($conn, "SELECT * FROM `Posts` WHERE `PostId` = $post_id LIMIT 1;")) {
			if(mysqli_num_rows($result) > 0 && $row = $result->fetch_assoc()) {
				$post = array("date" => $row["CreationDate"], "author" => $row["CreationUser"], "text" => $row["PostBody"], "title" => $row["PostTitle"], "id" => $row["PostId"]);
				return $post;
			}
			else {
				return null;
			}
		}
		else {
			write_log("mysqli", "get_single_post: MySQLi Query failed with error #" . mysqli_errno($conn) . ": '" . mysqli_error($conn) . "'.");
			return false;
		}
	}
	
	// User controls
	
	function is_logged_in() {
		$authkey = isset($_SESSION["UserAuthKey"]);
		$username = isset($_SESSION["UserName"]);
		$authlevel = isset($_SESSION["AuthLevel"]);
		$id = isset($_SESSION["UserId"]);
		// echo "AuthKey: $authkey; UserName: $username; AuthLevel: $authlevel; UserId: $id;";
		return $authkey && $username && $authlevel;
	}
    
    function get_auth_level($uid) {
        global $DB_CONN;
        $conn = $DB_CONN;
        
        $uid = mysqli_real_escape_string($conn, $uid);
        
        if($result = mysqli_query($conn, "SELECT `AuthLevel` FROM `Users` WHERE `UserId` = $uid;")) {
            $row = $result->fetch_assoc();
            return $row["AuthLevel"];
        }
        else {
            write_log("mysqli", "get_auth_level: MySQLi SELECT `AuthLevel` failed: #" . mysqli_errno($conn) . ": " . mysqli_error($conn));
        }
        
        return 0;
    }
	
	function get_username() {
		return is_logged_in() ? $_SESSION["UserName"] : null;
	}
	
	function get_user_id() {
		return is_logged_in() ? $_SESSION["UserId"] : null;
	}
	
	function get_user_details($id) {
		global $DB_CONN;
        $conn = $DB_CONN;
		$id = mysqli_real_escape_string($conn, $id);
		if($result = mysqli_query($conn, "SELECT * FROM `Users` WHERE `UserId` = $id LIMIT 1;")) {
			if(mysqli_num_rows($result) > 0 && $row = $result->fetch_assoc()) {
				$user = array("id" => $row["UserId"], "name" => $row["UserName"], "email" => $row["Email"], "auth_level" => $row["AuthLevel"]);
				return $user;
			}
			else {
				return null;
			}
		}
		else {
			write_log("mysqli", "get_user_details: MySQLi Query failed with error #" . mysqli_errno($conn) . ": '" . mysqli_error($conn) . "'.");
			return false;
		}
	}
	
	function is_admin_user() {
		return isset($_SESSION["UserAuthKey"]) && isset($_SESSION["UserName"])
			&& isset($_SESSION["AuthLevel"]) && $_SESSION["AuthLevel"] > 2;
	}
	
	function is_editor() {
		return isset($_SESSION["UserAuthKey"]) && isset($_SESSION["UserName"])
			&& isset($_SESSION["AuthLevel"]) && $_SESSION["AuthLevel"] > 2;
	}
	function is_manager() {
		return isset($_SESSION["UserAuthKey"]) && isset($_SESSION["UserName"])
			&& isset($_SESSION["AuthLevel"]) && $_SESSION["AuthLevel"] > 10;
	}
	function is_owner() {
		return isset($_SESSION["UserAuthKey"]) && isset($_SESSION["UserName"])
			&& isset($_SESSION["AuthLevel"]) && $_SESSION["AuthLevel"] > 20;
	}
	
	function generate_salt($max = 15) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $i = 0;
        $salt = "";
        while ($i < $max) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
	}
	
	function validate_credentials($email, $password) {
		global $DB_CONN;
        $conn = $DB_CONN;
		$email = mysqli_real_escape_string($conn, $email);
		if($result = mysqli_query($conn, "SELECT * FROM `Users` WHERE `Email` = '$email' LIMIT 1;")) {
			while($row = $result->fetch_assoc()) {
				$hash = hash_pbkdf2('sha256', $password, $row["Salt"], 1000, 0);
				if($row["Password"] == $hash) {
					return array("email" => $row["Email"], "auth_level" => $row["AuthLevel"], "username" => $row["UserName"], "id" => $row["UserId"]);
				}
			}
			return false;
		}
		else {
			write_log("mysqli", "validate_credentials: MySQLi Query failed with error #" . mysqli_errno($conn) . ": '" . mysqli_error($conn) . "'.");
			return false;
		}
	}
	
	function create_user($email, $username, $password, $auth = 1) {
		global $DB_CONN;
        $conn = $DB_CONN;
		$email = mysqli_real_escape_string($conn, $email);
		$username = mysqli_real_escape_string($conn, $username);
		$result = mysqli_query($conn, "SELECT * FROM `Users` WHERE `Email` = '$email';");
		if($result && mysqli_num_rows($result) > 0) {
			return 1;
		}
		else {
			$salt = generate_salt(32);
			$hash = hash_pbkdf2('sha256', $password, $salt, 1000, 0);
			if($result = mysqli_query($conn, "INSERT INTO `Users` VALUES (DEFAULT, '$email', '$username', '$hash', '$salt', $auth);")) {
				return true;
			}
			else {
				write_log("mysqli", "create_user: MySQLi Query failed with error #" . mysqli_errno($conn) . ": '" . mysqli_error($conn) . "'.");
				return 2;
			}
		}
	}
	
	function change_password($user_id, $new_pass) {
		global $DB_CONN;
        $conn = $DB_CONN;
		$salt = generate_salt(32);
		$hash = hash_pbkdf2('sha256', $new_pass, $salt, 1000, 0);
		if($result = mysqli_query($conn, "UPDATE `Users` SET `Salt` = '$salt', `Password` = '$hash' WHERE `UserId` = $user_id LIMIT 1;")) {
			return true;
		}
		else {
			write_log("mysqli", "change_password: MySQLi Query failed with error #" . mysqli_errno($conn) . ": '" . mysqli_error($conn) . "'.");
			return false;
		}
	}
	
	function get_paginated_users($page, $pagesize) {
		global $_CONFIG;
		global $DB_CONN;
        $conn = $DB_CONN;
		
		$page = mysqli_real_escape_string($conn, $page);
		
		if($last_id = mysqli_query($conn, "SELECT MAX(`UserId`) FROM `Users`;")) {
			$id_row = $last_id->fetch_assoc();
			$min_fetch_id = $id_row["MAX(`UserId`)"] - ($pagesize * $page);
			if($result = mysqli_query($conn, "SELECT * FROM `Users` WHERE `UserId` > $min_fetch_id ORDER BY `UserId` ASC LIMIT $pagesize;")) {
				$users = array();
				while($row = $result->fetch_assoc()) {
					array_push($users, array("id" => $row["UserId"], "email" => $row["Email"], "name" => $row["UserName"], "auth_level" => $row["AuthLevel"]));
				}
				return $users;
			}
			else {
				write_log("mysqli", "get_paginated_users: MySQLi Query #2 failed with error #" . mysqli_errno($conn) . ": '" . mysqli_error($conn) . "'.");
				return false;
			}
		}
		else {
			write_log("mysqli", "get_paginated_users: MySQLi Query #1 failed with error #" . mysqli_errno($conn) . ": '" . mysqli_error($conn) . "'.");
			return false;
		}
	}
    
    // Blocking controls
    function get_blocked_users() {
        global $DB_CONN;
        $conn = $DB_CONN;
        
        $users = [];
        
        if($results = mysqli_query($conn, "SELECT * FROM `BlockedUsers`;")) {
            while($row = $results->fetch_assoc()) {
                $user = array("id" => $row["Id"], "ip" => $row["IpAddress"], "reason" => $row["Reason"]);
                $users[] = $user;
            }
        }
        
        return $users;
    }
    
    function get_blocked_user($ip_address) {
        global $DB_CONN;
        $conn = $DB_CONN;
        
        $ip_address = mysqli_real_escape_string($conn, $ip_address);
        
        if($result = mysqli_query($conn, "SELECT `IpAddress`, `Reason` FROM `BlockedUsers` WHERE `IpAddress` = '$ip_address';")) {
            $row = $result->fetch_assoc();
            return array("ip" => $row["IpAddress"], "reason" => $row["Reason"]);
        }
        
        return null;
    }
    
    function add_block($ip_address, $reason) {
        global $DB_CONN;
        $conn = $DB_CONN;
        
        $ip_address = mysqli_real_escape_string($conn, $ip_address);
        $reason = mysqli_real_escape_string($conn, $reason);
        
        if($result = mysqli_query($conn, "INSERT INTO `BlockedUsers` VALUES (DEFAULT, '$ip_address', '$reason');")) {
            return true;
        }
        else {
            return false;
        }
    }
    
    function delete_block($block_id) {
        global $DB_CONN;
        $conn = $DB_CONN;
        
        $block_id = mysqli_real_escape_string($conn, $block_id);
        
        if($result = mysqli_query($conn, "DELETE FROM `BlockedUsers` WHERE `Id` = $block_id;")) {
            return true;
        }
        else {
            return false;
        }
    }
    
    function block_users() {
        $users = get_blocked_users();
        $ip_address = $_SERVER["REMOTE_ADDR"];
        
        if(!($_SERVER["REQUEST_URI"] === "/blocked" || $_SERVER["REQUEST_URI"] === "/blocked/") &&
            strpos($_SERVER["REQUEST_URI"], "/res") === false && !is_owner()) {
            foreach($users as $user) {
                if($user["ip"] == $ip_address) {
                    header("Location: /blocked");
                }
            }
        }
    }
    
    if(isset($_CONFIG["site"]["blocking_active"]) && $_CONFIG["site"]["blocking_active"] == true) {
        block_users();
    }
	
?>