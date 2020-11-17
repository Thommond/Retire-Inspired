<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Doctors Appointment</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
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

        <label for="patient_id">Patient ID:
        <input type="text" name="patient_id">
        </label>

        <label for="the_date">Date:
          <input type="date" name="the_date">
        </label>

        <input type="submit" name="submit" value="Submit">

      </form>

      <?php

      if(isset($_POST['submit'])) {

        $patient = $_POST['patient_id'];
        $the_date = $_POST['the_date'];

        $db_link = mysqli_connect("localhost", "root", "", "retire");

        if ($db_link == false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT Fname, Lname FROM users
                WHERE id LIKE '$patient'";

        if(mysqli_query($db_link, $sql)) {
          $result = mysqli_fetch_row(mysqli_query($db_link, $sql));

          $patient_name =  $result[0] . ' ' . $result[1];
        }

        else echo "<p class='error'>Could not get patient from database, check your values.</p>";

      }

       ?>



       <p>Note: Select date to get on duty doctor displayed below.</p>

       <?php
        if(isset($_POST['submit'])) {

           echo "<form  action='docappt.php' method='post'>";
           echo "<label for='Doctor'>Doctor:";
           echo "<select  name='Doctor'>";

          $sql = "SELECT id FROM rosters
                  WHERE the_date LIKE '$the_date'";

          print_r($mysqli_query($db_link, $sql));
          
          if(mysqli_query($db_link, $sql)) {
            $result = mysqli_fetch_row(mysqli_query($db_link, $sql));
          }

          else echo "<p class='error'>Could not get patient from database, check your values.</p>";

          $sql = "SELECT Fname, Lname, id FROM users
                  WHERE id LIKE '$result'";

          if(mysqli_query($db_link, $sql)) {
            $result2 = mysqli_fetch_row(mysqli_query($db_link, $sql));

            echo "<option value=" . $result2[2] . " " . ">" . $result2[0] . ' ' . $result2[1] . "</option>";
          }

          else echo "<p class='error'>Could not get doctor from database, check your values.</p>";

           echo "</select>";
           echo "</label>";
           echo "<input type='submit' name='press' value='Submit'>";
           echo "</form>";
        }
        ?>


      <label for="patients_name" class='display_only'>Patient Name:
        <p class='display_only' ><?php if(isset($_POST['submit'])) echo $patient_name ?></p>
      </label>

      <?php
        if(isset($_POST['press'])) {
          echo 'hello';
        }
       ?>

    </section>

  </body>
</html>
