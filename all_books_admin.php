<?php
require_once('includes/start_session_admin.php');
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
	<title>All Books</title>
	<?php
require_once('includes/head_tag.php');
	?>
</head>
<body>
<div id="wrap">
  <div id="main" class="container clear-top">

	<div class="navbar navbar-inverse navbar-fixed-top">	
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target=".navbar-collapse">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <!-- <a class="navbar-brand" href="#">Brand</a> -->

	    </div>
	    <div class="collapse navbar-collapse">
	      <ul class="nav navbar-nav">
	        <li class=""><a href="home_admin.php">Add Book</a></li>
	        <li class=""><a href="library_admin.php">Opening Hours</a></li>
	        <li class="active"><a href="all_books_admin.php">All Books</a></li>
	        <li class=""><a href="all_users_admin.php">All Users</a></li>
	      </ul>

	    </div><!--/.nav-collapse -->
			        	<?php
require_once('includes/switch_admin_view.php');
		?>

	  </div>



		<?php
require_once('includes/header.php');
		?>

	<!-- main -->
	<section class="row">
	

		<div class="col-xs-12">
			<h2 class="brandfont text-center">List of all Books</h2>
			<hr>
		</div>
		
		<?php
require_once('includes/search_bar.php');
		?>

		<?php
require_once('includes/alert_box.php');
		?>
		
		<div class="col-xs-12">
			<table class="table">
				<thead>
			      <tr>
			        <th>Title</th>
			        <th>Author</th>
			        <th>Publishing <br>year</th>
			        <th>Genre</th>
			        <th>Age <br>Class</th>
			        <th>Status</th>
			        <th>Username</th>
			        <th>Cancel <br>Reservation</th>
			      </tr>
			    </thead>
			    <tbody>
			<?php 			
				 // select all available books
				 
				if ( isset($_GET['btn-search']) ){
					
					$search = trim($_GET['search']);
			 		$search = strip_tags($search);
			  		$search = htmlspecialchars($search);
			  		// MYSQL query to get all data which is connected to the search key word
					$res_book=mysql_query("SELECT 
					title, authors.first_name, authors.family_name, publishing_year, genre, age, available, books.id as books_id, username
					FROM books 
					JOIN authors ON books.FK_authors=authors.id
					JOIN genres ON books.FK_genres=genres.id
					JOIN age_recommendations ON books.FK_age_recommendations=age_recommendations.id
					JOIN books_tags ON books.id=books_tags.FK_books
					JOIN tags ON books_tags.FK_tags=tags.id
					LEFT JOIN borrows ON books.id = borrows.FK_books
                    LEFT JOIN users ON borrows.FK_users=users.id 
 					
					WHERE title LIKE '%$search%'
					OR authors.first_name LIKE '%$search%'
					OR authors.family_name LIKE '%$search%'
					OR genre LIKE '%$search%'
					OR publishing_year LIKE '%$search%'
					OR tag LIKE '%$search%'
					ORDER BY title ASC");
					// get telephone number
					$res_library=mysql_query("SELECT * FROM libraries");
					$row_library=mysql_fetch_array($res_library);
					$telephone = $row_library['telephone'];

require_once('includes/count_search_result.php');
					
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
											<input type="submit" class="btn btn-primary" value="Cancel" id="btn-cancel_reservation" name="btn-cancel_reservation">
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
											<input type="submit" class="btn btn-primary" value="Cancel" id="btn-cancel_reservation" name="btn-cancel_reservation">
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
<!-- end wrapper to put footer on the bottom of the page -->
  </div>
</div>
	<!-- footer -->
	<?php
require_once('includes/footer.php');
	?>
	 
</body>
</html>
<?php ob_end_flush(); ?>