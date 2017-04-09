<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['admin']) ) {
  header("Location: index.php");
  exit;
 }
 // select logged-in users detail
 $res=mysql_query("SELECT * FROM users WHERE id=".$_SESSION['admin']);
 $userRow=mysql_fetch_array($res);
?>
<?php
	$book_id = $_GET['book_id'];
	if (!empty($book_id)) {
		$res=mysql_query("SELECT * FROM borrows WHERE FK_books = ".$book_id);
		$borrowRow=mysql_fetch_array($res);
		$borrows_id =$borrowRow['id'];
		$query_borrows = "DELETE FROM borrows WHERE id='".$borrows_id."'";
		$res_borrows = mysql_query($query_borrows);

		$query_books_availability = "UPDATE books SET available=1 WHERE books.id=$book_id";
		$res_books_availability = mysql_query($query_books_availability);

		if ($res_borrows && $res_books_availability) {
		$errTyp = "alert alert-success";
		$errMSG = "You successfully canceled the reservation!";
		// echo $errMSG;
		unset($borrows_id);
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
    <title>Library Administration</title>
	<link rel="icon" href="pictures/logo.png">
    <!-- style sheet -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- jquery and bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight.js"></script>
    <!-- webfont -->
    <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster+Two" rel="stylesheet">
	
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
						    <li class="">
						      <a href="home_user.php" aria-label="User View">
						        <span aria-hidden="true">User View</span>
						      </a>
						    </li>
						    <li class="active">
						      <a href="home_admin.php" aria-label="Admin Panel">
						        <span aria-hidden="true">Admin Panel</span>
						      </a>
						    </li>
							</ul>
					</nav>';
		} 
	?>
	<nav class="row margin-top">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 text-center">
					<ul class="nav nav-tabs">
						<li role="presentation"><a href="home_admin.php">Add Book/Author/Genre</a></li>
						<li role="presentation"><a href="library_admin.php">Opening Hours</a></li>
						<li role="presentation" class="active"><a href="all_books_admin.php">All Books</a></li>
						<li role="presentation"><a href="all_users_admin.php">All Users</a></li>
					</ul>
				</div>
				
			</div>
		</div>
	</nav>
	<!-- main -->
	<section class="row">
	

		<div class="col-xs-12">
			<h2 class="brandfont text-center">List of all Books</h2>
			<hr>
		</div>
		
		<form class="col-xs-6 col-xs-offset-3" role="search" method="get">
    		<div class="input-group">
    			<input type="search" class="form-control" name="search" placeholder="Search for a book">
        		<div class="input-group-btn">
            		<button class="btn btn-default" name="btn-search" id="btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>

        		</div>
    		</div>
    		<hr>		
		</form>

		<?php
			echo 	'<div class="col-xs-12 '.$errTyp.' text-center">
						<h3>'.$errMSG.'</h3>
					</div>';
		?>
		
		<div class="col-xs-12">
			<table class="table">
				<thead>
			      <tr>
			        <th>Title</th>
			        <th>Author</th>
			        <th>Publishing year</th>
			        <th>Genre</th>
			        <th>Age Class</th>
			        <th>Status</th>
			        <th>Username</th>
			        <th>Cancel Reservation</th>
			      </tr>
			    </thead>
			    <tbody>
			<?php 			
				 // select all available books
				 
				if ( isset($_GET['btn-search']) ){
					$search = trim($_GET['search']);
			 		$search = strip_tags($search);
			  		$search = htmlspecialchars($search);
					$res_book=mysql_query("SELECT 
					title, authors.first_name, authors.family_name, publishing_year, genre, age, available, books.id as books_id, username
					FROM books 
					JOIN authors ON books.FK_authors=authors.id
					JOIN genres ON books.FK_genres=genres.id
					JOIN age_recommendations ON books.FK_age_recommendations=age_recommendations.id
					LEFT JOIN borrows ON books.id = borrows.FK_books
                    LEFT JOIN users ON borrows.FK_users=users.id 
 					
					WHERE title LIKE '%$search%'
					OR authors.first_name LIKE '%$search%'
					OR authors.family_name LIKE '%$search%'
					OR genre LIKE '%$search%'
					ORDER BY title ASC");
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
				  		$username = $bookRow['username'];
				  		// echo "book id is: ".$book_id;
				  		if ($availability == 1){
				  			$available = "available";
				  		} else {
				  			$available = "not available";
				  		}
				  	
				  		echo 	'<tr> 
									<td>'.$title.'</td>
									<td>'.$author_first_name.' '.$author_family_name.'</td>
									<td>'.$published.'</td>
									<td>'.$genre.'</td>
									<td>'.$age.'</td>
									<td>'.$available.'</td>
									<td>';

						if ($availability == 0) {
							echo $username;
						}
						echo '</td>
									<td>';

						if ($availability == 0){

				  		
						echo			'<form method="post" action="all_books_admin.php?book_id='.$book_id.'">
											<input type="submit" class="btn btn-primary" value="Cancel Reservation" id="btn-cancel_reservation" name="btn-cancel_reservation">
										</form>
						  	';
					  	}
					  	echo 		'</td>
					  			</tr>';
			  		}
				} else {

					$res_book=mysql_query("SELECT 
					title, authors.first_name, authors.family_name, publishing_year, genre, age, available, books.id as books_id, username
					FROM books 
					JOIN authors ON books.FK_authors=authors.id
					JOIN genres ON books.FK_genres=genres.id
					JOIN age_recommendations ON books.FK_age_recommendations=age_recommendations.id
					LEFT JOIN borrows ON books.id = borrows.FK_books
                    LEFT JOIN users ON borrows.FK_users=users.id 
 					ORDER BY title ASC");
				
				
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
				  		$username = $bookRow['username'];
				  		// echo "book id is: ".$book_id;
				  		if ($availability == 1){
				  			$available = "available";
				  		} else {
				  			$available = "not available";
				  		}
				  	
				  		echo 	'<tr> 
									<td>'.$title.'</td>
									<td>'.$author_first_name.' '.$author_family_name.'</td>
									<td>'.$published.'</td>
									<td>'.$genre.'</td>
									<td>'.$age.'</td>
									<td>'.$available.'</td>
									<td>';

						if ($availability == 0) {
							echo $username;
						}
						echo '</td>
									<td>';

						if ($availability == 0){

				  		
						echo			'<form method="post" action="all_books_admin.php?book_id='.$book_id.'">
											<input type="submit" class="btn btn-primary" value="Cancel Reservation" id="btn-cancel_reservation" name="btn-cancel_reservation">
										</form>
						  	';
					  	}
					  	echo 		'</td>
					  			</tr>';
					  	
			  		}
  				}
	  				
			?>
				</tbody>
			</table>
		</div>







	</section>
	<!-- footer -->
	<div class="row margin-top ">
        <div class="col-xs-12 text-center shadow panel panel-default">
            All rights reserved for Nati
        </div>
    </div>
	 
</div>
</body>
</html>
<?php ob_end_flush(); ?>