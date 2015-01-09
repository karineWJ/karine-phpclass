<?php 
require('../includes/config.php');
require('admin-header.php'); 
$board_id = $_GET['id'];?>
	

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
			<hr>
				<li><span class="coral"><?php echo count_boards($user_id, $db); ?></span> <a href="#">boards</a></li>
				<li><span class="coral"><?php echo count_photos_uploaded($user_id, $db); ?></span> <a href="#">uploaded</a></li>
				<li><i class="icon-heart coral"></i></span> <a href="#">likes</a></li>
				<hr>
			</ul>
		</section>

		<button onclick="history.go(-1);">Back </button>

		
			<section class="main-section">
				<?php //get all photos inside boards, including
				 $query = "SELECT photos.photo_id, photos.photo_link,users.username
						   FROM photos, photo_boards, boards, users
			  			   WHERE photo_boards.board_id = boards.board_id
			  			   AND photo_boards.photo_id = photos.photo_id
			  			   AND users.user_id = photos.user_id
			  			   AND boards.board_id = $board_id
			  			   ORDER BY photos.date DESC";

			  	$result = $db->query($query);
			  	//make sure it was found
				if($result->num_rows >= 1 ){ ?>

				<?php while( $row = $result->fetch_assoc() ){ ?>

					<article class="photo-container">
						<a href="<?php echo SITE_URL ?>admin/single-photo.php?id=<?php echo $row['photo_id'] ?>"><img src="<?php 
							echo uploaded_image_path($row['photo_link'], 'medium_img', false) ?>" class="photo"></a>
						<p>Added by <a href="#" class="username"><?php echo $row['username']; ?></a></p>
						<?php echo get_tags($row['photo_id'], $db) ?>
						<div class="likes"><i class="icon-heart coral"></i>LIKES</div>
					</article>
				<?php }//end while ?>
				 
			</section>
			<?php }//end if ?>
		
		</div>
	</main>

<?php include('admin-footer.php'); ?>