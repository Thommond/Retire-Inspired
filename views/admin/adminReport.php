<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>New Roster</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>

  <body>

    <section>

      <h2>Admin Report</h2>
      
      <?php
      include ('../../common-functions.php');
      check_session(2);
      $day = date('Y-m-d');
      if ($_SESSION['Role_id'] == 1) echo '<a href=' . "adminHome.php" . '>' . 'Back' . '</a>';
      if ($_SESSION['Role_id'] == 2) echo '<a href=' . "../home/supervisorHome.php" . '>' . 'Back' . '</a>';
      ?>

      <label>Date:
        <h4><?php echo $day ?></h4>
      </label>

      <h3>Missed Activity</h3>



    </section>

  </body>

</html>
