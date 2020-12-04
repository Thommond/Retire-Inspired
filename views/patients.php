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
      include ('../common-functions.php');
      check_session(4);

      if ($_SESSION['Role_id'] == 1) echo '<a href=' . "admin/adminHome.php" . '>' . 'Back' . '</a>';
      if ($_SESSION['Role_id'] == 2) echo '<a href=' . "home/supervisorHome.php" . '>' . 'Back' . '</a>';
      if ($_SESSION['Role_id'] == 3) echo '<a href=' . "doctor/doctorHome.php" . '>' . 'Back' . '</a>';
      if ($_SESSION['Role_id'] == 4) echo '<a href=' . "home/caregiverHome.php" . '>' . 'Back' . '</a>';
      ?>

      <h1>Patients List</h1>

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

      $filter = '';
      $column = '';

      $db_link = mysqli_connect("localhost", "root", "", "retire");

      if ($db_link == false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
      }

      if (isset($_POST['Submit'])) {

        $id = $_POST['id'];
        $fname = $_POST['Fname'];
        $lnname = $_POST['Lname'];
        $age = $_POST['age'];
        $contact1 = $_POST['contact1'];
        $contact2 = $_POST['contact2'];
        $adddate = $_POST['adddate'];
        $day = date('Y-m-d');

        // Check if one is filled if not
        // keep checking until end of list.
        if (!empty($id)) {
            $filter = $id;
            $column = 'u.id';
        }
        else if (!empty($fname)) {

            $filter = $fname . '%';
            $column = 'Fname';
        }
        else if (!empty($lname)){

            $filter = $lname . '%';
            $column = 'Lname';
        }
        else if (!empty($age)) {

            $filter = $age . '%';
            $column = 'age';
        }
        else if (!empty($contact1)) {

          $filter = $contact1 . '%';
          $column = 'Relation_Contact';
        }
        else if (!empty($contact2)) {

          $filter = $contact2 . '%';
          $column = 'emergency_contact';
        }

        else if (!empty($adddate)) {
          $filter = $adddate . '%';
          $column = 'admission_date';
        }
        else {

          echo '<p class="error">You have no fields filled out. Please fill in one field.</p>';
        }

      }

      $sql = "SELECT u.id,u.Fname, u.Lname, p.admission_date,
             DATEDIFF(CURRENT_DATE, STR_TO_DATE(u.Birth_date, '%Y-%m-%d'))/365 AS age,
             p.Relation_Contact, p.emergency_contact
             FROM users as u JOIN patients_info as p ON (u.id=p.user_id)";

      if ($column == 'age') {
        $sql = $sql . "WHERE FLOOR(DATEDIFF(CURRENT_DATE, STR_TO_DATE(u.Birth_date, '%Y-%m-%d'))/365) LIKE '$filter'";
      }
      elseif ($column && $filter) {
        $sql = $sql . "WHERE '$column' LIKE '$filter'";
      }


      $result = mysqli_query($db_link, $sql);

      mysqli_close($db_link);

      if (empty($result)) {
        die("<p class='error'>The field you entered has no results</p>");
      }

      else {
        // Print table to page
        echo '<table>';
        echo '<tbody>';
        echo '<tr>';
        echo '<th>Id</th>';
        echo '<th>First Name</th>';
        echo '<th>Last Name</th>';
        echo '<th>Age</th>';
        echo '<th>Admission Date</th>';
        echo '<th>Emergency Contact</th>';
        echo '<th>Emergency Contact Name</th>';
        echo '</tr>';

        while ($row = $result->fetch_assoc()) {

          if (empty($row)) {
            die("<p class='error'>The field you entered has no results</p>");
          }

          // Add result row to table
          echo '<tr>';
          echo '<td>' . $row['id'] . '</td>';
          echo '<td>' . $row['Fname'] . '</td>';
          echo '<td>' . $row['Lname'] . '</td>';
          echo '<td>' . floor($row['age']) . '</td>';
          echo '<td>' . $row['admission_date'] . '</td>';
          echo '<td>' . $row['Relation_Contact'] . '</td>';
          echo '<td>' . $row['emergency_contact'] . '</td>';
          echo '</tr>';

        }

        echo '</tbody>';
        echo '</table>';

      }

      ?>

    </section>

  </body>
</html>
