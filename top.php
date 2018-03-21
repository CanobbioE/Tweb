<?php session_start(); 
# Top of every page of the website. It starts the session. Has the navigation bar's code.
require_once("utility/functions/utils.php");
require_once("utility/functions/db.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- 
			Progetto TWEB 2017: Rurals Comunity
			Studente: Edoardo Canobbio 805585
			Progetto: l'idea è quella di fornire ad una comunità rurale una semplice piattaforma tramite la quale i pochi abitanti della comunità possano coordinarsi e orgnizzarsi riguardo alle necessità dei compaesani, sia per quanto riguarda materie prime che per servizi.
		 -->
		<title>Rurals Comunity</title>
		<script src="utility/js/prototype/prototype.js" type="text/javascript"></script>
	 	<script src="utility/js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
		<script src="utility/js/progetto.js" type="text/javascript"></script>
		<link rel="icon" href="stili/img/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="stili/shared.css">
		<link rel="stylesheet" type="text/css" href="stili/navigation.css">
		<link rel="stylesheet" type="text/css" href="stili/slideshow.css">
		<link rel="stylesheet" type="text/css" href="stili/weather.css">
		<link rel="stylesheet" type="text/css" href="stili/market.css">
		<link rel="stylesheet" type="text/css" href="stili/forms.css">
		<link rel="stylesheet" type="text/css" href="stili/main.css">
	</head>

	<body class="c5">
			<div id="navigation" class="p-0 m-0">
				<div id="logo" class="f-left p-0 m-0">
					<a href="index.php">
						<img src="stili/img/logo.png" alt="Home">
					</a>
				</div>
				<ul class="p-0 m-0 c2">
					<li><a href="index.php">Home</a></li>
					<li><a href="events.php">Events</a></li>
					<li><a href="weather.php">Weather</a></li>
					<li><a href="market.php">Market</a></li>
					<li><a href="profile.php">Profile</a></li>
					<?php if (isset($_SESSION["user"])) { ?> 
		 			<li class="f-right"><a href="utility/actions/a_logout.php">Logout</a></li> 	<?php } else { ?>
					<li class="f-right"><a href="login.php">Login</a></li> 						<?php } ?>
				</ul>
			</div>
	
	<div id="wrapper" class="c3 m-a">
<?php
	if (isset($_SESSION["flash"])) {
		?>
		<div id="flash" class="c4 it cntr p-1"><?= $_SESSION["flash"] ?></div>
		<?php
		unset($_SESSION["flash"]);
	}
 ?>
