<?php
require_once('includes/start_session_user.php');
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
	<title>Your Books</title>
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
	        <li class=""><a href="home_user.php">Search for Books</a></li>
			<li class="active"><a href="your_books.php">Your Books</a></li>
			<li class=""><a href="opening_hours.php">Opening Hours</a></li>
	      </ul>

	    </div><!--/.nav-collapse -->
			        	<?php
require_once('includes/switch_user_view.php');
		?>

	  </div>



		<?php
require_once('includes/header.php');
		?>


	
	<!-- main -->
	<section class="row">


		<div class="col-xs-12">
			<h2 class="brandfont text-center">Search for one of your books</h2>
			<hr>
		</div>
		
		<?php
	require_once('includes/search_bar.php');
		?>
		

		<div class="col-xs-12">

			<div class="row">
			<?php 	

				echo 	'<div class="col-xs-12">
							<h2 class="brandfont text-center">Your Books</h2>
							<hr>
						</div>';
		
require_once('includes/alert_box.php');

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
                    JOIN books_tags ON books.id=books_tags.FK_books
					JOIN tags ON books_tags.FK_tags=tags.id
					WHERE (title LIKE '%$search%'
					OR authors.first_name LIKE '%$search%'
					OR authors.family_name LIKE '%$search%'
					OR publishing_year LIKE '%$search%'
					OR tag LIKE '%$search%'
					OR genre LIKE '%$search%') AND
					borrows.FK_users =".$user_id." ORDER BY title ASC");


					// get telephone number
					$res_library=mysql_query("SELECT * FROM libraries");
					$row_library=mysql_fetch_array($res_library);
					$telephone = $row_library['telephone'];

					
require_once('includes/count_search_result.php');
require_once('includes/while_loop_your_books.php');

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
				
require_once('includes/while_loop_your_books.php');
	
  				}
	  				
			?>
			</div>
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