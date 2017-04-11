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
			<li class=""><a href="your_books.php">Your Books</a></li>
			<li class="active"><a href="opening_hours.php">Opening Hours</a></li>
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
			<h2 class="brandfont text-center">Opening Hours</h2>
			<hr>
		</div>
		<div class="col-xs-12">
		
<?php
	$res_library=mysql_query("SELECT TIME_FORMAT(open_from, '%H:%i') AS 'open_from', TIME_FORMAT(open_to, '%H:%i') AS 'open_to', telephone FROM libraries");
	$row_library=mysql_fetch_array($res_library);
	$telephone = $row_library['telephone'];
	$open_from = $row_library['open_from'];
	$open_to = $row_library['open_to'];

	echo 	'<div class="row margin-top text-center">
				<h4></h4>
				<div class="col-xs-4 col-xs-offset-1"> 
					<div class="padding alert alert-success"> <h3>'.$open_from.'</h3></div>
				</div>
				<div class="col-xs-2 text-center"><h2>to</h2></div>
				<div class="col-xs-4 "> 
					<div class="padding alert alert-success"> <h3>'.$open_to.'</h3></div>
				</div>	
			</div>'

?>

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