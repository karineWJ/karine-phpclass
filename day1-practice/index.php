<?php  
	//keep track of the status of the page (error/success/etc)
	$status = 'success';

	//change the message if the page is in success or error mode
	if($status == 'success'){
		$message = 'Woohoo! You made it!';
	}else{
		$message = 'Ooops, You are wrong!';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>PHP Practice!</title> 
	<style type="text/css">
		.success{
			color:green;
			background-color: #BFEAC0;
		}
		.error{
			color:red;
			background-color: #FAC9EE;
		}
	</style>
</head>

<body class="<?php echo $status; ?>">
	<h1>
		<?php 
		//show the message we set at the top of the page
		echo $message; 
		?>
	</h1>
</body>
</html>
