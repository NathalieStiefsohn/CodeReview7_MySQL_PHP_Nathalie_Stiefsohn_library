<?php
require_once('includes/start_session_user.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Opening Hours</title>
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
						<li role="presentation" class=""><a href="your_books.php">Your Books</a></li>
						<li role="presentation" class="active"><a href="opening_hours.php">Opening Hours</a></li>
					</ul>
					 
				
				</div>
				
			</div>
		</div>
	</nav>

	<!-- main -->
	<section class="row">
	
		<div class="col-xs-12">
			<h2 class="brandfont text-center">Opening Hours</h2>
			<hr>
		</div>
		
<?php
	$res_library=mysql_query("SELECT * FROM libraries");
	$row_library=mysql_fetch_array($res_library);
	$telephone = $row_library['telephone'];
	$open_from = $row_library['open_from'];
	$open_to = $row_library['open_to'];

	echo 	'<div class="row margin-top text-center">
				<h4>The library has the following opening hours:</h4>
				<div class="col-xs-6 alert alert-success"> 
					<h3>'.$open_from.'</h3>
				</div>
				<div class="col-xs-6 alert alert-success"> 
					<h3>'.$open_to.'</h3>
				</div>	
			</div>'

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