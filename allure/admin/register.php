<?php 
//open the sesion and connect to database
session_start();
require('../includes/config.php');
include_once('../includes/functions.php');

//parse the form if the user submitted it
if($_POST['did_register']){
	//clean the data
	$username = clean_input($_POST['username'], $db);
	$email 	  = clean_input($_POST['email'], $db);
	$password = clean_input($_POST['password'], $db);
	$policy   = clean_input($_POST['policy'], $db);

	//hashed password
	$hashed_password = sha1($password);

	//validate
	$valid = true;

	//username not within the limits
	if( strlen($username) < 3 || strlen($username) > 50 ){
		$valid = false;
		$errors['username'] = 'Choose a username that is between 3 to 50 characters long.';
	}else{
		//if the length check passed, check to see if this username is already taken in DB
		$query_username = "SELECT username
						   FROM users
						   WHERE username = '$username'
						   LIMIT 1";

		$result_username = $db->query($query_username);
		//if one result found, name is already taken
		if($result_username->num_rows == 1){
			$valid = false;
			$errors['username'] = 'That username is already taken.';
		}
	}//end username tests

	//check for invalid or blank email
	if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = false;
		$errors['email'] = 'Please provide a valid email address, like johndoe@mail.com';
	}else{
		//valid email, but make sure it isnt already taken in DB
		$query_email = "SELECT email
						FROM users
						WHERE email = '$email'
						LIMIT 1";

		$result_email = $db->query($query_email);
		//if one result found, email is already taken
		if($result_email->num_rows == 1){
			$valid = false;
			$errors['email'] = 'That email is already taken. <a href="login.php">Do you want to login</a>?';
		}
	}//end email check

	//check for invalid password
	if( strlen($password) < 5 ){
		$valid = false;
		$errors['password'] = 'Password must be at least 5 characters long.';
	}

	//check to see if policy checkbox was checked
	if( $policy != 1 ){
		$valid = false;
		$errors['policy'] = 'Please agree to the Terms before registering.';
	}

	//if valid, add the new user to DB
	if($valid){
		$query_newuser = "INSERT INTO users
						 (username, is_admin, email, password, date_joined)
						 VALUES
						 ( '$username', 1, '$email', '$hashed_password', now() )"; //put quotes if field is varchar
	
		$result_newuser = $db->query($query_newuser);

		//check to make sure the user was added
		if($db->affected_rows == 1 ){
			//log them in and redirect to admin
			setcookie('loggedin', true, time() + 60 * 60 * 24 * 7 );
			$_SESSION['loggedin'] = true;

			//get their new user id
			$user_id = $db->insert_id;

			setcookie('user_id', $user_id, time() + 60 * 60 * 24 * 7 );
			$_SESSION['user_id'] = $user_id;

			//redirect
			header('Location:index.php');

		}else{
			$errors['db'] = 'Something went wrong during account creation. Contact customer service.';
		}

	}//end valid
	
}//end of parser
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Allure Sign Up for an Account</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
	<div id="register-container">
		<a href="../index.php"><img src="../images/allure_logo_black.png" alt="Logo"></a>
		<h1>Create an account</h1>

		<?php //if there are errors, show them
			if( isset($errors) ){
			kwj_array_list($errors);
			}
		 ?>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="register-form">  <!--the value for action will give you the relative path to this file -->
			
			<input type="text" name="username" id="username" placeholder="Username">

			<input type="email" name="email" id="email" placeholder="Email Address">

			<input type="password" name="password" id="password" placeholder="Password">

			<label>
			<input type="checkbox" name="policy" value="1" id="policy" <?php if($policy){echo 'checked';} ?>>
			By creating an account, I agree to the <a href="../policy.php">terms and conditions.</a>
			</label>

			<input type="submit" value="Create account">
			<input type="hidden" name="did_register" value="true">
		</form>


		
	</div>

</body>
</html>