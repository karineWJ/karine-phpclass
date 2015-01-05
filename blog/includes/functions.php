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
			$image = SITE_PATH . $row['thumb_img'];
		}else{
			//document root is htdocs
			$image = 'http://localhost/karine-phpclass/blog/images/default-avatar.png';
		}

		//display it
		?>
		<div class="user-badge">
			<img src="<?php echo $image; ?>" class="user-pic">
			<div class="user-name"><?php echo $row['username']; ?></div>
			<div class="user-role"><?php echo $row['is_admin'] == 1 ? 'Administrator' : 'Commentor';
			// this ask whether user is an admin. If yes, it will write administrator, and if not it will write commentor ?>
			</div> 
		</div>
		<?php
	}//end if 

	
}//end function


//no close php