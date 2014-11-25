<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Example mini site with switch and Query String variables</title>

	<style type="text/css">
		h2{
			color:pink;
		}
		.home .home,
		.about .about,
		.contact .contact{
			background-color: fuchsia;
		}
	</style>
</head>
<body class="<?php echo $_GET['content']; ?>">

	<header>
		<h1>Mini Site</h1>

		<nav>
			<ul>
				<li class="home"><a href="index.php?content=home">Home</a></li>
				<li class="about"><a href="index.php?content=about">About</a></li>
				<li class="contact"><a href="index.php?content=contact">Contact</a></li>	
			</ul>
		</nav>
	</header>

	<main>
		<?php //get the right content depending on which link was clicked
		switch( $_GET['content'] ){
			case 'home': 
				include('content-home.php');
				break;

			case 'about': 
				include('content-about.php');
				break;

			case 'contact': 
				include('content-contact.php');
				break;

			default:
				include('content-home.php');
		} ?>
	</main>

	<footer>
		&copy; 2014 Platt!
	</footer>
</body>
</html>