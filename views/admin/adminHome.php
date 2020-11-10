<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <!-- <?php
    // session_start();
    //
    // if (isset($_SESSION)){
    //
    //   if($_SESSION['id'])
    //   header('Location: http://localhost/Retire-Inspired/views/errors/forbidden.php ');
    // }
    ?> -->


    <form class="exit" action="adminHome.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

    <?php
    session_start();
    print_r($_SESSION);

    if(isset($_POST['logout'])) {
      session_start();
      session_destroy();
      header('Location: http://localhost/Retire-Inspired/views/auth/login.php');
      }

     ?>

    <section class='links'>

      <h1>Welcome Home Admin!</h1>

      <a href="createRoles.php">Create Roles</a>

    </section>

  </body>
</html>
