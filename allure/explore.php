<?php 
require('includes/config.php');

 //if logged in, show admin-header.php and search form
if( $_SESSION['loggedin'] = true ){
?>
<?php require('admin/admin-header.php'); ?>

<?php }else{ ?>
<?php require('includes/header.php'); 
}

	//explore configuration
	$per_page = 16; //number of photos per page
	 $page_number = 1; //default current starting page
?> 
 
<main>
	<div id="explore-wrapper" class="container">
	<?php  // get username, photo_link, photo_id, and tag title. Get most recent photos
	$query = "SELECT photos.photo_id, photos.photo_link, users.username, tags.title
			  FROM photos, users, tags, photo_tags
			  WHERE users.user_id = photos.user_id
			  AND photos.photo_id = photo_tags.photo_id
			  AND photo_tags.tag_id = tags.tag_id
			  ORDER BY photos.date DESC";

	$result = $db->query($query);
	//check to see if rows were found
	if( $result->num_rows >= 1 ){
		$totalposts = $result->num_rows;

		//pagination calculations
		//how many pages do we need?
		$max_page = ceil( $totalposts / $per_page );

		//check to see if the page the user is viewing is within the max number of pages
		if($_GET['page']){
			$page_number = $_GET['page'];
		}
		if($page_number <= $max_page){
			//add a limit to the original query
			$offset = ($page_number - 1) * $per_page;

			$query_modified = $query . " LIMIT $offset, $per_page";

			//run the modified query
			$result_modified = $db->query($query_modified);
	?>


	<?php while( $row = $result_modified->fetch_assoc() ){ ?>
		<article class="photo-container">
			<a href="#"><img src="<?php echo 'http://localhost/karine-phpclass/allure' . $row['photo_link']; ?>" class="photo"></a>
			<p>Added by <a href="#" class="username"><?php echo $row['username']; ?></a></p>
			<P>Tags: <a href="#" class="tag"><?php echo $row['title'] ?></a></P>
			<div class="likes"><i class="icon-heart"></i>NUMBER OF LIKES</div>
		</article>
		<?php }//end while ?>


	<?php 
	$prev_page = $page_number - 1;
	$next_page = $page_number + 1;
	?>

	<section class="pagination">
	<?php //only show Prev button if on a page higher than 1 
		if( $page_number > 1 ){ ?>
		<a href="?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $prev_page; ?>">Previous</a>
		<?php }//end if higher than 1 

		//only show next button if not on the last page
		if( $page_number < $max_page ){
		?>
		<a href="?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next_page; ?>">Next</a>
		<?php } ?>
	</section>

	<?php 
		}//end if on valid page

	}// end if rows found 
	else{
		echo 'Sorry, no photos found';
	} ?>
	</div>
</main>

<?php include('includes/footer.php'); ?>
	