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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<script type="text/javascript" >
		$(document).ready(function(){

			$(".account").click(function(){
				var X=$(this).attr('id');
				
				if(X==1){
					$(".submenu").hide();
					$(this).attr('id', '0'); 
				}else{
					$(".submenu").show();
					$(this).attr('id', '1');
				}
			});

			//Mouse click on sub menu
			$(".submenu").mouseup(function(){
				return false
			});

			//Mouse click on my account link
			$(".account").mouseup(function(){
				return false
			});

			//Document Click
			$(document).mouseup(function(){
				$(".submenu").hide();
				$(".account").attr('id', '');
			});
		});
	</script>

</head>

<body>
	<header>
		<div class="container">
			<h1 class="logo"><a href="index.php">Allure</a></h1>
			
			<nav id="home-nav" class="cf">
				<ul>
					<li><a href="../explore.php">Explore</a></li>
					<li><a href="#" class="coral"><i class="icon-upload"></i>Upload</a></li>
					<li><a href="#"><i class="icon-plus"></i>Board</a></li>
				</ul>
			</nav>
			
			<?php user_badge( $user_id, $db ); ?>
			
			<!-- <ul class="utilities">
				<li><a href="#">Account Settings</a></li>
				<li><a href="login.php?action=logout">Log Out</a></li>
			</ul> -->
		</div>

	</header>