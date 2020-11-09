<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    if ($_SESSION['email'] != $email OR $_SESSION['pass'] != $password) {
      header()
    }
    ?>


    <form class="exit" action="adminHome.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

    <?php

    if(isset($_POST['logout'])) {
      session_write_close();
      header('Location: http://localhost/Retire-Inspired/views/auth/login.php');
      }

     ?>

    <section class='links'>

      <h1>Welcome Home Admin!</h1>

      <a href="createRoles.php">Create Roles</a>

    </section>

  </body>
</html>
