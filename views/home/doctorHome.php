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
    ?>

    <form class="exit" action="doctorHome.php" method="post">
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

      <p>Welcome home <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']?>!</p>

      <a href="../admin/roster.php">Look at todays Roster</a>

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

        $day = 'day';
        $Last = 'Lname';
        $first = 'Fname';
        $com = 'Comment';
        $morn = 'morning_med';
        $aft = 'afternoon_med';
        $night = 'night_med';
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
          $column = $day;
        }
        else {

          if (!empty($Fname)) {
            $filter = $Fname . '%';
            $column = $first;
          }

          else {

              if (!empty($Lname)) {
                $filter = $Lname . '%';
                $column = $Last;
              }

              else {

                if (!empty($Comment)) {

                  $filter = $Comment . '%';
                  $column = $com;
                }

                else {

                  if (!empty($Mmed)) {

                    $filter = $Mmed . '%';
                    $column = $morn;

                  }

                  else {

                    if (!empty($Amed)) {

                      $filter = $Amed . '%';
                      $column = $aft;

                    }

                    else {

                      if (!empty($Nmed)) {

                        $filter = $Nmed . '%';
                        $column = $night;

                      }

                      else {

                        echo '<p class="error">You have no fields filled out. Please fill in one field.</p>';

                    }
                  }
                }
              }
            }
          }
        }

        // TODO: Make sure to get only unique prescriptions may require adding day to
        // prescriptions table.
         $sql = "SELECT  a.day, p.morning_med, p.afternoon_med, p.night_med,
                p.comment, u.Fname, u.Lname
                FROM appointments as a JOIN prescriptions as p on (a.patient_id = p.patient_id)
                JOIN users as u ON (a.patient_id=u.id)
                WHERE doctor_id LIKE $id AND $column LIKE '$filter' AND day < '2020-11-19%'";

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
         echo '</tr>';

         if ($result->fetch_assoc()) {

            // Every result row displayed in table if there is any
           while ($row = $result->fetch_assoc()) {
             // TODO: Create patient_of_doctor.php linked by patient_id only accessble by proper doctor.
             // TODO: Next to each patients name add link to patient_of_doctor.php
             echo '<tr>';
             echo '<td>' . $row['day'] . '</td>';
             echo '<td>' . $row['Fname'] . '</td>';
             echo '<td>' . $row['Lname'] . '</td>';
             echo '<td>' . $row['comment'] . '</td>';
             echo '<td>' . $row['morning_med'] . '</td>';
             echo '<td>' . $row['afternoon_med'] . '</td>';
             echo '<td>' . $row['night_med'] . '</td>';
             echo '</tr>';

           }
           echo '</tbody>';
           echo '</table>';

         }

         else {
           die("<p class='error'>The field you entered has no results</p>");
         }
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
         echo '</tr>';


           // Get all rows if result not empty
           while($row = $result->fetch_assoc()) {
             echo '<tr>';
             echo "<td>" .  $row['Fname'] .  ' ' . $row['Lname'] . "</td>";
             echo "<td>" . $row['day'] . "</td>";
             echo '</tr>';
           }

           echo '</tbody>';
           echo '</table>';

         }
        }
       mysqli_close($db_link);
       ?>

    </section>

  </body>
</html>
