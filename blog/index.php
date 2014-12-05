<?php
//connect to DB!
require('includes/config.php');
require_once('includes/functions.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Demo PHP + MySQL Blog</title>
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Average+Sans' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
</head>
<body>
	<header id="banner">
		<h1>Welcome to Karine's Blog</h1>
	</header>
	
	<main id="content">
		<?php //get all the published posts, most recent first
			$query = "SELECT posts.*, users.username , categories.title AS category
					  FROM posts, users, post_cats, categories
					  WHERE is_published = 1 
					  AND posts.user_id = users.user_id
					  AND posts.post_id = post_cats.post_id
					  AND categories.category_id = post_cats.category_id
					  ORDER BY date DESC "; //DESC=>newest to oldest post; ASC=>oldest to newest
			//Run the query. Hold onto the results in a variable
			$result = $db->query( $query );
			//check to see if one or more rows were found
			if( $result->num_rows >= 1 ){
				while( $row = $result->fetch_assoc() ){ //fetch_assoc gets the next post
			?>
			<article class="post">
				<h1><?php echo $row['title'] ?></h1>
				<div class="date">By <?php echo $row['username'] ?>
					<?php echo convert_date( $row['date'] ) //'convert_date function' will clean the date format ?>
					In the category <?php echo $row['category'] ?>
				</div>
				<p><?php echo $row['body'] ?></p>
			</article>

			<?php
				} //end while
			 } //end if rows found
		else{
			echo 'Sorry, no posts to show';
		}
		?>
	</main>
	
	<?php include('includes/sidebar.php'); ?>

	<footer id="colophon" class="cf">&copy; 2014 Karine Wu Jye</footer>
</body>
</html>