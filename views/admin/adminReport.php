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

      // Back buttons
      if ($_SESSION['Role_id'] == 1) echo '<a href=' . "adminHome.php" . '>' . 'Back' . '</a>';
      if ($_SESSION['Role_id'] == 2) echo '<a href=' . "../home/supervisorHome.php" . '>' . 'Back' . '</a>';
      ?>

      <p>Enter a date then missed activity for patients on that date.</p>

      <form class="" action="adminReport.php" method="post">

        <label>Date:
          <input type="text" name="activity">
        </label>

        <input type="submit" name="Submit" value="Submit">

      </form>

      <h3>Missed Activity</h3>

      <?php

        if (isset($_POST['Submit'])) {

          if (empty($_POST['activity'])) $date = $day;
          else $date = $_POST['activity'];

          $db_link = mysqli_connect("localhost", "root", "", "retire");

          if ($db_link == false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
          }

          // This sql gets user info and checks if date is an appointment day

          // Gets caregiver info and checks schedules


        }

       ?>


    </section>

  </body>

</html>
