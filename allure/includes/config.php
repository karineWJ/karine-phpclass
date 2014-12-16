<?php
//DB credentials
$db_name = 'karine_allureproject';
$db_user = 'kwj_allure';
$db_password = 'rCypawuRbnmRK5va';

//connect to DB
$db = new mysqli( 'localhost', $db_user, $db_password, $db_name );

//handle any errors
if( $db->connect_errno > 0 ){ //check to see if the database has more than 0 errors
	//stop the page from loading and show a message instead
	die('Unable to connect to Database');
}

//error reporting
//show all errors except notices ( E_ALL & ~E_NOTICE )
//show all errors ( E_ALL )
error_reporting( E_ALL & ~E_NOTICE );

//no close php