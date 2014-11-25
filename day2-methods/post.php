<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>

	<style type="text/css">
		input{
			display: block;
			margin: 1em 0;
		}
	</style>

</head>
<body>

	<?php if( $_POST['did_submit'] == true ){ ?> <!-- isset ==> checks to see if a variable has a value -->
		<p>Good morning, <?php echo $_POST['name'] ?>. 
		<?php echo $_POST['breakfast'] ?> sounds delish!</p>
	<?php } ?>

	<form method="post" action="post.php">
		<label for="name">What is your name?</label>
		<input type="text" name="name" id="name">
		<!-- The name attribute is what the _post uses -->

		<label for="breakfast">What did you have for breakfast?</label>
		<input type="text" name="breakfast" id="breakfast"> <!-- the ID needs to be the same as the 'for' in label -->

		<input type="submit" value="Submit this Info!">

		<input type="hidden" name="did_submit" value="true">
	</form>

</body>
</html>