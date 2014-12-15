<?php 
session_start();
//security check! make sure the person viewing this page is logged in 
if( $_SESSION['loggedin'] != true ){
	//kick them out to the login form
	header('Location:login.php');
	//stop this file from loading
	die('You do not have permission to view this page.');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Blog Admin Panel</title>
</head>
<body>
This is the Dashboard of the admin panel
<a href="login.php?action=logout">Log out</a>
</body>
</html>