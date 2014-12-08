<?php
//parse the comments form
if( $_POST['did_comment'] ){
	//extract and sanitize the data
	$body = mysqli_real_escape_string( $db, strip_tags($_POST['body']) ); //this protects the database

	//@TODO: change this so it works with the DB
	$user_id = 1; //a valid user id --> user this to fake login form

	//validate
	$valid = true;
	if( $body == '' ){
		$valid = false;
		$message = 'Please fill in the body';
	}
	//if valid, store in database, show a success message to user
	if( $valid ){
		//set up query 
		$query_insert = "INSERT INTO comments
						 (body, date, user_id, post_id, status)
						 VALUES
						 ('$body', now(), $user_id, $post_id, 1)";
		//run it
		$result_insert = $db->query($query_insert);
		//check to see if it worked
		if( $db->affected_rows == 1 ){
			$message = 'Thank you for your comment.';
		}//end if query worked
		else{
			$message = 'Sorry, your comment could not be added. Try again.';
		}
	}//end if valid
}//end of parser