<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="static/style.css">

  </head>

  <body>

    <h1>Login</h1>

    <form class="" action="login.php" method="post">

      <input type="text" name="email" >

      <input type="text" name="pass" >

      <input type="submit" name="Login" value="Login">

      <input type="submit" name="cancel" value="Cancel">

    </form>

    <p>Need to create an account? <a href="http://localhost:8080/Retire-Inspired/views/register.php">Register here</a>.</p>

    <?php

    if (isset($_POST['Login'])) {

      $email = $_POST['email'];
      $password = $_POST['pass'];

      // TODO: Change password of database for security
      $db_link = mysqli_connect("localhost", "root", '', "retire");

      if ($db_link == false) {

        die("ERROR: Could not login must be incorrect email or passowrd" . mysqli_connect_error());
      }

      $sql = "SELECT email, password
              FROM users
              WHERE email = '$email' AND password = '$password' ";

      if (mysqli_query($db_link, $sql)) header('Location: http://localhost/Retire-Inspired/views/home.html');
      else echo "ERROR: Could exectute" . mysqli_error($db_link);

      mysqli_close($db_link);


    }
    ?>

  </body>
</html>
