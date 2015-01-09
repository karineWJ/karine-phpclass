<?php
/**
 * Convert mysql datetime format to human readable date
 * @param datetime $dateR  	the date that needs to be made readable
 * @return string 			the date in Month Day, Year format
 * @author karine <karine.wj89@gmail.com>
 */

function convert_date($dateR){
$engMon=array('January','February','March','April','May','June','July','August','September','October','November','December',' ');
$l_months='January:February:March:April:May:June:July:August:September:October:November:December';
$dateFormat='F j, Y';
$months=explode (':', $l_months);
$months[]='&nbsp;';
$dfval=strtotime($dateR);
$dateR=date($dateFormat,$dfval);
$dateR=str_replace($engMon,$months,$dateR);
return $dateR;
}

/**
 * Make timestamp for RSS feed
 */
function convTimestamp($date){
  $year   = substr($date,0,4);
  $month  = substr($date,5,2);
  $day    = substr($date,8,2);
  $hour   = substr($date,11,2);
  $minute = substr($date,14,2);
  $second = substr($date,17,2);
  $stamp =  date('D, d M Y H:i:s O', mktime($hour, $min, $sec, $month, $day, $year));
  return $stamp;
}

/**
 * Clean String Inputs before submitting to DB
 *@param  $input - the dirty data that needs cleaning!
 *@param  $db -  Database object
 *@return cleaned data
 */
function clean_input($input, $db){ //arguments are things coming from the outside file
	return mysqli_real_escape_string( $db, strip_tags($input));
}

function kwj_array_list($array){
	//if the array exists, display it
	if( is_array( $array )){
	echo '<ul>';
	//output one list item per thing in the array
	foreach( $array as $item ){ // $item is a made up alias name for the $array
		echo '<li>' . $item . '</li>';
	}
	echo '</ul>';
	}
}

//Display one error message (use this next to a field)
function kwj_inline_error( $array, $item ){
	//check to make sure the item exists in the array
	if( isset( $array[$item] ) ){
		echo '<div class="inline-error">' . $array[$item] . '</div>';
	}
}

/**
 * Count posts of any user
 * @param   int user - a user ID
 * @param   int status - what kind of posts are we counting
 *						1 = default. only published posts
 *						2 = only private (draft) posts
 *						3 = count all posts
 * @param resource db - database connection
 * @return int - total count of posts
 */
function count_posts( $user, $status = 1, $db){
	//count the posts
	$query = "SELECT COUNT(*) AS total
			  FROM posts
			  WHERE user_id = $user";
	//depending on the value of status, refine the query
	if ( 1 == $status ){
		$query .= " AND is_published = 1";
	}elseif( 2 == $status ){
		$query .= " AND is_published = 0";
	}

	//run it
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	return $row['total'];

}

/**
 * Count the number of comments on any user's posts
  * @param   int user - a user ID
  * @param   resource db- database connection
 */
function count_user_post_comments( $user, $db){
	//count the comments
	$query = "SELECT COUNT(*) AS total
			  FROM posts, comments
			  WHERE posts.post_id = comments.post_id
			  AND posts.user_id = $user";

	$result = $db->query($query);
	$row = $result->fetch_assoc();
	return $row['total'];
}

/**
 *  TODO: Count total number of photos uploaded and photos saved. Order by newest to oldest
 * @param int user - a user ID
 * @param resource db - database connection
 */
function count_all_photos( $user, $db ){
	//count all photos
	$query = "SELECT COUNT(*) AS total
			  FROM photos, photo_boards
			  WHERE user_id = $user
			  ORDER BY date DESC";

	$result = $db->query($query);
	$row = $result->fetch_assoc();
	return $row['total'];
}


/**
 * Count the total number of uploaded images
 * @param  int user - a user ID
 * @param resource db - database connection
 */
function count_photos_uploaded(	$user, $db){
	//count photos uploaded
	$query = "SELECT COUNT(*) AS total
			  FROM photos
			  WHERE user_id = $user";

	$result = $db->query($query);
	$row = $result->fetch_assoc();
	return $row['total'];
}

/**
 * Count total number of boards created
 * @param int user - a user ID
 * @param resource db - database connection
 */
function count_boards( $user, $db ){
	//count boards created
	$query ="SELECT COUNT(*) AS total
			 FROM boards
			 WHERE user_id = $user";

	$result = $db->query($query);
	$row = $result->fetch_assoc();
	return $row['total'];
}

/**
 * Generate an ID badge for any user
 */
function user_badge( $user, $db ){
	//get the user's name, profile pic, admin status
	$query = "SELECT username, thumb_img, is_admin
			  FROM users
			  WHERE user_id = $user
			  LIMIT 1";

	$result = $db->query($query);
	//check it
	if($result->num_rows == 1 ){
		$row = $result->fetch_assoc();

		if( $row['thumb_img'] ){
			$image = SITE_URL . $row['thumb_img'];
		}else{
			//document root is htdocs
			$image = 'http://localhost/karine-phpclass/allure/images/default-avatar.png';
		}

		//display it
		?>
		<div class="user-badge">
			<img src="<?php echo $image; ?>" class="user-pic">
			
			<div class="user-name dropdown">
				
				<a href="#" class="account"><?php echo $row['username']; ?><i class="icon-down-dir"></i></a>

				<div class="submenu">
					<ul class="root">
						<li><a href="<?php echo SITE_URL ?>admin/index.php">View profile</a></li>
						<li><a href="<?php echo SITE_URL ?>admin/account-setting.php">Account Settings</a></li>
						<li><a href="<?php echo SITE_URL ?>admin/login.php?action=logout">Log Out</a></li>
					</ul>
				</div>

			</div>

		</div> 
	
		<?php
	}//end if 

	
}//end function

/**
 * helper for generating complete URL or filepath to an uploaded image
 * Path will look like C:/xampp/htdocs/folder/uploads/s45fs836p434_small.jpg
 * Path will look like C:/xampp/htdocs/folder/uploads/s45fs836p434_small.jpg
 * URL will look like http://localhost/folder/uploads/s45fs836p434_small.jpg
 * @param $key string randomly generated key unique to each image
 * @param $size_name string. valid values are 'thumb_img' (DEFAULT), 'medium_img', 'large_img'
 * @param $is_path boolean. 1 = returns a file path
 *							0 = returns a URL
 */
function uploaded_image_path($key, $size_name = 'thumb_img', $is_path = true){
	if($is_path){
		return SITE_PATH . 'uploads/' .$key . '_' . $size_name . '.jpg';
	}else{
		return SITE_URL . 'uploads/' .$key . '_' . $size_name . '.jpg';
	}
}

function get_tags($photo_id, $db){
	//get the tags that are assigned to THIS photo
		$query = "SELECT tags.title
				 FROM  tags, photo_tags, photos
				 WHERE photo_tags.tag_id = tags.tag_id
				 AND photos.photo_id = photo_tags.photo_id
				 AND photos.photo_id = $photo_id";
	//run it
		$result = $db->query($query);
	//check it
	//loop it - return a comma sep list	
		$num_tags = $result->num_rows;
		if( $result->num_rows >= 1){
			$i = 1;
			?><p>Tags: 
			
			<?php while( $row = $result->fetch_assoc() ){ ?>
			<a href="#"><?php echo $row['title'] ?></a><?php if($i < $num_tags){
				echo  ', ';
			} ?> 
		<?php 
			$i ++;
			}//end while
			?>
		</p>
			<?php 
		}//end if 
		
}

//no close php