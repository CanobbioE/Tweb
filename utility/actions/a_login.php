<?php session_start();
$ROOT = dirname(dirname(dirname(__FILE__)));
require_once($ROOT . "/utility/functions/utils.php");
require_once($ROOT . "/utility/functions/db.php");

$flash = "Insert username and password.";
if (isset($_POST["username"]) && isset($_POST["password"])) {
	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];

	if (is_password_correct($username, $password)) {
		if (isset($_SESSION)) {
			session_destroy();
			session_regenerate_id(TRUE);
			session_start();
		}

		$_SESSION["user"] = $username;
		$info = get_user_info($username);
		redirect("profile.php", "Wellcome to the site " . htmlspecialchars(ucfirst($info["fname"])));
	} else {
		$flash = "Wrong username and password combination.";
	}
}
redirect("login.php", $flash);
?>