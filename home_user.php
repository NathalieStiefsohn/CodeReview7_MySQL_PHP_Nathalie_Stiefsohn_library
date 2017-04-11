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
						<li role="presentation" class="active"><a href="home_user.php">Search for Books</a></li>
						<li role="presentation" class=""><a href="your_books.php">Your Books</a></li>
						<li role="presentation" class=""><a href="opening_hours.php">Opening Hours</a></li>
					</ul>
					 
				
				</div>
				
			</div>
		</div>
	</nav>
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