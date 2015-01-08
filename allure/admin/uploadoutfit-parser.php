<?php
//parse image uploads if the form was submitted
if($_POST['did_uploadoutfit']){
	//sanitize the data
	$description = clean_input($_POST['description'], $db);
	$tag = $_POST['tag'];
	$board =$_POST['board'];

	//validate
	$valid = true;
	//did they leave description or tag blank?
	if( strlen($description) == 0 || strlen($tag) == 0 ){
		$valid = false;
		$message = "Please fill in all fields.";
	}

	if($valid){


	//file uploading stuff begins
	
	$target_path = "uploads/";
	
	//list of image sizes to generate. make sure a column name in your DB matches up with a key for each size
	$sizes = array(
		'thumb_img' => 100,
		'medium_img' => 200,
		'large_img' => 500
	);	
	
		
	// This is the temporary file created by PHP
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
	// Capture the original size of the uploaded image
	list($width,$height) = getimagesize($uploadedfile);
	
	//make sure the width and height exist, otherwise, this is not a valid image
	if($width > 0 AND $height > 0){
	
	//what kind of image is it
	$filetype = $_FILES['uploadedfile']['type'];
	
	switch($filetype){
		case 'image/gif':
			// Create an Image from it so we can do the resize
			$src = imagecreatefromgif($uploadedfile);
		break;
		
		case 'image/pjpeg':
		case 'image/jpg':
		case 'image/jpeg': 
			// Create an Image from it so we can do the resize
			$src = imagecreatefromjpeg($uploadedfile);
		break;
	
		case 'image/png':
			// Create an Image from it so we can do the resize
			$required_memory = Round($width * $height * $size['bits']);
			$new_limit=memory_get_usage() + $required_memory;
			ini_set("memory_limit", $new_limit);
			$src = imagecreatefrompng($uploadedfile);
			ini_restore ("memory_limit");
		break;
		
			
	}
	//for filename
	$randomsha = sha1(microtime());
	
	//do it!  resize images
	foreach($sizes as $size_name => $size_width){
		if($width >=  $size_width){
		$newwidth = $size_width;
		$newheight=($height/$width) * $newwidth;
		}else{
			$newwidth=$width;
			$newheight=$height;
		}
		$tmp=imagecreatetruecolor($newwidth,$newheight);
		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		
		$filename = $target_path.$randomsha.'_'.$size_name.'.jpg';
		$didcreate = imagejpeg($tmp,'../'.$filename,70);
		imagedestroy($tmp);
		
		
	}//end of foreach
	//store in DB if it successfully saved the image to the file
		if($didcreate){
			//add the photo
			$query = "INSERT INTO photos
						   (user_id, description, photo_link, date)
				 		   VALUES
				 		   ($user_id, '$description', '$randomsha', now() )";

			$result = $db->query($query);
			$photo_id = $db->insert_id;

			if($board != ''){
			//board
			$query_b = "INSERT INTO photo_boards
						   (photo_id, board_id)
				 		   VALUES
				 		   ( $photo_id, $board )";

			$result_b = $db->query($query_b);
			}
			//TODO: tags??!
		}		
	imagedestroy($src);
	
		
	}else{//width and height not greater than 0
		$didcreate = false;
	}
	
	
	if($didcreate) {
		$statusmsg .=  "The file ".  basename( $_FILES['uploadedfile']['name']). 
		" has been uploaded <br />";
	}else{
		$statusmsg .= "There was an error uploading the file, please try again!<br />";
	}
}//end if valid
}
//end of image parser