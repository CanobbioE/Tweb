<?php include("top.php"); ?> 

<div id="login" class="f-left pt-1">
	<form action="utility/actions/a_login.php" method="POST">
			<label>Username		<input type="text" name="username" placeholder="Username" required="required"></label>
			<label>Password		<input type="password" name="password" placeholder="Password" required="required"></label>
			<label>				<input type="submit" value="Log In"></label>
	</form>
</div>

<div id="signin" class="f-right pt-1">
	<form action="utility/actions/a_signin.php" method="POST">
			<label>First Name* 			<input type="text" name="fname" placeholder="First Name" required="required"></label>
			<label>Last Name* 			<input type="text" name="lname" placeholder="Last Name" required="required"></label>
			<label>Username* 			<input type="text" name="username" placeholder="Username" required="required"></label>
			<label>Password* 			<input type="password" name="password" placeholder="Password" required="required"></label>
			<label>Confirm Password* 	<input type="password" name="confirm_password" placeholder="Password" required="required"></label>
			<label>e-mail 				<input type="email" name="email" placeholder="e-mail"></label>
			<label>						<input type="submit" value="Sign In"></label>

		<span id="info" class="it">* required</span>
	</form>
	
</div>
<?php include("bottom.php"); ?>
