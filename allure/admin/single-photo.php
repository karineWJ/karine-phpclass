<?php 
//figure out which post to display
require('../includes/config.php');
require('admin-header.php'); 
$photo_id = $_GET['id'];?>
	

<div class="container">

	<?php include('admin-sidebar.php'); ?>

	<main class="cf container all-photos">
		<?php //get username
		$query_getusername = "SELECT username
				  			  FROM users
				  			  WHERE user_id = $user_id";

		$result_getusername = $db->query($query_getusername);
		$row_getusername = $result_getusername->fetch_assoc();

		 ?>

		<section>
			<h1><?php echo $row_getusername['username']; ?>'s' Profile</h1>

			<ul class="statistics">
				<li>You have <?php echo count_boards($user_id, $db); ?> boards</li>
				<li>You have <?php echo count_photos_uploaded($user_id, $db); ?> uploaded</li>
				<li>You have NUMBER likes</li>
			</ul>
		</section>
		
		<button onclick="history.go(-1);">Back </button>
		
			<section class="main-section">
				<?php //get the all information of photo that the user is trying to view (user, date, description, tags)
				 $query = "SELECT photos.*, users.username, tags.title 
						   FROM photos, photo_tags, tags, users
			  			   WHERE photos.user_id = users.user_id
			  			   AND photos.photo_id = photo_tags.photo_id
			  			   AND photo_tags.tag_id = tags.tag_id
			  			   AND photos.photo_id = $photo_id
			  			   ORDER BY photos.date DESC";

			  	$result = $db->query($query);
			  	//make sure it was found
				if($result->num_rows >= 1 ){ ?>

					<?php while( $row = $result->fetch_assoc() ){ ?>

					<article class="single-photo">
						<img src="<?php 
							echo uploaded_image_path($row['photo_link'], 'large_img', false) ?>" class="large-outfit">
						<p>Added by <a href="#" class="username"><?php echo $row['username']; ?></a></p>
						<?php echo get_tags($row['photo_id'], $db) ?>
						
						<div class="photo-description">Description: <?php echo $row['description'] ?></div>
					</article>
				<?php }//end while ?>
				 
			</section>
			<?php }//end if ?>
		
		</div>
	</main>

<?php include('admin-footer.php'); ?>