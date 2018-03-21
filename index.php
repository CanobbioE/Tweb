<?php 
# This is the main page of the web-application.
include("top.php");
?>

<div id="slideshow">
	<?php 
	$dir = "content/img/slideshow/";
	foreach (scandir($dir) as $img) { 
		if(strpos($img, "rural")!== FALSE) { ?>
			<img class="slide" src="<?= $dir.$img ?>" alt="slideshow">
<?php	}
	}
	?>
</div> 

<dl class="sidelist f-left m-0 p-0">
	<?php # Get all the needed info on the events and print them
		foreach (all_of("events", "ORDER BY event_date") as $event) {
				$dt = htmlspecialchars($event["title"]." - ".$event["event_date"]);
				$dd = htmlspecialchars($event["description"]);
				?>
				<div class="sidelist-elem event m-0 p-0">
					<dt class="c1 bld cntr"><?=$dt?></dt> 
					<dd class="c2"><?=$dd?></dd>
				</div>
	<?php
		} # end foreach ?>
</dl> <!--End sidelist-->
	
<div id="article" class="sidecontainer f-right bl m-0 p-0">
</div>

<?php include("bottom.php"); ?>

