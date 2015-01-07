<?php 
require('../includes/config.php');
require('admin-header.php'); 


//parse the form if the user submitted it
if($_POST['did_save']){
	//clean the data
	$username = clean_input($_POST['username'], $db);
	$email 	  = clean_input($_POST['email'], $db);
	$password = clean_input($_POST['password'], $db);
	$biography   = clean_input($_POST['about'], $db);

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
						   AND user_id != $user_id
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
						AND user_id != $user_id
						LIMIT 1";

		$result_email = $db->query($query_email);
		//if one result found, email is already taken
		if($result_email->num_rows == 1){
			$valid = false;
			$errors['email'] = 'That email is already taken. <a href="login.php">Do you want to login</a>?';
		}
	}//end email check

	//check for invalid password
	if( strlen($password) < 5 AND strlen($password) != 0 ){
		$valid = false;
		$errors['password'] = 'Password must be at least 5 characters long.';
	}


	//if valid, update change in the database

	if($valid){
		$query_editaccount ="UPDATE users
							 SET username = '$username',
							     email = '$email',
							     biography = '$biography'
							    ";
		//only edit password if they filled it in
		if(strlen($password) != 0){
			$query_editaccount .= ", password = '$hashed_password'";
		}
		$query_editaccount .= "WHERE user_id = $user_id";
		

		$result_editaccount = $db->query($query_editaccount);

		//make sure it worked
		if( $db->affected_rows >= 1 ){
			$message = 'Account settings was successfully saved.';

		} //end if query worked
		else{
			$message = 'No changes were made.';
		}
	} //end if valid
	else{
			$message = 'not valid.';
		}
}//end parse

//Pre-fill the form with the current values, and check to make sure the logged in person wrote it
$query = "SELECT username, email, password, biography, medium_img
		  FROM users
		  WHERE user_id = $user_id
		  LIMIT 1";

$result = $db->query($query);
?>
	
	<main>
		<div class="container">
			<?php //make sure it was found
				if( $result->num_rows == 1){
					$row = $result->fetch_assoc();
			?>
			<h2 class="tabbed-title">Account Settings</h2>

			<?php if( isset($statusmsg) ){
				echo $statusmsg;
			} ?>

			<?php echo $message;
			kwj_array_list($errors); ?>
			
			<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="edit-account">
				
				<fieldset class="no-border">
					<label>Profile Picture</label>
					<input type="file" name="uploadedfile" class="uploadfile">

					<input type="submit" value="Upload Image">
					<input type="hidden" name="did_upload" value="true">
				</fieldset>
			</form>

			<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="edit-account">

				<fieldset class="no-border">
					<label for="username">Username</label>
					<input type="text" name="username" id="username-edit" value="<?php echo $row['username'] ?>" class="grey-input">

					<label for="email">Email Address</label>
					<input type="email" name="email" id="email-edit" value="<?php echo $row['email'] ?>" class="grey-input">

					<label for="password">New Password</label>
					<input type="password" name="password" id"password-edit" class="grey-input">

					<label for="about">About Me</label>
					<input type="text" name="about" id="about-edit" value="<?php echo $row['biography'] ?>" class="grey-input">
				</fieldset>

				<input type="submit" value="Save Profile" class="save">
				<input type="hidden" name="did_save" value="true" class="save">

				<a href="index.php" class="cancel">Cancel</a>
			</form>

		</div>
		<?php 
		} ?>
	</main>

<?php include('admin-footer.php'); ?>