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
// validation ADD BOOK
		if(isset($_POST['btn_add_book'])) {
			// prevent sql injections/ clear user invalid inputs
			$title = trim($_POST['title']);
			$title = strip_tags($title);
			$title = htmlspecialchars($title);
			
			$author = trim($_POST['author']);
			$author = strip_tags($author);
			$author = htmlspecialchars($author);
			// convert author to author_FK
			$parts = explode(",", $author);
			$author_first_name = str_replace(' ','',$parts[1]);
			$author_family_name = $parts[0];

			$query_convert_author = "SELECT id FROM authors WHERE authors.family_name='$author_family_name' AND authors.first_name = '$author_first_name'";
			$author_FK1 = mysql_query($query_convert_author);
			$author_FK2 = mysql_fetch_array($author_FK1);
			$author_FK = $author_FK2[id];


			$genre = trim($_POST['genre']);
			$genre = strip_tags($genre);
			$genre = htmlspecialchars($genre);	
			// convert genre to genre_FK
			$query_convert_genre = "SELECT id FROM genres WHERE genres.genre='$genre'";
			$genre_FK1 = mysql_query($query_convert_genre);
			$genre_FK2 = mysql_fetch_array($genre_FK1);
			$genre_FK = $genre_FK2[id];

			$publishing_year = trim($_POST['publishing_year']);
			$publishing_year = strip_tags($publishing_year);
			$publishing_year = htmlspecialchars($publishing_year);

			$age = trim($_POST['age']);
			$age = strip_tags($age);
			$age = htmlspecialchars($age);
			// convert age to age_FK
			$query_convert_age = "SELECT id FROM age_recommendations WHERE age_recommendations.age='$age'";
			$age_FK1 = mysql_query($query_convert_age);
			$age_FK2 = mysql_fetch_array($age_FK1);
			$age_FK = $age_FK2[id];


			$image = trim($_POST['image']);
			$image = strip_tags($image);
			$image = htmlspecialchars($image);
		 
		  // prevent sql injections / clear user invalid inputs
		  $error_add_book = 0;	
			// TITLE
			  	if(empty($title)){
				   $error_add_author = 1;
				   $titleError = "Please enter the title.";
			  	} 

			// AUTHOR
			 		
			  	if(empty($author)){
				   $error_add_book = 1;
				   $authorError = "Please enter the author.";
			  	} 
			// PUBLISHING YEAER
			  	if($publishing_year===NULL){
				   $error_add_author = 1;
				   $publishing_yearError = "Please enter the publishing year.";
			  	} 
			// AGE RECOMMENDATION
			  	

	  		// IMAGE
			  	if(empty($image)){
				   $error_add_author = 1;
				   $imageError = "Please enter the image link.";
			  	} 
			// if there's no error, continue to save in db
			if( $error_add_book == 0 ) {
				$query_add_book = "INSERT INTO books(title, FK_authors, FK_genres, publishing_year, FK_age_recommendations, image) VALUES('$title', $author_FK, $genre_FK, $publishing_year, $age_FK, '$image')";
				$res_add_book = mysql_query($query_add_book);

				if ($res_add_book) {
					$errTyp_add_book = "success";
					$errMSG_add_book = "Successfully entered! Book is available for users now.";
					unset($title);
					unset($author_FK);
					unset($genre_FK);
					unset($publishing_year);
					unset($age_FK);
					unset($image);
					
				} else {
					$errTyp_add_book = "danger";
					$errMSG_add_book = "Something went wrong, try again later...";
					// echo $errMSG_add_book;
				}
   
  			} 
		}
// validation ADD AUTHOR
		if(isset($_POST['btn_add_author'])) {
			// prevent sql injections/ clear user invalid inputs
			$add_author_first_name1 = trim($_POST['add_author_first_name']);
			$add_author_first_name1 = strip_tags($add_author_first_name1);
			$add_author_first_name1 = htmlspecialchars($add_author_first_name1);
			$add_author_first_name = str_replace(' ','-',$add_author_first_name1);

			$add_author_family_name = trim($_POST['add_author_family_name']);
			$add_author_family_name = strip_tags($add_author_family_name);
			$add_author_family_name = htmlspecialchars($add_author_family_name);
		 
		  // prevent sql injections / clear user invalid inputs
		  $error_add_author = 0;	
			// AUTHOR'S FIRST NAME
			  	if(empty($add_author_first_name)){
				   $error_add_author = 1;
				   $add_author_firstnameError = "Please enter the author's first name.";
			  	} 
			// AUTHOR'S Family NAME
			 		
			  	if(empty($add_author_family_name)){
				   $error_add_author = 1;
				   $add_author_familynameError = "Please enter the author's family name.";
			  	} else {
				   // check whether the author exist or not
				   $query_add_author = "SELECT family_name FROM authors WHERE authors.family_name='$add_author_family_name' AND authors.first_name='$add_author_first_name'";
				   $result_add_author = mysql_query($query_add_author);
				   $count_add_author = mysql_num_rows($result_add_author);
				   if($count_add_author!=0){
					    $error_add_author = 1;
					    $errMSG_add_author = "Provided author is already available.";
				   }
				}
			// if there's no error, continue to save in db
			if( $error_add_author == 0 ) {
				// echo "no error";
				$query_add_author = "INSERT INTO authors(first_name, family_name) VALUES('$add_author_first_name', '$add_author_family_name')";
				$res_add_author = mysql_query($query_add_author);

				if ($res_add_author) {
					$errTyp_add_author = "success";
					$errMSG_add_author = "Successfully entered! Author available in dropdown now.";
					// echo $errMSG_add_genre;
					unset($add_author_first_name);
					unset($add_author_family_name);
				} else {
					$errTyp_add_author = "danger";
					$errMSG_add_author = "Something went wrong, try again later...";
					// echo $errMSG_add_genre;
				}
   
  			} 
		}
