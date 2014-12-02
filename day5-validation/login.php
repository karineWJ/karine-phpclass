<?php
//opens or resumes a session
session_start();
//parse the form if it was submitted
if( $_POST['did_login'] == true ){
	//extract the user submitted data
	$username = strip_tags( $_POST['username'] ); //the strip_tags strips HTML and PHP tags from strings ==> it sanitizes it
	$password = strip_tags( $_POST['password'] );

	//TEMPORARY: The correct credentials. We will replace this with database driven logic in the future
	$correct_username = 'karine';
	$correct_password = 'kakaka';

	//make sure the values are within the length limits
	if( strlen($username) < 20 && strlen($password) > 5 ){
	//compare the user submitted values with the correct credentials
	//if they match, log them in
		if( $username == $correct_username && $password == $correct_password ){
			//success! Remember the user for 1 week
			setcookie('loggedin', true, time() + 60 * 60 * 24 * 7 );
			$_SESSION['loggedin'] = true;
			$message = 'You are now logged in';
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
}
elseif( $_COOKIE['loggedin'] == true){
	$_SESSION['loggedin'] = true;
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
		<?php //if the user is logged in, hide the form
			if( $_SESSION['loggedin'] == true ){
				include('content-loggedin.php');
			}else{ ?>
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
		<?php } //end if logged in ?>
	</div>

</body>
</html>