<header class="row shadow">
		<div class="col-xs-12 col-sm-6">
			<span><img id="logo" src="pictures/logo.png" alt="logo"></span>
			<span><h1 class="brandfont">Code Library</h1></span>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="padding">
				<div class="row header_right text-right">
					
					<?php
						echo'<div class="col-xs-10">
								Welcome back, '. $userRow["first_name"].'!<br>
			       				<a href="logout.php?logout">Sign Out</a>
			       			</div>
			       			<div class="col-xs-2 pull-right">
			       			<img class="img-circle show_avatar border" src="'.$user_avatar.'" alt="avatar">
			       			</div>';
			       	?>

		    	</div>
	    	</div>
		</div>
<!-- 		<div class="visible-xs navbar navbar-default">
		  
		   <ul class="nav nav-pills nav-stacked">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
		          <ul class="dropdown-menu nav nav-pills nav-stacked" role="menu">
		            	<li role="presentation" class=""><a href="home_admin.php">Add Book/Author/Genre</a></li>
						<li role="presentation"><a href="library_admin.php">Opening Hours</a></li>
						<li role="presentation"><a href="all_books_admin.php">All Books</a></li>
						<li role="presentation"><a href="all_users_admin.php">All Users</a></li>
		          </ul>
		        </li>
		  </ul>
  		</div> -->
	</header>
