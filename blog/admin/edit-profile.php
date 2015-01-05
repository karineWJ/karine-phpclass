<?php require('admin-header.php'); ?>

<main>
	<h1>Edit your Profile picture</h1>

	<?php if( isset($statusmsg) ){
		echo $statusmsg;
	} ?>

	<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		<label>Choose a file:</label>
		<input type="file" name="uploadedfile">

		<input type="submit" value="Upload Image">
		<input type="hidden" name="did_upload" value="true">
	</form>
</main>

<?php include('admin-footer.php'); ?>