<?php 
require('../includes/config.php');
require('admin-header.php'); ?>
	
	<main>
		<div class="container">
			<h2 class="tabbed-title">Upload Image</h2>

			<?php if( isset($statusmsg) ){
				echo $statusmsg;
			} ?>
			
			<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" id="uploadImage-form" >
				
					<label>Upload a photo:</label>
					<input type="file" name="uploadedfile" class="uploadfile">


					<label for="description">Description</label>
					<input type="text" name="description" id="description" class="grey-input">

					<label for="tags">Tags</label>
					<input type="text" name="tag" id="photo-tag" class="grey-input">

					<input type="submit" value="Upload Image" class="save">
					<input type="hidden" name="did_upload" value="true">
				
				<a href="index.php" class="cancel">Cancel</a>
			</form>

		</div>

	</main>

<?php include('admin-footer.php'); ?>