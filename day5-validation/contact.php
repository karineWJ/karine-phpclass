<?php
//load the functions file
require_once('functions.php'); //similar to 'include' but 'require' will kill the rest of the page if it doesn't load


//parse the form when it is submitted
if( $_POST['did_send'] == true ){
	//extract and sanitize user submitted data
	$name    = filter_var( $_POST['name'], FILTER_SANITIZE_STRING ); //got it from php.net
	$email   = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL );
	$phone   = filter_var( $_POST['phone'], FILTER_SANITIZE_NUMBER_INT );
	$message = filter_var( $_POST['message'], FILTER_SANITIZE_STRING );
	
	//validate all fields
	$valid = true;
	//check to see if name is blank
	if( $name == '' ){
		$valid = false;
		$errors['name'] = 'Please provide your name';
	}
	//check for invalid or blank email
	if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = false;
		$errors['email'] = 'Please provide a valid email address';
	}
	//check to see if message is blank
	if( $message == '' ){
		$valid = false;
		$errors['message'] = 'Please fill in the message';
	}

	//if the data passes validation, send the mail. Otherwise, show an error message
	if( $valid ){
		//send mail
		$to = 'karine.wj89@gmail.com';
		$subject = 'Testing PHP contact';
		// \n is equal to line break
		// .= is the concatenating operator (add on to)
		$body = "Sent By: $name \n";
		$body .= "Email: $email \n"; 
		$body .= "Phone Number: $phone \n";
		$body .= "message: $message \n";

		$headers = "Reply-to: $email";

		$mail_status = mail($to, $subject, $body, $headers);

		if($mail_status){
			$feedback = 'Thank you for your message';
		}else{
			$feedback - 'There was a problem sending the mail.';
		}

	}else{
		$feedback = 'Something went wrong. Try again';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contact Form with validation and sanitization</title>
	<link rel="stylesheet" type="text/css" href="contact-style.css">
	<link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
</head>
<body>
	<h1>Contact Us</h1>

	<?php 
	//show the feedback if it exists
	if( isset($feedback) ){ //isset - Determine if a variable is set and is not NULL
		echo '<div class="feedback">';
		echo $feedback;
		
		kwj_array_list($errors);

		echo '</div>';
	} ?>
	<!-- Use the novalidate attribute in the form to test the PHP, then remove it -->

	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<label for="name">Name:</label>
		<?php kwj_inline_error( $errors, 'name'); ?>
		<input type="text" name="name" id="name" value="<?php echo $name; ?>"> <!-- Adding a value attribute will allow the value to stick/remain once you have submitted ==> Better usability -->

		<label for="email">Email:</label>
		<?php kwj_inline_error( $errors, 'email'); ?>
		<input type="email" name="email" id="email" value="<?php echo $email; ?>">

		<label for="phone">Phone Number: (optional)</label>
		<input type="tel" name="phone" id="phone" value="<?php echo $phone; ?>">

		<label for="message">Message:</label>
		<?php kwj_inline_error( $errors, 'message'); ?>
		<textarea name="message" id="message"><?php echo $message; ?></textarea>

		<input type="submit" value="Send Message">
		<input type="hidden" name="did_send" value="true"> <!-- It's designed to save raw data, without user's direct input -->
	</form>

</body>
</html>