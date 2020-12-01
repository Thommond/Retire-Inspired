<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Patient Of Doctor</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <section>
    <?php
    include ('../../common-functions.php');
    check_session(3);
    echo '<a href=' . "doctorHome.php" . '>' . 'Back' . '</a>';

    $patient = $_GET['patient_id_num'];

    $id = intval($_SESSION['id']);
    $day = date('Y-m-d');

    $db_link = mysqli_connect("localhost", "root", "", "retire");

    if ($db_link == false) {
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $sql = "SELECT Fname, Lname FROM users WHERE id LIKE $patient";


    $result = mysqli_fetch_row(mysqli_query($db_link, $sql));


    if (!empty($result[0]) AND !empty($result[1])) {

      echo '<h2>' . 'Patient Of Doctor for ' . $result[0] . ' ' . $result[1] . '</h2>';

    }

    else {
      die('Error could not get desired patient info:' . mysqli_connect_error());
    }

    $sql = "SELECT  a.day, p.morning_med, p.afternoon_med, p.night_med, p.comment
           FROM appointments as a JOIN prescriptions as p on (a.patient_id = p.patient_id) AND (a.day = p.appt_day)
           JOIN users as u ON (a.patient_id=u.id)
           WHERE doctor_id LIKE $id AND a.patient_id LIKE '$patient'";


           $result = mysqli_query($db_link, $sql);

           if (empty($result)) {
             die("<p class='error'>Patient info has no results</p>");
           }

           else {

             echo "<h3>Previous Appointments</h3>";

             // If result is not empty then display table
             echo '<table>';
             echo '<tbody>';
             echo '<tr>';
             echo '<th>Date</th>';
             echo '<th>Comment</th>';
             echo '<th>Morning Med</th>';
             echo '<th>Afternoon Med</th>';
             echo '<th>Night Med</th>';
             echo '</tr>';


             // Every result row displayed in table if there is any
             while ($row = $result->fetch_assoc()) {

               if (empty($row)) {
                 die("<p class='error'>Patient info has no results</p>");
               }

               // TODO: Link up the patient pages
               echo '<tr>';
               echo '<td>' . $row['day'] . '</td>';
               echo '<td>' . $row['comment'] . '</td>';
               echo '<td>' . $row['morning_med'] . '</td>';
               echo '<td>' . $row['afternoon_med'] . '</td>';
               echo '<td>' . $row['night_med'] . '</td>';
               echo '</tr>';

            }

            echo '</tbody>';
            echo '</table>';

          }

        $sql = "SELECT patient_id, day
                FROM appointments
                WHERE patient_id LIKE '$patient' AND day LIKE '$day%'";


        $result = mysqli_fetch_row(mysqli_query($db_link, $sql));

        if (!empty($result)) {

        echo "<h3>New Prescription</h3>";

        echo '<form action="patientOfDoctor.php" method="post">';

        echo '<label>Comment:';
        echo '<input type="text" name="comment">';
        echo '</label>';

        echo '<label>Morning Medication:';
        echo '<input type="text" name="morning">';
        echo '</label>';

        echo '<label>Afternoon Medication:';
        echo '<input type="text" name="afternoon">';
        echo '</label>';

        echo '<label>Night Medication:';
        echo '<input type="text" name="night">';
        echo '</label>';

        echo '<input type="submit" name="submit" value="Submit">';

        echo '</form>';

        if (isset($_POST['submit'])) {

          $day = date('Y-m-d');
          $Comment = $_POST['comment'];
          $Mmed = $_POST['morning'];
          $Amed = $_POST['afternoon'];
          $Nmed = $_POST['night'];

          $sql = "INSERT INTO prescriptions (appt_day, patient_id, comment, morning_med, afternoon_med, night_med)
                  VALUES ('$day', $patient, '$Comment', '$Mmed', '$Amed', '$Nmed')";


          if (mysqli_query($db_link, $sql)) echo "<p class='success'>Prescription added successfully!</p>";

          else echo "<p class='error'>Could not add roster check values!</p> " . mysqli_error($db_link);

        }

      }

      else {
        echo"<h4>Today is not an appointment day for this patient, so no new prescriptions will be created.</h4>";
      }

     ?>

  </section>



  </body>
</html>
