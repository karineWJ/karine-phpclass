<?php 
//which post are we editing?
$post_id = $_GET['post_id'];

require('admin-header.php'); 


//parse the form if submitted
if( $_POST['did_post'] ){
	//sanitize the data
	$title = clean_input( $_POST['title'], $db );
	$body = clean_input( $_POST['body'], $db );
	$category =  $_POST['category'];
	$is_published = clean_input( $_POST['is_published'], $db );
	$allow_comments = clean_input( $_POST['allow_comments'], $db );
	
	//validate
	$valid = true;
	//did they leave title or body blank?
	if( strlen($title) == 0 OR strlen($body) == 0 ){
		$valid = false;
		$message = 'Please fill in all fields.';
	}

	//checkbox boolean: convert null to ZERO.
	if( $is_published != 1){
		$is_published = 0;
	}
	if( $allow_comments != 1){
		$allow_comments = 0;
	}

	//edit this post in the database
	if($valid){
		$query_addpost = "UPDATE posts
						 SET title = '$title',
							 body = '$body',
							 is_published = $is_published,
							 allow_comments = $allow_comments
						WHERE post_id = $post_id
						LIMIT 1";
		$result_addpost = $db->query($query_addpost);

		//reset all categories for this post
		$query_delete = "DELETE FROM post_cats 
						WHERE post_id = $post_id";
		$result_delete = $db->query($query_delete);
		
		//go through the list of checked categories, adding one row to post_cats for each
		foreach( $category AS $category_id){
			$query_pc = "INSERT INTO post_cats
						(post_id, category_id)
						VALUES
						( $post_id,  $category_id )";
			$result_pc = $db->query($query_pc);

		}//end foreach

		//make sure it worked
		if( $db->affected_rows >= 1 ){
			$message = 'Post successfully saved.';

		} //end if query worked
		else{
			$message = 'No changes made to post.';
		}
	} //end if valid
} //end parse


//get an array of all categories this post is in
//cc means current cats
$query_cc = "SELECT category_id 
			FROM post_cats
			WHERE post_id = $post_id";
$result_cc = $db->query($query_cc);
$cat_list = array();
if( $result_cc->num_rows >= 1 ){
	while($row_cc = $result_cc->fetch_assoc()){
		$cat_list[] = $row_cc['category_id'];
	}
}

//Pre-fill the form with the current values, and check to make sure the logged in person wrote it
$query_post = "SELECT * 
				FROM posts
				WHERE user_id = $user_id
				AND post_id = $post_id
				LIMIT 1";
$result_post = $db->query($query_post);
?>
<main>

	<?php //make sure one post was found
	if( $result_post->num_rows == 1 ){
		$row_post = $result_post->fetch_assoc();

	?>

	<h1>Edit Post</h1>

	<?php echo $message; ?>

	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?post_id=<?php echo $post_id; ?>" method="post">
		
		<label for="title">Title:</label>
		<input type="text" name="title" id="title" value="<?php echo $row_post['title'] ?>">

		<label for="body">Body of Post:</label>
		<textarea name="body" id="body"><?php echo $row_post['body']; ?></textarea>

		<fieldset>
			<h2>Categories:</h2>

			<?php //get all the categories
			$query_cats = "SELECT * FROM categories";
			$result_cats = $db->query($query_cats);
			if( $result_cats->num_rows >= 1 ){
				while( $row = $result_cats->fetch_assoc() ){ ?>
			<label>
				<input type="checkbox" name="category[<?php echo $row['category_id'] ?>]" value="<?php echo $row['category_id'] ?>" <?php 
					//check to see if the category we are showing 
					//is in the array of cats this post is in
					if(in_array( $row['category_id'], $cat_list )){
						echo 'checked';
					}					
				 ?>>
				<?php echo $row['title'] ?>
			</label>
			<?php 
				}//end while
			}//end if cats found ?>
		</fieldset>

		<h2>Publishing Settings:</h2>
		<label>
			<input type="checkbox" name="is_published" value="1" <?php 
					echo $row_post['is_published'] == 1 ? 'checked' : '' ;  ?>>
			Make this post public?
		</label>

		<label>
			<input type="checkbox" name="allow_comments" value="1" <?php 
					echo $row_post['allow_comments'] == 1 ? 'checked' : '' ; ?>>
			Allow people to comment on this post?
		</label>

		<input type="submit" value="Save Post">

		<input type="hidden" name="did_post" value="1">

	</form>
	<?php 
	}else{
		echo 'You did not write this post.';
	} ?>
</main>
<?php include('admin-footer.php'); ?>