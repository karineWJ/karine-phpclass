<?php 
session_start();
//security check! make sure the person viewing this page is logged in 
if( $_SESSION['loggedin'] != true ){
	//kick them out to the login form
	header('Location:'. SITE_URL.'login.php');
	//stop this file from loading
	die('You do not have permission to view this page.');
}
//connect to database

include_once( SITE_PATH . 'includes/functions.php');

//who is logged in? store in a var for easy use on admin pages
$user_id = $_SESSION['user_id'];

//upload for avatars
include( SITE_PATH. 'admin/upload-parser.php');
//upload for new outfits
include( SITE_PATH. 'admin/uploadoutfit-parser.php');



//parse the create board form if submitted
if( $_POST['did_createboard'] ){
	//sanitize the data
	$title = clean_input($_POST['title'], $db);

	//validate
	$valid = true;
	//did they leave title 
	if( strlen($title) == 0 ){
		$valid = false;
		$message = "Please enter a title.";
	}

	if($valid){
		$query_createboard = "INSERT INTO boards
							  (title, user_id, date )
							  VALUES
							  ('$title', $user_id, now() )";

		$result_createboard = $db->query($query_createboard);
		//make sure it worked
		if( $db->affected_rows == 1 ){
			//get the ID of the new board so we can use it later
			$board_id = $db->insert_id;

			$message = 'Board successfully created';
		}//end if query
	}//end if valid
}//end parse

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Panel - Profile Page</title>
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL ?>css/normalize.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL ?>css/admin-style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL ?>css/fontello.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<script type="text/javascript" >
		$(document).ready(function(){

			$(".account").click(function(){
				var X=$(this).attr('id');
				
				if(X==1){
					$(".submenu").hide();
					$(this).attr('id', '0'); 
				}else{
					$(".submenu").show();
					$(this).attr('id', '1');
				}
			});

			//Mouse click on sub menu
			$(".submenu").mouseup(function(){
				return false
			});

			//Mouse click on my account link
			$(".account").mouseup(function(){
				return false
			});

			//Document Click
			$(document).mouseup(function(){
				$(".submenu").hide();
				$(".account").attr('id', '');
			});

			//show addboard form when clicking on link
			$('#addboard').click(function(){

				var X=$(this).attr('id');

				if(X==1){
					$('.newboard').hide();
					$(this).attr('id', '0'); 
				}else{
					$(".newboard").show();
					$(this).attr('id', '1');
				}
			});

			//Mouse click on new board
			$(".newboard").mouseup(function(){
				return false
			});

			//Mouse click on my account link
			$("#addboard").mouseup(function(){
				return false
			});

			//Document Click
			$(document).mouseup(function(){
				$(".newboard").hide();
				$("#addboard").attr('id', '');
			});

		});
	</script>

</head>

<body>
	<header>
		<div class="container">
			<h1 class="logo"><a href="index.php">Allure</a></h1>
			
			<nav id="home-nav" class="cf">
				<ul>
					<li><a href="<?php echo SITE_URL ?>explore.php">Explore</a></li>
					<li><a href="<?php echo SITE_URL ?>admin/upload-images.php" class="coral"><i class="icon-upload"></i>Upload</a></li>
					<li id="addboard">
						<a href="#" ><i class="icon-plus"></i>Board</a>
						<form class="newboard" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    			<input type="text" placeholder="Name of board" name="title" id="board-title"/>
      			
      			<input type="submit" value="Create board" />
      			<input type="hidden" name="did_createboard" value="true">
			</form>
					</li>
				</ul>
			</nav>
			
			

			<?php user_badge( $user_id, $db ); ?>

		</div>
		
		<form action="search.php" method="get" id="searchform">
			<input type="search" name="phrase" id="phrase" class="searchTerm" placeholder="Search look" value="<?php echo $_GET['phrase']; ?>"><button type="submit" class="searchButton"><i class="icon-search"></i></button>
		</form>

	</header>