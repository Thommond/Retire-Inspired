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

    <section class="schedule">

      <form class="manageSchedules" action="caregiverHome.php" method="post">

        <table>
          <tr>
            <th>Name</th>
            <th>Morning Medicine</th>
            <th>Afternoon Medicine</th>
            <th>Night Medicine</th>
            <th>Breakfast</th>
            <th>Lunch</th>
            <th>Dinner</th>
          </tr>
          <tr>

            <?php

            #use the submitted date or default to today
            if (isset($_POST['search'])) {
              $date = $_POST['date'];
            }
            else {
              $date = date('Y-m-d');
            }

            $id = $_SESSION['id'];

            $link = mysqli_connect("localhost", "root", "", "retire");

            if ($link == false) {
              die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            #Check which group the caregiver is assigned to
            $sql = "SELECT caretaker_1, caretaker_2, caretaker_3, caretaker_4
            FROM rosters
            WHERE day = CURRENT_DATE()";

            $result = mysqli_query($link, $sql);

            $row = [];

            if ($result) $row = $result->fetch_assoc();

            if ($row) {

              if (!in_array($id, $row)) {

                echo "<p>You have no assignment today!</p>";
              }
              else {

                if ($row['caretaker_1'] == $id) $group = 1;

                elseif ($row['caretaker_2'] == $id) $group = 2;

                elseif ($row['caretaker_3'] == $id) $group = 3;

                else $group = 4;

                #Get all of the patients in that group
                $sql = "SELECT user_id FROM patients_info
                WHERE patient_group = '$group'";

                $result = mysqli_query($link, $sql);

                $patient_list = [];

                if ($result) $patient_list = $result->fetch_assoc();

                #Display a row for each patient
                foreach ($patient_list as $key => $user_id) {

                  #Get and display the patient's name
                  $sql = "SELECT Fname, Lname FROM users
                  WHERE id = '$user_id'";

                  $result = mysqli_query($link, $sql);

                  $row = [];

                  if ($result) $row = $result->fetch_assoc();

                  if ($row) {
                    $patient_name = $row['Fname'] . ' ' . $row['Lname'];
                  }
                  else {
                    $patient_name = "Patient $user_id";
                  }

                  echo "<td>$patient_name</td>";

                  #Get and display the patient's schedule
                  $sql = "SELECT morning_med, afternoon_med, night_med, breakfast, lunch, dinner
                  FROM schedules
                  WHERE user_id = '$user_id'";

                  $result = mysqli_query($link, $sql);

                  $schedule = [];

                  if ($result) $schedule = $result-> fetch_assoc();

                  if ($schedule) {

                    foreach ($schedule as $key => $value) {

                      echo "<td>$value</td>";
                    }
                  }
                  else {

                    echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
                  }
                }
              }
            }
            else {
              echo "<p class='error'>There is no roster set for today.</p>";
            }

            mysqli_close($link);
            ?>
          </tr>
        </table>
      </form>
    </section>

  </body>
</html>
