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
	 $res=mysql_query("SELECT first_name, family_name, username, users.id AS user_id, avatar, avatars.id AS avatar_id FROM users JOIN avatars ON users.FK_avatars=avatars.id WHERE users.id=".$_SESSION['user']);
	 $userRow=mysql_fetch_array($res);
	 $user_id = $userRow['user_id'];
	 $user_avatar = $userRow['avatar'];
?>