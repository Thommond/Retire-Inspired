<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Family Home</title>
    <link rel="stylesheet" href="../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(6);
    ?>

    <form class="exit" action="familyMemberHome.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

    <?php

    if(isset($_POST['logout'])) {
      session_start();
      session_destroy();
      header('Location: http://localhost/Retire-Inspired/views/auth/login.php');
      }

     ?>

    <p>Welcome Home Family Member!</p>

  </body>
</html>
