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
						<li role="presentation"><a href="all_books_admin.php">All Books</a></li>
						<li role="presentation" class="active"><a href="all_users_admin.php">All Users</a></li>
					</ul>
				</div>
				
			</div>
		</div>
	</nav>
	<!-- main -->
	<section class="row">
	

		<div class="col-xs-12">
			<h2 class="brandfont text-center">List of all Users</h2>
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
			        <th>Username</th>
			        <th>First Name</th>
			        <th>Last Name</th>
			        <th>E-Mail</th>
			        <th>Member since</th>
			      </tr>
			    </thead>
			    <tbody>
			<?php 			
				 // select all available books
				 
				if ( isset($_GET['btn-search']) ){
					$search = trim($_GET['search']);
			 		$search = strip_tags($search);
			  		$search = htmlspecialchars($search);
					$res_user=mysql_query("SELECT 
					username, first_name, family_name, email, member_since
					FROM users
					WHERE username LIKE '%$search%'
					OR first_name LIKE '%$search%'
					OR family_name LIKE '%$search%'
					OR email LIKE '%$search%'
					OR member_since LIKE '%$search%'
					ORDER BY username ASC");

					$count_search = mysql_num_rows($res_user);
					if ($count_search == 1){
						echo "<h4 class='text-center'>We found ".$count_search." result for '".$search."'.</h4> <hr>";
					} else if ($count_search == 0) {
					echo '<div class="alert alert-danger">
							<h4 class="text-center">Unfortunately there are no results for "'.$search.'". <br></h4> 
						</div><hr>';
					} else {
						echo "<h4 class='text-center'>We found ".$count_search." results for '".$search."'.</h4> <hr>";
					}
					
			  		while($userRow=mysql_fetch_array($res_user)){
				  		$username = $userRow['username'];
				  		$first_name = $userRow['first_name'];
				  		$family_name = $userRow['family_name'];
				  		$email = $userRow['email'];
				  		$member_since = $userRow['member_since'];

				  	
				  		echo 	'<tr> 
									<td>'.$username.'</td>
									<td>'.$first_name.'</td>
									<td>'.$family_name.'</td>
									<td>'.$email.'</td>
									<td>'.$member_since.'</td>
								</tr>';
			  		}
				} else {

					$res_user=mysql_query("SELECT 
					username, first_name, family_name, email, member_since
					FROM users
					ORDER BY username ASC");

					
			  		while($userRow=mysql_fetch_array($res_user)){
				  		$username = $userRow['username'];
				  		$first_name = $userRow['first_name'];
				  		$family_name = $userRow['family_name'];
				  		$email = $userRow['email'];
				  		$member_since = $userRow['member_since'];
				  	
				  		echo 	'<tr> 
									<td>'.$username.'</td>
									<td>'.$first_name.'</td>
									<td>'.$family_name.'</td>
									<td>'.$email.'</td>
									<td>'.$member_since.'</td>
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