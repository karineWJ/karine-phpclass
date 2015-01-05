<?php require('admin-header.php'); ?>
	
	<main>
		<div class="container">
			<form id="edit-account">
				<h2>Account Settings</h2>
				<fieldset class="no-border">
					<label>Profile Picture</label>
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