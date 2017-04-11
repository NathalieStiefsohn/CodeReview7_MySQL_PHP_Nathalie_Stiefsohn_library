<?php
require_once('includes/start_session_admin.php');
?>
<?php
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>All Users</title>
	<?php
require_once('includes/head_tag.php');
	?>
</head>
<body>
<div class="container">


	<?php
require_once('includes/header.php');
require_once('includes/switch_admin_view.php');
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
	<?php
require_once('includes/footer.php');
	?>
	 
</div>
</body>
</html>
<?php ob_end_flush(); ?>