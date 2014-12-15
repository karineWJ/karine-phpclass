<?php
//opens or resumes a session
session_start();
//connect to DB
require('../includes/config.php');
include_once('../includes/functions.php');
//parse the form if it was submitted
if( $_POST['did_login'] == true ){
	//extract the user submitted data
	$username = clean_input( $_POST['username'], $db ); //this will clean everything
	$password = clean_input( $_POST['password'], $db );

	//hashed version of the password for DB comparison
	$hashed_password = sha1($password); 


	//make sure the values are within the length limits
	if( strlen($username) <= 50 && strlen($username) >= 3 && strlen($password) >= 5 ){
	//check to see if these credentials exist in the DB
		$query = "SELECT user_id
				  FROM users
				  WHERE username = '$username'
				  AND password = '$hashed_password' 
				  LIMIT 1";

		//run it
		$result = $db->query($query);

	//if they match, log them in
		if( $result->num_rows == 1 ){
			//TODO: Make these cookies more secure
			//success! Remember the user for 1 week
			setcookie('loggedin', true, time() + 60 * 60 * 24 * 7 );
			$_SESSION['loggedin'] = true;

			//WHO is logged in?
			$row = $result->fetch_assoc();
			$user_id = $row['user_id'];

			setcookie('user_id', $user_id, time() + 60 * 60 * 24 * 7 );
			$_SESSION['user_id'] = $user_id;

			//redirect to admin panel
			header('Location:index.php');
		}else{
			$message = 'Your username and password combo is incorrect.';
		}//end if credentials match
	}// end if within limits
	else{
		//length out of bounds
		$message = 'Your username and password combo is incorrect.';
	}
}//end if did login

// Note: This will destroy the session, and not just the session data!
//Got this code from php.net
if (ini_get("session.use_cookies")) {
	//remove the session_id cookie from the user's computer
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

//check to see if the cookie is still valid, if so, re-build the session
if( $_GET['action'] == 'logout'){
	//remove all session and cookie vars
	session_destroy(); //deletes session ID
	//remove all the session to null
	unset( $_SESSION['loggedin'] );
	//set cookies to null
	setcookie( 'loggedin', '' );
	
	unset($_SESSION['user_id']);
	setcookie('user_id', '');
}
//if the user returns to this file and is still logged in(cookie still valid), re-create the session and then redirect to admin
elseif( $_COOKIE['loggedin'] == true){ 
	//TODO: fix this secity loophole
	$_SESSION['loggedin'] = true;
	$_SESSION['user_id'] = $_COOKIE['user_id'];
	//redirect to admin
	header('Location:index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Simple Login Form</title>
	<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>

	<style type="text/css">
		body{
			font-family: 'Amaranth', sans-serif;
			margin: 0 auto;
			padding-top: 5em;
		}
		#container{
			width: 320px;
			border: solid 2px #C0C0C0;
			border-radius: 5px;
			margin: 0 auto;
			-webkit-box-shadow: 0px 0px 11px 0px rgba(50, 50, 50, 0.49);
			-moz-box-shadow:    0px 0px 11px 0px rgba(50, 50, 50, 0.49);
			box-shadow:         0px 0px 11px 0px rgba(50, 50, 50, 0.49);
		}
		h1{
			font-size: 1.8em;
			text-align: center;
		}

		label,
		input[type="submit"]{
			display: block;
		}
		label{
			margin-top: 1em;
			margin-bottom: 0.5em;
			font-weight: bold;
		}
		input[type="submit"]{
			margin-top: 1em;
			background-color: #3DA03F;
			padding: 0.4em 1em;
			color: white;
			border:none;
			border-radius: 2px;
			cursor:pointer;
			margin-bottom: 3em;
		}
		input[type="submit"]:hover{
			background-color: #46B749;
		}
		input[type="text"],
		input[type="password"]{
			padding: 0.25em 0;
		}
		form{
			width: 180px;
			margin: 0 auto;
		}
	</style>
</head>
<body>
	<div id="container">
		
		<h1>Log In to Your Account</h1>

		<?php echo $message; //success/fail message from above ?>

		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">  <!--the value for action will give you the relative path to this file -->
			<label for="username">Username</label>
			<input type="text" name="username" id="username">

			<label for="password">Password</label>
			<input type="password" name="password" id="password">

			<input type="submit" value="Log In">
			<input type="hidden" name="did_login" value="true">
		</form> 
		
	</div>

</body>
</html>