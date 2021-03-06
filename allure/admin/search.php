<?php 
require('../includes/config.php');
require('admin-header.php');
//search configuration
$per_page = 10; //number of photos per page
$page_number = 1; //default current starting page
?>

<main id="result-content">
	<div class="container">

	<?php 
	$phrase = $_GET['phrase'];

	//look up all photos that have that phrase in the description and tags. Also add username 
	$query = "SELECT photos.description, photos.photo_id, photos.photo_link, users.username, tags.title
			  FROM photos, users, tags, photo_tags
			  WHERE users.user_id = photos.user_id
			  AND photos.photo_id = photo_tags.photo_id
			  AND photo_tags.tag_id = tags.tag_id
			  AND ( description LIKE '%" . $phrase . "%' 
			  OR title LIKE '%" . $phrase . "%' ) ";
			 // need to concatenate $phrase because php will take single quotes literally
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

	<form action="search.php" method="get" class="searchform">
		<input type="search" name="phrase" id="phrase" class="searchTerm" placeholder="Search look" value="<?php echo $_GET['phrase']; ?>"><button type="submit" class="searchButton"><i class="icon-search"></i></button>
	</form>
	
	<h1>Search Results</h1>
	<p class="success message">
	<?php echo $totalposts; ?> results found for '<?php echo $phrase; ?>'. 
	Showing page <?php echo $page_number; ?> of <?php echo $max_page; ?>. </p>

	<section class="search-results">

		<?php while( $row = $result_modified->fetch_assoc() ){ ?>
		<article class="photo-container">
			<a href="#"><img src="<?php echo 'http://localhost/karine-phpclass/allure' . $row['photo_link']; ?>" class="photo"></a>
			<p>Added by <a href="#" class="username"><?php echo $row['username']; ?></a></p>
			<P>Tags: <a href="#" class="tag"><?php echo $row['title']; ?></a></P>
			<div class="likes"><i class="icon-heart"></i> LIKES</div>
		</article>
		<?php }//end while ?>
	</section>

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

<?php include('admin-footer.php'); ?>
	