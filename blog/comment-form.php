<form action ="#leavecomment" method="post" id="leavecomment">

	<?php 
	if( isset($message) ){
		echo '<div>';
		echo $message;
		echo '</div>';
	}
	?>
	<h2>Your Comment:</h2>
	<textarea name="body" id="body"></textarea>

	<input type="submit" value="Submit Comment">
	<input type="hidden" name="did_comment" value="true">
</form>