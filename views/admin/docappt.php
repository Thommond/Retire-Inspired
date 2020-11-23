<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Doctors Appointment</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>



    <?php
    // TODO: Add success messages to all needed places in project
    include ('../../common-functions.php');
    check_session(2);
    ?>

    <section>

      <?php
      if ($_SESSION['Role_id'] == 1) echo '<a href=' . "adminHome.php" . '>' . 'Back' . '</a>';
      if ($_SESSION['Role_id'] == 2) echo '<a href=' . "../home/supervisorHome.php" . '>' . 'Back' . '</a>';
      ?>


      <h1>Doctors Appointment</h1>

      <form  action="docappt.php" method="post">

        <label>Patient ID:
          <input type="text" name="patient_id">
        </label>

        <label>Date:
          <input type="date" name="day">
        </label>

        <input type="submit" name="submit" value="Submit">

      </form>

      <?php

      if(isset($_POST['submit'])) {

        $day = $_POST['day'];
        $patient = $_POST['patient_id'];

        $db_link = mysqli_connect("localhost", "root", "", "retire");

        if ($db_link == false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT Fname, Lname FROM users
                WHERE id LIKE '$patient'";

        if(mysqli_query($db_link, $sql)) {

          $result = mysqli_fetch_row(mysqli_query($db_link, $sql));

          if (empty($result)) {
            echo "<p class='error'>Couldn not get patient from database.<p>";
          }

          else {
            $patient_name =  $result[0] . ' ' . $result[1];
          }

        }

        else echo "<p class='error'>Could not get patient from database, check your values.</p>";

      }

       ?>



       <p>Note: Select date to get on duty doctor displayed below.</p>

       <?php
        if(isset($_POST['submit'])) {

          $id = 0 ;

          $sql = "SELECT id FROM rosters
                  WHERE day LIKE '$day'";

          if(mysqli_query($db_link, $sql)) {

            $result = mysqli_fetch_row(mysqli_query($db_link, $sql));

            if (empty($result)) {
              die("<p class='error'>There is no roster for selected date.</p>");
            }

            else {
              $id = $result[0];
            }

          }

          else echo "<p class='error'>Could not get patient from database, check your values.</p>";

          if ($id and $id != 0) {

             $sql = "SELECT Fname, Lname, id FROM users
                     WHERE id LIKE '$id'";

             echo "<form  action='docappt.php' method='post'>";
             echo "<label for='Doctor'>Doctor:";
             echo "<select  name='Doctor'>";

             if(mysqli_query($db_link, $sql)) {
                $result2 = mysqli_fetch_row(mysqli_query($db_link, $sql));
                echo "<option value=" . $result2[2] . " " . ">" . $result2[0] . ' ' . $result2[1] . "</option>";
             }

             else echo "<p class='error'>Could not get doctor from database, check your values.</p>";

           echo "</select>";
           echo "</label>";
           echo "<input type='text' name='patient' value=" .  $patient .  ">";
           echo "<input type='text' name='date' value=" . $day . ">";
           echo "<input type='text' name='doc' value=" . $id . ">";
           echo "<input type='submit' name='press' value='Submit'>";
           echo "</form>";


             echo "<label for='patients_name' class='display_only'>Patient Name:";
             echo "<p class='display_only' >" . $patient_name . "</p>";
             echo "</label>";
         }
      }

      if(isset($_POST['press'])) {

          $day = $_POST['day'];
          $patient = $_POST['patient'];
          $id = $_POST['doc'];

          $db_link = mysqli_connect("localhost", "root", "", "retire");

          if ($db_link == false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
          }

          $sql = "INSERT INTO appointments (patient_id, doctor_id, day)
                  VALUES ('$patient', '$id', '$day')";

          if(mysqli_query($db_link, $sql)) {
            echo "<p class='success'>Added appointment to the database successfully!</p>";
          }

          else echo "<p class='error'>Could not add appointment to database, check your values.</p>";
        }
       ?>

    </section>

  </body>
</html>
