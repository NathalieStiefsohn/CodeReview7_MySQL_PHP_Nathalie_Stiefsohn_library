<?php
	while($bookRow=mysql_fetch_array($res_book)){
		$title = $bookRow['title'];
		$author_first_name = $bookRow['first_name'];
		$author_family_name = $bookRow['family_name'];
		$image = $bookRow['image'];
		$published = $bookRow['publishing_year'];
		$genre = $bookRow['genre'];
		$age = $bookRow['age'];
		$availability = $bookRow['available'];
		$book_id = $bookRow['books_id'];
		// echo "book id is: ".$book_id;
		if ($availability == 1){
			$available = "available";
		} else {
			$available = "not available";
		}

		echo 	'<div class="col-xs-12 col-md-6 margin-top">
	  			<form method="post" action="selected_book.php?book_id='.$book_id.'" class="wrapper book_form panel panel-default card ">
					<div class="row max-width">
						<div class=" col-xs-12">
							<div class="book_header">
							    <h4 class="card-title">'.$title.'</h4>
						      	
						      	
					      	</div>
					      	<div class="book_header_author"
						      	<p class="card-text">'.$author_first_name.' '.$author_family_name.'</p>
						      	<hr>
					      	</div>
				      	</div>

						<figure class="col-xs-4 book_image">
						    <img src="'.$image.'"  alt="'.$title.'" class="img-responsive img-thumbnail">
						  </figure>
						  <div class="col-xs-8">
						    <div class="card-block">
						      <div class="content">
							      <ul class="list-unstyled">
							      <li><b>Published:</b> '.$published.'</li>
							      <li><b>Genre:</b> '.$genre.'</li>
							      <li><b>Age Class:</b> '.$age.'</li>
							      <li><b>Status:</b> '.$available.'</li>
							      <li class="margin-top"><input type="submit" class="btn btn-primary" value="Select" id="btn-Select" name="btn-Select"></li>
							      </ul>
						      </div>
						      
						    </div>
						  </div>

						</div
					</div>
				</form>
			</div>
			
		';
	}
?>