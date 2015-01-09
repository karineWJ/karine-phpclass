
<aside id="sidebar" class="cf">
	<div class="container">

	<?php //get profile picture, joined date, user's biography
	$query = "SELECT medium_img, date_joined, biography
			  FROM users
			  WHERE user_id = $user_id";
	//run it
	$result = $db->query($query);
	if( $result->num_rows >= 1 ){
		$row = $result->fetch_assoc();

		if( $row['medium_img'] ){
			$image = SITE_URL . $row['medium_img'];
		}else{
			//document root is htdocs
			$image = 'http://localhost/karine-phpclass/allure/images/default-avatar.png';
		}
		
	//display it
	?>
	<section class="profile-bio">
		<img src="<?php echo $image; ?>" class="big-profilepic">
		<div class="user-info">
			<p>Joined <?php echo convert_date($row['date_joined']); ?></p>
			<h2>About me</h2>
			<p><?php echo $row['biography']; ?></p>	
		</div>
	</section>
	<?php }//end if ?>


	<?php //get number of followers and number of followees

	?>
	<section class="follow-stats cf">
		<ul>
			<li># <span style="color:#697fbf">Followers</span></li>
			<li># <span style="color:#697fbf">Following</span></li>
		</ul>
	</section>


	</div>
</aside>