// validation ADD GENRE
		if(isset($_POST['btn_add_genre'])) {
			// prevent sql injections/ clear user invalid inputs
			$add_genre = trim($_POST['add_genre']);
			$add_genre = strip_tags($add_genre);
			$add_genre = htmlspecialchars($add_genre);
		 
		  // prevent sql injections / clear user invalid inputs
		 	$error_add_genre = 0;	
		  	if(empty($add_genre)){
			   $error_add_genre = 1;
			   $add_genreError = "Please enter a genre.";
		  	} else {
			   // check whether the genre exist or not
			   $query_add_genre = "SELECT genre FROM genres WHERE genres.genre='$add_genre'";
			   $result_add_genre = mysql_query($query_add_genre);
			   $count_add_genre = mysql_num_rows($result_add_genre);
			   if($count_add_genre!=0){
				    $error_add_genre = 1;
				    $add_genreError = "Provided genre is already available.";
			   }
			}
			// if there's no error, continue to save in db
			if( $error_add_genre == 0 ) {
				// echo "no error";
				$query_add_genre = "INSERT INTO genres(genre) VALUES('$add_genre')";
				$res_add_genre = mysql_query($query_add_genre);

				if ($res_add_genre) {
					$errTyp_add_genre = "success";
					$errMSG_add_genre = "Successfully entered! Genre available in dropdown now.";
					// echo $errMSG_add_genre;
					unset($add_genre);
				} else {
					$errTyp_add_genre = "danger";
					$errMSG_add_genre = "Something went wrong, try again later...";
					// echo $errMSG_add_genre;
				}
   
  			} 
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - <?php echo $userRow['first_name']; ?></title>
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
						<li role="presentation" class="active"><a href="home_admin.php">Add Book/Author/Genre</a></li>
						<li role="presentation"><a href="library_admin.php">Opening Hours</a></li>
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
			<h2 class="brandfont text-center">Add a new Book</h2>
			<hr>
		</div>
		<form class="col-xs-12" method="post">
			<?php
	            if ( isset($_POST['btn_add_book']) ) {
	              echo '<div class="alert">'.$errMSG_add_book.'</div>';
	            }
          	?>
			<div class="row">
				<!-- first_row -->
				<div class="col-xs-12 col-md-6">
				<!-- TITLE -->
				  <h4>Title:</h4>
				  <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title">
				  <span class="text-danger"><?php echo $titleError; ?></span>
				  <!-- AUTHOR -->
				  <h4>Author:</h4>
				  	<input type="text" list="list_authors" placeholder="Pick author from dropdown." name="author" class="form-control"/>
					<datalist id="list_authors" name="author">
				  	<?php
				  	 // select all available authors
 						$res_author=mysql_query("SELECT * FROM authors ORDER BY family_name ASC");
 						
 						
				  		while($authorRow=mysql_fetch_array($res_author)){
					  		$author_db_first_name = $authorRow['first_name'];
					  		$author_db_family_name = $authorRow['family_name'];
					  		$author_db_id = $authorRow['id'];
					  		echo "<option value='".$author_db_family_name.", ".$author_db_first_name."'>".$author_db_family_name.", ".$author_db_first_name."</option>";
				  		}
				  	?>

				  </datalist>
				  <span class="text-danger"><?php echo $authorError; ?></span>
				  <!-- GENRE -->
				  <h4>Genre:</h4>
				  	<input type="text" list="list_genres" name="genre" class="form-control" placeholder="Pick genre from dropdown."/>
					<datalist id="list_genres" name="genre">
				  	<?php
				  	 // select all available genres
 						$res_genre=mysql_query("SELECT * FROM genres ORDER BY genre ASC");
 						
 						
				  		while($genreRow=mysql_fetch_array($res_genre)){
					  		$genre_db = $genreRow['genre'];
					  		$genre_db_id = $genreRow['id'];
					  		echo "<option value='".$genre_db."'>".$genre_db."</option>";
				  		}
				  	?>

				  </datalist>
				  
				  <span class="text-danger"><?php echo $genreError; ?></span>
				</div>
				<!-- second row -->
				<div class="col-xs-12 col-md-6">
				  <!-- PUBLISHING YEAR -->
				  <h4>Publishing Year:</h4>
				  <?php
				  	echo '<input type="number" id="publishing_year" name="publishing_year" class="form-control" placeholder="Enter Publishing Year" min="1500" max="'.date("Y").'" value="'.date("Y").'"/>';
				  ?>
				  
				  <span class="text-danger"><?php echo $publishingyearError; ?></span>  
				  <!-- AGE RECOMMENDATION -->
				  <h4>Age Recommendation:</h4>
				  <input type="text" list="list_aage" placeholder="Pick age recommendation from dropdown." name="age" class="form-control" autocomplete="off" />
					<datalist id="list_aage" name="age">
				  	<?php
				  	 // select all available authors
 						$res_age=mysql_query("SELECT * FROM age_recommendations");
 						
 						
				  		while($ageRow=mysql_fetch_array($res_age)){
					  		$age_db_age = $ageRow['age'];

					  		echo "<option value='".$age_db_age."'>".$age_db_age."</option>";
				  		}
				  	?>
				  </datalist>
				  <span class="text-danger"><?php echo $ageError; ?></span> 
				  <!-- IMAGE -->
				  <h4>Image:</h4>
				  <input type="text" value="pictures/default.jpg" name="image" id="image" class="form-control" placeholder="Enter image link.">
				  <span class="text-danger"><?php echo $imageError; ?></span> 
				 
				</div>
				<div class="col-xs-12">
					 <!-- SUBMIT -->
         			<hr />
          			<button type="submit" id="btn_add_book" class="btn btn-block btn-primary" name="btn_add_book">Add Book</button>
				</div>
			</div>
		</form>
<!-- ADD AUTHOR -->
		<div class="col-xs-12 margin-top">
			<h2 class="brandfont text-center">Add a new Author</h2>
			<hr>
		</div>
		<form class="col-xs-12" method="post">
			<?php
	            if ( isset($_POST['btn_add_author']) ) {
	              echo '<div class="alert">'.$errMSG_add_author.'</div>';
	            }
          	?>
			<div class="row">
				<!-- first_row -->
				<div class="col-xs-12 col-md-6">
				<!-- FIRST NAME AUTHOR -->
				  <h4>First Name: </h4>
				  <input type="text" name="add_author_first_name" id="add_author_first_name" class="form-control" placeholder="Enter author's first name.">
				  <span class="text-danger"><?php echo $add_author_firstnameError; ?></span>
				 
				</div>
				<!-- second row -->
				<div class="col-xs-12 col-md-6">
				 	<!-- FAMILY NAME AUTHOR -->
				  <h4>Family Name:</h4>
				  <input type="text" name="add_author_family_name" id="add_author_family_name" class="form-control" placeholder="Enter author's family name.">
				  <span class="text-danger"><?php echo $add_author_familynameError; ?></span>
				 
				</div>
				<div class="col-xs-12">
					 <!-- SUBMIT -->
         			<hr />
          			<button type="submit" id="btn_add_author" class="btn btn-block btn-primary" name="btn_add_author">Add Author</button>
				</div>
			</div>
		</form>
<!-- ADD GENRE -->
		<div class="col-xs-12 margin-top">
			<h2 class="brandfont text-center">Add a new Genre</h2>
			<hr>
		</div>
		<form class="col-xs-12" method="post">
			<?php
	            if ( isset($_POST['btn_add_genre']) ) {
	              echo '<div class="alert">'.$errMSG_add_genre.'</div>';
	            }
          	?>
			<div class="row">
				<!-- first_row -->
				<div class="col-xs-12 col-md-6">
				<!-- GENRE -->
				  <h4>Genre:</h4>
				  <input type="text" name="add_genre" id="add_genre" class="form-control" placeholder="Enter Genre">
				  <span class="text-danger"><?php echo $add_genreError; ?></span>
				 
				</div>
				<!-- second row -->
				<div class="col-xs-12 col-md-6">
				 
				 
				</div>
				<div class="col-xs-12">
					 <!-- SUBMIT -->
         			<hr />
          			<button type="submit" id="btn_add_genre" class="btn btn-block btn-primary" name="btn_add_genre">Add Genre</button>
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