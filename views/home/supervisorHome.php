<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Supervisors Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(2);
    ?>

    <form class="exit" action="supervisorHome.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

    <section class='links'>

      <p>Welcome Home Supervisor!</p>

      <a href="../admin/approve.php">Approve Registrations</a>

    </section>




  </body>
</html>
