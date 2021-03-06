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
			<hr>
				<li><span class="coral"><?php echo count_boards($user_id, $db); ?></span> <a href="#">boards</a></li>
				<li><span class="coral"><?php echo count_photos_uploaded($user_id, $db); ?></span> <a href="#">uploaded</a></li>
				<li><i class="icon-heart coral"></i></span> <a href="#">likes</a></li>
				<hr>
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
				
					
				<article>
					<?php while( $row_board = $result_board->fetch_assoc() ){ ?> 
					<a href="<?php echo SITE_URL ?>admin/single-board.php?id=<?php echo $row_board['board_id'] ?>" class="board">
					<h3 class="boardname"><?php echo $row_board['title'] ?></h3>
					</a>
					<?php }//end while ?>
					
				</article>
 					<?php }else{
 						echo 'You have no boards on your profile';
 					}//end if ?>
			</section>
		
		</div>
	</main>

<?php include('admin-footer.php'); ?>