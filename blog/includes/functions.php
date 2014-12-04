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

//no close php