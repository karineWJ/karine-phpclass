<?php require('admin-header.php'); ?>

<form action="../search.php" method="get" id="searchform">
			<input type="search" name="phrase" id="phrase" placeholder="Search look" value="<?php echo $_GET['phrase']; ?>">
			<input type="submit" value="Search">
		</form>

<?php include('admin-sidebar.php'); ?>

<main class="cf">
	<section>
		<h1>Stats</h1>

		<ul>
			<li>You have NUMBER boards</li>
			<li>You have NUMBER uploaded</li>
			<li>You have NUMBER saved images</li>
			<li>You have NUMBER likes</li>
		</ul>
	</section>
</main>

<?php include('admin-footer.php'); ?>