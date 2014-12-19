<?php 
session_start();
//security check! make sure the person viewing this page is logged in 
if( $_SESSION['loggedin'] != true ){
	//kick them out to the login form
	header('Location:login.php');
	//stop this file from loading
	die('You do not have permission to view this page.');
}
//connect to database
require('../includes/config.php');
include_once('../includes/functions.php');

//who is logged in? store in a var for easy use on admin pages
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Panel - Profile Page</title>
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<link rel="stylesheet" type="text/css" href="../css/admin-style.css">
	<link rel="stylesheet" type="text/css" href="../css/fontello.css">
</head>
<body>
	<header>
		<div class="container">
			<h1 class="logo"><a href="index.php">Allure</a></h1>

			<nav id="home-nav">
				<ul>
					<li><a href="#">Explore</a></li>
					<li><a href="#">Upload an Image</a></li>
					<li><a href="#">Add Board</a></li>
				</ul>
			</nav>

			
			<!--	<ul class="utilities">
				<li><a href="#">Account Settings</a></li>
				<li><a href="login.php?action=logout">Log Out</a></li>
			</ul> -->

			<?php user_badge( $user_id, $db ); ?>

		</div>

	</header>