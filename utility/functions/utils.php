<?php
#------------------------------------------------------------------------------------#
# Studente: Edoardo Canobbio (805585) - Progetto di Tweb 2017                        #
# Collection of handy functions to manage the webapp.			                     #
#------------------------------------------------------------------------------------#

# --------------------------------------------- UTILITY ---------------------------------------------

#-------------------------------------------#
# Redirects current page to the given URL 	#
# and optionally sets flash message.		#
#                                           #
#-------------------------------------------#
function redirect($url, $flash_message = NULL) {
	$root = "http://localhost/progetto/";	# @@@@@@ WARNING: This variable must be changed accordingly
	if ($flash_message) {
    	$_SESSION["flash"] = $flash_message;
  	}
	header("Location: $root$url");
	die;
}

#-------------------------------------------#
# Redirects current page to login.php if 	#
# user is not logged in.					#
#                                           #
#-------------------------------------------#
function ensure_logged_in() {
  if (!isset($_SESSION["user"])) {
    redirect("login.php", "You must be logged in before you can view this page.");
  }
}


# --------------------------------------------- INPUT CHECKING ---------------------------------------------

#-------------------------------------------#
# Returns TRUE if the market search input 	#
# conditions are match.						#
#                                           #
#-------------------------------------------#
function check_input_market() {
	if ($_GET["product"] && $_GET["flag"]) {
		$flag = $_GET["flag"];
		$product = $_GET["product"];
		if ( preg_match('/[^A-Za-z]/', $product) === 0) {
			if ($flag == "only_me" || $flag == "any" ) { return TRUE; }
		}
	}
	return FALSE;
}

#-------------------------------------------#
# Returns TRUE if the event creation input 	#
# conditions are match.						#
#                                           #
#-------------------------------------------#
function check_input_event() {
	if (isset($_POST["title"]) && isset($_POST["date"]) && isset($_POST["description"])) {
		$pattern = "/^[^0-1][0-9]{3}-(0?[1-9]|1[0-2])-(0?[1-9]|[1-2][0-9]|3[0-1])$/";
		return preg_match($pattern, $_POST["date"]);
	}
	return FALSE;
}

#-------------------------------------------#
# Returns TRUE if the request creation 		#
# input conditions are met.					#
#                                           #
#-------------------------------------------#
function check_input_request() {
	if (isset($_POST["quantity"]) && isset($_POST["product"])) {
		$validp = (preg_match("/[^A-Za-z]/", $_POST["product"]) === 0);
		$validq = (preg_match("/[^\d]/", $_POST["quantity"]) === 0);

		return $validq && $validp;
	}
	return FALSE;
}
?>

