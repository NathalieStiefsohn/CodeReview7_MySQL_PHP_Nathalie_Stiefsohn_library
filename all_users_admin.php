<?php
require_once('includes/start_session_admin.php');
?>
<?php
$user_id = $_GET['user_id'];
if (!empty($user_id)) {

		$query_add_admin = "INSERT INTO admins(FK_users) VALUES($user_id)";
				$res_add_admin = mysql_query($query_add_admin);
		
		if ($res_add_admin) {
		$errTyp = "alert alert-success";
		$errMSG = "You successfully added a new admin!";
		// echo $errMSG;
		unset($user_id);
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
	<title>All Users</title>
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
	        <li class=""><a href="all_books_admin.php">All Books</a></li>
	        <li class="active"><a href="all_users_admin.php">All Users</a></li>
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
			        <th>Give Admin-Rights</th>
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
					username, first_name, family_name, email, member_since, admins.id AS admin_id, users.id AS user_id
					FROM users
					LEFT JOIN admins ON users.id=admins.FK_users
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
				  		$admin_id = $userRow['admin_id'];
				  		$user_id = $userRow['user_id'];

				  	
				  		echo 	'<tr> 
									<td>'.$username.'</td>
									<td>'.$first_name.'</td>
									<td>'.$family_name.'</td>
									<td>'.$email.'</td>
									<td>'.$member_since.'</td>
									<td>';

						if (empty($admin_id)) {
							echo '<form method="post" action="all_users_admin.php?user_id='.$user_id.'">
											<input type="submit" class="btn btn-primary" value="Give Admin-Rights" id="btn-give_admin_rights" name="btn-give_admin_rights">
										</form>
						  	';
						} else {
							echo '';
						}
						echo '</td>
								</tr>';
			  		}
				} else {

					$res_user=mysql_query("SELECT 
					username, first_name, family_name, email, member_since, admins.id AS admin_id, users.id AS user_id
					FROM users
					LEFT JOIN admins ON users.id=admins.FK_users

					ORDER BY username ASC");

					
			  		while($userRow=mysql_fetch_array($res_user)){
				  		$username = $userRow['username'];
				  		$first_name = $userRow['first_name'];
				  		$family_name = $userRow['family_name'];
				  		$email = $userRow['email'];
				  		$member_since = $userRow['member_since'];
				  		$admin_id = $userRow['admin_id'];
				  		$user_id = $userRow['user_id'];
				  	
				  		echo 	'<tr> 
									<td>'.$username.'</td>
									<td>'.$first_name.'</td>
									<td>'.$family_name.'</td>
									<td>'.$email.'</td>
									<td>'.$member_since.'</td>
									<td>';

						if (empty($admin_id)) {
							echo '<form method="post" action="all_users_admin.php?user_id='.$user_id.'">
											<input type="submit" class="btn btn-primary" value="Give Admin-Rights" id="btn-give_admin_rights" name="btn-give_admin_rights">
										</form>
						  	';
						} else {
							echo '';
						}
						echo '</td>
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