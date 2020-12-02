<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Patients List</title>
    <link rel="stylesheet" href="../static/style.css">
  </head>
  <body>

    <section>
      <?php
      include ('../../common-functions.php');
      check_session(3);

      if ($_SESSION['Role_id'] == 1) echo '<a href=' . "adminHome.php" . '>' . 'Back' . '</a>';
      if ($_SESSION['Role_id'] == 2) echo '<a href=' . "../home/supervisorHome.php" . '>' . 'Back' . '</a>';
      if ($_SESSION['Role_id'] == 3) echo '<a href=' . "../home/doctorHome.php" . '>' . 'Back' . '</a>';
      if ($_SESSION['Role_id'] == 4) echo '<a href=' . "../home/caregiverHome.php" . '>' . 'Back' . '</a>';
      ?>



      <p>If you would like to filter the results fill in a field only one field at a time.</p>

      <form  action="patients.php" method="post">

        <label>ID:
          <input type="text" name="id">
        </label>

        <label>First Name:
          <input type="text" name="Fname">
        </label>

        <label>Last Name:
          <input type="text" name="Lname">
        </label>

        <label>Age:
          <input type="text" name="age">
        </label>

        <label>Emergency Contact:
          <input type="text" name="contact1">
        </label>

        <label>Emergency Contact Name:
          <input type="text" name="contact2">
        </label>

        <label>Admission Date:
          <input type="text" name="adddate">
        </label>

        <input type="submit" name="Submit" value="Submit">

      </form>

      <?php

      if (isset($_POST['Submit'])) {

        

      }


       ?>



    </section>

  </body>
</html>
