<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(1);
    ?>


    <form class="exit" action="adminHome.php" method="post">
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

      <h1>Welcome Home Admin!</h1>

      <a href="createRoles.php">Create Roles</a>

      <a href="approve.php">Approve Registrations</a>

      <a href="newRoster.php">Create a Roster</a>

      <a href="roster.php">Look at todays Roster</a>

    </section>

  </body>
</html>
