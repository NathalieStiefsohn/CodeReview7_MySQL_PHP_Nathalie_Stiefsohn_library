<?php 
	if( isset($_SESSION['admin']) ) {
		echo 	'<nav class="text-right reduce-bottom-margin" aria-label="Page navigation">
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