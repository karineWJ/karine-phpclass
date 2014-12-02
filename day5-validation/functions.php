<?php
//Output any array as an unordered list
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

//no close PHP