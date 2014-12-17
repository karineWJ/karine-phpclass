<?php require('admin-header.php'); ?>
<main>
	<section>
		<h1>Stats</h1>

		<ul>
			<li>You have <?php echo count_posts( $user_id, 1, $db ); ?> published posts</li>
			<li>You have <?php echo count_posts( $user_id, 2, $db); ?> post drafts</li>
			<li>Your posts have <?php echo count_user_post_comments( $user_id, $db ); ?> comments</li>
		</ul>
	</section>
</main>
<?php include('admin-footer.php'); ?>