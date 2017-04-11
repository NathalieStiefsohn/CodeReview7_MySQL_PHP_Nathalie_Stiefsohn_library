<?php 
	if( isset($_SESSION['admin']) ) {
		echo 	'<span class="text-right reduce-bottom-margin pull-right reduce_top_margin" aria-label="Page navigation">
						<ul class="pagination">
					    <li class="active">
					      <a href="home_user.php" aria-label="User View">
					        <span aria-hidden="true">User View <i class="glyphicon glyphicon-user"></i></span>
					      </a>
					    </li>
					    <li class="">
					      <a href="home_admin.php" aria-label="Admin Panel">
					        <span aria-hidden="true">Admin Panel <i class="glyphicon glyphicon-pencil"></i></span>
					      </a>
					    </li>
						</ul>
				</span>';
	} 
?>