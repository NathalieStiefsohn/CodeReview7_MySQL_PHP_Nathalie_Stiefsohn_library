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
 $user_id = $userRow['id'];
?>
<?php
	$borrows_id = $_GET['borrows_id'];
	

	if (!empty($borrows_id)) {
		$res=mysql_query("SELECT * FROM borrows WHERE id = ".$borrows_id);
		$borrowRow=mysql_fetch_array($res);
		$book_FK =$borrowRow['FK_books'];
		$query_borrows = "DELETE FROM borrows WHERE id='".$borrows_id."'";
		$res_borrows = mysql_query($query_borrows);

		$query_books_availability = "UPDATE books SET available=1 WHERE books.id=$book_FK";
		$res_books_availability = mysql_query($query_books_availability);

		if ($res_borrows && $res_books_availability) {
		$errTyp = "alert alert-success";
		$errMSG = "You successfully canceled your reservation!";
		// echo $errMSG;
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
						<li role="presentation"><a href="home_user.php">Search for Books</a></li>
						<li role="presentation" class="active"><a href="your_books.php">Your Books</a></li>
						<li role="presentation" class=""><a href="opening_hours.php">Opening Hours</a></li>
					</ul>
					 
				
				</div>
				
			</div>
		</div>
	</nav>
	<!-- main -->
	<section class="row">


		<div class="col-xs-12">
			<h2 class="brandfont text-center">Search for one of your books</h2>
			<hr>
		</div>
		<form class="col-xs-6 col-xs-offset-3" role="search" method="get">
    		<div class="input-group">
    			<input type="search" class="form-control" name="search" placeholder="Search for one of your books">
        		<div class="input-group-btn">
            		<button class="btn btn-default" name="btn-search" id="btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>

        		</div>
    		</div>
    		<hr>		
		</form>
		
		

		<div class="col-xs-12">

			<div class="row">
			<?php 	

				echo 	'<div class="col-xs-12">
							<h2 class="brandfont text-center">Selected Book</h2>
							<hr>
						</div>
						<div class="col-xs-12 '.$errTyp.' text-center">
							<h3>'.$errMSG.'</h3>
						</div>';		
				 // select all available books from this user
				 
				if ( isset($_GET['btn-search']) ){
					$search = trim($_GET['search']);
			 		$search = strip_tags($search);
			  		$search = htmlspecialchars($search);
					$res_book=mysql_query("SELECT 
					title, authors.first_name, authors.family_name, image, publishing_year, genre, age, available, books.id as books_id, authors.id as authors_id, borrows.id as borrows_id
					FROM books 
					JOIN authors ON books.FK_authors=authors.id
					JOIN genres ON books.FK_genres=genres.id
					JOIN age_recommendations ON books.FK_age_recommendations=age_recommendations.id 
					JOIN libraries ON books.FK_libraries=libraries.id
					JOIN borrows ON books.id = borrows.FK_books
                    JOIN users ON borrows.FK_users=users.id
					WHERE (title LIKE '%$search%'
					OR authors.first_name LIKE '%$search%'
					OR authors.family_name LIKE '%$search%'
					OR genre LIKE '%$search%') AND
					borrows.FK_users =".$user_id." ORDER BY title ASC");


					// get telephone number
					$res_library=mysql_query("SELECT * FROM libraries");
					$row_library=mysql_fetch_array($res_library);
					$telephone = $row_library['telephone'];

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
				  		$borrows_id = $bookRow['borrows_id'];
				  		// echo "book id is: ".$book_id;
				  		if ($availability == 1){
				  			$available = "available";
				  		} else {
				  			$available = "not available";
				  		}
				  	
				  		echo 	'<div class="col-xs-12 col-md-6 margin-top">
						  			<form method="post" action="your_books.php?borrows_id='.$borrows_id.'" class="wrapper book_form panel panel-default card ">
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
												      <li class="margin-top"><input type="submit" class="btn btn-primary" value="Cancel Reservation" id="btn-cancel_reservation" name="btn-cancel_reservation"></li>
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
				} else {

					$res_book=mysql_query("SELECT 
					title, authors.first_name, authors.family_name, image, publishing_year, genre, age, available, books.id as books_id, authors.id as authors_id, borrows.id as borrows_id
					FROM books 
					JOIN authors ON books.FK_authors=authors.id
					JOIN genres ON books.FK_genres=genres.id
					JOIN age_recommendations ON books.FK_age_recommendations=age_recommendations.id 
					JOIN libraries ON books.FK_libraries=libraries.id
					JOIN borrows ON books.id = borrows.FK_books
                    JOIN users ON borrows.FK_users=users.id
					WHERE borrows.FK_users =".$user_id." ORDER BY title ASC");
				
				
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
				  		$borrows_id = $bookRow['borrows_id'];
				  		// echo "book id is: ".$book_id;
				  		if ($availability == 1){
				  			$available = "available";
				  		} else {
				  			$available = "not available";
				  		}
				  	
				  		echo 	'<div class="col-xs-12 col-md-6 margin-top">
						  			<form method="post" action="your_books.php?borrows_id='.$borrows_id.'" class="wrapper book_form panel panel-default card ">
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
												      <li class="margin-top"><input type="submit" class="btn btn-primary" value="Cancel Reservation" id="btn-cancel_reservation" name="btn-cancel_reservation"></li>
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
	  				
			?>
			</div>
		</div>







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