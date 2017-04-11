

<header class="row shadow header_margin">
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
</header>
