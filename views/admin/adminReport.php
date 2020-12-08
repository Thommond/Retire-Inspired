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

      // Checking if there is a roster for today.
      $db_link = mysqli_connect("localhost", "root", "", "retire");

      if ($db_link == false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
      }

      $sql = "SELECT * FROM rosters
              WHERE day LIKE '$day'";

      $result = mysqli_fetch_row(mysqli_query($db_link, $sql));

      if (!$result) {
        die("ERROR: no roster for today make roster before checking missed activity for the day.");
      }

      mysqli_close($db_link);

      ?>

      <p>Enter a date then missed activity for patients on that date.</p>

      <form class="" action="adminReport.php" method="post">

        <label>Date:
          <input type="date" name="activity">
        </label>

        <input type="submit" name="submit" value="Submit">

      </form>

      <h3>Missed Activity</h3>

      <table>
        <tr>
          <th>Patient Name</th>
          <th>Doctor Name</th>
          <th>Appt?</th>
          <th>Care Giver Name</th>
          <th>Morning Medicine</th>
          <th>Afternoon Medicine</th>
          <th>Night Medicine</th>
          <th>Breakfast</th>
          <th>Lunch</th>
          <th>Dinner</th>
        </tr>

            <?php

              if (isset($_POST['submit'])) {

                if (!empty($_POST['activity']))  $day = $_POST['activity'];

                $db_link = mysqli_connect("localhost", "root", "", "retire");

                if ($db_link == false) {
                  die("ERROR: Could not connect. " . mysqli_connect_error());
                }

                // This sql gets user info and checks if date is an appointment day
                $sql = "SELECT DISTINCT u.id, u.Lname, u.Fname, p.patient_group, s.morning_med,
                        s.afternoon_med, s.night_med, s.breakfast,
                        s.lunch, s.dinner
                        FROM users as u
                        JOIN patients_info as p ON (u.id=p.user_id)
                        JOIN schedules as s ON (u.id=s.user_id)
                        JOIN appointments as a ON (u.id=a.patient_id)
                        WHERE 0 IN (morning_med, afternoon_med, night_med,
                                    breakfast, lunch, dinner) AND
                                    s.day = '$day'
                        ORDER BY u.id, u.Lname, u.Fname ASC";

                $result = mysqli_query($db_link, $sql);

                if(!$result) {
                  echo "<p>There is no results or missed activity so far today.</p>";
                }

                while ($row = $result->fetch_assoc()) {

                    $patient_id = $row['id'];
                    $patient_name = $row['Fname'] . ' ' . $row['Lname'];
                    $patient_group = $row['patient_group'];

                    echo '<tr>';
                    echo "<td>$patient_name</td>";

                    // Checks appt_day see if today
                    $sql_2 = "SELECT day FROM appointments
                            WHERE patient_id = '$patient_id' AND day = '$day%'";

                    $appt_result = mysqli_fetch_row(mysqli_query($db_link, $sql_2));

                    if (!$appt_result[0]) {
                      echo "<td>No doc</td>";
                      echo "<td></td>";
                    }

                    else {

                      // Add doctor and appt status
                      $doctor_name = '';

                      $sql_3 = "SELECT Fname, Lname FROM users as u
                              JOIN rosters as r ON (u.id=r.doctor)
                              WHERE day = '$day%'";

                      $doc_result = mysqli_fetch_row(mysqli_query($db_link, $sql_3));

                      $doctor_name = $doc_result[0] . ' ' . $doc_result[1];

                      echo "<td>$doctor_name</td>";
                      echo "<td>&#10003;</td>";
                    }

                    // Get group and match caregiver

                    $group = 0;

                    if ($patient_group == 1) $group = 'r.caretaker_1';
                    elseif ($patient_group == 2) $group = 'r.caretaker_2';
                    elseif ($patient_group == 3) $group = 'r.caretaker_3';
                    else $group = 'r.caretaker_4';

                    # Get all patients care_giver_name via patient_group
                    $sql_4 = "SELECT Fname, Lname FROM users as u
                            JOIN rosters as r ON (u.id = $group)
                            WHERE r.day = '$day%'";

                    $row_2 = mysqli_fetch_row(mysqli_query($db_link, $sql_4));

                    if ($row_2) $care_name = $row_2[0] . ' ' . $row_2[1];
                    else $care_name = "Unknown";

                    echo "<td>$care_name</td>";

                    // Get schedule and match to user
                    $sql_5 = "SELECT morning_med, afternoon_med, night_med, breakfast,
                            lunch, dinner FROM schedules
                            WHERE user_id = '$patient_id' AND day LIKE '$day%'
                            AND 0 IN (morning_med, afternoon_med, night_med,
                            breakfast, lunch, dinner)";

                    $row_3 = mysqli_fetch_row(mysqli_query($db_link, $sql_5));

                    // Checking if user should see check or no check for each field
                    if ($row_3[0] == 1)  echo "<td class='check'>&#10003;</td>";
                    else echo "<td></td>";
                    if ($row_3[1] == 1)  echo "<td class='check'>&#10003;</td>";
                    else echo "<td></td>";
                    if ($row_3[2] == 1)  echo "<td class='check'>&#10003;</td>";
                    else echo "<td></td>";
                    if ($row_3[3] == 1)  echo "<td class='check'>&#10003;</td>";
                    else echo "<td></td>";
                    if ($row_3[4] == 1)  echo "<td class='check'>&#10003;</td>";
                    else echo "<td></td>";
                    if ($row_3[5] == 1)  echo "<td class='check'>&#10003;</td>";
                    else echo "<td></td>";

              }

              echo "</tr>";
            }

            mysqli_close($db_link);

             ?>
          </table>



    </section>

  </body>

</html>
