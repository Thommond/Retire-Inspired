<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Patient Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(5);
    ?>

    <form class="exit" action="patientHome.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

    <?php

    if(isset($_POST['logout'])) {
      session_start();
      session_destroy();
      header('Location: http://localhost/Retire-Inspired/views/auth/login.php');
      }

     ?>

    <p>Welcome Home Patient!</p>

    <?php
    echo "<p>Patient Name: " . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "</p>";
    echo "<p>Patient ID: " . $_SESSION['id'] . "</p>";
    ?>

    <section class="schedule">
      <form class="date" action="patientHome.php" method="post">

        <label>Date:
          <input type="date" name="date" value="<?php echo date('Y-m-d') ?>">
        </label>

        <input type="submit" name="search" value="Load Date">

      </form>

      <table>
        <tr>
          <th>Doctor</th>
          <th>Appointment</th>
          <th>Caregiver</th>
          <th>Morning Medicine</th>
          <th>Afternoon Medicine</th>
          <th>Night Medicine</th>
          <th>Breakfast</th>
          <th>Lunch</th>
          <th>Dinner</th>
        </tr>
        <tr>

          <?php
          $schedule = [];

          if (isset($_POST['search'])) {
            $id = $_SESSION['id'];
            $date = $_POST['date'];

            $link = mysqli_connect("localhost", "root", "", "retire");

            if ($link == false) {
              die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            $sql = "SELECT morning_med, afternoon_med, night_med, breakfast, lunch, dinner
            FROM schedules
            WHERE user_id = '$id' AND day = '$date'";

            $schedule = mysqli_query($link, $sql);

            mysqli_close();
          }

          if ($schedule) {
            echo "<td></td><td></td><td></td>"; #placeholder
            foreach ($schedule as $key => $value) {
              if ($value) echo "<td>&#10003;</td>";
              else echo "<td></td>";
            }
          }
          else {
            echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
          }
          ?>
        </tr>
      </table>
    </section>

  </body>
</html>
