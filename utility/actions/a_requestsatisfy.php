<?php session_start();
$ROOT = dirname(dirname(dirname(__FILE__)));
require_once($ROOT . "/utility/functions/utils.php");
require_once($ROOT . "/utility/functions/db.php");

$flash = "Invalid input.";
if (isset($_GET["id"])) {
	if (preg_match("/\d/", $rID) === 0) {
		$rID = $_GET["id"];
		$tmp = get_user_info($_SESSION["user"]);
		$uID = $tmp["id"];

		$tmp = all_of("requests", "WHERE id = $rID");

		foreach ($tmp as $req) {
			$taken = $req["id_seller"] != NULL;
		}
		$flash = "Request already been taken care of.";
		if (!$taken) {
			request_satisfy($rID, $uID);
			$flash = "You took care of the request.";
		}
	}
}
print_r($flash);
redirect("market.php", $flash);
?>