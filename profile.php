<?php
include("top.php");
ensure_logged_in();
?>

<div id="person" class="sidecontainer f-left pt-1">
	<?php
		$info = get_user_info($_SESSION["user"]);
	?>
	<div id="person_info" class="m-a">
		<dl>
			<dt class="bld f-left mr-1">First Name: </dt>	<dd><?= htmlspecialchars(ucfirst($info["fname"])) ?></dd>
			<dt class="bld f-left mr-1">Last Name: </dt>		<dd><?= htmlspecialchars(ucfirst($info["lname"])) ?></dd>
			<dt class="bld f-left mr-1">Username: </dt>		<dd><?= htmlspecialchars($info["username"]) ?></dd>
			<dt class="bld f-left mr-1">E-mail: </dt>		<dd><?= htmlspecialchars($info["email"]) ?></dd>

		</dl>
	</div>
</div>

<div id="my_events" class="sidelist f-right m-0 p-0 bl">
	<p> Your events: </p>	
	<?php # Get all the events created by the user
		$events = get_events($info["id"]);
		if ($events->rowCount() > 0) {
			foreach ($events as $event) {
	?>
		<div class="sidelist-elem m-0 p-0">
			<dt class="c1"> <?= htmlspecialchars($event["title"]) ?> - <?= htmlspecialchars($event["event_date"])?></dt> 
			<dd class="c2"><?= htmlspecialchars($event["description"]) ?></dd>
		</div>

	<?php 	} # end foreach
		} else { # no events found ?> 
			<div class="warning it"> You haven't created any events yet!<br><a href="events.php">Create one now.</a></div>
	<?php	} ?>
		
</div>

<?php include("bottom.php") ?>