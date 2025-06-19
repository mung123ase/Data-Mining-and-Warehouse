<?php
require('config.php');
session_start();
$errormsg = "";

if (isset($_POST['email'])) {
  $email = stripslashes($_REQUEST['email']);
  $email = mysqli_real_escape_string($con, $email);
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($con, $password);

  // Check if the email exists in the database
  $emailQuery = "SELECT * FROM `users` WHERE email='$email'";
  $emailResult = mysqli_query($con, $emailQuery) or die(mysqli_error($con));

  if (mysqli_num_rows($emailResult) > 0) {
    // Email exists, now check the password
    $query = "SELECT * FROM `users` WHERE email='$email' AND password='" . md5($password) . "'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));

    if (mysqli_num_rows($result) == 1) {
      $_SESSION['email'] = $email;
      header("Location: index.php");
    } else {
      $errormsg = "Incorrect password.";
    }
  } else {
    $errormsg = "User not registered. Please register first.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    .login-form {
      width: 340px;
      margin: 50px auto;
      font-size: 15px;
    }
    .login-form form {
      margin-bottom: 15px;
      background: #fff;
      box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
      padding: 30px;
      border: 1px solid #ddd;
    }
    .login-form h2 {
      color: #636363;
      margin: 0 0 15px;
      text-align: center;
    }
    .hint-text {
      color: #999;
      text-align: center;
      margin-bottom: 30px;
    }
    .error-message {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
    .form-control, .btn {
      min-height: 38px;
      border-radius: 2px;
    }
    .btn {
      font-size: 15px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="login-form">
    <form action="" method="POST" autocomplete="off">
      <h2 class="text-center">FinanceManager</h2>
      <p class="hint-text">Login Panel</p>
      <?php if ($errormsg) { echo "<p class='error-message'>$errormsg</p>"; } ?>
      <div class="form-group">
        <input type="text" name="email" class="form-control" placeholder="Email" required="required">
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Password" required="required">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-block">Login</button>
      </div>
      <div class="clearfix">
        <label class="float-left form-check-label"><input type="checkbox"> Remember me</label>
      </div>
    </form>
    <p class="text-center">Don't have an account?<a href="register.php" class="text-danger"> Register Here</a></p>
  </div>

  <script src="js/jquery.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
