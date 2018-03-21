<?php
include("top.php");
ensure_logged_in();
?>

<div id="create-event" class="p-1">
	<p class="cntr it p-1 m-1"> Have fun with people: create an event! </p>
	<form action="utility/actions/a_eventcreate.php" method="POST">
	
		<label>Envent name: 
			<input type="text" name="title" placeholder="Event Name" required="required">
		</label>

		<label>Date:		
			<input id="date" type="text" name="date" placeholder="yyyy-mm-dd" 
			required="required" pattern="[^0-1][0-9]{3}-(0?[1-9]|1[0-2])-(0?[1-9]|[1-2][0-9]|3[0-1])">
		</label>

		<label>Description: (<span id="counter" class="it"></span> chars)
			<textarea class="block" placeholder="Description" name="description" 
			maxlength="128" rows="4" cols="50" required="required" id="desc"></textarea>
		</label>

		<input class="inline mt-1" type="submit" value="Create">
		<input class="inline mt-1" type="reset" value="Reset">
	</form>
</div> <!--End create-event-->
<hr>
<div id="delete-event" class="p-1">
	<p class="cntr it p-1 m-1">Something unexpected? Delete your event!</p>
	<form action="utility/actions/a_eventdelete.php" method="POST">
		<select name="eventid">
		<?php foreach (all_of("events") as $event) { 
				$eventname = htmlspecialchars($event["title"]); ?>
				<option value="<?= $event["id"] ?>"><?= $eventname ?></option>
		<?php } ?>

		</select>
		<input class="mt-1" type="submit" value="Delete">
	</form>
</div><!--End delete-event-->

<?php include("bottom.php") ?>