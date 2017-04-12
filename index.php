<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // it will never let you open index(login) page if session is set
 if ( isset($_SESSION['admin'])!="" ) {
  header("Location: home_admin.php");
  exit;
 } else if ( isset($_SESSION['user'])!="" ) {
  header("Location: home_user.php");
  exit;
 }
 
 $error = 0;
 
 if( isset($_POST['btn-login']) ) {
 
  // prevent sql injections/ clear user invalid inputs
  $username = trim($_POST['username']);
  $username = strip_tags($username);
  $username = htmlspecialchars($username);
 
  $password = trim($_POST['password']);
  $password = strip_tags($password);
  $password = htmlspecialchars($password);
  // prevent sql injections / clear user invalid inputs
 
  if(empty($username)){
   $error = 1;
   $nameError = "Please enter your username address.";
  } 
 
  if(empty($password)){
   $error = 1;
   $passError = "Please enter your password.";
  }
 // echo "hello $error";
  // if there's no error, continue to login
  if ($error == 0) {
   
   $password = hash('sha256', $password); // password hashing using SHA256
  // user
   $res_user=mysql_query("SELECT id, username, first_name, password FROM users WHERE username='$username'");
   $row_user=mysql_fetch_array($res_user);
   $count_user = mysql_num_rows($res_user); // if uname/pass correct it returns must be 1 row
   // echo $count_user;
   // admin
   $res_admin=mysql_query("SELECT users.id, username, first_name, password FROM users JOIN admins ON users.id = admins.FK_users WHERE username='$username'");
   $row_admin=mysql_fetch_array($res_admin);
   $count_admin = mysql_num_rows($res_admin); // if uname/pass correct it returns must be 1 row
   // echo $count_admin;

   if( $count_user == 1 && $row_user['password']==$password ) {
    $_SESSION['user'] = $row_user['id'];
    header("Location: home_user.php");
   } else {
    $errTyp = "alert alert-danger";
    $errMSG = "Incorrect credentials. Try again...";
   }

   if( $count_admin == 1 && $row_admin['password']==$password ) {
    $_SESSION['admin'] = $row_admin['id'];
    header("Location: home_admin.php");
   }
   
  }
 
 }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log-in</title>
  <link rel="icon" href="pictures/logo2.png">
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
  <div id="wrap">
  <div id="main" class="container clear-top">
  
  <header class="row shadow">
    <div class="col-xs-6">
      <span><img id="logo" src="pictures/logo.png" alt="logo"></span>
      <span><h1 class="brandfont">Code Library</h1></span>
    </div>
  </header>
    <div class="row">
      <div class="col-xs-12">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

          <h2>Sign In.</h2>
          <hr />
                 
      <?php
require_once('includes/alert_box.php');
            ?>
      </div>
      <div class="col-xs-12 col-md-6">               
               
                 
        <!-- USERNAME -->
          <h4>USERNAME:</h4>
          <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" maxlength="50" value="<?php echo $name ?>" />
          <span class="text-danger"><?php echo $nameError; ?></span>
      </div>
      <div class="col-xs-12 col-md-6">
        <!-- PASSWORD -->
          <h4>PASSWORD:</h4>
          <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" maxlength="15" />
          <span class="text-danger"><?php echo $passError; ?></span>
      </div>
      <div class="col-xs-12">
        <!-- SUBMIT -->
          <hr />
          <button type="submit" id="btn-login" class="btn btn-primary" name="btn-login">Log-In</button>
          <hr />
          <a href="register.php">Sign Up Here...</a>
      </div>

      </form>

    </div>

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
