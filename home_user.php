<?php
require_once('includes/start_session_user.php');
?>

<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>Search Books</title>
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
	        <li class="active"><a href="home_user.php">Search for Books</a></li>
			<li class=""><a href="your_books.php">Your Books</a></li>
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
			<h2 class="brandfont text-center">Search for a book</h2>
			<hr>
		</div>
		
		<?php
require_once('includes/search_bar.php');
		?>
		
		<div class="col-xs-12">
			<div class="row">
			<?php 			
				 // select all available books
				 
				if ( isset($_GET['btn-search']) ){
require_once('includes/process_search_query.php');
					// get telephone number
					$res_library=mysql_query("SELECT * FROM libraries");
					$row_library=mysql_fetch_array($res_library);
					$telephone = $row_library['telephone'];

require_once('includes/count_search_result.php');	
require_once('includes/while_loop_home_user.php');						
			  		
				} else {

					$res_book=mysql_query("SELECT 
					title, first_name, family_name, image, publishing_year, genre, age, available, books.id as books_id, authors.id as authors_id
					FROM books 
					JOIN authors ON books.FK_authors=authors.id
					JOIN genres ON books.FK_genres=genres.id
					JOIN age_recommendations ON books.FK_age_recommendations=age_recommendations.id 
					JOIN libraries ON books.FK_libraries=libraries.id 
					ORDER BY title ASC");
				
				
require_once('includes/while_loop_home_user.php');

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