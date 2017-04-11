<?php
$count_search = mysql_num_rows($res_book);
if ($count_search == 1){
	echo "<h4 class='text-center'>We found ".$count_search." result for '".$search."'.</h4> <hr>";
} else if ($count_search == 0) {
echo '<div class="alert alert-danger">
		<h4 class="text-center">Unfortunately there are no results for "'.$search.'". <br><br>Please call Code Library for further information.
		<br>
		Telephone Number: '.$telephone.'</h4> 
	</div><hr>';
} else {
	echo "<h4 class='text-center'>We found ".$count_search." results for '".$search."'.</h4> <hr>";
}
?>