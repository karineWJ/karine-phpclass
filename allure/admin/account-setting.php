<?php 
require('../includes/config.php');
require('admin-header.php'); ?>
	
	<main>
		<div class="container">
			<h2 class="tabbed-title">Account Settings</h2>

			<?php if( isset($statusmsg) ){
				echo $statusmsg;
			} ?>
			
			<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" id="edit-account">
				
				<fieldset class="no-border">
					<label>Profile Picture</label>
					<input type="file" name="uploadedfile" class="uploadfile">

					<input type="submit" value="Upload Image">
					<input type="hidden" name="did_upload" value="true">
				</fieldset>

				<fieldset class="no-border">
					<label for="username">Username</label>
					<input type="text" name="username" id="username-edit" class="grey-input">

					<label for="email">Email Address</label>
					<input type="email" name="email" id="email-edit" class="grey-input">

					<label for="password">Password</label>
					<input type="password" name="password" id"password-edit" class="grey-input">

					<label for="about">About Me</label>
					<input type="text" name="about" id="about-edit" class="grey-input">
				</fieldset>

				<input type="submit" value="Save Profile" class="save">
				<a href="index.php" class="cancel">Cancel</a>
			</form>

		</div>

	</main>

<?php include('admin-footer.php'); ?>