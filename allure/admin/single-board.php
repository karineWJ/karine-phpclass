<?php 
require('../includes/config.php');
require('admin-header.php'); 
$board_id = $_GET['id'];?>
	

<div class="container">

	<?php include('admin-sidebar.php'); ?>

	<main id="all-photos" class="cf container">
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

		
			<section class="main-section">
				<?php //get all photos inside boards
				 $query = "SELECT photos.photo_id, photos.photo_link 
						   FROM photos, photo_boards, boards
			  			   WHERE photo_boards.board_id = boards.board_id
			  			   AND photo_boards.photo_id = photos.photo_id
			  			   AND board_id = $board_id
			  			   ORDER BY photos.date DESC";

			  	$result = $db->query($query);
			  	//make sure it was found
				if($result->num_rows >= 1 ){ ?>

				<?php while( $row = $result->fetch_assoc() ){ ?>

					<article class="photo-container">
						<a href="#"><img src="<?php 
							echo uploaded_image_path($row['photo_link'], 'medium_img', false) ?>" class="photo"></a>
						<p>Added by <a href="#" class="username"><?php echo $row['username']; ?></a></p>
						<?php echo get_tags($row['photo_id'], $db) ?>
						<div class="likes"><i class="icon-heart"></i>NUMBER OF LIKES</div>
					</article>
				<?php }//end while ?>
				 
			</section>
			<?php }//end if ?>
		
		</div>
	</main>

<?php include('admin-footer.php'); ?>