<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Caregiver Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(4);
    ?>

    <form class="exit" action="caregiverHome.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

    <?php

    if(isset($_POST['logout'])) {
      session_start();
      session_destroy();
      header('Location: http://localhost/Retire-Inspired/views/auth/login.php');
      }

     ?>

    <section class='links'>

      <p>Welcome Home Caregiver!</p>

      <a href="../admin/roster.php">Look at todays Roster</a>

    </section>

  </body>
</html>
