<?php
//opens or resumes a session
session_start();
//connect to DB
require('../includes/config.php');
require_once('../includes/functions.php');
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
			$message = 'Your username and password combo do not match.';
		}//end if credentials match
	}// end if within limits
	else{
		//length out of bounds
		$message = 'Your username and password combo is incorrect.';
	}
}//end if did login




//check to see if the cookie is still valid, if so, re-build the session
if( $_GET['action'] == 'logout'){
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
	<title>Allure Login Form</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	
	<div id="login-container">
		<a href="../index.php"><img src="../images/allure_logo_black.png" alt="Logo"></a>
		<h1>Log In to Your Account</h1>

		<?php echo $message; ?>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login-form">  <!--the value for action will give you the relative path to this file -->
			
			<input type="text" name="username" id="username" placeholder="Username">

			<input type="password" name="password" id="password" placeholder="Password">

			<a href="#" class="forgot-pass">Forgot Password?</a>

			<input type="checkbox" name="remember" id="remember" value="remember">
			<label for="remember">Remember me</label>

			<input type="submit" value="Log In">
			<input type="hidden" name="did_login" value="true">
		</form>
		<p>Don't have an account? <a href="register.php" class="signup-link">Sign up</a></p>
		
	</div>

</body>
</html>