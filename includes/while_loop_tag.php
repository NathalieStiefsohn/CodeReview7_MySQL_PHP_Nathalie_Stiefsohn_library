<?php
 // select all available tags
	$res_tag=mysql_query("SELECT * FROM tags");
	
	
	while($tagRow=mysql_fetch_array($res_tag)){
		$tag_db = $tagRow['tag'];

		echo "<option value='".$tag_db."'>".$tag_db."</option>";
	}
?>