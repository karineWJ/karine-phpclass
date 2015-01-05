 <?php 
//connect to DB
require('includes/config.php');
require_once('includes/functions.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Allure</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
	<header>
		<div class="container">
			<h1 class="logo"><a href="index.php">Allure</a></h1>
			
			<a href="admin/login.php" class="navigation login">Login</a>

			<nav id="home-nav" class="navigation cf">
				<ul>
					<li><a href="explore.php">Explore</a></li>
					<li><a href="about.php">About</a></li>
					<li><a href="#">How it works</a></li>
				</ul>
			</nav>
		</div>

	</header>