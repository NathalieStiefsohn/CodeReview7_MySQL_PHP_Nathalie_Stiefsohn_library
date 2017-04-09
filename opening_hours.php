<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';

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
						<li role="presentation" class=""><a href="selected_book.php">Selected Book</a></li>
						<li role="presentation"><a href="your_books.php">Your Books</a></li>
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