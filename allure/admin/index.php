<?php require('admin-header.php'); ?>
	<div class="container">

	<form action="search.php" method="get" id="searchform">
		<input type="search" name="phrase" id="phrase" class="searchTerm" placeholder="Search look" value="<?php echo $_GET['phrase']; ?>"><button type="submit" class="searchButton"><i class="icon-search"></i></button>
	</form>

	<?php include('admin-sidebar.php'); ?>

	<main id="all-photos" class="cf container">

		<?php //get sum of photos uploaded and photos saved, get total number of boards, total number of photos uploaded, total number of likes  ?>
		<section>
			<h1><?php echo $row['username']; ?> Profile</h1>

			<ul class="statistics">
				<li>You have NUMBER boards</li>
				<li>You have <?php echo count_photos_uploaded($user, $db); ?> uploaded</li>
				<li>You have NUMBER likes</li>
			</ul>
		</section>

		<?php 
		//get username, photo_link, photo_id, and tag title.
		$query = "SELECT photos.photo_id, photos.photo_link, users.username, tags.title
			 	  FROM photos, users, tags, photo_tags
			  	  WHERE users.user_id = photos.user_id
			  	  AND photos.photo_id = photo_tags.photo_id
			 	  AND photo_tags.tag_id = tags.tag_id
			 	  ORDER BY photos.date DESC";
		//run it 
		$result = $db->query($query);
		if( $result->num_row >= 1 ){
			while( $row = $result->fetch_assoc() ){
		?>
			<section id="main-section">
			<article class="photo-container">
				<a href="#"><img src="<?php echo 'http://localhost/karine-phpclass/allure' . $row['photo_link']; ?>" class="photo"></a>
				<p>Added by <a href="#" class="username"><?php echo $row['username']; ?></a></p>
				<P>Tags: <a href="#" class="tag"><?php echo $row['title']; ?></a></P>
				<div class="likes"><i class="icon-heart"></i>NUMBER OF LIKES</div>
			</article>
		</section>
		<?php }//end while
		}//end if
		else{
			echo 'You have no photos on your profile yet';
			} ?>
		

		</div>
	</main>

<?php include('admin-footer.php'); ?>