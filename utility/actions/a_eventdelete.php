<?php session_start();
$ROOT = dirname(dirname(dirname(__FILE__)));
require_once($ROOT . "/utility/functions/utils.php");
require_once($ROOT . "/utility/functions/db.php");

$flash = "Something went wrong.";
if (isset($_POST["eventid"])) { 				# id must be set
	$eventid = $_POST["eventid"];

	$flash = "Invalid event.";
	if (preg_match("/^\d*$/", $eventid)) { 		# id must be digits
		$option = "WHERE id = $eventid";
		$events = all_of("events", $option);

		$flash = "Event doesn't exist.";
			if ($events->rowCount() > 0) { 		# event must exist

				$flash = "You don't have permission for this event!";
				foreach ($events as $event) {	# managers only can delete
					$info = get_user_info($_SESSION["user"]);
					if ($event["id_manager"] === $info["id"]) {
						delete_event($eventid);
						$flash = "Event deleted.";
					}
				}	# end foreach
			} 		# end if exist
	} 				# end if preg_match
} 					# end if isset
redirect("events.php", $flash);
?>