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
          #establish some variables so that they exist without a POST
          $schedule = [];
          $caretaker_name = '';

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

            $result = mysqli_query($link, $sql);
            $schedule = $result->fetch_assoc();

            #get the group number that the user is in
            $sql = "SELECT patient_group FROM patients_info WHERE user_id = '$id'";
            $result = mysqli_query($link, $sql);
            $row = $result->fetch_assoc();

            $group = $row['patient_group'];

            #get the appropriate caregiver from the roster if there is a roster
            $sql = "SELECT caretaker_1, caretaker_2, caretaker_3, caretaker_4
            FROM rosters
            WHERE day = $date";

            $result = mysqli_query($link, $sql);
            $row = $result->fetch_assoc();

            if ($group == 1) {
              $caretaker = $row['caretaker_1'];
            }
            elseif ($group == 2) {
              $caretaker = $row['caretaker_2'];
            }
            elseif ($group == 3) {
              $caretaker = $row['caretaker_3'];
            }
            elseif ($group == 4) {
              $caretaker = $row['caretaker_4'];
            }

            #get the caretaker's name
            $sql = "SELECT Fname, Lname
            FROM users
            WHERE id = $caretaker";

            $result = mysqli_query($link, $sql);
            $row = $result->fetch_assoc()

            $caretaker_name = $row['Fname'] . ' ' . $row['Lname'];

            mysqli_close();
          }

          echo "<td></td><td></td>" #placeholder

          echo "<td>'$caretaker_name'</td>"

          if ($schedule) {
            foreach ($schedule as $key => $value) {
              if ($value) echo "<td>&#10003;</td>";
              else echo "<td></td>";
            }
          }
          else {
            echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
          }
          ?>
        </tr>
      </table>
    </section>

  </body>
</html>
