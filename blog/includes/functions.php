<?php
/**
 * Convert mysql datetime format to human readable date
 * @param datetime $dateR  	the date that needs to be made readable
 * @return string 			the date in Month Day, Year format
 * @author karine <karine.wj89@gmail.com>
 */

function convert_date($dateR){
$engMon=array('January','February','March','April','May','June','July','August','September','October','November','December',' ');
$l_months='January:February:March:April:May:June:July:August:September:October:November:December';
$dateFormat='F j, Y';
$months=explode (':', $l_months);
$months[]='&nbsp;';
$dfval=strtotime($dateR);
$dateR=date($dateFormat,$dfval);
$dateR=str_replace($engMon,$months,$dateR);
return $dateR;
}

/**
 * Make timestamp for RSS feed
 */
function convTimestamp($date){
  $year   = substr($date,0,4);
  $month  = substr($date,5,2);
  $day    = substr($date,8,2);
  $hour   = substr($date,11,2);
  $minute = substr($date,14,2);
  $second = substr($date,17,2);
  $stamp =  date('D, d M Y H:i:s O', mktime($hour, $min, $sec, $month, $day, $year));
  return $stamp;
}

/**
 * Clean String Inputs before submitting to DB
 *@param  $input - the dirty data that needs cleaning!
 *@param  $db -  Database object
 *@return cleaned data
 */
function clean_input($input, $db){ //arguments are things coming from the outside file
	return mysqli_real_escape_string( $db, strip_tags($input));
}

function kwj_array_list($array){
	//if the array exists, display it
	if( is_array( $array )){
	echo '<ul>';
	//output one list item per thing in the array
	foreach( $array as $item ){ // $item is a made up alias name for the $array
		echo '<li>' . $item . '</li>';
	}
	echo '</ul>';
	}
}

//Display one error message (use this next to a field)
function kwj_inline_error( $array, $item ){
	//check to make sure the item exists in the array
	if( isset( $array[$item] ) ){
		echo '<div class="inline-error">' . $array[$item] . '</div>';
	}
}
//no close php