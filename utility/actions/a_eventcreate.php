<?php session_start();
$ROOT = dirname(dirname(dirname(__FILE__)));
require_once($ROOT . "/utility/functions/utils.php");
require_once($ROOT . "/utility/functions/db.php");

$flash = "Invalid input.";
if (check_input_event()) {
	$info = get_user_info($_SESSION["user"]);
	$userid = $info["id"];
	create_event($_POST["title"],$_POST["date"],$_POST["description"], $userid);
	$flash = "Event created!";
}
redirect("events.php", $flash);
?>