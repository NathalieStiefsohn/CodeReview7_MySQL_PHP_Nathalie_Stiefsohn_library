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
// EDIT OPENING HOURS
		if(isset($_POST['btn_opening_hours'])) {
			// prevent sql injections/ clear user invalid inputs
			$open_at = trim($_POST['open_at']);
			$open_at = strip_tags($open_at);
			$open_at = htmlspecialchars($open_at);
			
			$close_at = trim($_POST['close_at']);
			$close_at = strip_tags($close_at);
			$close_at = htmlspecialchars($close_at);		  

				// echo "no error";
				$query_opening_hours = "UPDATE libraries SET open_from=TIME_FORMAT('$open_at', '%H:%i:%s'), open_to=TIME_FORMAT('$close_at', '%H:%i:%s') ";
				$res_opening_hours = mysql_query($query_opening_hours);

				if ($res_opening_hours) {
					$errTyp_opening_hours = "success";
					$errMSG_opening_hours = "Successfully changed opening hours! The library is now opened from $open_at to $close_at!";
					// echo $errMSG_add_genre;
					unset($add_genre);
				} else {
					$errTyp_opening_hours = "danger";
					$errMSG_opening_hours = "Something went wrong, try again later...";
					// echo $errMSG_add_genre;
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
						<li role="presentation" class="active"><a href="library_admin.php">Opening Hours</a></li>
						<li role="presentation"><a href="all_books_admin.php">All Books</a></li>
						<li role="presentation"><a href="all_users_admin.php">All Users</a></li>
					</ul>
				</div>
				
			</div>
		</div>
	</nav>
	<!-- main -->
	<section class="row">
		<div class="col-xs-12">
			<h2 class="brandfont text-center">Change Opening Hours</h2>
			<hr>
		</div>
		<form class="col-xs-12" method="post">
			<?php
	            if ( isset($_POST['btn_opening_hours']) ) {
	              echo '<div class="alert">'.$errMSG_opening_hours.'</div>';
	            }
          	?>
			<div class="row center_text">
				<!-- first_row -->
				<div class="col-xs-12 col-md-6">
				<!-- OPEN AT -->
				  <h4>Open at:</h4>
				  <input step="1" type="time" name="open_at" id="open_at" class="form-control" placeholder="When will you open the library?">				 
				</div>
				<!-- second row-->
				<div class="col-xs-12 col-md-6">
				<!-- CLOSE AT -->
				  <h4>Close at:</h4>
				  <input step="1" type="time" name="close_at" id="close_at" class="form-control" placeholder="When will you close the library?">				 
				</div>
				<div class="col-xs-12">
					 <!-- SUBMIT -->
         			<hr />
          			<button type="submit" id="btn_opening_hours" class="btn btn-block btn-primary" name="btn_opening_hours">Change opening hours</button>
				</div>
			</div>
		</form>
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