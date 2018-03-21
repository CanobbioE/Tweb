<?php session_start();
$ROOT = dirname(dirname(dirname(__FILE__)));
require_once($ROOT . "/utility/functions/utils.php");

session_destroy();
session_regenerate_id(TRUE);
session_start();
redirect("index.php", "Logout successful.");
?>