<?php require('includes/header.php'); ?>
	<main>
		<h1>Search Results</h1>
		<p class="success message">Results found for PHRASE. Showing page CURRENT PAGE of TOTAL PAGE.</p>

		<section>
			<article>
				<a href="#">PHOTO ID</a>
			</article>
		</section>

		<?php 
		$prev_page = $page_number - 1;
		$next_page = $page_number + 1;
		?>

		<section class="pagination">
			<a href="#">Previous</a>
			<a href="#">Next</a>
		</section>

	</main>

<?php include('includes/footer.php'); ?>
	