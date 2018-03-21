<?php
include("top.php");
ensure_logged_in();
?>

<div class="m-a">
	<p class="m-1"> This is the forcast for this week. Select a day: </p>
	<div id="days" class="m-a"></div>

	<dl id="forecast" class="m-a">
			<dt id="min">Min:</dt>
			<dt id="max">Max:</dt>
			<dt id="perc">Precipitation:</dt>
			<dd class="hidden"> Hi i'm here to validate</dd>
	</dl>
</div>
<?php include("bottom.php") ?>