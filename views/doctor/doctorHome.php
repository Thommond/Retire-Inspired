<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Doctors Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(3);

    include ('../nav.php');
    ?>


    <section class='links'>

      <p>Welcome home <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']?>!</p>

      <a href="../admin/roster.php">Look at todays Roster</a>

      <a href="../patients.php">Look at List of Patients</a>

    </section>


    <section>
      <p>If you would like to filter the results fill in a field only one field at a time.</p>

      <form  action="doctorHome.php" method="post">

        <label>Date:
          <input type="text" name="date">
        </label>

        <label>First Name:
          <input type="text" name="Fname">
        </label>

        <label>Last Name:
          <input type="text" name="Lname">
        </label>

        <label>Comment:
          <input type="text" name="Comment">
        </label>

        <label>Morning Medication:
          <input type="text" name="mmed">
        </label>

        <label>Afternoon Medication
          <input type="text" name="amed">
        </label>

        <label>Night Medication
          <input type="text" name="nmed">
        </label>

        <input type="submit" name="Submit" value="Submit">

      </form>

      <?php

      if (isset($_POST['Submit'])) {

        // Getting post requests and naming column names
        $date = $_POST['date'];
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];
        $Comment = $_POST['Comment'];
        $Mmed = $_POST['mmed'];
        $Amed = $_POST['amed'];
        $Nmed = $_POST['nmed'];
        $day = date('Y-m-d');
        $filter = '';
        $column = '';

        $id = intval($_SESSION['id']);

        $db_link = mysqli_connect("localhost", "root", "", "retire");

        if ($db_link == false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        // Check only one field can be filled
        // then setting proper variables.
        if (!empty($date)) {
            $filter = $date . '%';
            $column = 'day';
        }
        else if (!empty($Fname)) {

            $filter = $Fname . '%';
            $column = 'Fname';
        }
        else if (!empty($Lname)){

            $filter = $Lname . '%';
            $column = 'Lname';
        }
        else if (!empty($Comment)) {

            $filter = $Comment . '%';
            $column = 'Comment';
        }
        else if (!empty($Mmed)) {

            $filter = $Mmed . '%';
            $column = 'morning_med';
        }
        else if (!empty($Amed)) {

          $filter = $Amed . '%';
          $column = 'afternoon_med';
        }
        else if (!empty($Nmed)) {

          $filter = $Nmed . '%';
          $column = 'night_med';
        }
        else {

          echo '<p class="error">You have no fields filled out. Please fill in one field.</p>';
        }

         $sql = "SELECT  a.day, p.morning_med, p.afternoon_med, p.night_med,
                p.comment, u.Fname, u.Lname, a.patient_id
                FROM appointments as a JOIN prescriptions as p on (a.patient_id = p.patient_id) AND (a.day = p.appt_day)
                JOIN users as u ON (a.patient_id=u.id)
                WHERE doctor_id LIKE $id AND $column LIKE '$filter' AND day < '$day'";


         $result = mysqli_query($db_link, $sql);

         if (empty($result)) {
           die("<p class='error'>The field you entered has no results</p>");
         }

         else {

           // If result is not empty then display table
           echo '<table>';
           echo '<tbody>';
           echo '<tr>';
           echo '<th>Date</th>';
           echo '<th>First Name</th>';
           echo '<th>Last Name</th>';
           echo '<th>Comment</th>';
           echo '<th>Morning Med</th>';
           echo '<th>Afternoon Med</th>';
           echo '<th>Night Med</th>';
           echo '<th>Patient Page</th>';
           echo '</tr>';


           // Every result row displayed in table if there is any
           while ($row = $result->fetch_assoc()) {

             if (empty($row)) {
               die("<p class='error'>The field you entered has no results</p>");
             }

             // TODO: Link up the patient pages
             echo '<tr>';
             echo '<td>' . $row['day'] . '</td>';
             echo '<td>' . $row['Fname'] . '</td>';
             echo '<td>' . $row['Lname'] . '</td>';
             echo '<td>' . $row['comment'] . '</td>';
             echo '<td>' . $row['morning_med'] . '</td>';
             echo '<td>' . $row['afternoon_med'] . '</td>';
             echo '<td>' . $row['night_med'] . '</td>';
             echo '<td>' . "<a class='table_link' href='http://localhost/Retire-Inspired/views/doctor/patientOfDoctor.php?patient_id_num=" . $row['patient_id'] . "' >Patient Page</a> " . '</td>';
             echo '</tr>';

          }

          echo '</tbody>';
          echo '</table>';

        }

      }
       ?>

    </section>

    <section>

      <form class="" action="doctorHome.php" method="post">

        <label>Appointments:
          <input type="date" name="till_date">
        </label>

        <input type="submit" name="press" value="Submit">

      </form>


      <?php
      if (isset($_POST['press'])) {

        $date = $_POST['till_date'];
        $today = date('Y-m-d');
        $id = intval($_SESSION['id']);

        $db_link = mysqli_connect("localhost", "root", "", "retire");

        if ($db_link == false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        // Get from database
        $sql = "SELECT  a.day, u.Fname, u.Lname
               FROM appointments as a JOIN users as u on (a.patient_id = u.id)
               WHERE doctor_id LIKE $id AND day BETWEEN '$today%' AND '$date%'";

       $result = mysqli_query($db_link, $sql);

       if (empty($result)) die("<p class='error'>The field you entered has no results.</p>");
       else {

         echo '<table>';
         echo '<tbody>';
         echo '<tr>';
         echo '<th>Name</th>';
         echo '<th>Date</th>';
         echo '<th>Patient Page</th>';
         echo '</tr>';


         // Get all rows if result not empty
         while($row = $result->fetch_assoc()) {
           echo '<tr>';
           echo "<td>" .  $row['Fname'] .  ' ' . $row['Lname'] . "</td>";
           echo "<td>" . $row['day'] . "</td>";
           echo '<td>' . "<a class='table_link' href='#'>Patient Page</a>" . '</td>';
           echo '</tr>';
         }

         echo '</tbody>';
         echo '</table>';

       }
         mysqli_close($db_link);
      }

    ?>

    </section>


  </body>
</html>
