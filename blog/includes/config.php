<?php
//DB credentials
$db_name = 'karine_phpblog';
$db_user = 'kwj_bloguser';
$db_password = 'aRteUtZRURWLxPAF';

//connect to DB
$db = new mysqli( 'localhost', $db_user, $db_password, $db_name );

//handle any errors
if( $db->connect_errno > 0 ){ //check to see if the database has more than 0 errors
	//stop the page from loading and show a message instead
	die('Unable to connect to Database');
}

//no close php