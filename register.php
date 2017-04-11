<?php
 ob_start();
 session_start(); // start a new session or continues the previous
 
 // it will never let you open register(sign-up) page if session is set
 if ( isset($_SESSION['admin'])!="" ) {
  header("Location: home_admin.php");
  exit;
 } else if ( isset($_SESSION['user'])!="" ) {
  header("Location: home_user.php");
  exit;
 }

 include_once 'dbconnect.php';
 $error = 0;


 if ( isset($_POST['btn-signup']) ) {
  // sanitize user input to prevent sql injection
  $username = trim($_POST['username']);
  $username = strip_tags($username);
  $username = htmlspecialchars($username);
 
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
 
  $password = trim($_POST['password']);
  $password = strip_tags($password);
  $password = htmlspecialchars($password);

  $first_name = trim($_POST['first_name']);
  $first_name = strip_tags($first_name);
  $first_name = htmlspecialchars($first_name);

  $family_name = trim($_POST['family_name']);
  $family_name = strip_tags($family_name);
  $family_name = htmlspecialchars($family_name);

  $avatar = $_POST['avatar'];

  // basic username validation
  if (empty($username)) {
   $error = 1;
   $nameError = "Please enter your user name.";
  } else if (strlen($username) < 3) {
   $error = 1;
   $nameError = "Name must have atleat 3 characters.";
  } else {
   // check whether the username exist or not
   $query_username = "SELECT username FROM users WHERE users.username='$username'";
   $result_username = mysql_query($query_username);
   $count_username = mysql_num_rows($result_username);
   if($count_username!=0){
    $error = 1;
    $nameError = "Provided user name is already in use.";
   }
  }
  // echo " username: $error<br>";
 
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = 1;
   $emailError = "Please enter valid email address.";
  } else {
   // check whether the email exist or not
   $query_email = "SELECT email FROM users WHERE users.email='$email'";
   $result_email = mysql_query($query_email);
   $count_email = mysql_num_rows($result_email);
   if($count_email!=0){
    $error = 1;
    $emailError = "Provided Email is already in use.";
   }
  }
    // echo " email: $error<br>";

  // password validation
  if (empty($password)){
   $error = 1;
   $passError = "Please enter password.";
  } else if(strlen($password) < 6) {
   $error = 1;
   $passError = "Password must have atleast 6 characters.";
  }
      // echo " password: $error<br>";

 
  // password encrypt using SHA256();
  // not even the admin can see the password anymore
  $password = hash('sha256', $password);
  
  // firstname validation
  if (empty($first_name)){
   $error = 1;
   $firstnameError = "Please enter your first name.";
  }else if (!preg_match("/^[a-zA-Z ]+$/",$first_name)) {
   $error = 1;
   $firstnameError = "First name must contain alphabets and space.";
  }
      // echo " firstname: $error<br>";

  // family_name validation
  if (empty($family_name)){
   $error = 1;
   $familynameError = "Please enter your family name.";
  }else if (!preg_match("/^[a-zA-Z ]+$/",$family_name)) {
   $error = 1;
   $familynameError = "Family name must contain alphabets and space.";
  }
      // echo " familyname: $error<br>";

  // Avatar validation
  if (empty($avatar)){
   $error = 1;
   $avatarError = "Please choose an avatar.";
  }
        // echo " avatar: $error<br>";

  // if there's no error, continue to signup
  if( $error == 0 ) {
   // echo "no error";
   $query = "INSERT INTO users(username,email,password,first_name,family_name, FK_avatars) VALUES('$username','$email','$password','$first_name','$family_name', $avatar)";
   $res = mysql_query($query);
   
   if ($res) {
    $errTyp = "alert-success";
    $errMSG = "Successfully registered, you may login now";
    // echo $errMSG;
    unset($username);
    unset($email);
    unset($password);
    unset($first_name);
    unset($family_name);
    // unset($DOB);
   } else {
    $errTyp = "alert-danger";
    $errMSG = "Something went wrong, try again later...";
    // echo $errMSG;
   }
   
  } 
 
 
 }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign-up</title>
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
    <style>
      .avatar {
        width: 120px;
        height: 120px;
        margin: 4px;
      }

    </style>
</head>
<body>
    <div class="container">
    <header class="row shadow">
    <div class="col-xs-6">
      <span><img id="logo" src="pictures/logo.png" alt="logo"></span>
      <span><h1 class="brandfont">Code Library</h1></span>
    </div>
  </header>
      <div class="row">
      <div class="col-xs-12">
        <form method="post" action="register.php" autocomplete="off">
          <h2>Sign Up.</h2>
          <hr />
          <?php
            if ( isset($_POST['btn-signup']) ) {
              echo '<div class="alert">'.$errMSG.'</div>';
            }
          ?>
      </div>
      <!-- first_row -->
      <div class="col-xs-12 col-md-6">
        <!-- USERNAME -->
          <h4>User Name:</h4>
          <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" maxlength="50" value="<?php echo $name ?>" />
          <span class="text-danger"><?php echo $nameError; ?></span>
          <!-- EMAIL -->
          <h4>E-Mail:</h4>
          <input type="email" id="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
          <span class="text-danger"><?php echo $emailError; ?></span>
          <!-- PASSWORD -->
          <h4>Password:</h4>
          <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" maxlength="15" />
          <span class="text-danger"><?php echo $passError; ?></span>
      </div>
      <!-- second row -->
      <div class="col-xs-12 col-md-6">
          <!-- FIRSTNAME -->
          <h4>First name:</h4>
          <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter first name" />
          <span class="text-danger"><?php echo $firstnameError; ?></span>  
          <!-- FAMILYNAME -->
          <h4>Family name:</h4>
          <input type="text" id="family_name" name="family_name" class="form-control" placeholder="Enter family name" />
          <span class="text-danger"><?php echo $familynameError; ?></span> 

          
      </div>
      <div class="col-xs-12 text-center">
        <hr>
        <h4 class="">Pick an avatar:</h4>
        <hr>

        <?php
          $query_avatar = "SELECT * FROM avatars";
          $res_avatar = mysql_query($query_avatar);

          while($avatarRow=mysql_fetch_array($res_avatar)){
            $avatar = $avatarRow['avatar'];
            $avatar_id = $avatarRow['id'];

            echo    '<label class="radio-inline">
                      <input type="radio" value="'.$avatar_id.'" name="avatar"><img class="img-circle avatar" src="'.$avatar.'" alt="avatar">
                    </label>';
          }
        ?>
        <div class="text-center text-danger margin-top"><?php echo $avatarError; ?></div>  
      </div>
      <div class="col-xs-12">
        <!-- SUBMIT -->
          <hr />
          <button type="submit" id="btn-signup" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
      </div>
      <div class="col-xs-12">
          <hr />
          <a href="index.php">Sign in Here...</a>
        </form>
      </div>
      </div>
      <!-- footer -->
    <div class="row margin-top ">
        <div class="col-xs-12 text-center shadow panel panel-default">
          All rights reserved for Nati
        </div>
    </div>
    </div>
    <script type="text/javascript" src="js/register.js"></script>
</body>

</html>
<?php ob_end_flush(); ?>
