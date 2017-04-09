<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';

	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select logged-in users detail
	$res=mysql_query("SELECT * FROM users WHERE id=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
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
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - <?php echo $userRow['first_name']; ?></title>
    <link rel="icon" href="pictures/logo.png">
    
    <!-- jquery and bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight.js"></script>
    
    <!-- webfont -->
    <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster+Two" rel="stylesheet">
    <!-- style sheet -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

	<style type="text/css">
		.book_image {
			height: 150px;
			width: 33%;	
			display: flex;
			align-items: center;
		}
		.book_image img {
			height: 100%;
			width: 100%;
		}
		.book_form {
			/*height: 150px;*/
			display: flex;
			align-items: center;
			margin-left: auto;
			margin-right: auto;
			/*border: 1px solid;*/
		}
		.book_form hr {
			margin-top: -2px;
			margin-bottom: 2px;
		}
		.book_header  {
			width: 100%;
			/*border: 1px solid;*/
			padding: 10px;
			height: 60px;
		}
		.selected_book_header  {
			width: 100%;
			/*border: 1px solid;*/
			padding: 10px;
			/*height: 60px;*/
		}
		.book_header_author  {
			width: 100%;
			/*border: 1px solid;*/
			padding: 10px;
			/*height: 100px;*/
		}
		.book_form * {
			/*border: 1px solid;*/
		}
		.max-width {
			width: 100%;
		}
		.wrapper {
			padding:4px;
		}
		.selected_book {
			font-size: 1.4em;
		}
		.selected_book h4 {
			font-size: 1.2em;
		}

		.selected_book .book_image {
			height: 220px;
			width: 280px;
		}
		
	</style>
</head>
<body>
<div class="container">

	<header class="row shadow">
		<div class="col-xs-6">
			<span><img id="logo" src="pictures/logo.png" alt="logo"></span>
			<span><h1 class="brandfont">Code Library</h1></span>
		</div>
		<div class="col-xs-6">
			<div class="header_right text-right">
				
				<?php
					echo'<div class="">
					Welcome back, '. $userRow["first_name"].'!<br>
		       		<a href="logout.php?logout">Sign Out</a>
		       		</div>';
		       	?>

	    	</div>
		</div>
	</header>
	<?php 
		if( isset($_SESSION['admin']) ) {
			echo 	'<nav class="text-right" aria-label="Page navigation">
							<ul class="pagination">
						    <li class="active">
						      <a href="home_user.php" aria-label="User View">
						        <span aria-hidden="true">User View</span>
						      </a>
						    </li>
						    <li class="">
						      <a href="home_admin.php" aria-label="Admin Panel">
						        <span aria-hidden="true">Admin Panel</span>
						      </a>	
						    </li>
							</ul>
					</nav>';
		} 
	?>
	<nav class="row">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 text-center">
					<ul class="nav nav-tabs">
						<li role="presentation" class=""><a href="home_user.php">Search for Books</a></li>
						<li role="presentation" class="active"><a href="selected_book.php">Selected Book</a></li>
						<li role="presentation"><a href="your_books.php">Your Books</a></li>
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
			if ($count_search < 2){

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
	<div class="row margin-top ">
        <div class="col-xs-12 text-center shadow panel panel-default">
            All rights reserved for Nati
        </div>
    </div>
	 
</div>
<script>
	// $(".content").matchHeight();
</script>
</body>
</html>
<?php ob_end_flush(); ?>