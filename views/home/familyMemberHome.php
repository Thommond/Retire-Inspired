<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Family Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(6);

    include ('../nav.php');
    ?>


    <section class='links'>

      <p>Welcome Home Family Member!</p>

      <a href="../admin/roster.php">Look at todays Roster</a>

    </section>

    <section class="schedule">

      <form class="family" action="familyMemberHome.php" method="post">

        <label>Family Code:
          <input type="text" name="code" required value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['code']; ?>">
        </label>

        <label>Patient ID:
          <input type="number" name="id" required value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['id']; ?>">
        </label>

        <label>Date:
          <input type="date" name="date" required value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['date']; else echo date('Y-m-d'); ?>">
        </label>

        <input type="submit" name="search" value="Load Schedule">

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
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            #establish some variables so they exist if the database connection fails
            $schedule = [];
            $caretaker_name = '';
            $doctor_name = '';
            $appointment = false;

            #Retrieve necessary variables from the form
            $date = $_POST['date'];
            $code = $_POST['code'];
            $id = $_POST['id'];

            $link = mysqli_connect("localhost", "root", "", "retire");

            if ($link == false) {
              die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            #Verify that the family code and id are correct
            $sql = "SELECT Fname, Lname FROM users
            WHERE id = '$id'";

            $result = mysqli_query($link, $sql);
            if ($result) $row = $result->fetch_assoc();

            if (!$row) {
              die("Incorrect family code or ID.");
            }

            $patient_name = $row['Fname'] . ' ' . $row['Lname'];

            $sql = "SELECT family_code FROM patients_info
            WHERE user_id = '$id'";

            $result = mysqli_query($link, $sql);
            if ($result) $row = $result->fetch_assoc();

            if (!$row) {
              die("<p class='error'>Incorrect family code or ID.</p>");
            }
            if ($row['family_code'] != $code) {
              die("<p class='error'>Incorrect family code or ID</p>");
            }

            echo "<h2>$patient_name's Schedule</h2>";

            #get today's schedule
            $sql = "SELECT morning_med, afternoon_med, night_med, breakfast, lunch, dinner
            FROM schedules
            WHERE user_id = '$id' AND day = '$date'";

            $result = mysqli_query($link, $sql);
            if ($result) $schedule = $result->fetch_assoc();

            #get the group number that the user is in
            $sql = "SELECT patient_group FROM patients_info WHERE user_id = '$id'";
            $result = mysqli_query($link, $sql);
            if ($result) {
              $row = $result->fetch_assoc();

              $group = $row['patient_group'];

              #get the appropriate caregiver from the roster if there is a roster
              $sql = "SELECT doctor, caretaker_1, caretaker_2, caretaker_3, caretaker_4
              FROM rosters
              WHERE day = '$date'";

              $result = mysqli_query($link, $sql);

              if ($result) {

                $row = $result->fetch_assoc();

                if($row) {

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

                  #save the doctor id for later
                  $doctor = $row['doctor'];

                  #get the caretaker's name
                  $sql = "SELECT Fname, Lname
                  FROM users
                  WHERE id = $caretaker";

                  $result = mysqli_query($link, $sql);
                  if ($result) {

                    $row = $result->fetch_assoc();

                    if ($row) $caretaker_name = $row['Fname'] . ' ' . $row['Lname'];
                  }
                  else {
                    echo "ERROR: Unable to establish connection to database";
                  }

                  #get the doctor's name using the id from earlier
                  $sql = "SELECT Fname, Lname
                  FROM users
                  WHERE id = $doctor";

                  $result = mysqli_query($link, $sql);
                  if ($result) {

                    $row = $result->fetch_assoc();

                    if ($row) $doctor_name = $row['Fname'] . ' ' . $row['Lname'];
                  }
                  else {
                    echo "ERROR: Unable to establish connection to database";
                  }
                }
              }
              else {
                echo "ERROR: Unable to establish connection to database";
              }
            }
            else {
              echo "ERROR: Unable to establish connection to database";
            }

            #check if there is an appointment today
            $sql = "SELECT * FROM appointments
            WHERE day = '$date' AND patient_id = '$id'";

            $result = mysqli_query($link, $sql);
            if ($result->fetch_assoc()) $appointment = true;

            mysqli_close($link);

            echo "<td>$doctor_name</td>";

            #if there is an appointment put a checkmark in the field
            if ($appointment) echo "<td class='check'>&#10003;</td>";
            else echo "<td></td>";

            echo "<td>$caretaker_name</td>";

            #if there is a schedule check each value and put a checkmark for every true
            if ($schedule) {
              foreach ($schedule as $key => $value) {
                if ($value) echo "<td class='check'>&#10003;</td>";
                else echo "<td></td>";
              }
            }
            else {
              echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
            }
          }
          ?>
        </tr>
      </table>
    </section>

  </body>
</html>
