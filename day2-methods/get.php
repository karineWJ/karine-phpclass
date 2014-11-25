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

	<?php if( $_GET['did_submit'] == true ){ ?> <!-- isset ==> checks to see if a variable has a value -->
		<p>Good morning, <?php echo $_GET['name'] ?>. 
		<?php echo $_GET['breakfast'] ?> sounds delish!</p>
	<?php } ?>

	<form method="get" action="get.php">
		<label for="name">What is your name?</label>
		<input type="text" name="name" id="name">
		<!-- The name attribute is what the _get uses -->

		<label for="breakfast">What did you have for breakfast?</label>
		<input type="text" name="breakfast" id="breakfast"> <!-- the ID needs to be the same as the 'for' in label -->

		<input type="submit" value="Submit this Info!">

		<input type="hidden" name="did_submit" value="true">
	</form>

</body>
</html>