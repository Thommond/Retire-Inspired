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

      <input type="text" name="cancel" value="Cancel">

    </form>

    <?php

    if (isset($_POST['Login'])) {



    }
    ?>

  </body>
</html>
