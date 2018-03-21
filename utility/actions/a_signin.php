<?php session_start();
$ROOT = dirname(dirname(dirname(__FILE__)));
require_once($ROOT . "/utility/functions/utils.php");
require_once($ROOT . "/utility/functions/db.php");

$flash = "Sorry, something went wrong.";
if (check_input_signin()) {
	
	# Saving the compiled form camps into variables.
	$fname = $_REQUEST["fname"];
	$lname = $_REQUEST["lname"];
	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];
	$email = NULL;
	if (isset($_REQUEST["email"])){ $email = $_REQUEST["email"]; }
	# Creates new user.
	create_user($fname, $lname, $username, $password, $email);
	$flash = "User created!";
}
redirect("login.php", $flash);
?>