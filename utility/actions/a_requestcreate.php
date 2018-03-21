<?php session_start();
$ROOT = dirname(dirname(dirname(__FILE__)));
require_once($ROOT . "/utility/functions/utils.php");
require_once($ROOT . "/utility/functions/db.php");

$flash = "Invalid input.";
if(check_input_request()) {
	$info = get_user_info($_SESSION["user"]);
	$id_buyer = $info["id"];
	$product = $_POST["product"];

	$option = "WHERE name = '$product'";
	foreach (all_of("products", $option) as $product) {
		$id_product = $product["id"];
		$type = $product["type"];
	}

	print_r($id_product." and ".$id_buyer." and ".$_POST["quantity"]);
	if ($type == "service"){
		$flash = "Services quantity must be 1";
		if ($quantity == 1) {
			create_request($id_product, $id_buyer, $_POST["quantity"]);
			$flash = "Request submitted!";
		}
	} else { // type != service
		create_request($id_product, $id_buyer, $_POST["quantity"]);
		$flash = "Request submitted!";
	}
	
}
redirect("market.php", $flash);