<?php
include("top.php");
ensure_logged_in();
?>

<dl class="sidelist f-left">
	<?php
		$requests = get_requests();
		if ($requests->rowCount() > 0) {
			foreach ($requests as $request) {
				$name = htmlspecialchars(ucfirst($request["fname"]));
				$surname = htmlspecialchars(ucfirst($request["lname"]));
	?>
				<div class="sidelist-elem request cntr">
					<dt class="c1"><span class="bld"><?=$name?> <?=$surname?></span> needs</dt>
					<dd class="c2">
					<?php if ($request["type"] != "service") { # better displaying ?>
						<span class="dbitem it"><?=$request["quantity"]?></span> of
					<?php } ?>
						<span class="dbitem it"><?=$request["name"]?></span>
					</dd>
				</div>
	<?php	}		# end foreach

		} else { 	# no request found ?>
			<div class="warning"> No requests found. Maybe you <br> 
			<a href="#makerequest">need something?</a> </div>
	<?php } ?>
</dl> <!--End sidelist-->

<div id="marketplace" class="sidecontainer f-right bl">

	<?php 
		if (check_input_market()) { 			# valid input
			$fname = $_GET["fname"];
			$lname = $_GET["lname"];

			if ($_GET["flag"] == "only_me") { 	# set names to current user
	   			$info = get_user_info($_SESSION["user"]);
	    		$fname = $info["fname"];
	    		$lname = $info["lname"];
			}
			# Perform the query.
			$results = market_search($_GET["product"], $_GET["flag"], $fname, $lname, $_GET["check"]);
			if ($results->rowCount() > 0) { 	# found something ?>
				<!-- Section with the results -->
				<div id="result" class="m-a pl-1">
					<p class="cntr m-1 it"> Click on a request to take care of it.</p>
					<table class="m-a">
						<tr>
							<th>User</th>
							<th>Product</th>
							<th>Quantity</th>
						</tr>
					<?php 
						foreach($results as $result) {	 # extract info from query
							$tmp = get_user_info("", $result["id"]);
							$fname = $tmp["fname"];
							$lname = $tmp["lname"];
							$user = htmlspecialchars(ucfirst($fname)." ".ucfirst($lname)." (".$result["id"].")");
							$prod = htmlspecialchars(ucfirst($result["name"]));
							$rID = $result["rID"];

					?>
							<tr>
								<td>
									<a href="utility/actions/a_requestsatisfy.php?id=<?=$rID?>"><?= $user ?></a>
								</td>
								<td><?= $prod ?></td>
								<td class="cntr"><?= $result["quantity"] ?></td>
							</tr>
					<?php } 		# end foreach ?>
						</table>
							<div class="warning good"><a href="market.php">Search again.</a></div>
				</div> <!--End result-->
			<?php } else { 	# no results ?>
				 <div class="warning"> No Results found. 
				 <a href="market.php">Search again.</a> </div>
			<?php } ?>
				<hr>

	<?php } else {  # invalid input ?>
	<!-- Section to interrogate the db -->
	<div id="interrogation" class="pl-1">
		<p class="m-1 cntr"> 
			If you have something to offer, in this section you can search 
			what people needs and maybe help out. Or you can just search for all
			 your orders.
		</p>

		<form>
			<fieldset class="p-1">
				<legend class="it">Select a product</legend>
					<select name="product">
							<option value="all" selected="selected">All products</option>
						<?php foreach (all_of("products") as $product) { ?>
							<option value="<?= $product["name"] ?>"> <?= ucfirst($product["name"]) ?></option>
						<?php } ?>
					</select>
			</fieldset>

			<fieldset class="p-1" >
				<legend class="it">Type of research</legend>
				<label><input class="inline" type="radio" name="flag" value="only_me" id="box" checked="checked">Only my requests</label>
				<label><input class="inline" type="radio" name="flag" value="any" id="unbox">Everyone's requests</label>
				<label><input class="inline" type="checkbox" name="check" value="1">Show solved requests too</label>
			</fieldset>

			<fieldset class="p-1" id="name-search">
				<legend class="it">Search by name</legend>
				<input type="text" name="fname" placeholder="First Name">
				<input type="text" name="lname" placeholder="Last Name">
			</fieldset>
			<input class="mt-1 inline" type="submit" value="Search">
			<input class="mt-1 inline" type="reset" value="Reset">
		</form>

		<hr>
	</div><!--End interrogation-->
	<?php } # end else?>

	<!-- Section for making request, it's a cool interaction! -->
	<div id="market-request" class="pl-1 mt-1">
		<div id="interactive-form">
			<div id="drop-area"> 
				<img src="stili/img/droparea.png" alt="Drop here">
			 </div>

			<form action="utility/actions/a_requestcreate.php" method="POST">
				<label class="inline">Quantity:	<input type="number" name="quantity" value="1" min="1"></label>
				<label class="hidden">Product:	<input type="text" name="product" value="none"></label>
				<input type="submit" value="Submit">
			</form>
		</div> <!--End interactive-form-->
		<?php 
		foreach (all_of("products") as $product) {
			$url = "content/img/products/".$product["img"];
			$pname = $product["name"];
		?>
			<div class="item f-left m1">
				<img id="<?=$pname?>" alt="<?=$pname?>" src="<?=$url?>"> 	<br>
				<span class="bld"><?=ucfirst($pname)?></span> 				<br> 
				<?=$product["description"]?>
			</div>

		<?php }	# end foreach ?>
	</div> <!--End market-request-->
</div> <!--End marketplace--> 

<?php include("bottom.php") ?>