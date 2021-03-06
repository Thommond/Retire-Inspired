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

    include ('../nav.php');
    ?>

    <section class='links'>

      <p>Welcome Home Caregiver!</p>

      <a href="../admin/roster.php">Look at todays Roster</a>

      <a href="../patients.php">Look at List of Patients</a>

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

          <?php

            $id = $_SESSION['id'];
            $group = 0;
            $error = false; #This is just for the update/insertion success message, not all errors

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
                $error = true;
              }
              else {

                if ($row['caretaker_1'] == $id) $group = 1;

                elseif ($row['caretaker_2'] == $id) $group = 2;

                elseif ($row['caretaker_3'] == $id) $group = 3;

                else $group = 4;
              }
            }
            else {
              echo "<p class='error'>There is no roster set for today.</p>";
              $error = true;
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

              $link = mysqli_connect("localhost", "root", "", "retire");

              if ($link == false) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
              }

              #Get list of caregiver's patients
              $sql = "SELECT user_id FROM patients_info
                      WHERE patient_group = '$group'";

              $patients_result = mysqli_query($link, $sql);

              $row = [];
              if ($patients_result) {

                #Loop through each patient
                while($row = $patients_result->fetch_assoc()){

                  $patient_id = $row['user_id'];

                  $m_med = 0;
                  $a_med = 0;
                  $n_med = 0;
                  $breakfast = 0;
                  $lunch = 0;
                  $dinner = 0;

                  #Check every field for the given patient
                  if (isset($_POST[$patient_id . 'morning_med'])) {
                    if ($_POST[$patient_id . 'morning_med'] == 'on') {
                      $m_med = 1;
                    }
                  }
                  if (isset($_POST[$patient_id . 'afternoon_med'])) {
                    if ($_POST[$patient_id . 'afternoon_med'] == 'on') {
                      $a_med = 1;
                    }
                  }
                  if (isset($_POST[$patient_id . 'night_med'])) {
                    if ($_POST[$patient_id . 'night_med'] == 'on') {
                      $n_med = 1;
                    }
                  }
                  if (isset($_POST[$patient_id . 'breakfast'])) {
                    if ($_POST[$patient_id . 'breakfast'] == 'on') {
                      $breakfast = 1;
                    }
                  }
                  if (isset($_POST[$patient_id . 'lunch'])) {
                    if ($_POST[$patient_id . 'lunch'] == 'on') {
                      $lunch = 1;
                    }
                  }
                  if (isset($_POST[$patient_id . 'dinner'])) {
                    if ($_POST[$patient_id . 'dinner'] == 'on') {
                      $dinner = 1;
                    }
                  }

                  #Check if the patient has a schedule for today


                  $sql = "SELECT * FROM schedules
                          WHERE user_id = '$patient_id' AND day = CURRENT_DATE() ";

                  $result = mysqli_query($link, $sql);

                  if ($result) {

                    $row = $result->fetch_assoc();

                    if ($row) {

                      #If they have a schedule, update it with new information
                      $sql = "UPDATE schedules
                              SET morning_med = '$m_med',
                                  afternoon_med = '$a_med',
                                  night_med = '$n_med',
                                  breakfast = '$breakfast',
                                  lunch = '$lunch',
                                  dinner = '$dinner'
                              WHERE user_id = '$patient_id' AND day = CURRENT_DATE()";

                      $result = mysqli_query($link, $sql);

                      if (!$result) {
                        echo "ERROR: Update failed: " . mysqli_error($link);
                        $error = true;
                      }
                    }
                    else {

                      #If they do not have a schedule, create one for today
                      $sql = "INSERT INTO schedules (user_id, morning_med, afternoon_med, night_med, day, breakfast, lunch, dinner)
                              VALUES ($patient_id, '$m_med', '$a_med', '$n_med', CURRENT_DATE(), '$breakfast', '$lunch', '$dinner')";

                      $result = mysqli_query($link, $sql);

                      if (!$result) {
                        echo "ERROR: Insertion failed: " . mysqli_error($link);
                        $error = true;
                      }
                    }
                  }
                  else {
                    echo "ERROR: Unable to establish connection to database";
                  }

                }
              }
              if (!$error) {
                echo "<p class='success'>Schedule updated successfully!</p>";
              }
            }
            #END OF POST REQUEST SECTION


            #Get all of the patients in the caretaker's group
            $sql = "SELECT user_id FROM patients_info
                    WHERE patient_group = '$group'";

            $patient_list = mysqli_query($link, $sql);

            $patient = [];

            if ($result) {
            #Display a row for each patient
              while ($patient = $patient_list->fetch_assoc()) {

                $user_id = $patient['user_id'];

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

                echo "<tr>";
                echo "<td>$patient_name</td>";

                #Get and display the patient's schedule
                $sql = "SELECT morning_med, afternoon_med, night_med, breakfast, lunch, dinner
                        FROM schedules
                        WHERE user_id = '$user_id' AND day = CURRENT_DATE()";

                $result = mysqli_query($link, $sql);

                $schedule = [];

                if ($result) $schedule = $result-> fetch_assoc();

                if ($schedule) {

                  foreach ($schedule as $activity => $value) {

                    $name = $user_id . $activity;

                    #Each data in the table will be a checkbox
                    if ($value) {
                      echo "<td class='check'><input name=$name type='checkbox' checked></td>";
                    }
                    else {
                      echo "<td class='check'><input name=$name type='checkbox'></td>";
                    }
                  }
                }
                else {

                  $activities = ['morning_med', 'afternoon_med', 'night_med', 'breakfast', 'lunch', 'dinner'];

                  #Display the checkboxes even if the patient's schedule does not yet exist
                  foreach ($activities as $k => $activity) {

                    $name = $user_id . $activity;

                    echo "<td class='check'><input name=$name type='checkbox'></td>";
                  }
                }
                echo "</td>";
              }
            }

            mysqli_close($link);
            ?>
          </tr>
        </table>

        <input type="submit" name="submit" value="Save Changes">

      </form>

    </section>
  </body>
</html>
