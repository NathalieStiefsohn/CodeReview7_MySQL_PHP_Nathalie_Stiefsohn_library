<?php
require_once('includes/start_session_user.php');
?>
<?php
	// if no book is selected you cannot be on this page and get redirected to home_user.php
	$selected_book_id = $_GET['book_id'];
	if (empty($selected_book_id)) {
		header("Location: home_user.php");
		exit;
	}
	// making a reservation
	if( isset($_POST['btn-reservation']) ) {
		$user_FK = $_SESSION['user'];
		$book_FK = $selected_book_id;
		$availability = 0;

		$query_borrows = "INSERT INTO borrows(FK_users, FK_books) VALUES($user_FK, $book_FK)";
		$res_borrows = mysql_query($query_borrows);

		$query_books_availability = "UPDATE books SET available=$availability WHERE books.id=$book_FK";
		$res_books_availability = mysql_query($query_books_availability);

		if ($res_borrows && $res_books_availability) {
		$errTyp = "alert alert-success";
		$errMSG = "Your reservation was a success! <br>Please pick up your book with the next 2 days.";
		// echo $errMSG;
		unset($user_FK);
		unset($book_FK);
		} else {
		$errTyp = "alert alert-danger";
		$errMSG = "Something went wrong, try again later...";
		// echo $errMSG;
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Selected Book</title>
	<?php
require_once('includes/head_tag.php');
	?>
</head>
<body>
<div class="container">

	<?php
require_once('includes/header.php');
require_once('includes/switch_user_view.php');
	?>
	<nav class="row margin-top">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 text-center">
					<ul class="nav nav-tabs">
						<li role="presentation" class=""><a href="home_user.php">Search for Books</a></li>
						<li role="presentation" class="active"><a href="selected_book.php">Selected Book</a>
						<li role="presentation" class=""><a href="your_books.php">Your Books</a></li>
						<li role="presentation" class=""><a href="opening_hours.php">Opening Hours</a></li>
					</ul>
					 
				
				</div>
				
			</div>
		</div>
	</nav>

	<!-- main -->
	<section class="row">
	
	<?php
		$selected_book_id = $_GET['book_id'];
		if (!empty($selected_book_id)) {	
			echo 	'<div class="col-xs-12">
						<h2 class="brandfont text-center">Selected Book</h2>
						<hr>
					</div>
					<div class="col-xs-12 '.$errTyp.' text-center">
						<h3>'.$errMSG.'</h3>
					</div>';
		
			$res_selected_book=mysql_query("SELECT 
							title, first_name, family_name, image, publishing_year, genre, age, available, books.id as books_id, authors.id as authors_id
							FROM books 
							JOIN authors ON books.FK_authors=authors.id
							JOIN genres ON books.FK_genres=genres.id
							JOIN age_recommendations ON books.FK_age_recommendations=age_recommendations.id 
							JOIN libraries ON books.FK_libraries=libraries.id
							WHERE books.id = $selected_book_id
							ORDER BY title ASC");
			$selected_bookRow=mysql_fetch_array($res_selected_book);
			$title = $selected_bookRow['title'];
			$author_first_name = $selected_bookRow['first_name'];
			$author_family_name = $selected_bookRow['family_name'];
			$image = $selected_bookRow['image'];
			$published = $selected_bookRow['publishing_year'];
			$genre = $selected_bookRow['genre'];
			$age = $selected_bookRow['age'];
			$availability = $selected_bookRow['available'];
			$book_id = $selected_bookRow['books_id'];
			// echo "book id is: ".$book_id;
			if ($availability == 1){
				$available = "available";
			} else {
				$available = "not available";
			}

			echo 	'<div class="col-xs-12 margin-top">
		  			<form method="post" class="selected_book wrapper book_form panel panel-default card ">
						<div class="row max-width">
							<div class=" col-xs-12">
								<div class="selected_book_header">
								    <h4 class="card-title">'.$title.'</h4>
							      	
							      	
						      	</div>
						      	<div class="book_header_author"
							      	<p class="card-text">'.$author_first_name.' '.$author_family_name.'</p>
							      	<hr>
						      	</div>
					      	</div>

							<figure class="col-xs-6 col-md-4 book_image">
							    <img src="'.$image.'"  alt="'.$title.'" class="img-responsive img-thumbnail">
							  </figure>
							  <div class="col-xs-6 col-md-4">
							    <div class="card-block">
							      <div class="content">
								      <ul class="list-unstyled margin-top">
									      <li><b>Published:</b> '.$published.'</li>
									      <li><b>Genre:</b> '.$genre.'</li>
									      <li><b>Age Class:</b> '.$age.'</li>
									      <li><b>Status:</b> '.$available.'</li>
								      
								      </ul>
							      </div>
							      
							    </div>
							  </div>';
		  	if ($availability == 1){
			  	echo '<div class="col-xs-12 col-md-4 text-center alert alert-info margin-top"> 
								  <h4>Would you like to make a reservation for this book?</h4>
								  <input type="submit" class="btn btn-primary" value="Make reserveration now" id="btn-reservation" name="btn-reservation">
							  </div>	

							</div
						</div>
					</form>
				</div>';
	  		} else {
	  			echo '<div class="col-xs-4 text-center alert alert-danger margin-top"> 
								  <h4> This book is currently not available. <br> Please try again later</h4>
								  
							  </div>	

							</div
						</div>
					</form>
				</div>';	
	  		}
							  
		
			$res_recommended1_book=mysql_query("SELECT 
								authors.id as authors_id
								FROM books 
								JOIN authors ON books.FK_authors=authors.id
								JOIN genres ON books.FK_genres=genres.id
								JOIN age_recommendations ON books.FK_age_recommendations=age_recommendations.id 
								JOIN libraries ON books.FK_libraries=libraries.id
								WHERE books.id = $selected_book_id
								ORDER BY title ASC");
			$recommended1_bookRow=mysql_fetch_array($res_recommended1_book);
			$recommended_author = $recommended1_bookRow['authors_id'];
			$res_recommended_book=mysql_query("SELECT 
								title, first_name, family_name, image, publishing_year, genre, age, available, books.id as books_id, authors.id as authors_id
								FROM books 
								JOIN authors ON books.FK_authors=authors.id
								JOIN genres ON books.FK_genres=genres.id
								JOIN age_recommendations ON books.FK_age_recommendations=age_recommendations.id 
								JOIN libraries ON books.FK_libraries=libraries.id
								WHERE authors.id = $recommended_author
								AND books.id != $selected_book_id
								ORDER BY title ASC");

			$count_search = mysql_num_rows($res_recommended_book);
			if ($count_search < 1){

			} else {

				echo 	'<div class="col-xs-12">
							<h2 class="brandfont text-center">You might also like other books of this author: </h2>
							<hr>
						</div>';

				while($recommended_bookRow=mysql_fetch_array($res_recommended_book)){
			  		$title = $recommended_bookRow['title'];
			  		$author_first_name = $recommended_bookRow['first_name'];
			  		$author_family_name = $recommended_bookRow['family_name'];
			  		$image = $recommended_bookRow['image'];
			  		$published = $recommended_bookRow['publishing_year'];
			  		$genre = $recommended_bookRow['genre'];
			  		$age = $recommended_bookRow['age'];
			  		$availability = $recommended_bookRow['available'];
			  		$book_id = $recommended_bookRow['books_id'];
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
			}


		}

	?>



	</section>
	<!-- footer -->
	<?php
require_once('includes/footer.php');
	?>
	 
</div>
<script>
	// $(".content").matchHeight();
</script>
</body>
</html>
<?php ob_end_flush(); ?>