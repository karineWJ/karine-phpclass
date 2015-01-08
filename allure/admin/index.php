<?php 
require('../includes/config.php');
require('admin-header.php'); ?>
	

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

		
			<section class="main-section">

				<?php //get title of board
				$query_board = "SELECT title, board_id
				  			    FROM boards
				  			    WHERE user_id = $user_id";

				$result_board = $db->query($query_board); 
				 //make sure it was found
				if($result_board->num_rows >= 1 ){ ?>
				
					
				<article class="board">
					<?php while ( $row_board = $result_board->fetch_assoc() ){ ?> 
					<a href="<?php echo SITE_URL ?>admin/single-board.php?id=<?php echo $row_board['board_id'] ?>"><?php echo $row_board['title'] ?></a>
					<?php }//end while ?>
					
				</article>
 					<?php }else{
 						echo 'You have no boards on your profile';
 					}//end if ?>
			</section>
		
		</div>
	</main>

<?php include('admin-footer.php'); ?>